<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Ui\Component\Listing\Column;

class AreaTitle extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magepotato\Banners\Model\Source\Areas $areaOptions,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->areaOptions = $areaOptions;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $areas = $this->areaOptions->getAvailableOptions();
            foreach ($dataSource['data']['items'] as &$item) {
                $areaId = $item['area_id'];
                if ($areaId) {
                    $item['area_title'] = $areas[$areaId];
                }
            }
        }

        return $dataSource;
    }
}
