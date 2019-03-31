<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml\Banner;

use Magepotato\Banners\Api\Data\BannerInterface;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry(BannerInterface::CACHE_TAG)->getId()) {
            return __("Edit Banner '%1'", $this->escapeHtml($this->_coreRegistry->registry(BannerInterface::CACHE_TAG)->getTitle()));
        }

        return __('New Banner');
    }

    protected function _construct()
    {
        $this->_objectId = BannerInterface::ID;
        $this->_blockGroup = 'Magepotato_Banners';
        $this->_controller = 'adminhtml_banner';

        parent::_construct();

        if ($this->_isAllowedAction('Magepotato_Banners::banner_save')) {
            $this->buttonList->update('save', 'label', __('Save Banner'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ],
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Magepotato_Banners::banner_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Banner'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('mpotato_banners/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
