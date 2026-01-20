<?php
namespace KiwiCommerce\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;
use KiwiCommerce\Testimonials\Api\Data\TestimonialInterface;

class Testimonial extends AbstractModel implements TestimonialInterface
{
    protected function _construct()
    {
        $this->_init(\KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial::class);
    }

    public function getTestimonialId()
    {
        return $this->getData(self::TESTIMONIAL_ID);
    }

    public function setTestimonialId($id)
    {
        return $this->setData(self::TESTIMONIAL_ID, $id);
    }

    public function getCompanyName()
    {
        return $this->getData(self::COMPANY_NAME);
    }

    public function setCompanyName($companyName)
    {
        return $this->setData(self::COMPANY_NAME, $companyName);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    public function getPost()
    {
        return $this->getData(self::POST);
    }

    public function setPost($post)
    {
        return $this->setData(self::POST, $post);
    }

    public function getProfilePic()
    {
        return $this->getData(self::PROFILE_PIC);
    }

    public function setProfilePic($profilePic)
    {
        return $this->setData(self::PROFILE_PIC, $profilePic);
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
}
