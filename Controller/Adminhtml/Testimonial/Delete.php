<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use KiwiCommerce\Testimonials\Model\TestimonialFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::delete';
    private TestimonialFactory $factory; 

    public function __construct(
        Action\Context $context,
        TestimonialFactory $factory
    ) {
        parent::__construct($context);
        $this->factory = $factory; 
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('testimonial_id');

        if ($id) {
            try {
                $model = $this->factory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Testimonial deleted successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('Testimonial ID is missing.'));
        }

        return $this->_redirect('*/*/');
    }
}

