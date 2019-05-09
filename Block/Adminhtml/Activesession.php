<?php
namespace Bluethink\Actionlog\Block\Adminhtml;
class Activesession extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        
        $this->_controller = 'adminhtml_activesession';
        $this->_blockGroup = 'Bluethink_Actionlog';
        $this->_headerText = __('Brand');
        parent::_construct();
        $this->removeButton('add');
        
    }
}
