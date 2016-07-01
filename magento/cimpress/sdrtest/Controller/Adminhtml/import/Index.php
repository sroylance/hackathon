<?php
namespace cimpress\sdrtest\Controller\Adminhtml\Import;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface; // Needed to retrieve config values

require_once('CimpressApi.php');

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig // Needed to retrieve config values
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig; // Needed to retrieve config values
        $this->APIClient = new Cimpress\PortalApi($this->scopeConfig->getValue('sdrtest/general/refreshtoken'));
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('cimpress_sdrtest::mcp_import');
        $resultPage->addBreadcrumb(__('mcp'), __('mcp'));
        $resultPage->addBreadcrumb(__('MCP import'), __('MCP import'));
        $resultPage->getConfig()->getTitle()->prepend(__('MCP product import'));

        $cfg_token = $this->scopeConfig->getValue('sdrtest/general/refreshtoken');


        $resultPage->getLayout()->getBlock('Test')->setStuff(['a','b','c', $cfg_token]);
        echo $this->getVcsProducts();

        return $resultPage;
    }
}