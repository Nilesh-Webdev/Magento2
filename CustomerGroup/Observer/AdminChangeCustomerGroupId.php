<?php

namespace Rvs\CustomerGroup\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Rvs\CustomerGroup\Helper\Data;

class AdminChangeCustomerGroupId implements ObserverInterface
{
    public $helperData;

    protected $_customerRepositoryInterface;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface,
        Data $helperData
    ) {
        $this->helperData = $helperData;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->helperData->isEnabled()) {
            return $this;
        }

        $customer = $observer->getEvent()->getCustomer();
        $request  = $observer->getEvent()->getRequest();
        
        if ($customerGroupId = $this->helperData->getCustomerGroupIdByEmail($customer->getEmail())) {
            $customer->setGroupId($customerGroupId);
            //$this->customerRepositoryInterface->save($customer);
        }

        return $this;
    }
}