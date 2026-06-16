<?php

declare(strict_types=1);

namespace Etechflow\StoreLocator\Controller\Adminhtml\Store;

use Exception;
use Etechflow\StoreLocator\Model\StoreFactory;
use Etechflow\StoreLocator\Model\ResourceModel\Store as StoreResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Etechflow_StoreLocator::stores';

    public function __construct(
        Context $context,
        private readonly StoreFactory $storeFactory,
        private readonly StoreResource $storeResource
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $storeId = (int) $this->getRequest()->getParam('store_id');

        if (!$storeId) {
            $this->messageManager->addErrorMessage(__('We can\'t find a store to delete.'));
            return $resultRedirect->setPath('*/*/index');
        }

        $store = $this->storeFactory->create();
        $this->storeResource->load($store, $storeId);

        if (!$store->getId()) {
            $this->messageManager->addErrorMessage(__('This store no longer exists.'));
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $this->storeResource->delete($store);
            $this->messageManager->addSuccessMessage(__('The store has been deleted.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
