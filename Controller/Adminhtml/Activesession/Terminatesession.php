<?php


namespace Bluethink\Actionlog\Controller\Adminhtml\Activesession;

use Magento\Backend\App\Action;

class Terminatesession extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bluethink_Actionlog::activesession_terminatesession';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bluethink_Actionlog::actionlogs');
        return $resultPage;
    }

    /**
     * Edit FAQ Category page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $activesession_id = $this->getRequest()->getParam('activesession_id');
        $objectManager    = \Magento\Framework\App\ObjectManager::getInstance();
        $resource         = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection       = $resource->getConnection();
        try {
            $tableName        = $resource->getTableName('bluethink_activesession');
            $sql              = "Select * FROM " . $tableName." Where activesession_id    = ".$activesession_id ."";
            $result           = $connection->fetchAll($sql);
            $active_user_id   = $result[0]['active_user_id'];
            $session_id       = $result[0]['active_session'];
            $this->destroy_third_party_session($session_id);
            $No_0             = 0;
            $sql              = "UPDATE ".$tableName." SET for_login_filter='".$No_0."' WHERE active_session ='".$session_id."'";
            $connection->query($sql);
            $this->messageManager->addSuccess(__('The Activesession "'.$active_user_id.'" has been terminated successfully.'));
        }catch (\Exception $e) 
        {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('actionlog/activesession/index');  
    }
    function destroy_third_party_session($in_session_id)
   {
      session_id($in_session_id);
      session_destroy();
      session_commit();
   }
}
