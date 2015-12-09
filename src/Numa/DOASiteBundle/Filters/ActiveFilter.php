<?php
namespace Numa\DOASiteBundle\Filters;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
class ActiveFilter extends SQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->getReflectionClass()->name == 'Numa\DOAAdminBundle\Entity\Item') {

            return sprintf('%s.active = %s', $targetTableAlias, $this->getParameter('active'));
        }
        return '';


    }
}