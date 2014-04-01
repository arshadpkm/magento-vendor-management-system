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
 * Vendor product list
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Vendor_Catalog_Product_List extends Mage_Core_Block_Template{
	/**
	 * get the list of products
	 * @access public
	 * @return Mage_Catalog_Model_Resource_Product_Collection
	 * @author Arshad
	 */
	public function getProductCollection(){
		$collection = $this->getVendor()->getSelectedProductsCollection();
		$collection->addAttributeToSelect('name');
		$collection->addUrlRewrite();
		$collection->getSelect()->order('related.position');
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		return $collection;
	}
	/**
	 * get current vendor
	 * @access public
	 * @return Arshad_Vendor_Model_Vendor
	 * @author Arshad
	 */
	public function getVendor(){
		return Mage::registry('current_vendor_vendor');
	}
}