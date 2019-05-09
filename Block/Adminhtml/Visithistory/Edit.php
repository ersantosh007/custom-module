<?php
namespace Bluethink\Actionlog\Block\Adminhtml\Visithistory;
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
        $this->_objectId = 'visithistory_id';
        $this->_blockGroup = 'Bluethink_Actionlog';
        $this->_controller = 'adminhtml_visithistory';

        parent::_construct();

        //$this->buttonList->update('save', 'label', __('Save Block'));
        //$this->buttonList->update('delete', 'label', __('Delete Block'));

        // $this->buttonList->add(
        //     'saveandcontinue',
        //     array(
        //         'label' => __('Save and Continue Edit'),
        //         'class' => 'save',
        //         'data_attribute' => array(
        //             'mage-init' => array('button' => array('event' => 'saveAndContinueEdit', 'target' => '#edit_form'))
        //         )
        //     ),
        //     -100
        // );
      // $this->_removeButton('save');
       //$this->_removeButton('delete');
    //$this->_removeButton('reset');
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'hello_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'hello_content');
                }
            }
        ";
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('checkmodule_checkmodel')->getId()) {
            return __("Edit Item '%1'", $this->escapeHtml($this->_coreRegistry->registry('checkmodule_checkmodel')->getTitle()));
        } else {
            return __('New Item');
        }
    }
}
