<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Api\Data;

interface BannerInterface
{
    const CACHE_TAG = 'mpotato_banners_banner';
    const MEDIA_SUBDIR = '/cms/content/banners';
    const ID = 'entity_id';
    const TITLE = 'title';
    const TYPE_ID = 'type_id';
    const IS_ACTIVE = 'is_active';
    const SORT_ORDER = 'sort_order';
    const AREA_ID = 'area_id';
    const STORE_IDS = 'store_ids';
    const LINK = 'link';
    const LINK_TARGET = 'link_target';
    const ALT_TEXT = 'alt_text';
    const IMAGE = 'image';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @param bool  $link
     * @param mixed $isActive
     *
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return int
     */
    public function getTypeId();

    /**
     * @param int $typeId
     *
     * @return $this
     */
    public function setTypeId($typeId);

    /**
     * @return int
     */
    public function getAreaId();

    /**
     * @param int $areaId
     *
     * @return $this
     */
    public function setAreaId($areaId);

    /**
     * @return string
     */
    public function getStoreIds();

    /**
     * @param string $storeIds
     *
     * @return $this
     */
    public function setStoreIds($storeIds);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getLink();

    /**
     * @param string $link
     *
     * @return $this
     */
    public function setLink($link);

    /**
     * @return string
     */
    public function getCreationTime();

    /**
     * @param string $creationTime
     *
     * @return $this
     */
    public function setCreationTime($creationTime);

    /**
     * @return string
     */
    public function getUpdateTime();

    /**
     * @param string $updateTime
     *
     * @return $this
     */
    public function setUpdateTime($updateTime);
}
