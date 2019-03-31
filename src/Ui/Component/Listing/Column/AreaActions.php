<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Ui\Component\Listing\Column;

use Magepotato\Banners\Api\Data\AreaInterface;

class AreaActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const ACTION_URL_PATH_EDIT = 'mpotato_banners/area/edit';
    const ACTION_URL_PATH_DELETE = 'mpotato_banners/area/delete';

    protected $urlBuilder;
    private $editUrl;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ACTION_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item[AreaInterface::ID])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, [AreaInterface::ID => $item[AreaInterface::ID]]),
                        'label' => __('Edit'),
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::ACTION_URL_PATH_DELETE, [AreaInterface::ID => $item[AreaInterface::ID]]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.title }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?'),
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
