<?php
namespace KiwiCommerce\Testimonials\Model\Testimonial;

use Magento\Ui\DataProvider\AbstractDataProvider;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    protected $dataPersistor;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection    = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager  = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        foreach ($this->collection->getItems() as $testimonial) {
            $data = $testimonial->getData();


              if (isset($data['profile_pic']) && !empty($data['profile_pic'])) {
                $image = [];
                $image[0]['name'] = $data['profile_pic'];
                $image[0]['url'] = $this->getMediaUrl($data['profile_pic']);
                $data['profile_pic'] = $image;
            }



            $this->loadedData[$testimonial->getId()] = $data; 
        }

        $data = $this->dataPersistor->get('kiwicommerce_testimonial');
        if (!empty($data)) {
            $testimonial = $this->collection->getNewEmptyItem();
            $testimonial->setData($data);

             if (isset($data['profile_pic']) && !empty($data['profile_pic'])) {
                $image = [];
                $image[0]['name'] = $data['profile_pic'];
                $image[0]['url'] = $this->getMediaUrl($data['profile_pic']);
                $data['profile_pic'] = $image;
            }

            $id = $testimonial->getId() ?: 'new';
            $this->loadedData[$id]['data'] = $testimonial->getData(); 
            $this->dataPersistor->clear('kiwicommerce_testimonial');
        }
        

        return $this->loadedData;
    }

    protected function getMediaUrl($imageName)
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'form/images/' . $imageName;
    }

}
