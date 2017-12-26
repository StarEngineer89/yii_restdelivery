<?php
/**
 * Accept payment by Barclays ePDQ Payment Gateway
 *
 * Barclays ePDQ Payment Gateway by Kahanit(http://www.kahanit.com) is licensed under a
 * Creative Creative Commons Attribution-NoDerivatives 4.0 International License.
 * Based on a work at http://www.kahanit.com.
 * Permissions beyond the scope of this license m
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nd/4.0/.
 *
 * @author    Amit Sidhpura <amit@kahanit.com>
 * @copyright 2015 Kahanit
 * @license   http://creativecommons.org/licenses/by-nd/4.0/
 */

require_once dirname(__FILE__) . '/../../libraries/helper.php';

/**
 * Class BarclaysEPDQConfirmModuleFrontController
 */
class BarclaysEPDQConfirmModuleFrontController extends ModuleFrontController
{
    /* @var $module BarclaysEPDQ */
    public $module;
    public $ssl = true;

    public function postProcess()
    {
        // ================================ validations starts ================================ //

        $response = (count($_POST) > 0) ? $_POST : $_GET;
        uksort($response, 'strcasecmp');
        $shasign_received = $response['SHASIGN'];
        unset($response['SHASIGN']);
        unset($response['module']);
        unset($response['controller']);
        unset($response['fc']);

        $shasign = array();
        foreach ($response as $key => $value) {
            if ($value === '') {
                continue;
            }
            $shasign[] = strtoupper($key) . '=' . $value . $this->module->sha_out_pp;
        }
        $shasign = strtoupper(hash($this->module->hash_algo, implode('', $shasign)));

        if ($shasign !== $shasign_received) {
            BarclaysEPDQHelper::redirectTop('index.php');
        }

        // ================================ validations ends ================================ //

        if (in_array($response['STATUS'], array(5, 9))) {
            $message_id = 1;
            $order_status = (int)$this->module->status_payment_success;
        } else if ($response['STATUS'] == 1) {
            $message_id = 2;
            $order_status = (int)$this->module->status_payment_aborted;
        } else if (in_array($response['STATUS'], array(2, 93))) {
            $message_id = 3;
            $order_status = (int)$this->module->status_payment_error;
        } else {
            $message_id = 0;
            $order_status = false;
        }

        $order_id = (int)str_replace($this->module->order_prefix, '', $response['orderID']);

        if ($order_status !== false) {
            $history = new OrderHistoryCore();
            $history->id_order = $order_id;
            $history->changeIdOrderState($order_status, $order_id);

            if ($this->getOrderStateSendEmail($order_status)) {
                $history->addWithemail();
            } else {
                $history->add();
            }
        }

        $order = new OrderCore($order_id);
        $customer = new Customer($this->context->cookie->id_customer);

        BarclaysEPDQHelper::redirectTop('index.php?controller=order-confirmation&id_cart=' . $order->id_cart . '&id_module=' .
            $this->module->id . '&id_order=' . $order_id . '&key=' . $customer->secure_key . '&message_id=' . $message_id);
    }

    private function getOrderStateSendEmail($id_order_state)
    {
        $sql = 'SELECT `send_email`
		        FROM `' . _DB_PREFIX_ . 'order_state`
                WHERE `id_order_state` = ' . (int)$id_order_state;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

        return $result['send_email'];
    }
}
