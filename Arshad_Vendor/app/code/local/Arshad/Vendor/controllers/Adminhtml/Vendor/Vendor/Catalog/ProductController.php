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
 * Vendor product admin controller
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Arshad_Vendor_Adminhtml_Vendor_Vendor_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * construct
	 * @access protected
	 * @return void
	 * @author Arshad
	 */
	protected function _construct(){
		// Define module dependent translate
		$this->setUsedModuleName('Arshad_Vendor');
	}
	/**
	 * vendors in the catalog page
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function vendorsAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.vendor')
			->setProductVendors($this->getRequest()->getPost('product_vendors', null));
		$this->renderLayout();
	}
	/**
	 * vendors grid in the catalog page
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function vendorsGridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.vendor')
			->setProductVendors($this->getRequest()->getPost('product_vendors', null));
		$this->renderLayout();
	}
}