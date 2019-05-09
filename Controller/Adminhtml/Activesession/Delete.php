<?php

namespace Bluethink\Actionlog\Controller\Adminhtml\Activesession;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bluethink_Actionlog::activesession_delete';

    /**
     * Delete Actionlog Actionlog
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
       //check if we know what should be deleted
        $activesession_id = $this->getRequest()->getParam('activesession_id');
    
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
       if ($activesession_id && (int) $activesession_id > 0) {
            $username = '';
            try {
                 // init model and delete
                 $model = $this->_objectManager->create('Bluethink\Actionlog\Model\Activesession');
                 $category = $model->load($activesession_id);

                 if ($category->getActivesessionId()) {
                      $username = $model->getUserName();
                      $model->delete();
                      $this->messageManager->addSuccess(__('The "'.$username.'" Activesession has been deleted.'));
                      return $resultRedirect->setPath('*/*/');
                 }
             } catch (\Exception $e) {
                 // display error message
                 $this->messageManager->addError($e->getMessage());
                 // go back to edit form
                 return $resultRedirect->setPath('*/*/edit', ['activesession_id' => $activesession_id]);
             }
        }
         // display error message
         $this->messageManager->addError(__('Activesession to delete was not found.'));
         // go to grid
         return $resultRedirect->setPath('*/*/');
    }
}
