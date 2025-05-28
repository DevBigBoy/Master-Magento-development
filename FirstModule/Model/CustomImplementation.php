<?php

namespace SimplifiedMagento\FirstModule\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;

class CustomImplementation implements ProductRepositoryInterface
{

    public function save(\Magento\Catalog\Api\Data\ProductInterface $product, $saveOptions = false)
    {
        // TODO: Implement save() method.
    }

    public function get($sku, $editMode = false, $storeId = null, $forceReload = false)
    {
        // TODO: Implement get() method.
    }

    public function getById($productId, $editMode = false, $storeId = null, $forceReload = false)
    {
        // TODO: Implement getById() method.
    }

    public function delete(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($sku)
    {
        // TODO: Implement deleteById() method.
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}
