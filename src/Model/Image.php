<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Image
{
    const MEDIA_SUBDIR = 'cms/content/banners';

    protected $subDir = 'cms/banners/banner';
    protected $urlBuilder;
    protected $uploaderFactory;
    protected $fileSystem;

    public function __construct(
        UrlInterface $urlBuilder,
        UploaderFactory $uploaderFactory,
        Filesystem $fileSystem,
        File $file
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->uploaderFactory = $uploaderFactory;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
    }

    public function getBaseUrl(?string $path): string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$path;
    }

    public function getBaseDir(?string $path): string
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath($path);
    }

    public function upload($file, ?string $destinationFolder): ?string
    {
        $destination = $this->getBaseDir($destinationFolder);

        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $file]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            $result = $uploader->save($destination);

            return $result['file'];
        } catch (\Exception $e) {
            die('delete');
            if (\Magento\Framework\File\Uploader::TMP_NAME_EMPTY !== $e->getCode()) {
                throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
            }
            if (isset($data[$inputKey]['value'])) {
                return BannerInterface::MEDIA_SUBDIR.$data[$inputKey]['value'];
            }
        }
    }

    public function delete($fileName): ?string
    {
        $deletePath = $this->getBaseDir($fileName);

        try {
            if ($this->file->isExists($deletePath)) {
                $this->file->deleteFile($deletePath);
            }

            return null;
        } catch (\Exception $e) {
            return $fileName;
        }
    }
}
