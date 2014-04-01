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
 * Vendor helper
 *
 * @category	Arshad
 * @package		Arshad_Vendor
 * @author Arshad
 */
class Arshad_Vendor_Helper_Vendor extends Mage_Core_Helper_Abstract{
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author Arshad
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('vendor/vendor/breadcrumbs');
	}
}