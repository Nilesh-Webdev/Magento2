<?php

namespace Rvs\CustomerGroup\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Rvs\CustomerGroup\Controller\Adminhtml\Rule;
use Rvs\CustomerGroup\Model\RuleFactory;

class Edit extends Rule
{
    public $resultPageFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        RuleFactory $ruleFactory,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($ruleFactory, $registry, $context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $rule = $this->initRule();
        if (!$rule) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*');

            return $resultRedirect;
        }

        $data = $this->_session->getData('rvs_customergroup_rule_data', true);
        if (!empty($data)) {
            $rule->setData($data);
        }

        $this->coreRegistry->register('rvs_customergroup_rule', $rule);

        /** @var \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Rvs_CustomerGroup::rule');
        $resultPage->getConfig()->getTitle()->set(__('Rules'));

        $title = $rule->getId() ? $rule->getEmailDomain() : __('New Rule');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
