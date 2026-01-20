<?php
namespace KiwiCommerce\Testimonials\Block;

use Magento\Framework\View\Element\Template;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class Testimonials extends Template
{
    protected $collectionFactory;
    protected $storeManager;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getTestimonials()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', 1); 
        $collection->setOrder('created_at', 'DESC');
        return $collection;
    }

    public function getImageUrl($fileName)
    {
        if (!$fileName) {
            return '';
        }
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl . 'form/images/' . $fileName; // yaha 'form/images' same hai jo ImageUploader me set hai
    }

}
