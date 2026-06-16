<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Controller\Adminhtml\Store;

use Etechflow\StoreLocator\Model\StoreFactory;
use Etechflow\StoreLocator\Model\ResourceModel\Store as StoreResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Etechflow_StoreLocator::stores';

    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly StoreFactory $storeFactory,
        private readonly StoreResource $storeResource
    ) {
        parent::__construct($context);
    }

    public function execute(): Page
    {
        $storeId = (int) $this->getRequest()->getParam('store_id');

        $resultPage = $this->resultPageFactory->create();

        if ($storeId) {
            $store = $this->storeFactory->create();
            $this->storeResource->load($store, $storeId);

            if (!$store->getId()) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                $resultPage->getConfig()->getTitle()->prepend(__('New Store'));
                return $resultPage;
            }

            $resultPage->getConfig()->getTitle()->prepend(
                __('Edit Store: %1', $store->getName())
            );
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Store'));
        }

        return $resultPage;
    }
}
