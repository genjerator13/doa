<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


class TextLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function isSpam($text){
        $url = $this->container->get('numa.dms.user')->getCurrentSiteHost();
        preg_match_all('/https?:\/\/(www\.)?([-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4})\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/', $text, $matches, PREG_OFFSET_CAPTURE);

        if(!empty($matches[0])) {
            foreach ($matches[0] as $match) {
                 if(stripos($match[0],$url)!==false){
                    return false;
                }else{
                     return true;
                 }
            }
        }
        return false;
    }

}