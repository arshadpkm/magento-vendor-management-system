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
 * Adminhtml observer
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Model_Adminhtml_Observer{
	/**
	 * check if tab can be added
	 * @access protected
	 * @param Mage_Catalog_Model_Product $product
	 * @return bool
	 * @author Arshad
	 */
	protected function _canAddTab($product){
		if ($product->getId()){
			return true;
		}
		if (!$product->getAttributeSetId()){
			return false;
		}
		$request = Mage::app()->getRequest();
		if ($request->getParam('type') == 'configurable'){
			if ($request->getParam('attribtues')){
				return true;
			}
		}
		return false;
	}
	/**
	 * add the vendor tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Arshad_Vendor_Model_Adminhtml_Observer
	 * @author Arshad
	 */
	public function addVendorBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('vendors', array(
				'label' => Mage::helper('vendor')->__('Vendors'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/vendor_vendor_catalog_product/vendors', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * save vendor - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Arshad_Vendor_Model_Adminhtml_Observer
	 * @author Arshad
	 */
	public function saveVendorData($observer){
		$post = Mage::app()->getRequest()->getPost('vendors', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			$vendorProduct = Mage::getResourceSingleton('vendor/vendor_product')->saveProductRelation($product, $post);
		}
		return $this;
	}}