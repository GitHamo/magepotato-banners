<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml;

class Area extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_area';
        $this->_blockGroup = 'Magepotato_Banners';
        $this->_headerText = __('Manage Banner Areas');

        parent::_construct();

        if ($this->_isAllowedAction('Magepotato_Banners::area_save')) {
            $this->buttonList->update('add', 'label', __('Add New Area'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
