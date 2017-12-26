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

if (!defined('_PS_VERSION_')) {
    exit;
}

class BarclaysEPDQ extends PaymentModule
{
    private $html = '';
    private $post_error = array();
    private $post_success = array();
    public $mode;
    public $pspid;
    public $sha_in_pp;
    public $sha_out_pp;
    public $hash_algo;
    public $order_prefix;
    public $status_payment_pending_default;
    public $status_payment_pending;
    public $status_payment_success;
    public $status_payment_aborted;
    public $status_payment_error;
    public $title;
    public $font;
    public $txt_color;
    public $bg_color;
    public $btn_txt_color;
    public $btn_bg_color;
    public $tbl_txt_color;
    public $tbl_bg_color;
    public $extra_mail_vars;

    public function __construct()
    {
        $this->name = 'barclaysepdq';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'Kahanit';
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';
        $config = Configuration::getMultiple(array(
            'BARCLAYSEPDQ_MODE',
            'BARCLAYSEPDQ_PSPID',
            'BARCLAYSEPDQ_SHA_IN_PP',
            'BARCLAYSEPDQ_SHA_OUT_PP',
            'BARCLAYSEPDQ_HASH_ALGO',
            'BARCLAYSEPDQ_ORDER_PREFIX',
            'BARCLAYSEPDQ_STATUS_PAYMENT_PENDING_DEFAULT',
            'BARCLAYSEPDQ_STATUS_PAYMENT_PENDING',
            'BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS',
            'BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED',
            'BARCLAYSEPDQ_STATUS_PAYMENT_ERROR',
            'BARCLAYSEPDQ_TITLE',
            'BARCLAYSEPDQ_FONT',
            'BARCLAYSEPDQ_TXT_COLOR',
            'BARCLAYSEPDQ_BG_COLOR',
            'BARCLAYSEPDQ_BTN_TXT_COLOR',
            'BARCLAYSEPDQ_BTN_BG_COLOR',
            'BARCLAYSEPDQ_TBL_TXT_COLOR',
            'BARCLAYSEPDQ_TBL_BG_COLOR'
        ));

        $this->mode = ($config['BARCLAYSEPDQ_MODE'] !== false) ? $config['BARCLAYSEPDQ_MODE'] : 'test';
        $this->pspid = ($config['BARCLAYSEPDQ_PSPID'] !== false) ? $config['BARCLAYSEPDQ_PSPID'] : '';
        $this->sha_in_pp = ($config['BARCLAYSEPDQ_SHA_IN_PP'] !== false) ? $config['BARCLAYSEPDQ_SHA_IN_PP'] : '';
        $this->sha_out_pp = ($config['BARCLAYSEPDQ_SHA_OUT_PP'] !== false) ? $config['BARCLAYSEPDQ_SHA_OUT_PP'] : '';
        $this->hash_algo = ($config['BARCLAYSEPDQ_HASH_ALGO'] !== false) ? $config['BARCLAYSEPDQ_HASH_ALGO'] : 'sha1';
        $this->order_prefix = ($config['BARCLAYSEPDQ_ORDER_PREFIX'] !== false) ? $config['BARCLAYSEPDQ_ORDER_PREFIX'] : 'ORDER';
        $this->status_payment_pending_default = ($config['BARCLAYSEPDQ_STATUS_PAYMENT_PENDING_DEFAULT'] !== false) ? $config['BARCLAYSEPDQ_STATUS_PAYMENT_PENDING_DEFAULT'] : '';
        $this->status_payment_pending = ($config['BARCLAYSEPDQ_STATUS_PAYMENT_PENDING'] !== false) ? $config['BARCLAYSEPDQ_STATUS_PAYMENT_PENDING'] : '';
        $this->status_payment_success = ($config['BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS'] !== false) ? $config['BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS'] : '';
        $this->status_payment_aborted = ($config['BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED'] !== false) ? $config['BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED'] : '';
        $this->status_payment_error = ($config['BARCLAYSEPDQ_STATUS_PAYMENT_ERROR'] !== false) ? $config['BARCLAYSEPDQ_STATUS_PAYMENT_ERROR'] : '';
        $this->title = ($config['BARCLAYSEPDQ_TITLE'] !== false) ? $config['BARCLAYSEPDQ_TITLE'] : 'Barclays ePDQ Payment';
        $this->font = ($config['BARCLAYSEPDQ_FONT'] !== false) ? $config['BARCLAYSEPDQ_FONT'] : 'Arial, Helvetica, sans-serif';
        $this->txt_color = ($config['BARCLAYSEPDQ_TXT_COLOR'] !== false) ? $config['BARCLAYSEPDQ_TXT_COLOR'] : '#000000';
        $this->bg_color = ($config['BARCLAYSEPDQ_BG_COLOR'] !== false) ? $config['BARCLAYSEPDQ_BG_COLOR'] : '#ffffff';
        $this->btn_txt_color = ($config['BARCLAYSEPDQ_BTN_TXT_COLOR'] !== false) ? $config['BARCLAYSEPDQ_BTN_TXT_COLOR'] : '#ffffff';
        $this->btn_bg_color = ($config['BARCLAYSEPDQ_BTN_BG_COLOR'] !== false) ? $config['BARCLAYSEPDQ_BTN_BG_COLOR'] : '#008CC5';
        $this->tbl_txt_color = ($config['BARCLAYSEPDQ_TBL_TXT_COLOR'] !== false) ? $config['BARCLAYSEPDQ_TBL_TXT_COLOR'] : '#000000';
        $this->tbl_bg_color = ($config['BARCLAYSEPDQ_TBL_BG_COLOR'] !== false) ? $config['BARCLAYSEPDQ_TBL_BG_COLOR'] : '#ffffff';
        $this->bootstrap = version_compare(_PS_VERSION_, '1.6.0.1') >= 0;

        parent::__construct();

        $this->displayName = $this->l('Barclays ePDQ');
        $this->description = $this->l('Accept payments for your products via Barclays ePDQ.');
        $this->confirmUninstall = $this->l('Are you sure about removing these details?');

        if (!count(Currency::checkPaymentCurrencies($this->id))) {
            $this->warning = $this->l('No currency has been set for this module.');
        }
    }

    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('displayBackOfficeHeader') ||
            !$this->registerHook('displayHeader') ||
            !$this->registerHook('payment') ||
            !$this->registerHook('paymentReturn')
        ) {
            return false;
        }

        $order_state = new OrderState();
        $order_state->name = array_fill(0, 10, 'Awaiting Barclays ePDQ payment');
        $order_state->module_name = 'barclaysepdq';
        $order_state->unremovable = true;
        $order_state->color = '#4169E1';

        if ($order_state->add()) {
            Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING_DEFAULT', (int)$order_state->id);
            Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING', (int)$order_state->id);
        }

        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS', 2);
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED', 6);
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_ERROR', 8);

        return true;
    }

    public function uninstall()
    {
        $order_state = new OrderState($this->status_payment_pending_default);
        $order_state->delete();

        if (!parent::uninstall() ||
            !$this->unregisterHook('displayBackOfficeHeader') ||
            !$this->unregisterHook('displayHeader') ||
            !$this->unregisterHook('payment') ||
            !$this->unregisterHook('paymentReturn') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_MODE') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_PSPID') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_SHA_IN_PP') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_SHA_OUT_PP') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_HASH_ALGO') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_ORDER_PREFIX') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING_DEFAULT') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_STATUS_PAYMENT_ERROR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_TITLE') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_FONT') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_TXT_COLOR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_BG_COLOR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_BTN_TXT_COLOR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_BTN_BG_COLOR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_TBL_TXT_COLOR') ||
            !Configuration::deleteByName('BARCLAYSEPDQ_TBL_BG_COLOR')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        if (Tools::isSubmit('btnSubmit')) {
            $this->postMerchantDetails();
        }

        $this->displayHeader();
        $this->displayMerchantDetails();
        $this->displayFooter();

        return $this->html;
    }

    private function postMerchantDetails()
    {
        Configuration::updateValue('BARCLAYSEPDQ_MODE', Tools::getValue('mode', 'test'));
        Configuration::updateValue('BARCLAYSEPDQ_PSPID', Tools::getValue('pspid', ''));
        Configuration::updateValue('BARCLAYSEPDQ_SHA_IN_PP', Tools::getValue('sha_in_pp', ''));
        Configuration::updateValue('BARCLAYSEPDQ_SHA_OUT_PP', Tools::getValue('sha_out_pp', ''));
        Configuration::updateValue('BARCLAYSEPDQ_HASH_ALGO', Tools::getValue('hash_algo', 'sha1'));
        Configuration::updateValue('BARCLAYSEPDQ_ORDER_PREFIX', Tools::getValue('order_prefix', 'ORDER'));
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING', Tools::getValue('status_payment_pending'));
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS', Tools::getValue('status_payment_success'));
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED', Tools::getValue('status_payment_aborted'));
        Configuration::updateValue('BARCLAYSEPDQ_STATUS_PAYMENT_ERROR', Tools::getValue('status_payment_error'));
        Configuration::updateValue('BARCLAYSEPDQ_TITLE', Tools::getValue('title', 'Barclays ePDQ Payment'));
        Configuration::updateValue('BARCLAYSEPDQ_FONT', Tools::getValue('font', 'Arial, Helvetica, sans-serif'));
        Configuration::updateValue('BARCLAYSEPDQ_TXT_COLOR', Tools::getValue('txt_color', '#000000'));
        Configuration::updateValue('BARCLAYSEPDQ_BG_COLOR', Tools::getValue('bg_color', '#ffffff'));
        Configuration::updateValue('BARCLAYSEPDQ_BTN_TXT_COLOR', Tools::getValue('btn_txt_color', '#ffffff'));
        Configuration::updateValue('BARCLAYSEPDQ_BTN_BG_COLOR', Tools::getValue('btn_bg_color', '#008CC5'));
        Configuration::updateValue('BARCLAYSEPDQ_TBL_TXT_COLOR', Tools::getValue('tbl_txt_color', '#000000'));
        Configuration::updateValue('BARCLAYSEPDQ_TBL_BG_COLOR', Tools::getValue('tbl_bg_color', '#ffffff'));

        $this->post_success[] = $this->l('Settings updated');
    }

    private function displayHeader()
    {
        $this->context->smarty->assign(array(
            'post_success_count' => count($this->post_success),
            'post_success'       => implode('<br />', $this->post_success),
            'post_error_count'   => count($this->post_error),
            'post_error'         => implode('<br />', $this->post_error)
        ));

        $this->html .= $this->display(__FILE__, 'views/templates/admin/header.tpl');
    }

    private function displayMerchantDetails()
    {
        $this->context->smarty->assign(array(
            'request_uri'            => Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']),
            'mode'                   => htmlentities(Tools::getValue('mode', $this->mode), ENT_COMPAT, 'UTF-8'),
            'pspid'                  => htmlentities(Tools::getValue('pspid', $this->pspid), ENT_COMPAT, 'UTF-8'),
            'sha_in_pp'              => htmlentities(Tools::getValue('sha_in_pp', $this->sha_in_pp), ENT_COMPAT, 'UTF-8'),
            'sha_out_pp'             => htmlentities(Tools::getValue('sha_out_pp', $this->sha_out_pp), ENT_COMPAT, 'UTF-8'),
            'hash_algo'              => htmlentities(Tools::getValue('hash_algo', $this->hash_algo), ENT_COMPAT, 'UTF-8'),
            'order_prefix'           => htmlentities(Tools::getValue('order_prefix', $this->order_prefix), ENT_COMPAT, 'UTF-8'),
            'status_payment_pending' => $this->getOrderStatusDropDown('status_payment_pending', Tools::getValue('status_payment_pending', $this->status_payment_pending), 'form-control'),
            'status_payment_success' => $this->getOrderStatusDropDown('status_payment_success', Tools::getValue('status_payment_success', $this->status_payment_success), 'form-control'),
            'status_payment_aborted' => $this->getOrderStatusDropDown('status_payment_aborted', Tools::getValue('status_payment_aborted', $this->status_payment_aborted), 'form-control'),
            'status_payment_error'   => $this->getOrderStatusDropDown('status_payment_error', Tools::getValue('status_payment_error', $this->status_payment_error), 'form-control'),
            'font'                   => htmlentities(Tools::getValue('font', $this->font), ENT_COMPAT, 'UTF-8'),
            'title'                  => htmlentities(Tools::getValue('title', $this->title), ENT_COMPAT, 'UTF-8'),
            'txt_color'              => htmlentities(Tools::getValue('txt_color', $this->txt_color), ENT_COMPAT, 'UTF-8'),
            'bg_color'               => htmlentities(Tools::getValue('bg_color', $this->bg_color), ENT_COMPAT, 'UTF-8'),
            'btn_txt_color'          => htmlentities(Tools::getValue('btn_txt_color', $this->btn_txt_color), ENT_COMPAT, 'UTF-8'),
            'btn_bg_color'           => htmlentities(Tools::getValue('btn_bg_color', $this->btn_bg_color), ENT_COMPAT, 'UTF-8'),
            'tbl_txt_color'          => htmlentities(Tools::getValue('tbl_txt_color', $this->tbl_txt_color), ENT_COMPAT, 'UTF-8'),
            'tbl_bg_color'           => htmlentities(Tools::getValue('tbl_bg_color', $this->tbl_bg_color), ENT_COMPAT, 'UTF-8')
        ));

        $this->html .= $this->display(__FILE__, 'views/templates/admin/settings.tpl');
    }

    private function displayFooter()
    {
        $this->context->smarty->assign(array(
            'display_name' => $this->displayName,
            'version'      => $this->version
        ));

        $this->html .= $this->display(__FILE__, 'views/templates/admin/footer.tpl');
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (strcasecmp(Tools::getValue('controller'), 'AdminModules') != 0
            || strcasecmp(Tools::getValue('configure'), $this->name) != 0
        ) {
            return;
        }

        $this->context->controller->addCSS($this->_path . 'views/css/style.css');
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryPlugin('colorpicker');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/front.css', 'all');
    }

    public function hookPayment($params)
    {
        if (!$this->active || !$this->checkCurrency($params['cart'])) {
            return '';
        }

        $this->smarty->assign(array(
            'this_path'     => $this->_path,
            'this_path_cca' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/'
        ));

        return $this->display(__FILE__, 'payment.tpl');
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return '';
        }

        /* @var $order Order */
        $order = $params['objOrder'];
        $state = $order->getCurrentState();

        if ($state == Configuration::get('BARCLAYSEPDQ_STATUS_PAYMENT_PENDING') ||
            $state == Configuration::get('BARCLAYSEPDQ_STATUS_PAYMENT_SUCCESS') ||
            $state == Configuration::get('BARCLAYSEPDQ_STATUS_PAYMENT_ABORTED') ||
            $state == Configuration::get('BARCLAYSEPDQ_STATUS_PAYMENT_ERROR') ||
            $state == Configuration::get('PS_OS_OUTOFSTOCK')
        ) {
            $this->smarty->assign(array(
                'status'     => 'ok',
                'message_id' => Tools::getValue('message_id'),
                'amount'     => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
                'order_id'   => $order->id
            ));

            if (isset($order->reference) && !empty($order->reference)) {
                $this->smarty->assign('reference', $order->reference);
            }
        } else {
            $this->smarty->assign('status', 'failed');
        }

        return $this->display(__FILE__, 'payment_return.tpl');
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency((int)$cart->id_currency);
        $currencies_module = $this->getCurrency((int)$cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getOrderStatusDropDown($name = '', $selected = '', $class = '')
    {
        $order_states = OrderStateCore::getOrderStates($this->context->language->id);

        $html = '<select name="' . $name . '" class="' . $class . '">';
        $html .= '<option value=""></option>';

        foreach ($order_states as $order_state) {
            $html .= '<option' . (($selected == $order_state['id_order_state']) ? ' selected="selected"' : '') .
                ' value="' . $order_state['id_order_state'] . '">' . $order_state['name'] . '</option>';
        }

        $html .= '</select>';

        return $html;
    }
}
