<?php
namespace Numa\DOASettingsBundle\Util;

use Numa\DOASettingsBundle\Entity\Setting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class SettingsLib
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var EntityRepository
     */
    protected $repo;
    public function __construct(EntityManager $em){
        $this->em = $em;
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
    public function get($name)
    {
        $setting = $this->getRepo()->findOneBy(array(
            'name' => $name,
        ));
        if ($setting === null) {
            return "";
        }
        return $setting->getValue();
    }

    /**
     * @param string $name Name of the setting to update.
     * @param string|null $value New value for the setting.
     * @throws \RuntimeException If the setting is not defined.
     */
    public function set($name, $value)
    {
        $setting = $this->getRepo()->findOneBy(array(
            'name' => $name,
        ));
        if ($setting === null) {
            throw $this->createNotFoundException($name);
        }
        $setting->setValue($value);
        $this->em->flush($setting);
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

    public function getSections(){
        $q = $this->em->createQueryBuilder()
            ->select('s.section')
            ->distinct()
            ->from('NumaDOASettingsBundle:Setting', 's')
            ->getQuery();
        return $q->getArrayResult();
    }
}