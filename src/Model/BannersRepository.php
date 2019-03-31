<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model;

use Magepotato\Banners\Api\Data\BannerInterface;

class BannersRepository implements \Magepotato\Banners\Api\BannersRepositoryInterface
{
    protected $storeManager;
    protected $bannerCollectionFactory;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
    ) {
        $this->storeManager = $storeManager;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
    }

    public function getByAreaIdentifier(string $areaIdentifier, $storeId = null, $forceReload = false)
    {
        if (null === $storeId) {
            $storeId = $this->storeManager->getStore()->getId();
        }
        $collection = $this->bannerCollectionFactory->create();
        $collection->getSelect()
            ->joinInner(
                ['jta' => 'mpotato_banners_area'],
                "main_table.area_id = jta.entity_id AND jta.identifier = '{$areaIdentifier}'",
                []
            )
            ->where('main_table.'.BannerInterface::IS_ACTIVE, 1, 'eq')
            ->order('main_table.'.BannerInterface::SORT_ORDER, 'ASC');
        $this->filterCollectionByStoreIds($collection, [$storeId]);

        return $collection->getItems();
    }

    protected function filterCollectionByStoreIds(&$collection, array $storeIds = [])
    {
        $storeIdFilters = [0];
        foreach ($storeIds as $storeId) {
            $storeIdFilters[] = ['finset' => $storeId];
        }
        $collection->addFieldToFilter(
            ['store_ids'],
            [$storeIdFilters]
        );

        return $collection;
    }
}
