<?php 
/**
 * Arshad_Vendor extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Arshad
 * @package		Arshad_Vendor
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Vendor list on product page block
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Catalog_Product_List_Vendor extends Mage_Catalog_Block_Product_Abstract{
	/**
	 * get the list of vendors
	 * @access protected
	 * @return Arshad_Vendor_Model_Resource_Vendor_Collection 
	 * @author Arshad
	 */
	public function getVendorCollection(){
		if (!$this->hasData('vendor_collection')){
			$product = Mage::registry('product');
			$collection = Mage::getResourceSingleton('vendor/vendor_collection')
				->addStoreFilter(Mage::app()->getStore())

				->addFilter('status', 1)
				->addProductFilter($product);
			$collection->getSelect()->order('related_product.position', 'ASC');
			$this->setData('vendor_collection', $collection);
		}
		return $this->getData('vendor_collection');
	}
}