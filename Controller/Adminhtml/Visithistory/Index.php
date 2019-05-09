<?php


namespace Bluethink\Actionlog\Controller\Adminhtml\Visithistory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    /**
     * FAQ Categories Manager Page
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->addBreadcrumb(
            'Admin Visithistory Manager',
            'Admin Visithistory Manager'
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Visithistory'));
        $resultPage->getConfig()->getTitle()
            ->prepend('Admin Visithistory Manager');
        return $resultPage;
    }
}
