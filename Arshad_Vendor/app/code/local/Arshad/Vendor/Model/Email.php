<?php
/**
 * Created by JetBrains PhpStorm.
 * User: arshad
 * Date: 2/3/14
 * Time: 3:05 PM
 * To change this template use File | Settings | File Templates.
 */
class Arshad_Vendor_Model_Email extends Mage_Core_Model_Email_Template
{
    /**
     * Send email to recipient
     *
     * @param string $templateId template identifier (see config.xml to know it)
     * @param array $sender sender name with email ex. array('name' => 'John D.', 'email' => 'email@ex.com')
     * @param string $email recipient email address
     * @param string $name recipient name
     * @param string $subject email subject
     * @param array $params data array that will be passed into template
     */
    public function sendEmail($templateId, $sender, $email, $name, $subject, $params = array())
    {
        $this->setDesignConfig(array('area' => 'frontend', 'store' => $this->getDesignConfig()->getStore()))
            ->setTemplateSubject($subject)
            ->sendTransactional(
                $templateId,
                $sender,
                $email,
                $name,
                $params
            );
    }
}