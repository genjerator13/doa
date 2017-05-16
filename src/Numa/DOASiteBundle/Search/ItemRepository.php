<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 16.5.17.
 * Time: 18.44
 */

namespace Numa\DOASiteBundle\Search;


use Elastica\Query;
use FOS\ElasticaBundle\Repository;

class ItemRepository extends Repository
{
    public function findItem($item_id) {


        //$finder = $this->get('fos_elastica.finder.sava.blog');
        $finder = $this->get('fos_elastica.index.app.item');

        $query = new Query();
        $innerQuery = new Query\MatchAll();

        $query->setQuery($innerQuery);

        return $this->find($query);
    }
}