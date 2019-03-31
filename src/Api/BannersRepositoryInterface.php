<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Api;

interface BannersRepositoryInterface
{
    /**
     * @param string   $areaIdentifier
     * @param null|int $storeId
     * @param bool     $forceReload
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     *
     * @return \Magepotato\Banners\Api\Data\BannerInterface[]
     */
    public function getByAreaIdentifier(string $areaIdentifier, int $storeId = null, bool $forceReload = false);
}
