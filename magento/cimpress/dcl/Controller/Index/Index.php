<?php
namespace cimpress\dcl\Controller\Adminhtml\Import;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface; // Needed to retrieve config values

class Index extends \Magento\Framework\App\Action\Action
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
        #$cfg_token = $this->scopeConfig->getValue('sdrtest/general/refreshtoken');


        #$resultPage->getLayout()->getBlock('Test')->setStuff($this->APIClient->getVcsProducts());
        #var_dump($this->APIClient->getVcsProducts());

        return $resultPage;
    }
}