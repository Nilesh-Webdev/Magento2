<?php

namespace Rvs\FreeShippingBar\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ShippingPromotion extends Template
{
    protected $_storeManager;
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    )
    {
      $this->_storeManager = $storeManager;
      $this->scopeConfig = $scopeConfig;
      parent::__construct($context, $data);
    }

    /**
     *
     * @param type $configField
     */

    public function getShippingConfig($config) {
        return $this->scopeConfig->getValue('rvs_freeshippingbar/general/'.$config,
          \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
     }
}
