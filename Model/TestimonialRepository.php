<?php
namespace KiwiCommerce\Testimonials\Model;

use KiwiCommerce\Testimonials\Api\TestimonialRepositoryInterface;
use KiwiCommerce\Testimonials\Api\Data\TestimonialInterface;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial as ResourceModel;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resource;

    /**
     * @var TestimonialFactory
     */
    private $testimonialFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        ResourceModel $resource,
        TestimonialFactory $testimonialFactory,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    
    public function save(TestimonialInterface $testimonial)
    {
        $this->resource->save($testimonial);
        return $testimonial;
    }

   
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialFactory->create();
        $this->resource->load($testimonial, $testimonialId);

        if (!$testimonial->getId()) {
            throw new NoSuchEntityException(__('Testimonial not found.'));
        }

        return $testimonial;
    }

   
    public function delete(TestimonialInterface $testimonial)
    {
        $this->resource->delete($testimonial);
        return true;
    }

    
    public function deleteById($testimonialId)
    {
        return $this->delete($this->getById($testimonialId));
    }

   
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        $collection = $this->collectionFactory->create();

        if ($searchCriteria !== null) {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        $items = [];
        foreach ($collection->getItems() as $testimonial) {
            $items[] = $testimonial->getData(); // convert model to array
        }

        $searchResults->setItems($items);

        return $searchResults;
    }

}
