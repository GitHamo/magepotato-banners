<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model;

class Area extends \Magento\Framework\Model\AbstractModel implements \Magepotato\Banners\Api\Data\AreaInterface, \Magento\Framework\DataObject\IdentityInterface
{
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getDefaultValues()
    {
        return [];
    }

    protected function _construct()
    {
        $this->_init('Magepotato\Banners\Model\ResourceModel\Area');
    }
}
