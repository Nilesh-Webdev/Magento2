<?php

namespace Rvs\CustomerGroup\Block\Adminhtml\Rule\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('rule_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Rule Information'));
    }
}
