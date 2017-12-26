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

{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.' mod='barclaysepdq'}</p>
{else}
    <div id="barclaysepdq_loader">
        <p><img src="{$img_ps_dir|escape:'UTF-8'}loadingAnimation.gif" alt="Loading..."/></p>
    </div>
    <form id="barclaysepdq_form" name="barclaysepdq_form" method="post" action="{$submit_url}">
        {foreach from=$form_data key=k item=v}
            <input type="hidden" name="{$k}" value="{$v}"/>
        {/foreach}
        <input type="hidden" name="SHASIGN" value="{$shasign}">
    </form>
    <script language='javascript'>
        $(function () {
            $('#barclaysepdq_form').submit();
        });
    </script>
{/if}
