<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Controller\Adminhtml\Banner;

use Magepotato\Banners\Api\Data\BannerInterface;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam(BannerInterface::ID);
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Magepotato\Banners\Model\Banner');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The banner has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', [BannerInterface::ID => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a banner to delete.'));

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magepotato_Banners::banner_delete');
    }
}
