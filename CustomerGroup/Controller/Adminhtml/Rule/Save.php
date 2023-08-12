<?php

namespace Rvs\CustomerGroup\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Rvs\CustomerGroup\Controller\Adminhtml\Rule;
use Rvs\CustomerGroup\Model\RuleFactory;

class Save extends Rule
{
    public function __construct(
        Context $context,
        Registry $registry,
        RuleFactory $ruleFactory
    ) {
        parent::__construct($ruleFactory, $registry, $context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPost('rule')) {
            $rule = $this->initRule();
            $rule->addData($data);

            try {
                $rule->save();

                $this->messageManager->addSuccess(__('The rule has been saved.'));
                $this->_getSession()->setData('rvs_customergroup_rule_data', false);

                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath('rvs_customergroup/*/edit', ['id' => $rule->getId(), '_current' => true]);
                } else {
                    $resultRedirect->setPath('rvs_customergroup/*/');
                }

                return $resultRedirect;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Rule.'));
            }

            $this->_getSession()->setData('rvs_customergroup_rule_data', $data);

            $resultRedirect->setPath('rvs_customergroup/*/edit', ['id' => $rule->getId(), '_current' => true]);

            return $resultRedirect;
        }

        $resultRedirect->setPath('rvs_customergroup/*/');

        return $resultRedirect;
    }
}
