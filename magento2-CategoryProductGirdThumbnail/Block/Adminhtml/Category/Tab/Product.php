<?php

namespace HP\CategoryProductsCustomTabs\Block\Adminhtml\Category\Tab;

use HP\CategoryProductsCustomTabs\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Image;

class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{
      
    public function setCollection($collection)
    {
        $collection->addAttributeToSelect('type_id');
        $collection->addAttributeToSelect('thumbnail');
        $collection->addAttributeToSelect('special_price');
        $this->_collection = $collection;
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();
       
        $this->addColumnAfter(
            'image',
            [
                'header' => __('Image'),
                'index' => 'image',
                'renderer' => Image::class,
                'filter' => false,
                'sortable' => false,
                'column_css_class' => 'data-grid-image'
            ],
            'entity_id'
        );
        $this->addColumnAfter(
            'type_id',
            [
                'header' => __('Product Type'),
                'index' => 'type_id',
            ],
            'image'
        );
        $this->addColumnAfter(
            'special_price',
            [
                'header' => __('Special Price'),
                'index' => 'special_price',
            ],
            'price'
        );
        $this->sortColumnsByOrder();
        
        return $this;
    }
}
