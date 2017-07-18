<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 16.7.17.
 * Time: 08.25
 */
namespace Numa\DOADMSBundle\Tests\Util;

trait containerTrait // implements Logger
{
    protected $container;
    protected $em;
    protected function setUp()
    {
        self::bootKernel();

        $this->container = static::$kernel->getContainer();
        $this->em  = $this->container->get('doctrine.orm.entity_manager');

    }
}
