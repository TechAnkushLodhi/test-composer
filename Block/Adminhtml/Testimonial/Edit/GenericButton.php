<?php
namespace KiwiCommerce\Testimonials\Block\Adminhtml\Testimonial\Edit;

use Magento\Backend\Block\Widget\Context;
use KiwiCommerce\Testimonials\Api\TestimonialRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
    protected $testimonialRepository;

    public function __construct(
        Context $context,
        TestimonialRepositoryInterface $testimonialRepository
    ) {
        $this->context = $context;
        $this->testimonialRepository = $testimonialRepository;
    }

    public function getId()
    {
        try {
            $testimonial = $this->testimonialRepository->getById(
                $this->context->getRequest()->getParam('testimonial_id')
            );
            return $testimonial->getTestimonialId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
