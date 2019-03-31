<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\ResourceModel\Area;

use Magepotato\Banners\Api\Data\AreaInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = AreaInterface::ID;

    protected function _construct()
    {
        $this->_init('Magepotato\Banners\Model\Area', 'Magepotato\Banners\Model\ResourceModel\Area');
    }
}
