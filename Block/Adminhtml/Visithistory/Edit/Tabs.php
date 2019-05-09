<?php

namespace Bluethink\Actionlog\Block\Adminhtml\Visithistory\Edit;
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('checkmodule_visithistory_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Visit History Details'));
    }

    
}
