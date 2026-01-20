<?php
namespace KiwiCommerce\Testimonials\Service;

use KiwiCommerce\Testimonials\Model\TestimonialFactory;
use KiwiCommerce\Testimonials\Model\ResourceModel\Testimonial as TestimonialResource;

class imoporttestimonials
{
    protected $testimonialFactory;
    protected $testimonialResource;

    public function __construct(
        TestimonialFactory $testimonialFactory,
        TestimonialResource $testimonialResource
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialResource = $testimonialResource;
    }

    /**
     * Import testimonials from CSV file
     *
     * @param string $filePath
     * @return int
     * @throws \Exception
     */
  public function importFromCsv($filePath)
{
    if (!file_exists($filePath)) {
        throw new \Exception('CSV file not found at given path.');
    }

    $handle = fopen($filePath, 'r');
    if ($handle === false) {
        throw new \Exception('Unable to open CSV file.');
    }

    $header = fgetcsv($handle);
    if (!$header) {
        throw new \Exception('CSV header missing.');
    }

    $imported = 0;
    $rowNumber = 1;

    while (($row = fgetcsv($handle)) !== false) {
        $rowNumber++;

        if (count($row) === 1 && empty($row[0])) {
            continue;
        }

        if (count($header) !== count($row)) {
            throw new \Exception(
                'CSV column mismatch at row ' . $rowNumber
            );
        }

        $data = array_combine($header, $row);

        if (empty($data['company_name'])) {
            throw new \Exception(
                'Company Name is required at row ' . $rowNumber
            );
        }

        if (empty($data['name'])) {
            throw new \Exception(
                'Name is required at row ' . $rowNumber
            );
        }

        if (!isset($data['status'])) {
            throw new \Exception(
                'Status is required at row ' . $rowNumber
            );
        }

        $testimonial = $this->testimonialFactory->create();
        $testimonial->setCompanyName(trim($data['company_name']));
        $testimonial->setName(trim($data['name']));
        $testimonial->setMessage($data['message'] ?? '');
        $testimonial->setPost($data['post'] ?? '');
        $testimonial->setProfilePic($data['profile_pic'] ?? '');
        $testimonial->setStatus((int)$data['status']);

        $this->testimonialResource->save($testimonial);
        $imported++;
    }

    fclose($handle);
    return $imported;
}

}
