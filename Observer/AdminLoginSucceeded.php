<?php

namespace Bluethink\Actionlog\Observer; 
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Bluethink\Actionlog\Helper\Time as TimeHelper; 
use Bluethink\Actionlog\Model\Activesession as ActivesessionModel;
use Bluethink\Actionlog\Model\Loginattempt as LoginattemptModel;
use Bluethink\Actionlog\Model\Visithistory as VisithistoryModel;
class AdminLoginSucceeded implements ObserverInterface
{
     /**
     * @var \Bluethink\Actionlog\Helper\Time
     */
    protected $_timeHelper;
    /**
     * @var \Bluethink\Actionlog\Model\Activesession
    */
    protected $_activesessionModel;
    /**
     * @var \Bluethink\Actionlog\Model\Loginattempt
    */
    protected $_loginattemptModel;
    /**
     * @var \Bluethink\Actionlog\Model\Visithistory
    */
    protected $_visithistoryModel;
    /**
     * @var RequestInterface
     */
     protected $_request;
    /**
     * @var \Magento\Backend\Model\Auth\Session
    */
     protected $authSession;
    /**
     * @var \Magento\Customer\Model\Session
    */
     protected $customerSession;
    /**
     * @var \Magento\Framework\Session\SessionManager
    */
     protected $sessionManager;
    /**
     * @param RequestInterface $request
     * @param TimeHelper $timeHelper
     * @param ActivesessionModel $activesessionModel
     * @param LoginattemptModel $loginattemptModel
     * @param VisithistoryModel $visithistoryModel
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Session\SessionManager $sessionManager,
        TimeHelper $timeHelper, 
        ActivesessionModel $activesessionModel,
        LoginattemptModel $loginattemptModel,
        VisithistoryModel $visithistoryModel,
        RequestInterface $request
    ) {
        $this->authSession         = $authSession;
        $this->customerSession     = $customerSession;
        $this->sessionManager      = $sessionManager;
        $this->_timeHelper         = $timeHelper;
        $this->_activesessionModel = $activesessionModel;
        $this->_loginattemptModel  = $loginattemptModel;
        $this->_visithistoryModel  = $visithistoryModel;
        $this->_request            = $request;
    }
 
    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data             = $this->authSession->getUser();
        if($data['is_active'] == 1)
        {
            $is_active = "Just Now";
        }
        /*Here Updateing ActivesessionModel */
        $ua                          = $this->getBrowsername();
        $yourbrowser                 = "".$ua['name']." ".$ua['version'] ." on " .$ua['platform']."";
        $ActivesessionModel          = $this->_activesessionModel;
        $ActivesessionModel->setUserName($data['username']);
        $ActivesessionModel->setFullName($data['firstname']." ".$data['lastname']);
        $ActivesessionModel->setLoggedAt($data['logdate']);
        $ActivesessionModel->setIpAddress($this->getIp());
        $ActivesessionModel->setRecentActivity($is_active);
        $ActivesessionModel->setActiveUserId($data['user_id']);
        $ActivesessionModel->setForLoginFilter(1);
        $ActivesessionModel->setUserAgent($yourbrowser);
        $ActivesessionModel->setActiveSession($this->sessionManager->getSessionId());
        $ActivesessionModel->save();  
        /* End ActivesessionModel */
        
        /*Here Updateing LoginattemptModel */
        $LoginattemptModel          = $this->_loginattemptModel;
        $LoginattemptModel->setUserName($data['username']);
        $LoginattemptModel->setFullName($data['firstname']." ".$data['lastname']);
        $LoginattemptModel->setLoggAttempt($data['logdate']);
        $LoginattemptModel->setIpAddress($this->getIp());
        $LoginattemptModel->setActiveUserId($data['user_id']);
        $LoginattemptModel->setForLoginFilter(1);
        $LoginattemptModel->setUserAgent($yourbrowser);
        $LoginattemptModel->setStatus(1);
        $LoginattemptModel->setActiveSession($this->sessionManager->getSessionId());
        $LoginattemptModel->save();  
        /* End LoginattemptModel */

        /*Here Updateing VisithistoryModel */
        $VisithistoryModel            = $this->_visithistoryModel;
        $VisithistoryModel->setUserName($data['username']);
        $VisithistoryModel->setFullName($data['firstname']." ".$data['lastname']);
        $VisithistoryModel->setSessionStart($data['logdate']);
        $VisithistoryModel->setIpAddress($this->getIp());
        $VisithistoryModel->setRandomNumber($this->sessionManager->getSessionId());
        $VisithistoryModel->setUserId($data['user_id']);
        $VisithistoryModel->save(); 
         //here set random variable
        $this->customerSession->setRandomValue($this->sessionManager->getSessionId());
    }

      public function getIp()
     {
        return $this->_timeHelper->get_client_ip();
     } 

      public function getBrowsername()
     {
        return $this->_timeHelper->getBrowser();
     } 
   
} 

?>
