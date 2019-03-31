<?php
/**
 * Copyright © Magepotato, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Magepotato\Banners\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magepotato\Banners\Api\BannersRepositoryInterface;
use Magepotato\Banners\Api\Data\AreaInterface;


/**
 * @inheritdoc
 */
class Banners implements ResolverInterface
{
    /**
     * @var BannersRepositoryInterface
     */
    private $repository;

    /**
     * @param BannersRepositoryInterface $repository
     */
    public function __construct(
        BannersRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }


    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $items = [];


        // variable auto declaration: $filter, $pageSize, $currentPage
        $keys = ['filter', 'pageSize', 'currentPage'];
        foreach ($keys as $key) {
            $$key = $args[$key];
        }

        $pageSize = $pageSize ?? 10;
        $currentPage = $currentPage ?? 1;
        if($filter && is_array($filter)) {
            if(isset($filter[AreaInterface::IDENTIFIER])) {
                // get banners by area identifier
                $items = $this->repository->getCollectionByAreaIdentifier($filter[AreaInterface::IDENTIFIER]);
            }
        }
        ## STOPPED HERE

        $count = count($items);

        $data = [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $items,
            'page_info' => [
                'page_size' => $searchCriteria->getPageSize(),
                'current_page' => $currentPage,
                'total_pages' => $maxPages
            ],
            'layer_type' => $layerType
        ];



        return $data;





        throw new \Exception(json_encode($field), 1);

        throw new \Exception(json_encode($value), 1);
        throw new \Exception($args['filter'], 1);
        throw new \Exception(json_encode($info), 1);
        throw new \Exception(json_encode($context), 1);
        
        var_dump(json_encode($field));
        die('here');
        // resolver functionality ...
    }
}
