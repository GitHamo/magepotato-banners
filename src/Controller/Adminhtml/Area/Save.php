<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Controller\Adminhtml\Area;

use Magento\Backend\App\Action;
use Magepotato\Banners\Api\Data\AreaInterface;

class Save extends \Magento\Backend\App\Action
{
    public function __construct(
        Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Magepotato\Banners\Model\Area');
            $id = $this->getRequest()->getParam(AreaInterface::ID);
            if ($id) {
                $model->load($id);
            }
            $data[AreaInterface::IDENTIFIER] = strtolower($data[AreaInterface::IDENTIFIER]);
            $model->setData($data);
            $this->_eventManager->dispatch(
                'banners_area_prepare_save',
                ['area' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this record.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [AreaInterface::ID => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', [AreaInterface::ID => $this->getRequest()->getParam(AreaInterface::ID)]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magepotato_Banners::area_save');
    }
}
