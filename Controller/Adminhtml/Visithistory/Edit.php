<?php


namespace Bluethink\Actionlog\Controller\Adminhtml\Visithistory;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bluethink_Actionlog::visithistory_edit';

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
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
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
        // Get ID and create model
        $id    = $this->getRequest()->getParam('visithistory_id');
        $model = $this->_objectManager->create('Bluethink\Actionlog\Model\Visithistory');
        $model->setData([]);
        // Initial checking
        if ($id && (int) $id > 0) {
            $model->load($id);
            if (!$model->getVisithistoryId()) {
                $this->messageManager->addError(__('This Actionlog no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $title = $model->getTitle();
        }

        $FormData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($FormData)) {
            $model->setData($FormData);
        }

        $this->_coreRegistry->register('bluethink_visithistory', $model);

        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Visithistory') : __('New Category'),
            $id ? __('Edit Visithistory') : __('New Category')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Visithistory Manager'));
        $resultPage->getConfig()->getTitle()
            ->prepend($id ? 'Edit(Visit History): '.$title.' ('.$id.')' : __('New Visithistory'));

        return $resultPage;
    }
}
