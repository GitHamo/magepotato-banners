<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Api\Data;

interface AreaInterface
{
    const CACHE_TAG = 'mpotato_banners_area';
    const ID = 'entity_id';
    const TITLE = 'title';
    const IDENTIFIER = 'identifier';

    /**
     * @return int|null
     */
    public function getId();
}
