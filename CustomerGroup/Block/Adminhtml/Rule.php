<?php

namespace Rvs\CustomerGroup\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Rule extends Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_rule';
        $this->_blockGroup = 'Rvs_CustomerGroup';
        $this->_headerText = __('Rules');
        $this->_headerText = __('Rules');
        $this->_addButtonLabel = __('Create New Rule');

        parent::_construct();
    }
}
