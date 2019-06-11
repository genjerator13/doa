<?php
namespace Numa\DOAAdminBundle\Listeners;

use FOS\ElasticaBundle\Event\IndexPopulateEvent;
use FOS\ElasticaBundle\Index\IndexManager;

class PopulateListener
{
    /**
     * @var IndexManager
     */
    private $indexManager;

    /**
     * @param IndexManager $indexManager
     */
    public function __construct(IndexManager $indexManager)
    {
        $this->indexManager    = $indexManager;
    }

    public function onElasticaIndexIndexprepopulate(IndexPopulateEvent $event)
    {

    }

    public function postIndexPopulate(IndexPopulateEvent $event)
    {
        $index = $this->indexManager->getIndex($event->getIndex());
        $settings = $index->getSettings();
        $index->optimize(['max_num_segments' => 5]);
        $settings->setRefreshInterval('1s');
    }
}