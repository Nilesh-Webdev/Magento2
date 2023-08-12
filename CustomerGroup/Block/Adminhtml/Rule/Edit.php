<?php

namespace Rvs\CustomerGroup\Block\Adminhtml\Rule;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    public $coreRegistry;

    /**
     * constructor
     *
     * @param Registry $coreRegistry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Registry $coreRegistry,
        Context $context,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context, $data);
    }

    /**
     * Initialize Post edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Rvs_CustomerGroup';
        $this->_controller = 'adminhtml_rule';

        parent::_construct();

        $this->buttonList->add(
            'save-and-continue',
            [
                'label'          => __('Save and Continue Edit'),
                'class'          => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event'  => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
    }
    
    public function getHeaderText()
    {
        $post = $this->coreRegistry->registry('rvs_customergroup_rule');
        if ($post->getId()) {
            return __("Edit Rule '%1'", $this->escapeHtml($post->getName()));
        }

        return __('New Rule');
    }

    public function getFormActionUrl()
    {
        $rule = $this->coreRegistry->registry('rvs_customergroup_rule');
        if ($id = $rule->getId()) {
            return $this->getUrl('*/*/save', ['id' => $id]);
        }

        return parent::getFormActionUrl();
    }
}
