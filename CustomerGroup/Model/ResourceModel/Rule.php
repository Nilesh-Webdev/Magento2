<?php

namespace Rvs\CustomerGroup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rule extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('rvs_customer_group_rule', 'group_id');
    }
}
