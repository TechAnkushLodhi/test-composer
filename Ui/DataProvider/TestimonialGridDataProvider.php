<?php
namespace KiwiCommerce\Testimonials\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;

class TestimonialGridDataProvider extends AbstractDataProvider
{
    /**
     * @var \KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\Collection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Return Data for UI Component grid
     *
     * @return array
     */
    public function getData()
    {
        $items = $this->collection->toArray();
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => $items['items'] ?? []
        ];
    }
}
