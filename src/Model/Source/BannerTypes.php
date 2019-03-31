<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\Source;

class BannerTypes implements \Magento\Framework\Data\OptionSourceInterface
{
    const TYPE_LINK = 0;
    const TYPE_PRODUCT = 1;
    const TYPE_CATEGORY = 2;

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getAvailableOptions();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }

    public function getAvailableOptions()
    {
        return [
            self::TYPE_LINK => __('Link'),
            self::TYPE_PRODUCT => __('Product'),
            self::TYPE_CATEGORY => __('Category'),
        ];
    }
}
