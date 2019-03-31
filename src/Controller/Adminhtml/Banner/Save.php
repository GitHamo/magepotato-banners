<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magepotato\Banners\Api\Data\BannerInterface;

class Save extends \Magento\Backend\App\Action
{
    public function __construct(
        Action\Context $context,
        \Magepotato\Banners\Model\Image $imageModel
    ) {
        $this->imageModel = $imageModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Magepotato\Banners\Model\Banner');
            $id = $this->getRequest()->getParam(BannerInterface::ID);
            if ($id) {
                $model->load($id);
            }

            if (!$data[BannerInterface::AREA_ID]) {
                $model->setAreaId(null);
            }

            if ($data[BannerInterface::STORE_IDS]) {
                $data[BannerInterface::STORE_IDS] = implode(',', $data[BannerInterface::STORE_IDS]);
            }

            $modelData = $this->prepareModelData($data);
            $model->setData($modelData);

            $this->_eventManager->dispatch(
                'banners_banner_prepare_save',
                ['banner' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this record.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [BannerInterface::ID => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                // $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', [BannerInterface::ID => $this->getRequest()->getParam(BannerInterface::ID)]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magepotato_Banners::banner_save');
    }

    private function prepareModelData(array $data)
    {
        $imageKey = BannerInterface::IMAGE;

        // check if to upload banner image
        $upload = $this->getRequest()->getFiles($imageKey);
        if ($upload['size']) {
            // attempt to upload banner image
            $file = $this->imageModel->upload($upload, BannerInterface::MEDIA_SUBDIR);
            $data[$imageKey]['value'] = BannerInterface::MEDIA_SUBDIR.$file;
        }

        // check if to delete banner image
        if (isset($data[$imageKey]['delete']) && '1' === $data[$imageKey]['delete']) {
            // attempt to delete banner image
            $data[$imageKey] = $this->imageModel->delete($data[$imageKey]['value']);
        }

        $data[$imageKey] = $data[$imageKey]['value'];

        return $data;
    }
}
