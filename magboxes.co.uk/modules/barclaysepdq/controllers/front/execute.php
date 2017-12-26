<?php
/**
 * Accept payment by Barclays ePDQ Payment Gateway
 *
 * Barclays ePDQ Payment Gateway by Kahanit(http://www.kahanit.com) is licensed under a
 * Creative Creative Commons Attribution-NoDerivatives 4.0 International License.
 * Based on a work at http://www.kahanit.com.
 * Permissions beyond the scope of this license may be available at http://www.kahanit.com.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nd/4.0/.
 *
 * @author    Amit Sidhpura <amit@kahanit.com>
 * @copyright 2015 Kahanit
 * @license   http://creativecommons.org/licenses/by-nd/4.0/
 */

require_once dirname(__FILE__) . '/../../libraries/helper.php';

class BarclaysEPDQExecuteModuleFrontController extends ModuleFrontController
{
    /* @var $module BarclaysEPDQ */
    public $module;
    public $ssl = true;

    public function initContent()
    {
        $this->display_column_left = false;

        parent::initContent();

        /* @var $cart Cart */
        $cart = $this->context->cart;
        $currency = $this->context->currency;

        // ================================ validations starts ================================ //

        if ($cart->id === null || !$this->module->checkCurrency($cart)) {
            BarclaysEPDQHelper::redirectTop('index.php?controller=order');
        }

        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
            BarclaysEPDQHelper::redirectTop('index.php?controller=order&step=1');
        }

        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'barclaysepdq') {
                $authorized = true;
                break;
            }
        }
        if (!$authorized) {
            die($this->module->l('This payment method is not available.', 'validation'));
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            BarclaysEPDQHelper::redirectTop('index.php?controller=order&step=1');
        }

        // ================================ validations ends ================================ //

        $amount = (float)$cart->getOrderTotal(true, Cart::BOTH);
        $this->module->validateOrder($cart->id, $this->module->status_payment_pending, $amount,
            $this->module->displayName, null, array(), (int)$currency->id, false, $customer->secure_key);
        $order_id = $this->module->order_prefix . $this->module->currentOrder;
        $address_invoice = new AddressCore($cart->id_address_invoice);
        $lang_code = explode('-', $this->context->language->language_code);
        if (count($lang_code) == 2) {
            $lang_code[1] = strtoupper($lang_code[1]);
            $lang_code = implode('_', $lang_code);
        } else {
            $lang_code = 'en_US';
        }

        $form_data = array(
            'ORDERID'        => $order_id,
            'COM'            => implode(', ', array_column($cart->getProducts(), 'name')),
            'AMOUNT'         => $amount * 100,
            'CURRENCY'       => $currency->iso_code,
            'CN'             => $address_invoice->firstname . ' ' . $address_invoice->lastname,
            'OWNERADDRESS'   => $address_invoice->address1 . ' ' . $address_invoice->address2,
            'OWNERCTY'       => Country::getIsoById($address_invoice->id_country),
            'OWNERTOWN'      => $address_invoice->city,
            'OWNERZIP'       => $address_invoice->postcode,
            'OWNERTELNO'     => ($address_invoice->phone != '') ? $address_invoice->phone : $address_invoice->phone_mobile,
            'EMAIL'          => $customer->email,
            'LOGO'           => '',
            'TITLE'          => $this->module->title,
            'FONTTYPE'       => $this->module->font,
            'TXTCOLOR'       => $this->module->txt_color,
            'BGCOLOR'        => $this->module->bg_color,
            'BUTTONTXTCOLOR' => $this->module->btn_txt_color,
            'BUTTONBGCOLOR'  => $this->module->btn_bg_color,
            'TBLTXTCOLOR'    => $this->module->tbl_txt_color,
            'TBLBGCOLOR'     => $this->module->tbl_bg_color,
            'PMLISTTYPE'     => '1',
            'LANGUAGE'       => $lang_code,
            'PSPID'          => $this->module->pspid,
            'ACCEPTURL'      => $this->context->link->getModuleLink('barclaysepdq', 'confirm'),
            'DECLINEURL'     => $this->context->link->getModuleLink('barclaysepdq', 'confirm'),
            'EXCEPTIONURL'   => $this->context->link->getModuleLink('barclaysepdq', 'confirm'),
            'CANCELURL'      => $this->context->link->getModuleLink('barclaysepdq', 'confirm'),
            'CATALOGURL'     => $this->context->link->getModuleLink('barclaysepdq', 'confirm'),
            'BACKURL'        => $this->context->link->getModuleLink('barclaysepdq', 'confirm')
        );

        ksort($form_data);
        $shasign = array();
        foreach ($form_data as $key => $value) {
            if ($value === '') {
                continue;
            }
            $shasign[] = $key . '=' . $value . $this->module->sha_in_pp;
        }
        $shasign = strtoupper(hash($this->module->hash_algo, implode('', $shasign)));
        $submit_url = ($this->module->mode == 'test')
            ? 'https://mdepayments.epdq.co.uk/ncol/test/orderstandard.asp'
            : 'https://payments.epdq.co.uk/ncol/prod/orderstandard.asp';

        $this->context->smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'submit_url' => $submit_url,
            'form_data'  => $form_data,
            'shasign'    => $shasign
        ));
        $this->setTemplate('execute.tpl');
    }
}
