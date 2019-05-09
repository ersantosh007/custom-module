<?php

namespace Bluethink\Actionlog\Helper;

/**
 * Bluethink time helper
 * @category    Bluethink
 */
class Santosh extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
    */
    protected $_timezoneInterface;
 
    /**
    * @param \Magento\Framework\App\Helper\Context $context
    * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        //time zone interface 
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    ) 
    {
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }
}