<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use KiwiCommerce\Testimonials\Model\TestimonialRepository;
use KiwiCommerce\Testimonials\Api\Data\TestimonialInterface;

class InlineEdit extends Action
{
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::inlineEdit';

    protected $testimonialRepository;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        TestimonialRepository $testimonialRepository,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->testimonialRepository = $testimonialRepository;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $error = false;
        $messages = [];

        try {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
                return $resultJson->setData([
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]);
            }

            foreach (array_keys($postItems) as $testimonialId) {
                try {
                    $testimonial = $this->testimonialRepository->getById($testimonialId);
                    $testimonialData = $postItems[$testimonialId];
                    
                    foreach ($testimonialData as $key => $value) {
                        $testimonial->setData($key, $value);
                    }
                    
                    $this->testimonialRepository->save($testimonial);
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $messages[] = $this->getErrorWithTestimonialId($testimonialId, $e->getMessage());
                    $error = true;
                } catch (\RuntimeException $e) {
                    $messages[] = $this->getErrorWithTestimonialId($testimonialId, $e->getMessage());
                    $error = true;
                } catch (\Exception $e) {
                    $messages[] = $this->getErrorWithTestimonialId(
                        $testimonialId,
                        __('Something went wrong while saving the Testimonial: %1', $e->getMessage())
                    );
                    $error = true;
                }
            }
        } catch (\Exception $e) {
            $messages[] = __('An error occurred while processing the request: %1', $e->getMessage());
            $error = true;
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithTestimonialId($testimonialId, $errorText)
    {
        return '[ID: ' . $testimonialId . '] ' . $errorText;
    }
}
