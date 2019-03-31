<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\ResourceModel\Banner;

use Magepotato\Banners\Api\Data\BannerInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = BannerInterface::ID;

    protected function _construct()
    {
        $this->_init('Magepotato\Banners\Model\Banner', 'Magepotato\Banners\Model\ResourceModel\Banner');
    }
}
