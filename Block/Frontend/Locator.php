<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Block\Frontend;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class Locator extends Template
{
    private const XML_PATH_API_KEY        = 'etechflow_storelocator/general/google_maps_api_key';
    private const XML_PATH_DEFAULT_RADIUS = 'etechflow_storelocator/general/default_radius';

    public function __construct(
        Context $context,
        private readonly ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getGoogleMapsApiKey(): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_API_KEY,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getDefaultRadius(): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_DEFAULT_RADIUS,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getSearchUrl(): string
    {
        return $this->getUrl('store-finder/stores/search');
    }
}
