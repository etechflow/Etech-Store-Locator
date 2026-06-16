<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Model\ResourceModel\Store;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Etechflow\StoreLocator\Model\Store;
use Etechflow\StoreLocator\Model\ResourceModel\Store as StoreResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'store_id';

    protected $_eventPrefix = 'etechflow_store_locator_collection';

    protected $_eventObject = 'store_collection';

    protected function _construct(): void
    {
        $this->_init(Store::class, StoreResource::class);
    }
}
