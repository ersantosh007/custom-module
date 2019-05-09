<?php
 
namespace Bluethink\Actionlog\Controller\Adminhtml\Auth;
 
class Logout extends \Magento\Backend\Controller\Adminhtml\Auth
{    
     /**
     * Administrator logout action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        
        $objectManager    = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession  = $objectManager->create('Magento\Customer\Model\Session');
        //here get random variable
        $randomvariable   = $customerSession->getRandomValue();

        $resource         = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection       = $resource->getConnection();
        $objDate          = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
        $date             = $objDate->gmtDate();
        $tableName        = $resource->getTableName('bluethink_visithistory');
        $sql              = "UPDATE ".$tableName." SET session_end='".$date."' WHERE random_number ='".$randomvariable."'";
        $connection->query($sql);

        $sessionObj       = $objectManager->get('\Magento\Framework\Session\SessionManager');
        $No_0             = 0;
        $tableName1       = $resource->getTableName('bluethink_activesession');
        $sql1             = "UPDATE ".$tableName1." SET for_login_filter='".$No_0."' WHERE active_session ='".$sessionObj->getSessionId()."'";
        $connection->query($sql1);

        $_Status0         = 0;
        $tableName2       = $resource->getTableName('bluethink_loginattempt');
        $sql2             = "UPDATE ".$tableName2." SET status='".$_Status0."' WHERE active_session ='".$sessionObj->getSessionId()."'";
        $connection->query($sql2);


        $this->_auth->logout();
        $this->messageManager->addSuccess(__('You have logged out.'));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath($this->_helper->getHomePageUrl());
    }
}
?>