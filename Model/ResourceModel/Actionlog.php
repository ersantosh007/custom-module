<?php
/**
 * Copyright © 2015 Bluethink. All rights reserved.
 */
namespace Bluethink\Actionlog\Model\ResourceModel;

/**
 * Actionlog resource
 */
class Actionlog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('bluethink_actionlog', 'actionlog_id');
    }

  
}
