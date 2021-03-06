<?php
/**
 * Magmodules.eu - http://www.magmodules.eu
 *
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magmodules.eu so we can send you a copy immediately.
 *
 * @category      Magmodules
 * @package       Magmodules_Channableapi
 * @author        Magmodules <info@magmodules.eu>
 * @copyright     Copyright (c) 2018 (http://www.magmodules.eu)
 * @license       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Magmodules_Channableapi_Block_Adminhtml_System_Config_Form_Field_Webhook
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * Mollie Helper.
     *
     * @var Magmodules_Channableapi_Helper_Data
     */
    public $helper;

    /**
     * Magmodules_Channableapi_Block_Adminhtml_System_Config_Form_Field_Webhook constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->helper = Mage::helper('channableapi');
    }

    /**
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return mixed
     */
    public function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $storeId = 0;
        if (strlen($code = Mage::getSingleton('adminhtml/config_data')->getStore())) {
            $storeId = Mage::getModel('core/store')->load($code)->getId();
        }

        return strtok($this->helper->getItemUpdateWebhook($storeId, true), '?');
    }

}