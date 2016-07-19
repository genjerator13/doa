<?php
namespace Numa\DOASiteBundle\Lib;
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.5.16.
 * Time: 12.41
 */
interface DealerSiteControllerInterface
{
    public function initializeDealer($dealer);
    public function initializePageComponents($component);
    //public function initializeDealerComponents($component);

}