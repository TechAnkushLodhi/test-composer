<?php
namespace KiwiCommerce\Testimonials\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_ENABLED, 'label' => __('Enabled')],
            ['value' => self::STATUS_DISABLED, 'label' => __('Disabled')]
        ];
    }
}
