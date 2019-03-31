<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml\Banner\Edit\Renderer;

class Image extends \Magento\Framework\Data\Form\Element\Image
{
    protected function _getUrl()
    {
        return implode(
            '/',
            [
                trim($this->getValue(), '/'),
            ]
        );
    }
}
