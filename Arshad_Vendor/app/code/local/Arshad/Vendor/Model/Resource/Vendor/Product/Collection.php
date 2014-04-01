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
 * Vendor - product relation resource model collection
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Model_Resource_Vendor_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection{
	/**
	 * remember if fields have been joined
	 * @var bool
	 */
	protected $_joinedFields = false;
	/**
	 * join the link table
	 * @access public
	 * @return Arshad_Vendor_Model_Resource_Vendor_Product_Collection
	 * @author Arshad
	 */
	public function joinFields(){
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('vendor/vendor_product')),
				'related.product_id = e.entity_id',
				array('position')
			);
			$this->_joinedFields = true;
		}
		return $this;
	}
	/**
	 * add vendor filter
	 * @access public
	 * @param Arshad_Vendor_Model_Vendor | int $vendor
	 * @return Arshad_Vendor_Model_Resource_Vendor_Product_Collection
	 * @author Arshad
	 */
	public function addVendorFilter($vendor){
		if ($vendor instanceof Arshad_Vendor_Model_Vendor){
			$vendor = $vendor->getId();
		}
		if (!$this->_joinedFields){
			$this->joinFields();
		}
		$this->getSelect()->where('related.vendor_id = ?', $vendor);
		return $this;
	}
}