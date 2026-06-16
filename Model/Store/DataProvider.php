<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Model\Store;

use Etechflow\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        private readonly CollectionFactory $collectionFactory,
        private readonly DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $this->collectionFactory->create();
    }

    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $store) {
            $this->loadedData[$store->getId()] = $store->getData();
        }

        $persistedData = $this->dataPersistor->get('etechflow_store_locator');

        if (!empty($persistedData)) {
            $store = $this->collection->getNewEmptyItem();
            $store->setData($persistedData);
            $this->loadedData[$store->getId()] = $store->getData();
            $this->dataPersistor->clear('etechflow_store_locator');
        }

        return $this->loadedData;
    }
}
