<?php

namespace Rvs\CustomerGroup\Controller\Adminhtml\Rule;

use Rvs\CustomerGroup\Controller\Adminhtml\Rule;

class Delete extends Rule
{    
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $this->ruleFactory->create()
                    ->load($id)
                    ->delete();

                $this->messageManager->addSuccess(__('The Rule has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $resultRedirect->setPath('rvs_customergroup/*/edit', ['id' => $id]);

                return $resultRedirect;
            }
        } else {
            $this->messageManager->addError(__('Rule to delete was not found.'));
        }

        $resultRedirect->setPath('rvs_customergroup/*/');

        return $resultRedirect;
    }
}
