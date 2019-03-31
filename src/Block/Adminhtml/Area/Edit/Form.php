<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml\Area\Edit;

use Magepotato\Banners\Api\Data\AreaInterface;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('area_form');
        $this->setTitle(__('Area Information'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry(AreaInterface::CACHE_TAG);
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('area_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField(
                AreaInterface::ID,
                'hidden',
                [
                    'name' => AreaInterface::ID,
                ]
            );
        }
        $fieldset->addField(
            AreaInterface::TITLE,
            'text',
            [
                'name' => AreaInterface::TITLE,
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            AreaInterface::IDENTIFIER,
            'text',
            [
                'name' => AreaInterface::IDENTIFIER,
                'label' => __('Identifier'),
                'title' => __('Identifier'),
                'required' => true,
                'class' => 'validate-xml-identifier',
            ]
        );
        // $fieldset->addField(
        //     'is_active',
        //     'select',
        //     [
        //         'label' => __('Status'),
        //         'title' => __('Status'),
        //         'name' => 'is_active',
        //         'required' => true,
        //         'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
        //     ]
        // );
        // if (!$model->getId()) {
        //     $model->setData('is_active', '1');
        // }
        // $fieldset->addField(
        //     'content',
        //     'editor',
        //     [
        //         'name' => 'content',
        //         'label' => __('Content'),
        //         'title' => __('Content'),
        //         'style' => 'height:36em',
        //         'required' => true
        //     ]
        // );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
