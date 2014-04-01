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
 * Vendor admin controller
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Adminhtml_Vendor_VendorController extends Arshad_Vendor_Controller_Adminhtml_Vendor{
	/**
	 * init the vendor
	 * @access protected
	 * @return Arshad_Vendor_Model_Vendor
	 */
	protected function _initVendor(){
		$vendorId  = (int) $this->getRequest()->getParam('id');
		$vendor	= Mage::getModel('vendor/vendor');
		if ($vendorId) {
			$vendor->load($vendorId);
		}
		Mage::register('current_vendor', $vendor);
		return $vendor;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('vendor')->__('Vendor'))
			 ->_title(Mage::helper('vendor')->__('Vendors'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit vendor - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function editAction() {
		$vendorId	= $this->getRequest()->getParam('id');
		$vendor  	= $this->_initVendor();
		if ($vendorId && !$vendor->getId()) {
			$this->_getSession()->addError(Mage::helper('vendor')->__('This vendor no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$vendor->setData($data);
		}
		Mage::register('vendor_data', $vendor);
		$this->loadLayout();
		$this->_title(Mage::helper('vendor')->__('Vendor'))
			 ->_title(Mage::helper('vendor')->__('Vendors'));
		if ($vendor->getId()){
			$this->_title($vendor->getName());
		}
		else{
			$this->_title(Mage::helper('vendor')->__('Add vendor'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new vendor action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save vendor - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('vendor')) {
			try {
				$vendor = $this->_initVendor();
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$vendor->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                    $pro=split('&',$products);
                    $c=count($pro);
                    $data['total_product']=$c;
				}
                $vendor->addData($data);
				$vendor->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Vendor was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $vendor->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('There was a problem saving the vendor.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Unable to find vendor to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete vendor - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$vendor = Mage::getModel('vendor/vendor');
				$vendor->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Vendor was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('There was an error deleteing vendor.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Could not find vendor to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete vendor - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function massDeleteAction() {
		$vendorIds = $this->getRequest()->getParam('vendor');
		if(!is_array($vendorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Please select vendors to delete.'));
		}
		else {
			try {
				foreach ($vendorIds as $vendorId) {
					$vendor = Mage::getModel('vendor/vendor');
					$vendor->setId($vendorId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Total of %d vendors were successfully deleted.', count($vendorIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('There was an error deleteing vendors.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function massStatusAction(){
		$vendorIds = $this->getRequest()->getParam('vendor');
		if(!is_array($vendorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Please select vendors.'));
		} 
		else {
			try {
				foreach ($vendorIds as $vendorId) {
				$vendor = Mage::getSingleton('vendor/vendor')->load($vendorId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendors were successfully updated.', count($vendorIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('There was an error updating vendors.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass Email notification for low stock change - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function massSemailAction(){
		$vendorIds = $this->getRequest()->getParam('vendor');
		if(!is_array($vendorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Please select vendors.'));
		} 
		else {
			try {
				foreach ($vendorIds as $vendorId) {
				$vendor = Mage::getSingleton('vendor/vendor')->load($vendorId)
							->setSemail($this->getRequest()->getParam('flag_semail'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendors were successfully updated.', count($vendorIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('There was an error updating vendors.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function productsAction(){
		$this->_initVendor();
		$this->loadLayout();
		$this->getLayout()->getBlock('vendor.edit.tab.product')
			->setVendorProducts($this->getRequest()->getPost('vendor_products', null));
		$this->renderLayout();
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function productsgridAction(){
		$this->_initVendor();
		$this->loadLayout();
		$this->getLayout()->getBlock('vendor.edit.tab.product')
			->setVendorProducts($this->getRequest()->getPost('vendor_products', null));
		$this->renderLayout();
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function exportCsvAction(){
		$fileName   = 'vendor.csv';
		$content	= $this->getLayout()->createBlock('vendor/adminhtml_vendor_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Arshad
	 */
	public function exportExcelAction(){
		$fileName   = 'vendor.xls';
		$content	= $this->getLayout()->createBlock('vendor/adminhtml_vendor_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Arshad
	 * @author Arshad
	 */
	public function exportXmlAction(){
		$fileName   = 'vendor.xml';
		$content	= $this->getLayout()->createBlock('vendor/adminhtml_vendor_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
 }