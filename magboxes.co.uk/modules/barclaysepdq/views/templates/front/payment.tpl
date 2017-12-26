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

{capture name=path}{l s='Payment' mod='barclaysepdq'}{/capture}

<h1 class="page-heading">{l s='Payment' mod='barclaysepdq'}</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<iframe id="payment-execute" src="{$link->getModuleLink('barclaysepdq', 'execute', ['content_only' => 1])|escape:'UTF-8'}" height="500" width="100%"></iframe>
