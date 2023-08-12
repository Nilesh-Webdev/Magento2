<?php

namespace Rvs\CustomerGroup\Model;

use Magento\Framework\Model\AbstractModel;

class Rule extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Rule::class);
    }
}
