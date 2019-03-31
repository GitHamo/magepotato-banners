<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Controller\Adminhtml\Area;

use Magepotato\Banners\Api\Data\AreaInterface;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam(AreaInterface::ID);
        $model = $this->_objectManager->create('Magepotato\Banners\Model\Area');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This area no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register(AreaInterface::CACHE_TAG, $model);
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Area') : __('New Area'),
            $id ? __('Edit Area') : __('New Area')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Areas'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Area'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magepotato_Banners::area_save');
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Backend::content')
            ->addBreadcrumb(__('Areas'), __('Areas'))
            ->addBreadcrumb(__('Manage Areas'), __('Manage Areas'));

        return $resultPage;
    }
}
