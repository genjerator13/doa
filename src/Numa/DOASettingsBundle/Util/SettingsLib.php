<?php
namespace Numa\DOASettingsBundle\Util;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOASettingsBundle\Entity\Setting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;

class SettingsLib
{
    /**
     * @var EntityManager
     */
    protected $em;
    protected $container;
    /**
     * @var EntityRepository
     */
    protected $repo;
    public function __construct(EntityManager $em,Container $container){
        $this->em = $em;
        $this->container = $container;
        $this->repo = null;
    }
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = null;
    }

    /**
     * @param string $name Name of the setting.
     * @return string|null Value of the setting.
     * @throws \RuntimeException If the setting is not defined.
     */
    public function get($name,$map=array())
    {
        $setting = $this->getRepo()->findOneBy(array(
            'name' => $name,
        ));
        if ($setting === null) {
            return "";
        }

        $value = $setting->getValue();
        if(!empty($map)) {
            $value = $this->replaceRealValues($value,$map);
        }
        return $value;
    }

    public function getSetting($name,$section="",$dealer=null){
        return $this->getRepo()->getSingle($name,$section,$dealer);
    }

    /**
     * @param $host
     * @return mixed
     * NOT USED
     *
     */
    public function getDealerForHost($host)
    {
        $setting = $this->getRepo()->findOneBy(array(
            'name' => 'host','value'=>$host
        ));
        $dealer = $setting->getDealer();
        return $dealer;
    }

    /**
     * @param $host
     * @return mixed
     * NOT USED
     *
     */
    public function activateTheme($host){
        $dealer = $this->getDealerForHost($host);
        $theme = $this->getRepo()->getSingle('theme','site',$dealer);
        $activeTheme = $this->container->get('liip_theme.active_theme');

        $activeTheme->setName($theme->getValue());

        return $theme;
    }

    /**
     * @param string $name Name of the setting to update.
     * @param string|null $value New value for the setting.
     * @throws \RuntimeException If the setting is not defined.
     */
    public function set($name, $value,$section="",$dealer_id=null)
    {
        $setting = $this->getRepo()->findOneBy(array(
            'name' => $name,
        ));
        $dealer = $this->container->get('Numa.Dms.User')->getSignedDealer();
        if ($setting === null) {
            $setting= new Setting();
            $setting->setName($name);
            $setting->setValue($value);
            $setting->setDealer($dealer);
            $setting->setSection($section);
            $this->em->persist($setting);

        }
        $setting->setDealer($dealer);
        $setting->setValue($value);
        $setting->setSection($section);

        $this->em->flush();
    }

    /**
     * @param array $newSettings List of settings (as name => value) to update.
     * @throws \RuntimeException If at least one of the settings is not defined.
     */
    public function setMultiple(array $newSettings)
    {
        if (empty($newSettings)) {
            return;
        }
        $settings = $this->em->createQueryBuilder()
            ->select('s')
            ->from('Numa\DOASettings\Entity\Setting', 's', 's.name')
            ->where('s.name IN (:names)')
            ->getQuery()
            ->execute(array('names' => array_keys($newSettings)));
        foreach ($newSettings as $name => $value) {
            if (!isset($settings[$name])) {
                throw $this->createNotFoundException($name);
            }
            $settings[$name]->setValue($value);
        }
        $this->em->flush();
    }

    /**
     * @return array with name => value
     */
    public function all()
    {
        return $this->getAsNamesAndValues($this->getRepo()->findAll());
    }

    /**
     * @param string|null $section Name of the section to fetch settings for.
     * @return array with name => value
     */
    public function getBySection($section)
    {
        return $this->getAsNamesAndValues($this->getRepo()->findBy(array('section' => $section)));
    }

    /**
     * @param Setting[] $entities
     * @return array with name => value
     */
    protected function getAsNamesAndValues(array $settings)
    {
        $result = array();
        foreach ($settings as $setting) {
            $result[$setting->getName()] = $setting->getValue();
        }
        return $result;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepo()
    {
        if ($this->repo === null) {
            $this->repo = $this->em->getRepository('NumaDOASettingsBundle:Setting');
        }
        return $this->repo;
    }

    /**
     * @param string $name Name of the setting.
     * @return \RuntimeException
     */
    protected function createNotFoundException($name)
    {
        return new \RuntimeException(sprintf('Setting "%s" couldn\'t be found.', $name));
    }

    public function getSections($dealer=null){
        $q = $this->em->createQueryBuilder();
        $q->select('s.section')
            ->distinct()
            ->from('NumaDOASettingsBundle:Setting', 's');
        if($dealer instanceof Catalogrecords){
            $q->where('s.dealer_id=:dealer_id');
            $q->setParameter('dealer_id',$dealer->getId());
        }
        $res=$q->getQuery();
        return $res->getArrayResult();
    }

    public function replaceRealValues($subject,$map=array()){

        if(!empty($subject) && is_array($map) && !empty($map)){
            foreach ($map as $search=>$replace){
                $subject = str_ireplace("{{".$search."}}",$replace,$subject);
            }
        }
        return $subject;
    }

    public function generateItemTitle(Item $item){
        $titleTemplate = strip_tags($this->get('item_title'));

        if(empty($titleTemplate)){
            $titleTemplate = strip_tags($item->getTitle());
        }
        preg_match_all("/\{(.*?)\}/", $titleTemplate, $matches);

        $title = "";
        $replace = array();
        foreach($matches[1] as $match){
            $replace[] = $item->get($match);
        }

        $title =  str_replace($matches[0], $replace, $titleTemplate);
        return $title;
    }

    public function generateItemDescription(Item $item){
        $titleTemplate = strip_tags($this->get('item_description'));
        if(empty($titleTemplate)){
            $titleTemplate = strip_tags($item->getUrlDescription());
        }
        return $this->parseStringFormula($item, $titleTemplate);
    }

    public function getItemKeywords(Item $item){
        $titleTemplate = strip_tags($this->get('item_keywords'));

        return $this->parseStringFormula($item, $titleTemplate);
    }

    public function parseStringFormula(Item $item, $stringFormula)
    {
        preg_match_all("/\{(.*?)\}/", $stringFormula, $matches);

        $title = "";
        $replace = array();
        foreach($matches[1] as $match){
            if($match=='sitename') {
                $host = $this->container->get('router')->getContext()->getBaseUrl();
                if(empty($host)) {
                    $host = $this->container->get('router')->getContext()->getHost();
                }
                $replace[] = $host;
            }else{
                $replace[] = $item->get($match);
            }
        }

        $title =  str_replace($matches[0], $replace, $stringFormula);
        return $title;
    }

    public function createDealerUploadFolders($dealer_id){
        //upload to
        $upload =$this->container->getParameter('upload_dealer').$dealer_id;
        if(!is_dir($upload)) {

            if (!is_dir($this->container->getParameter('upload_dealer'))) {
                mkdir($this->container->getParameter('upload_dealer'),777,true);

            }
            mkdir($upload,0777,true);

        }
    }

    public function createDealerComponentUploadFolders($dealer_id,$component_id){
        //$this->createDealerUploadFolders($dealer_id);
        $upload =$this->container->getParameter('upload_dealer').$dealer_id."/component/".$component_id;
        if(!is_dir($this->container->getParameter('upload_dealer').$dealer_id."/component")){
            mkdir($this->container->getParameter('upload_dealer').$dealer_id."/component",0777,true);
            if(!is_dir($upload)){
                mkdir($upload,0777,true);
            }

        }
    }

    public function getPageTitle($page,$dealer){
        $pageTitle="";
        if ($page instanceof Page) {
            $pageTitle = $page->getTitle();
        }

        if(empty($pageTitle) && $dealer instanceof Catalogrecords) {
            $pageTitle = $this->get('title', 'seo', $dealer);
        }
        return strip_tags($pageTitle);
    }

    public function getPageDescription($page,$dealer){
        $pageDescription="";
        if ($page instanceof Page) {
            $pageDescription = $page->getDescription();
        }

        if(empty($pageTitle) && $dealer instanceof Catalogrecords) {
            $pageDescription = $this->get('description', 'seo', $dealer);
        }

        return strip_tags($pageDescription);
    }

    public function getPageKeywords($page, $dealer){
        $pageKeywords="";
        if ($page instanceof Page) {
            $pageKeywords = $page->getKeywords();
        }

        if(empty($pageKeywords) && $dealer instanceof Catalogrecords) {
            $pageKeywords = $this->get('keywords', 'seo', $dealer);
        }

        return strip_tags($pageKeywords);
    }
}