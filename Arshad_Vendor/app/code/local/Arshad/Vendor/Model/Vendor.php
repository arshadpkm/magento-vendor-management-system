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
 * Vendor model
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Model_Vendor extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'vendor_vendor';
	const CACHE_TAG = 'vendor_vendor';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'vendor_vendor';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'vendor';
	protected $_productInstance = null;
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('vendor/vendor');
	}
	/**
	 * before save vendor
	 * @access protected
	 * @return Arshad_Vendor_Model_Vendor
	 * @author Arshad
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * save vendor relation
	 * @access public
	 * @return Arshad_Vendor_Model_Vendor
	 * @author Arshad
	 */
	protected function _afterSave() {
		$this->getProductInstance()->saveVendorRelation($this);
		return parent::_afterSave();
	}
	/**
	 * get product relation model
	 * @access public
	 * @return Arshad_Vendor_Model_Vendor_Product
	 * @author Arshad
	 */
	public function getProductInstance(){
		if (!$this->_productInstance) {
			$this->_productInstance = Mage::getSingleton('vendor/vendor_product');
		}
		return $this->_productInstance;
	}
	/**
	 * get selected products array
	 * @access public
	 * @return array
	 * @author Arshad
	 */
	public function getSelectedProducts(){
		if (!$this->hasSelectedProducts()) {
			$products = array();
			foreach ($this->getSelectedProductsCollection() as $product) {
				$products[] = $product;
			}
			$this->setSelectedProducts($products);
		}
		return $this->getData('selected_products');
	}
	/**
	 * Retrieve collection selected products
	 * @access public
	 * @return Arshad_Vendor_Resource_Vendor_Product_Collection
	 * @author Arshad
	 */
	public function getSelectedProductsCollection(){
		$collection = $this->getProductInstance()->getProductCollection($this);
		return $collection;
	}
}