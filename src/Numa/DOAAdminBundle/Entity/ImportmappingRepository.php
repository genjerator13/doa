<?php
namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ImportmappingRepository extends EntityRepository
{
    public static function matchPropertyAndListingField($property)
    {
        return "test";
    }
}

?>