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

{if $status == 'ok'}
    {if $message_id eq 1}
        <div class="alert alert-success success">{l s='Thank you for shopping with us. Your credit card has been charged with amount %s and your transaction for order #%s is successful. We will be shipping your order to you soon.' sprintf=[$amount, $order_id] mod='barclaysepdq'}</div>
    {elseif $message_id eq 2}
        <div class="alert alert-info success">{l s='Transaction for order cancelled.' sprintf=$order_id mod='barclaysepdq'}</div>
    {elseif $message_id eq 3}
        <div class="alert alert-warning warning">{l s='Transaction for order #%s has been declined.' sprintf=$order_id mod='barclaysepdq'}</div>
    {/if}
{else}
    <p class="warning">
        {l s='We have noticed that there is a problem with your order. If you think this is an error, you can contact our' mod='barclaysepdq'}
        <a href="{$link->getPageLink('contact', true)|escape:'UTF-8'}">{l s='customer service department.' mod='barclaysepdq'}</a>.
    </p>
{/if}
