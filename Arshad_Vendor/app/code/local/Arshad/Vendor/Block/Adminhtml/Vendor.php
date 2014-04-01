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
 * Vendor admin block
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Ultimate Module Creator
 */
class Arshad_Vendor_Block_Adminhtml_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_vendor';
		$this->_blockGroup 		= 'vendor';
		$this->_headerText 		= Mage::helper('vendor')->__('Vendor');
		$this->_addButtonLabel 	= Mage::helper('vendor')->__('Add Vendor');
		parent::__construct();
	}
}