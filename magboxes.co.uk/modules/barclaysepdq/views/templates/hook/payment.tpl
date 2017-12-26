{**
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
 *}

<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="barclaysepdq" href="{$link->getModuleLink('barclaysepdq', 'payment')|escape:'UTF-8'}" title="{l s='Pay by Barclays ePDQ' mod='barclaysepdq'}">
                {l s='Pay by Debit/Credit Card' mod='barclaysepdq'}
            </a>
        </p>
    </div>
</div>
