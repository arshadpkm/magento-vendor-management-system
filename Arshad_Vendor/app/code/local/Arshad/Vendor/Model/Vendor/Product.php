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
 * Vendor product model
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Model_Vendor_Product extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Arshad
	 */
	protected function _construct(){
		$this->_init('vendor/vendor_product');
	}
	/**
	 * Save data for vendor-product relation
	 * @access public
	 * @param  Arshad_Vendor_Model_Vendor $vendor
	 * @return Arshad_Vendor_Model_Vendor_Product
	 * @author Arshad
	 */
	public function saveVendorRelation($vendor){
		$data = $vendor->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveVendorRelation($vendor, $data);
		}
		return $this;
	}
	/**
	 * get products for vendor
	 * @access public
	 * @param Arshad_Vendor_Model_Vendor $vendor
	 * @return Arshad_Vendor_Model_Resource_Vendor_Product_Collection
	 * @author Arshad
	 */
	public function getProductCollection($vendor){
		$collection = Mage::getResourceModel('vendor/vendor_product_collection')
			->addVendorFilter($vendor);
		return $collection;
	}
}