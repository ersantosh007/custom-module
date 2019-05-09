<?php

namespace Bluethink\Actionlog\Controller\Adminhtml\Actionlog;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bluethink_Actionlog::actionlog_delete';

    /**
     * Delete Actionlog Actionlog
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
       //check if we know what should be deleted
        $actionlog_id = $this->getRequest()->getParam('actionlog_id');
    
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
       if ($actionlog_id && (int) $actionlog_id > 0) {
            $username = '';
            try {
                 // init model and delete
                 $model = $this->_objectManager->create('Bluethink\Actionlog\Model\Actionlog');
                 $category = $model->load($actionlog_id);

                 if ($category->getActionlogId()) {
                      $username = $model->getUserName();
                      $model->delete();
                      $this->messageManager->addSuccess(__('The "'.$username.'" Actionlog has been deleted.'));
                      return $resultRedirect->setPath('*/*/');
                 }
             } catch (\Exception $e) {
                 // display error message
                 $this->messageManager->addError($e->getMessage());
                 // go back to edit form
                 return $resultRedirect->setPath('*/*/edit', ['actionlog_id' => $actionlog_id]);
             }
        }
         // display error message
         $this->messageManager->addError(__('Actionlog to delete was not found.'));
         // go to grid
         return $resultRedirect->setPath('*/*/');
    }
}
