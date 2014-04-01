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
 * Vendor admin edit tabs
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('vendor_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vendor')->__('Vendor'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Edit_Tabs
	 * @author Arshad
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_vendor', array(
			'label'		=> Mage::helper('vendor')->__('Vendor'),
			'title'		=> Mage::helper('vendor')->__('Vendor'),
			'content' 	=> $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_vendor', array(
				'label'		=> Mage::helper('vendor')->__('Store views'),
				'title'		=> Mage::helper('vendor')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_stores')->toHtml(),
			));
		}
		$this->addTab('products', array(
			'label' => Mage::helper('vendor')->__('Associated products'),
			'url'   => $this->getUrl('*/*/products', array('_current' => true)),
   			'class'	=> 'ajax'
		));
        $this->addTab('email', array(
            'label'     => Mage::helper('vendor')->__('Email notification'),
            'title'     => Mage::helper('vendor')->__('Email notification'),
            'content'   => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_email')->toHtml(),
        ));
		return parent::_beforeToHtml();
	}
}