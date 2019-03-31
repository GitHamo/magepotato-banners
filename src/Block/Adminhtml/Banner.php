<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml;

class Banner extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'Magepotato_Banners';
        $this->_headerText = __('Manage Banner Areas');

        parent::_construct();

        if ($this->_isAllowedAction('Magepotato_Banners::banner_save')) {
            $this->buttonList->update('add', 'label', __('Add New Banner'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
