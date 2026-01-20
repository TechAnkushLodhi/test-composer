<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use KiwiCommerce\Testimonials\Model\TestimonialFactory;
use KiwiCommerce\Testimonials\Model\ImageUploader\ImageUploader as ImageUploader;

class Save extends Action
{
   const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::save';
    private $factory;
    private $imageUploader;

    public function __construct(
        Action\Context $context,
        TestimonialFactory $factory,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->factory = $factory;
        $this->imageUploader = $imageUploader;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data found to save.'));
            return $this->_redirect('*/*/');
        }

        try {
            $model = $this->factory->create();


                if (isset($data['profile_pic'][0]['name'])) {
                $fileName = $this->imageUploader->moveFileFromTmp($data['profile_pic'][0]['name']);
                $data['profile_pic'] = $fileName;
                } elseif (isset($data['profile_pic'][0]['file'])) {
                    $data['profile_pic'] = $data['profile_pic'][0]['file'];
                } else {
                    $data['profile_pic'] = null;
                }

            $model->setData($data);
            $model->save();

            $this->messageManager->addSuccessMessage(__('Testimonial saved successfully.'));
             $back = $this->getRequest()->getParam('back');
             if ($back === 'edit') {
                return $this->_redirect('*/*/edit', ['testimonial_id' => $model->getId()]);
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('*/*/edit', ['testimonial_id' => $this->getRequest()->getParam('testimonial_id')]);
        }

        return $this->_redirect('*/*/');
    }
}
