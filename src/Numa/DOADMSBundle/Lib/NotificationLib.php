<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Entity\Notification;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Util\containerTrait;
use Numa\Util\searchESParameters;
use Numa\Util\SearchItem;

class NotificationLib
{
    use containerTrait;

    public function createCarfinderCreatedNotificationForDealer(SaveSearch $ss)
    {
        $notificationCF = new CarfinderDealerNotification($this->container);
        $notificationCF->setSaveSearch($ss);

        $notificationCF->createNotificationEntity();
    }
}