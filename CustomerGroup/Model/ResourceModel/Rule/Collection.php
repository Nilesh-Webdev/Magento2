<?php

namespace Rvs\CustomerGroup\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rvs\CustomerGroup\Model\ResourceModel\Rule;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'group_id';
    
    protected function _construct()
    {
        $this->_init(\Rvs\CustomerGroup\Model\Rule::class, Rule::class);
    }
}
