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
 * Vendor edit form tab
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Vendor_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form
	 * @author Arshad
*/
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('vendor_');
		$form->setFieldNameSuffix('vendor');
		$this->setForm($form);
		$fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('vendor')->__('Vendor')));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('vendor')->__('Name'),
			'name'  => 'name',
			'note'	=> $this->__('name of the vendor'),
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('total_product', 'text', array(
			'label' => Mage::helper('vendor')->__('Total Product'),
			'name'  => 'total_product',

		));

		$fieldset->addField('email', 'text', array(
			'label' => Mage::helper('vendor')->__('Email'),
			'name'  => 'email',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('mobile', 'text', array(
			'label' => Mage::helper('vendor')->__('Mobile'),
			'name'  => 'mobile',
			'required'  => true,
			'class' => 'required-entry',

		));


		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('vendor')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('vendor')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('vendor')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_vendor')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getVendorData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
			Mage::getSingleton('adminhtml/session')->setVendorData(null);
		}
		elseif (Mage::registry('current_vendor')){
			$form->setValues(Mage::registry('current_vendor')->getData());
		}
		return parent::_prepareForm();
	}
}