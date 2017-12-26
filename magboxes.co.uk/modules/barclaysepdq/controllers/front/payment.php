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

/**
 * Class BarclaysEPDQPaymentModuleFrontController
 */
class BarclaysEPDQPaymentModuleFrontController extends ModuleFrontController
{
    /* @var $module BarclaysEPDQ */
    public $module;
    public $ssl = true;

    public function initContent()
    {
        $this->display_column_left = false;

        parent::initContent();

        $this->setTemplate('payment.tpl');
    }
}
