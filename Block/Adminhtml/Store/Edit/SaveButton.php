<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Block\Adminhtml\Store\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label'          => __('Save Store'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'save'],
                ],
            ],
            'sort_order' => 90,
        ];
    }
}
