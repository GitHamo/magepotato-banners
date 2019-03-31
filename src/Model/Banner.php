<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model;

class Banner extends \Magento\Framework\Model\AbstractModel implements \Magepotato\Banners\Api\Data\BannerInterface, \Magento\Framework\DataObject\IdentityInterface
{
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getIsActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function getType()
    {
        $typeId = (int) $this->getTypeId();
        $types = (new \Magepotato\Banners\Model\Source\BannerTypes())->getAvailableOptions();
        if (array_key_exists($typeId, $types)) {
            return strtolower($types[$typeId]);
        }

        return '';
    }

    public function getTypeId()
    {
        return $this->getData(self::TYPE_ID);
    }

    public function setTypeId($typeId)
    {
        return $this->setData(self::TYPE_ID, $typeId);
    }

    public function getAreaId()
    {
        return $this->getData(self::AREA_ID);
    }

    public function setAreaId($areaId)
    {
        return $this->setData(self::AREA_ID, $areaId);
    }

    public function getStoreIds()
    {
        return $this->getData(self::STORE_IDS);
    }

    public function setStoreIds($storeIds)
    {
        return $this->setData(self::STORE_IDS, $storeIds);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    //# @todo: add more fields to interface

    public function getLinkTarget()
    {
        return $this->getData(self::LINK_TARGET);
    }

    public function setLinkTarget($linkTarget)
    {
        return $this->setData(self::LINK_TARGET, $linkTarget);
    }

    public function getAltText()
    {
        return $this->getData(self::ALT_TEXT);
    }

    public function setAltText($link)
    {
        return $this->setData(self::ALT_TEXT, $link);
    }

    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    protected function _construct()
    {
        $this->_init('Magepotato\Banners\Model\ResourceModel\Banner');
    }
}
