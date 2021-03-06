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

class Magmodules_Channableapi_Block_Adminhtml_System_Config_Form_Field_Api
    extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
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
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '';
        $stores = Mage::app()->getStores();

        foreach ($stores as $store) {
            $storeId = $store->getId();
            $storeName = $store->getName();
            $ordersApiUrl = $this->helper->getOrderWebhook($storeId, true);

            if ($this->helper->getOrderEnabled($storeId)) {
                $ordersApi = '<img src="' . $this->getSkinUrl('images/rule_component_apply.gif') . '">';
            } else {
                $ordersApi = '<img src="' . $this->getSkinUrl('images/rule_component_remove.gif') . '">';
            }

            if ($this->helper->getItemEnabled($storeId)) {
                $itemApi = '<img src="' . $this->getSkinUrl('images/rule_component_apply.gif') . '">';
            } else {
                $itemApi = '<img src="' . $this->getSkinUrl('images/rule_component_remove.gif') . '">';
            }

            $itemApiResult = $this->helper->getItemResults($storeId);

            $html .= '<tr>';
            $html .= '  <td colspan="3"><strong>' . $storeName . '</strong></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '  <td width="75px">Order</td>';
            $html .= '  <td align="center">' . $ordersApi . '</td>';
            $html .= '  <td>' . $ordersApiUrl . '</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '  <td>Item</td>';
            $html .= '  <td align="center">' . $itemApi . '</td>';
            $html .= '  <td width="475px">' . $itemApiResult . '</td>';
            $html .= '</tr>';
        }

        if (empty($html)) {
            $html = Mage::helper('channable')->__('No enabled stores found');
        } else {
            $htmlHeader = '<div class="grid"><table cellpadding="2" cellspacing="0" class="border" style="width:655px;height:75px;">';
            $htmlHeader .= '<tbody><tr class="headings"><th>Store</th><th>Type</th><th></th></tr>';
            $htmlFooter = '</tbody></table></div>';

            $html = $htmlHeader . $html . $htmlFooter;
        }

        return sprintf(
            '<tr id="row_%s"><td colspan="7" class="label" style="margin-bottom: 10px;">%s</td></tr>',
            $element->getHtmlId(), $html
        );
    }

}