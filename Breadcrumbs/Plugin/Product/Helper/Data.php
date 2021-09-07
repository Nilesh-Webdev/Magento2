<?php

namespace Rvs\Breadcrumbs\Plugin\Product\Helper;

class Data 
{
	/**
     * Category repository
     *
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    protected $categoryRepository;

	/**     
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     */
    public function __construct(        
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Return current category object
     *
     * @return \Magento\Catalog\Model\Category|null
     */
    public function afterGetCategory(\Magento\Catalog\Helper\Data $subject, $result)
    {
        if($result)
        	return $result;        

        return $this->getProductCategory($subject);
    }

    private function getProductCategory($subject){
        $product = $subject->getProduct();        
        $categories = $category = null;

        if($product){
        	$categories = $product->getCategoryIds();	
        }        
        
        if($categories){
            $categoryId = isset($categories[0]) ? $categories[0] : null;
            if($categoryId)
            	$category = $this->categoryRepository->get($categoryId);            
        }
        
        return $category;
    }
}
