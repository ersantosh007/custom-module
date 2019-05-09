<?php


namespace Bluethink\Actionlog\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Success')], ['value' => 0, 'label' => __('Logout')]];
    }
}
