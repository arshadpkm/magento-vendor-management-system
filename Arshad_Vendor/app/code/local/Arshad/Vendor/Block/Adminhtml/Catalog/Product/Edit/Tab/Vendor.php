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
 * Vendor tab on product edit form
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Adminhtml_Catalog_Product_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Arshad
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('vendor_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getProduct()->getId()) {
			$this->setDefaultFilter(array('in_vendors'=>1));
		}
	}
	/**
	 * prepare the vendor collection
	 * @access protected 
	 * @return Arshad_Vendor_Block_Adminhtml_Catalog_Product_Edit_Tab_Vendor
	 * @author Arshad
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('vendor/vendor_collection');
		if ($this->getProduct()->getId()){
			$constraint = 'related.product_id='.$this->getProduct()->getId();
			}
			else{
				$constraint = 'related.product_id=0';
			}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('vendor/vendor_product')),
			'related.vendor_id=main_table.entity_id AND '.$constraint,
			array('position')
		);
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Catalog_Product_Edit_Tab_Vendor
	 * @author Arshad
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Catalog_Product_Edit_Tab_Vendor
	 * @author Arshad
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_vendors', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_vendors',
			'values'=> $this->_getSelectedVendors(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('vendor')->__('Name'),
			'align' => 'left',
			'index' => 'name',
		));
		$this->addColumn('position', array(
			'header'		=> Mage::helper('vendor')->__('Position'),
			'name'  		=> 'position',
			'width' 		=> 60,
			'type'		=> 'number',
			'validate_class'=> 'validate-number',
			'index' 		=> 'position',
			'editable'  	=> true,
		));
	}
	/**
	 * Retrieve selected vendors
	 * @access protected
	 * @return array
	 * @author Arshad
	 */
	protected function _getSelectedVendors(){
		$vendors = $this->getProductVendors();
		if (!is_array($vendors)) {
			$vendors = array_keys($this->getSelectedVendors());
		}
		return $vendors;
	}
 	/**
	 * Retrieve selected vendors
	 * @access protected
	 * @return array
	 * @author Arshad
	 */
	public function getSelectedVendors() {
		$vendors = array();
		//used helper here in order not to override the product model
		$selected = Mage::helper('vendor/product')->getSelectedVendors(Mage::registry('current_product'));
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $vendor) {
			$vendors[$vendor->getId()] = array('position' => $vendor->getPosition());
		}
		return $vendors;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Arshad
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Arshad
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/vendorsGrid', array(
			'id'=>$this->getProduct()->getId()
		));
	}
	/**
	 * get the current product
	 * @access public
	 * @return Mage_Catalog_Model_Product
	 * @author Arshad
	 */
	public function getProduct(){
		return Mage::registry('current_product');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return Arshad_Vendor_Block_Adminhtml_Catalog_Product_Edit_Tab_Vendor
	 * @author Arshad
	 */
	protected function _addColumnFilterToCollection($column){
		if ($column->getId() == 'in_vendors') {
			$vendorIds = $this->_getSelectedVendors();
			if (empty($vendorIds)) {
				$vendorIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$vendorIds));
			} 
			else {
				if($vendorIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$vendorIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}