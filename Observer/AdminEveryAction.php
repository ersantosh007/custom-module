<?php

namespace Bluethink\Actionlog\Observer; 
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Bluethink\Actionlog\Model\Visitlisting as VisitlistingModel;
class AdminEveryAction implements ObserverInterface 
{
    /**
     * @var RequestInterface
     */
    protected $_request;
    
    /**
     * @param RequestInterface $request
     */
     /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;
     /**
     * @var \Magento\Backend\Model\Auth\Session
    */
     protected $authSession;
     /**
     * @var \Bluethink\Actionlog\Model\Visitlisting
    */
     protected $_visitlistingModel;
     /**
     * @var Magento\Framework\App\Request\Http
    */
     protected $_http;
      /**
     * @var Magento\Store\Model\StoreManagerInterface
    */
     protected $_storeManagerInterface;
    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
       protected $_customerSession;
    /**
     * @param VisitlistingModel $visitlistingModel
     */



   public function __construct(
        RequestInterface $request,
        \Magento\Framework\App\Request\Http $http,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
         VisitlistingModel $visitlistingModel,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    ) {
        $this->_request                  = $request;
        $this->authSession               = $authSession;
        $this->_http                     = $http;
        $this->_visitlistingModel        = $visitlistingModel;
        $this->_customerSession          = $customerSession;
        $this->_storeManagerInterface    = $storeManagerInterface;
        $this->redirect                  = $redirect;
    }

   /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
       
        $objectManager         =  \Magento\Framework\App\ObjectManager::getInstance();
        $objDate               =  $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
       
        $_magentodate          =  $objDate->gmtDate();
        $sessionObj            =  $objectManager->get('\Magento\Framework\Session\SessionManager');
        $resource              =  $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection            =  $resource->getConnection();
        $data                  =  $this->authSession->getUser();
        $store                 =  $this->_storeManagerInterface->getStore();
        //$getCurrentUrl         =  $store->getCurrentUrl();

        $storeManager          =  $objectManager->get('Magento\Framework\UrlInterface');
        $getCurrentUrl         =  $storeManager->getCurrentUrl();
        $prevUrl               =  $this->_http->getServer('HTTP_REFERER');

        $sql                   = "SELECT page_url FROM bluethink_visitlisting ORDER BY visitlisting_id DESC LIMIT 1";
        $lastVisitedUrl        = '';
        if (count($connection->fetchAll($sql)) > 0) 
        {
           $lastVisitedUrl     = $connection->fetchAll($sql)['0']['page_url'];
        }
       

        if (stripos($getCurrentUrl, "mui") === false && stripos($getCurrentUrl, "admin/admin/index/") === false  && $getCurrentUrl != $lastVisitedUrl) 
        {

            
            $model             =  $this->_visitlistingModel;
            $model->setModuleName($this->_http->getModuleName());
            $model->setControllerName($this->_http->getControllerName());
            $model->setActionName($this->_http->getActionName());
            $model->setPageUrl($getCurrentUrl);
            $model->setPageInTime($_magentodate);
            $model->setUserId($data['user_id']);
            $model->setSessionId($sessionObj->getSessionId());
            $model->save();
            $lastInsertedId  = $model->getVisitlistingId();


            if(stripos($prevUrl, "admin/admin/index/") == false)
            {
               $sqlQuery= "SELECT page_in_time FROM bluethink_visitlisting where page_url='".$prevUrl."' ORDER BY visitlisting_id DESC LIMIT 1";
               $lastVisitedUrlTime ='';

                if (count($connection->fetchAll($sqlQuery)) > 0) 
                {
                   $lastVisitedUrlTime = $connection->fetchAll($sqlQuery)['0']['page_in_time'];
                }

                if(strtotime($lastVisitedUrlTime)!='')
                {
                    $dteStart = new \DateTime($lastVisitedUrlTime);
                    $dteEnd   = new \DateTime($_magentodate);
                    $dteDiff  = $dteStart->diff($dteEnd);
                    $stayTime = $dteDiff->format("%H:%I:%S");
            
                    $Updatequery      = "UPDATE bluethink_visitlisting SET page_out_time='".$No_0."' WHERE active_session ='".$sessionObj->getSessionId()."'";
                    $connection->query($Updatequery);
                    // $strtimediff=strtotime($lastVisitedUrlTime)-strtotime($_magentodate);
                    // $stayTime=date('h:i:s',$strtimediff);
             
                }

            }
            
        }
    }   
        
}
