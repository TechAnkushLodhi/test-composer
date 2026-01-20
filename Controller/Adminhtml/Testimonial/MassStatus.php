<?php

namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassStatus extends Action
{
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::massaction';
    protected Filter $filter;
    protected CollectionFactory $collectionFactory;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );

        if (!$collection->getSize()) {
            $this->messageManager->addErrorMessage(__('No records selected.'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                ->setPath('*/*/');
        }

        $updated = 0;

        foreach ($collection as $item) {
            $currentStatus = (int) $item->getStatus();
            $newStatus = $currentStatus === 1 ? 0 : 1;

            $item->setStatus($newStatus);
            $item->save();
            $updated++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been updated.', $updated)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }

}
