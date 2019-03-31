<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Controller\Adminhtml\Area;

use Magepotato\Banners\Api\Data\AreaInterface;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam(AreaInterface::ID);
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Magepotato\Banners\Model\Area');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The area has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', [AreaInterface::ID => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a area to delete.'));

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magepotato_Banners::area_delete');
    }
}
