<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;

class DealerLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container = null) // this is @service_container
    {
        $this->container = $container;
    }

    public function isCommercialDealer($dealer)
    {
        if (!$dealer instanceof Catalogrecords) {
            return false;
        }
        $dcs = $dealer->getDcategory();
        foreach ($dcs as $dc) {
            if ($dc->getSlug() == "commercial-dealer") {
                return true;
            }
        }
        return false;
    }
}