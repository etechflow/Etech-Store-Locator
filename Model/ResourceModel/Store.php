<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Store extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('etechflow_store_locator', 'store_id');
    }
}
