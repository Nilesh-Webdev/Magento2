<?php

namespace Rvs\CustomerGroup\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Rvs\CustomerGroup\Model\RuleFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Data extends AbstractHelper
{
    public $ruleFactory;
    protected $storeManager;
    public $logger;

    public function __construct(
        Context $context,        
        StoreManagerInterface $storeManager,
        RuleFactory $ruleFactory,
        LoggerInterface $logger
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function getCustomerGroupIdByEmail($email){

        $this->logger->info('START Email: '.$email);

        //map full email address first
        $collection = $this->ruleFactory
            ->create()
            ->getCollection()            
            ->addFieldToFilter('email_domain', array('finset' => $email))
            ->addFieldToFilter('status_id', 1)
            ->setOrder('group_id','DESC')
            ->getFirstItem();

        if(!$collection->getId()){
            $this->logger->info('Email: '.$email.' No Email rule found');
            //map email domain only
            $emailArr = explode('@', $email);
            $emailDomain = $emailArr[1] ? $emailArr[1] : '';
            if($emailDomain){
                $this->logger->info('Email: '.$email.' Email Domain rule found');
                $collection = $this->ruleFactory
                    ->create()
                    ->getCollection()
                    ->addFieldToFilter('email_domain', array('like' => '%'.$emailDomain.'%'))
                    ->addFieldToFilter('status_id', 1)
                    ->setOrder('group_id','desc')
                    ->getFirstItem();
            }
        }

        if($collection && $collection->getGroup()){
            $this->logger->info('Email: '.$email.' Group: '.$collection->getGroup());
            return $collection->getGroup();
        }

        $this->logger->info('END Email: '.$email);

        return false;
    }

    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue('rvscustomergroup/general/enabled', ScopeInterface::SCOPE_STORE, null);        
    }
}
