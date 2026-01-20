<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::massaction';

    protected $filter;
    protected $collectionFactory;

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
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            $collection = $this->filter->getCollection(
                $this->collectionFactory->create()
            );

            $deleted = 0;
            foreach ($collection as $item) {
                $item->delete();
                $deleted++;
            }

            if ($deleted) {
                $this->messageManager->addSuccessMessage(
                    __('%1 testimonial(s) deleted successfully.', $deleted)
                );
            } else {
                $this->messageManager->addNoticeMessage(__('No records deleted.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
