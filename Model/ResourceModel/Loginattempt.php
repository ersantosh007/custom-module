<?php
/**
 * Copyright © 2015 Bluethink. All rights reserved.
 */
namespace Bluethink\Actionlog\Model\ResourceModel;

/**
 * Actionlog resource
 */
class Loginattempt extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('bluethink_loginattempt', 'loginattempt_id');
    }

  
}
