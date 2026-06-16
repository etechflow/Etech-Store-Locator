<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Model;

use Magento\Framework\Model\AbstractModel;
use Etechflow\StoreLocator\Model\ResourceModel\Store as StoreResource;

class Store extends AbstractModel
{
    public const CACHE_TAG = 'etechflow_store_locator';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'etechflow_store_locator';

    protected function _construct(): void
    {
        $this->_init(StoreResource::class);
    }

    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
