<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\Source;

class Areas implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var null|array
     */
    protected $options;

    public function __construct(
        \Magepotato\Banners\Model\ResourceModel\Area\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        if (null == $this->options) {
            $this->options = $this->collectionFactory->create()->toOptionArray();
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
