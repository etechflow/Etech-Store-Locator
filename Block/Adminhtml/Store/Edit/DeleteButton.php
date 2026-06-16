<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Block\Adminhtml\Store\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{
    public function __construct(
        private readonly Context $context
    ) {
    }

    public function getButtonData(): array
    {
        $storeId = $this->getStoreId();

        if (!$storeId) {
            return [];
        }

        $deleteUrl = $this->context->getUrlBuilder()->getUrl(
            '*/*/delete',
            ['store_id' => $storeId]
        );

        return [
            'label'          => __('Delete Store'),
            'class'          => 'delete',
            'id'             => 'store-edit-delete-button',
            'data_attribute' => [
                'mage-init' => [
                    'Magento_Ui/js/form/button-adapter' => [
                        'actions' => [
                            [
                                'targetName' => 'index = deleteConfirm',
                                'actionName' => 'toggleModal',
                            ],
                        ],
                    ],
                ],
            ],
            'on_click'   => sprintf(
                "deleteConfirm('%s', '%s', {data: {}})",
                __('Are you sure you want to delete this store?'),
                $deleteUrl
            ),
            'sort_order' => 20,
        ];
    }

    private function getStoreId(): ?int
    {
        $storeId = $this->context->getRequest()->getParam('store_id');

        return $storeId ? (int) $storeId : null;
    }
}
