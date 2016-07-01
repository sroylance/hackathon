<?php
namespace cimpress\sdrtest\Controller\Adminhtml\Import;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface; // Needed to retrieve config values

require_once('CimpressApi.php');
use Cimpress\PortalApi;

class Save extends \Magento\Backend\App\Action
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
        $this->APIClient = new PortalApi($this->scopeConfig->getValue('sdrtest/general/refreshtoken'));
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        var_dump($this->getRequest()->getParams());
    }
}