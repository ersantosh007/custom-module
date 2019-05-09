<?php
namespace Bluethink\Actionlog\Controller\Adminhtml\Visithistory;
class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bluethink_Actionlog::visithistory_delete';

    /**
     * Delete Actionlog Visithistory
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
    
        
        //check if we know what should be deleted
        $visithistory_id = $this->getRequest()->getParam('visithistory_id');
    
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
       if ($visithistory_id && (int) $visithistory_id > 0) {
            $username = '';
            try {
                 // init model and delete
                 $model = $this->_objectManager->create('Bluethink\Actionlog\Model\Visithistory');
                 $category = $model->load($visithistory_id);

                 if ($category->getVisithistoryId()) {
                      $username = $model->getUserName();
                      $model->delete();
                      $this->messageManager->addSuccess(__('The "'.$username.'" Visithistory has been deleted.'));
                      return $resultRedirect->setPath('*/*/');
                 }
             } catch (\Exception $e) {
                 // display error message
                 $this->messageManager->addError($e->getMessage());
                 // go back to edit form
                 return $resultRedirect->setPath('*/*/edit', ['visithistory_id' => $visithistory_id]);
             }
        }
         // display error message
         $this->messageManager->addError(__('Visithistory to delete was not found.'));
         // go to grid
         return $resultRedirect->setPath('*/*/');
    }
}
