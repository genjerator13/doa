<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 16.7.17.
 * Time: 08.25
 */
namespace Numa\DOADMSBundle\Util;

trait containerTrait // implements Logger
{
    protected $container;
    protected $em;
    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container = null) // this is @service_container
    {
        $this->container = $container;
        $this->em  = $this->container->get('doctrine.orm.entity_manager');
    }
}
