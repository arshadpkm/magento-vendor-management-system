<?php
/**
 * Created by JetBrains PhpStorm.
 * User: arshad
 * Date: 2/1/14
 * Time: 11:39 AM
 * To change this template use File | Settings | File Templates.
 */
class Arshad_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Email extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('vendor_');
        $form->setFieldNameSuffix('vendor');
        $this->setForm($form);
        $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('vendor')->__('Vendor')));

        $fieldset->addField('semail', 'select', array(
            'label' => Mage::helper('vendor')->__('E-Mail notification for low stock :'),
            'name'  => 'semail',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('vendor')->__('Enable'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('vendor')->__('Disable'),
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