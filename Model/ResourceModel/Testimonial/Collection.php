<?php
namespace KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use KiwiCommerce\Testimonials\Model\Testimonial as Model;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'testimonial_id';
    protected $_eventPrefix = 'testimonial_collection';
    protected $_eventObject = 'testimonial_collection';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
