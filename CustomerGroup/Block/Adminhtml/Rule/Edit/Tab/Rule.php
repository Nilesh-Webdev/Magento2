<?php

namespace Rvs\CustomerGroup\Block\Adminhtml\Rule\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Customer\Model\Config\Source\Group;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Rule extends Generic implements TabInterface
{
    /**
     * @var \Magento\Config\Model\Config\Source\Enabledisable
     */
    protected $enabledisable;

    protected $_customerGroupOptions;

    public function __construct(
        Context $context,
        Registry $registry,
        Group $customerGroup,
        FormFactory $formFactory,
        Enabledisable $enableDisable,
        array $data = []
    ) {
        $this->enabledisable = $enableDisable;
        $this->_customerGroupOptions = $customerGroup;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $rule = $this->_coreRegistry->registry('rvs_customergroup_rule');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('rule_');
        $form->setFieldNameSuffix('rule');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Rule Information'),
            'class'  => 'fieldset-wide'
        ]);

        $fieldset->addField('email_domain', 'text', [
            'name'     => 'email_domain',
            'label'    => __('Email Domain'),
            'title'    => __('Email Domain'),
            'required' => true
        ]);

        $fieldset->addField('group', 'select', [
            'name'   => 'group',
            'label'  => __('Customer Group'),
            'title'  => __('Customer Group'),
            'values' => $this->_customerGroupOptions->toOptionArray()
        ]);

        $fieldset->addField('status_id', 'select', [
            'name'   => 'status_id',
            'label'  => __('Status'),
            'title'  => __('Status'),
            'values' => $this->enabledisable->toOptionArray()
        ]);
        if (!$rule->hasData('status_id')) {
            $rule->setStatusId(1);
        }

        $form->addValues($rule->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Rule');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
