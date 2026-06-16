<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class StoreActions extends Column
{
    private const URL_PATH_EDIT   = 'etechflow_storelocator/store/edit';
    private const URL_PATH_DELETE = 'etechflow_storelocator/store/delete';

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        private readonly Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['store_id'])) {
                continue;
            }

            $storeName = $this->escaper->escapeHtml($item['name'] ?? '');

            $item[$this->getData('name')] = [
                'edit' => [
                    'href'  => $this->urlBuilder->getUrl(
                        self::URL_PATH_EDIT,
                        ['store_id' => $item['store_id']]
                    ),
                    'label' => __('Edit'),
                ],
                'delete' => [
                    'href'    => $this->urlBuilder->getUrl(
                        self::URL_PATH_DELETE,
                        ['store_id' => $item['store_id']]
                    ),
                    'label'   => __('Delete'),
                    'confirm' => [
                        'title'   => __('Delete "%1"', $storeName),
                        'message' => __('Are you sure you want to delete the store "%1"?', $storeName),
                    ],
                    'post' => true,
                ],
            ];
        }

        return $dataSource;
    }
}
