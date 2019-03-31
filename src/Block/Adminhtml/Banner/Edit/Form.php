<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Block\Adminhtml\Banner\Edit;

use Magepotato\Banners\Api\Data\BannerInterface;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_wysiwygConfig;
    protected $_systemStore;
    protected $bannerAreasList;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magepotato\Banners\Model\Source\Areas $bannerAreasList,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_systemStore = $systemStore;
        $this->bannerAreasList = $bannerAreasList;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_form');
        $this->setTitle(__('Banner Information'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry(BannerInterface::CACHE_TAG);
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $form->setHtmlIdPrefix('banner_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField(
                BannerInterface::ID,
                'hidden',
                [
                    'name' => BannerInterface::ID,
                ]
            );
        }
        $fieldset->addField(
            BannerInterface::TITLE,
            'text',
            [
                'name' => BannerInterface::TITLE,
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            BannerInterface::TYPE_ID,
            'select',
            [
                'name' => BannerInterface::TYPE_ID,
                'label' => __('Type'),
                'title' => __('Type'),
                'required' => true,
                'class' => 'select',
                'values' => (new \Magepotato\Banners\Model\Source\BannerTypes())->toOptionArray(),
            ]
        );
        if (!$model->getId()) {
            $model->setData(BannerInterface::TYPE_ID, '1');
        }
        $fieldset->addField(
            BannerInterface::IS_ACTIVE,
            'select',
            [
                'name' => BannerInterface::IS_ACTIVE,
                'label' => __('Status'),
                'title' => __('Status'),
                'required' => true,
                'class' => 'select',
                'values' => (new \Magepotato\Banners\Model\Source\IsActive())->toOptionArray(),
            ]
        );
        if (!$model->getId()) {
            $model->setData(BannerInterface::IS_ACTIVE, '1');
        }
        $fieldset->addField(
            BannerInterface::AREA_ID,
            'select',
            [
                'name' => BannerInterface::AREA_ID,
                'label' => __('Area'),
                'title' => __('Area'),
                'required' => true,
                // 'class' => '',
                'class' => 'select validate-no-empty no-whitespace',
                'values' => $this->bannerAreasList->toOptionArray(),
            ]
        );
        $fieldset->addField(
            BannerInterface::SORT_ORDER,
            'text',
            [
                'name' => BannerInterface::SORT_ORDER,
                'label' => __('Order'),
                'title' => __('Order'),
                'required' => false,
                'class' => 'validate-number',
            ]
        );
        $fieldset->addField(
            BannerInterface::STORE_IDS,
            'multiselect',
            [
               'name' => BannerInterface::STORE_IDS.'[]',
               'label' => __('Store Views'),
               'title' => __('Store Views'),
               'required' => false,
               'values' => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addType('image_uploader', '\Magepotato\Banners\Block\Adminhtml\Banner\Edit\Renderer\Image');
        $fieldset->addField(
            BannerInterface::IMAGE,
            'image_uploader',
            [
                'name' => BannerInterface::IMAGE,
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            BannerInterface::LINK,
            'text',
            [
                'name' => BannerInterface::LINK,
                'label' => __('Link'),
                'title' => __('Link'),
                'required' => false,
                'class' => '',
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
