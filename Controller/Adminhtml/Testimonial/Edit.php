<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use KiwiCommerce\Testimonials\Model\TestimonialFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
   const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::edit';



    protected $resultPageFactory;
    protected $testimonialFactory;
    protected $_registry;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        TestimonialFactory $testimonialFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->testimonialFactory = $testimonialFactory;
        $this->_registry = $registry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('testimonial_id');
        $model = $this->testimonialFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This testimonial no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $this->_registry->register('testimonial', $model);

        $resultPage = $this->resultPageFactory->create();
        $title = $id ? __('Edit Testimonial %1', $model->getName()) : __('Add New Testimonial');
        $resultPage->setActiveMenu('KiwiCommerce_Testimonials::main');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
