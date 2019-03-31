<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model\ResourceModel;

use Magepotato\Banners\Api\Data\AreaInterface;

class Area extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(AreaInterface::CACHE_TAG, AreaInterface::ID);
    }
}
