<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\Source;

class Areas implements \Magento\Framework\Data\OptionSourceInterface
{
    public function __construct(
        \Magepotato\Banners\Model\ResourceModel\Area\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        // $this->options = ['label' => __('-- Please Select Area --'), 'value' => ''];
        $collection = $this->collectionFactory->create(); //->toOptionArray();
        foreach ($this->getAvailableOptions() as $value => $label) {
            $this->options[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $this->options;
    }

    public function getAvailableOptions()
    {
        $areas = [];
        $collection = $this->collectionFactory->create();
        foreach ($collection->getItems() as $area) {
            $areas[$area->getId()] = $area->getTitle();
        }

        return $areas;
    }
}
