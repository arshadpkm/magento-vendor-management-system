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
 * Vendor admin edit block
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Adminhtml_Vendor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'vendor';
		$this->_controller = 'adminhtml_vendor';
		$this->_updateButton('save', 'label', Mage::helper('vendor')->__('Save Vendor'));
		$this->_updateButton('delete', 'label', Mage::helper('vendor')->__('Delete Vendor'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('vendor')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author Arshad
	 */
	public function getHeaderText(){
		if( Mage::registry('vendor_data') && Mage::registry('vendor_data')->getId() ) {
			return Mage::helper('vendor')->__("Edit Vendor '%s'", $this->htmlEscape(Mage::registry('vendor_data')->getName()));
		} 
		else {
			return Mage::helper('vendor')->__('Add Vendor');
		}
	}
}