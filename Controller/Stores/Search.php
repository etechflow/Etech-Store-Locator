<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Controller\Stores;

use Etechflow\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;

class Search implements HttpGetActionInterface
{
    private const IMAGE_BASE_PATH = 'etechflow/stores/';

    public function __construct(
        private readonly JsonFactory $resultJsonFactory,
        private readonly CollectionFactory $collectionFactory,
        private readonly StoreManagerInterface $storeManager
    ) {
    }

    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);
        $collection->setOrder('sort_order', 'ASC');
        $collection->setOrder('name', 'ASC');

        $baseMediaUrl = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );

        $stores = [];

        foreach ($collection as $store) {
            $imageFile = $store->getImage();
            $imageUrl  = '';

            if ($imageFile) {
                $imageUrl = rtrim($baseMediaUrl, '/') . '/' . self::IMAGE_BASE_PATH . ltrim($imageFile, '/');
            }

            $stores[] = [
                'id'        => (int) $store->getId(),
                'name'      => $store->getName(),
                'street'    => $store->getStreet(),
                'city'      => $store->getCity(),
                'county'    => $store->getCounty(),
                'postcode'  => $store->getPostcode(),
                'phone'     => $store->getPhone(),
                'email'     => $store->getEmail(),
                'tagline'   => $store->getTagline(),
                'hours'     => $store->getHours(),
                'lat'       => $store->getLat() !== null ? (float) $store->getLat() : null,
                'lng'       => $store->getLng() !== null ? (float) $store->getLng() : null,
                'image'     => $imageUrl,
                'store_url' => $store->getStoreUrl(),
            ];
        }

        $result->setData($stores);

        return $result;
    }
}
