<?php
namespace KiwiCommerce\Testimonials\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KiwiCommerce\Testimonials\Service\imoporttestimonials;

class ImportTestimonials extends Command
{
    protected $importTestimonials;

    public function __construct(
        imoporttestimonials $importTestimonials, 
        string $name = null
    ) {
        $this->importTestimonials = $importTestimonials;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('kiwicommerce:importtestimonials')
            ->setDescription('Import testimonials from source.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            $filePath = BP . '/var/import/testimonials_import.csv';
            try {
                $count = $this->importTestimonials->importFromCsv($filePath);
                $output->writeln("<info>{$count} testimonials imported successfully.</info>");
            } catch (\Exception $e) {
                $output->writeln("<error>{$e->getMessage()}</error>");
            }

            return Command::SUCCESS;
    }
}
