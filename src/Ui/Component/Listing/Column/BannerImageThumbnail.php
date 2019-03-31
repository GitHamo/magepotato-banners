<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magepotato\Banners\Api\Data\BannerInterface;

class BannerImageThumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const ALT_FIELD = 'title';

    protected $storeManager;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        Image $imageHelper,
        UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Helper\ImageFactory $helperFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->helperFactory = $helperFactory;
        $this->assetRepo = $assetRepo;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                $url = '';
                if ('' !== $item[$fieldName]) {
                    $url = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                    $url = rtrim($url, '/').'/';
                    $url .= ltrim($item[$fieldName], '/');
                } else {
                    $url = $this->getDefaultPlaceholder();
                }
                $item[$fieldName.'_src'] = $url;
                $item[$fieldName.'_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName.'_link'] = $this->urlBuilder->getUrl(
                    'mpotato_banners/banner/edit',
                    [BannerInterface::ID => $item[BannerInterface::ID]]
                );
                $item[$fieldName.'_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;

        return isset($row[$altField]) ? $row[$altField] : null;
    }

    protected function getDefaultPlaceholder(string $placeholder = 'small_image')
    {
        $helper = $this->helperFactory->create();

        return $this->assetRepo->getUrl($helper->getPlaceholder($placeholder));
    }
}
