<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\Source;

class StoreViews implements \Magento\Framework\Data\OptionSourceInterface
{
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getAvailableOptions();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value['name'],
                'value' => $key,
            ];
        }

        return $options;
    }

    protected function getAvailableOptions()
    {
        return $this->storeManager->getStores();
    }
}
