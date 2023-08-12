<?php

namespace Rvs\CustomerGroup\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Rvs\CustomerGroup\Model\RuleFactory;

abstract class Rule extends Action
{
    /** Authorization level of a basic admin session */
    const ADMIN_RESOURCE = 'Rvs_CustomerGroup::rule';

    public $ruleFactory;
    public $coreRegistry;

    public function __construct(
        RuleFactory $ruleFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }
    
    protected function initRule($register = false)
    {
        $ruleId = (int)$this->getRequest()->getParam('id');

        $rule = $this->ruleFactory->create();
        if ($ruleId) {
            $rule->load($ruleId);
            if (!$rule->getId()) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));

                return false;
            }
        }

        /* if (!$rule->getAuthorId()) {
            $rule->setAuthorId($this->_auth->getUser()->getId());
        }*/

        if ($register) {
            $this->coreRegistry->register('rvs_customergroup_rule', $rule);
        }

        return $rule;
    }
}
