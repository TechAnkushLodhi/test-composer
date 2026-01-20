<?php
namespace KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial;

class NewAction extends \KiwiCommerce\Testimonials\Controller\Adminhtml\Testimonial\Edit
{
    const ADMIN_RESOURCE = 'KiwiCommerce_Testimonials::create';

    public function execute()
    {
        $this->_forward('edit');
    }
}
