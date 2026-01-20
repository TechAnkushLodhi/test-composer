<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;

class Index extends Action
{   
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::list';
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('KiwiCommerce_Testimonials::main');
        $resultPage->getConfig()->getTitle()->prepend(__('Testimonials'));
        return $resultPage;
    }
}
