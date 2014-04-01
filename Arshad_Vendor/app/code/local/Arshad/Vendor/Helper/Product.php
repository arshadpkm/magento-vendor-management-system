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
 * Product helper
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Helper_Product extends Arshad_Vendor_Helper_Data{
	/**
	 * get the selected vendors for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return array()
	 * @author Arshad
	 */
	public function getSelectedVendors(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedVendors()) {
			$vendors = array();
			foreach ($this->getSelectedVendorsCollection($product) as $vendor) {
				$vendors[] = $vendor;
			}
			$product->setSelectedVendors($vendors);
		}
		return $product->getData('selected_vendors');
	}
	/**
	 * get vendor collection for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return Arshad_Vendor_Model_Resource_Vendor_Collection
	 */
	public function getSelectedVendorsCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('vendor/vendor_collection')
			->addProductFilter($product);
		return $collection;
	}
}