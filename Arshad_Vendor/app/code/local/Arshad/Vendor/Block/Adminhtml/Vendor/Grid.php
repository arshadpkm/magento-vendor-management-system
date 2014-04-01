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
 * Vendor admin grid block
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('vendorGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Grid
	 * @author Arshad
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('vendor/vendor')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Grid
	 * @author Arshad
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('vendor')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('vendor')->__('Name'),
			'index' => 'name',
			'type'	 	=> 'text',

		));
		$this->addColumn('total_product', array(
			'header'=> Mage::helper('vendor')->__('Total Product'),
			'index' => 'total_product',
			'type'	 	=> 'text',

		));
		$this->addColumn('email', array(
			'header'=> Mage::helper('vendor')->__('Email'),
			'index' => 'email',
			'type'	 	=> 'text',

		));
		$this->addColumn('mobile', array(
			'header'=> Mage::helper('vendor')->__('Mobile'),
			'index' => 'mobile',
			'type'	 	=> 'text',

		));
		$this->addColumn('status', array(
			'header'	=> Mage::helper('vendor')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('vendor')->__('Enabled'),
				'0' => Mage::helper('vendor')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('vendor')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		$this->addColumn('created_at', array(
			'header'	=> Mage::helper('vendor')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('vendor')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('vendor')->__('Action'),
				'width' => '100',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('vendor')->__('Edit'),
						'url'   => array('base'=> '*/*/edit'),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('vendor')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('vendor')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('vendor')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Grid
	 * @author Arshad
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('vendor');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('vendor')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('vendor')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('vendor')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendor')->__('Status'),
						'values' => array(
								'1' => Mage::helper('vendor')->__('Enabled'),
								'0' => Mage::helper('vendor')->__('Disabled'),
						)
				)
			)
		));
		$this->getMassactionBlock()->addItem('semail', array(
			'label'=> Mage::helper('vendor')->__('Change Email notification for low stock'),
			'url'  => $this->getUrl('*/*/massSemail', array('_current'=>true)),
			'additional' => array(
				'flag_semail' => array(
						'name' => 'flag_semail',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendor')->__('Email notification for low stock'),
						'values' => array(
								'1' => Mage::helper('vendor')->__('Yes'),
								'0' => Mage::helper('vendor')->__('No'),
						)
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Arshad_Vendor_Model_Vendor
	 * @return string
	 * @author Arshad
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * @author Arshad
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Grid
	 * @author Arshad
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Arshad_Vendor_Model_Resource_Vendor_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Arshad_Vendor_Block_Adminhtml_Vendor_Grid
	 * @author Arshad
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
}