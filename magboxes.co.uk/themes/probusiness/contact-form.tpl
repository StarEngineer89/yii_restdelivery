{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{capture name=path}{l s='Contact'}{/capture}
<h4 class="title_block title_block_home">
	{if isset($customerThread) && $customerThread}{l s='Your reply'}{else}{l s='Contact us'}{/if}
</h4>
{if isset($confirmation)}
	<p class="alert alert-success">{l s='Your message has been successfully sent to our team.'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home'}
				</span>
			</a>
		</li>
	</ul>
{elseif isset($alreadySent)}
	<p class="alert alert-warning">{l s='Your message has already been sent.'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home'}
				</span>
			</a>
		</li>
	</ul>
{else}
	{include file="$tpl_dir./errors.tpl"}
    
        {if isset($tc_config.YBC_TC_CONTACT_FORM_LAYOUT) && $tc_config.YBC_TC_CONTACT_FORM_LAYOUT == 'layout2'}
                        <!--  Contact form (Layout 2)  -->
                    	<form action="{$request_uri}" method="post" class="contact-form-box contact-form-box-layout-2" enctype="multipart/form-data">
                    		<div>
                                <div class="row">
                    			<div class="clearfix">
                                    {if isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                                        <div class="col-xs-12 embe_map_contact">
                                            {$tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                                        </div>
                                    {/if}
                                    {if isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) && $tc_config.YBC_TC_CONTACT_PAGE_TEXT}
                                        <div class="col-xs-12 col-sm-6 contact_infor">
                                            <p>{$tc_config.YBC_TC_CONTACT_PAGE_TEXT}</p>
                                            <div class="contact_store_information">
                                                <ul class="contact_store_information_list">
                                                    <li class="contact_store_information_item">
                                                        <div class="contact_store_information_left"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                                        <div class="contact_store_information_right">
                                                            <label>{l s='Address:'}</label>
                                                            {if (isset($tc_config.BLOCKCONTACTINFOS_COMPANY) && $tc_config.BLOCKCONTACTINFOS_COMPANY)}
                                                                <div class="content">
                                                                    {$tc_config.BLOCKCONTACTINFOS_COMPANY},{$tc_config.BLOCKCONTACTINFOS_ADDRESS}
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </li>
                                                    
                                                    <li class="contact_store_information_item">
                                                        <div class="contact_store_information_left"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                        <div class="contact_store_information_right">
                                                            <label>{l s='Phone:'}</label>
                                                            {if (isset($tc_config.BLOCKCONTACTINFOS_PHONE) && $tc_config.BLOCKCONTACTINFOS_PHONE)}
                                                                <div class="content">
                                                                    {$tc_config.BLOCKCONTACTINFOS_PHONE},{$tc_config.BLOCKCONTACTINFOS_PHONE}
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </li>
                                                    
                                                    
                                                    <li class="contact_store_information_item">
                                                        <div class="contact_store_information_left"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                                        <div class="contact_store_information_right">
                                                            <label>{l s='Email:'}</label>
                                                            {if (isset($tc_config.BLOCKCONTACTINFOS_EMAIL) && $tc_config.BLOCKCONTACTINFOS_EMAIL)}
                                                                <div class="content">
                                                                    {$tc_config.BLOCKCONTACTINFOS_EMAIL}
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    {/if}
                                    
                                    
                    				<div class="col-xs-12 col-sm-6">
                    					<div class="form-group selector1">
                    						<label for="id_contact">{l s='Subject Heading'}</label>
                    					{if isset($customerThread.id_contact) && $customerThread.id_contact && $contacts|count}
                    							{assign var=flag value=true}
                    							{foreach from=$contacts item=contact}
                    								{if $contact.id_contact == $customerThread.id_contact}
                    									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contact.name|escape:'html':'UTF-8'}" readonly="readonly" />
                    									<input type="hidden" name="id_contact" value="{$contact.id_contact|intval}" />
                    									{$flag=false}
                    								{/if}
                    							{/foreach}
                    							{if $flag && isset($contacts.0.id_contact)}
                    									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contacts.0.name|escape:'html':'UTF-8'}" readonly="readonly" />
                    									<input type="hidden" name="id_contact" value="{$contacts.0.id_contact|intval}" />
                    							{/if}
                    					</div>
                    					{else}
                    						<select id="id_contact" class="form-control" name="id_contact">
                    							<option value="0">{l s='-- Choose --'}</option>
                    							{foreach from=$contacts item=contact}
                    								<option value="{$contact.id_contact|intval}"{if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact} selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
                    							{/foreach}
                    						</select>
                    					</div>
                    						<p id="desc_contact0" class="desc_contact{if isset($smarty.request.id_contact)} unvisible{/if}">&nbsp;</p>
                    						{foreach from=$contacts item=contact}
                    							<p id="desc_contact{$contact.id_contact|intval}" class="desc_contact contact-title{if !isset($smarty.request.id_contact) || $smarty.request.id_contact|intval != $contact.id_contact|intval} unvisible{/if}">
                    								<i class="icon-comment-alt"></i>{$contact.description|escape:'html':'UTF-8'}
                    							</p>
                    						{/foreach}
                    					{/if}
                    					<p class="form-group">
                    						<label for="email">{l s='Email address'}</label>
                    						{if isset($customerThread.email)}
                    							<input class="form-control grey" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
                    						{else}
                    							<input class="form-control grey validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
                    						{/if}
                    					</p>
                    					{if !$PS_CATALOG_MODE}
                    						{if (!isset($customerThread.id_order) || $customerThread.id_order > 0)}
                    							<div id="contact_reference" class="form-group selector1">
                    								<label>{l s='Order reference'}</label>
                    								{if !isset($customerThread.id_order) && isset($is_logged) && $is_logged}
                    									<select name="id_order" class="form-control">
                    										<option value="0">{l s='-- Choose --'}</option>
                    										{foreach from=$orderList item=order}
                    											<option value="{$order.value|intval}"{if $order.selected|intval} selected="selected"{/if}>{$order.label|escape:'html':'UTF-8'}</option>
                    										{/foreach}
                    									</select>
                    								{elseif !isset($customerThread.id_order) && empty($is_logged)}
                    									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.id_order) && $customerThread.id_order|intval > 0}{$customerThread.id_order|intval}{else}{if isset($smarty.post.id_order) && !empty($smarty.post.id_order)}{$smarty.post.id_order|escape:'html':'UTF-8'}{/if}{/if}" />
                    								{elseif $customerThread.id_order|intval > 0}
                    									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.reference) && $customerThread.reference}{$customerThread.reference|escape:'html':'UTF-8'}{else}{$customerThread.id_order|intval}{/if}" readonly="readonly" />
                    								{/if}
                    							</div>
                    						{/if}
                    						{if isset($is_logged) && $is_logged}
                    							<div id="contact_order_products" class="form-group selector1">
                    								<label class="unvisible">{l s='Product'}</label>
                    								{if !isset($customerThread.id_product)}
                    									{foreach from=$orderedProductList key=id_order item=products name=products}
                    										<select name="id_product" id="{$id_order}_order_products" class="unvisible product_select form-control"{if !$smarty.foreach.products.first} style="display:none;"{/if}{if !$smarty.foreach.products.first} disabled="disabled"{/if}>
                    											<option value="0">{l s='-- Choose --'}</option>
                    											{foreach from=$products item=product}
                    												<option value="{$product.value|intval}">{$product.label|escape:'html':'UTF-8'}</option>
                    											{/foreach}
                    										</select>
                    									{/foreach}
                    								{elseif $customerThread.id_product > 0}
                    									<input  type="hidden" name="id_product" id="id_product" value="{$customerThread.id_product|intval}" readonly="readonly" />
                    								{/if}
                    							</div>
                    						{/if}
                    					{/if}
                    					{if $fileupload == 1}
                    						<p class="form-group">
                    							<label for="fileUpload">{l s='Attach File'}</label>
                    							<input type="hidden" name="MAX_FILE_SIZE" value="{if isset($max_upload_size) && $max_upload_size}{$max_upload_size|intval}{else}2000000{/if}" />
                    							<input type="file" name="fileUpload" id="fileUpload" class="form-control" />
                    						</p>
                    					{/if}
                    					<div class="form-group message_contact">
                    						
                    						<textarea class="form-control" id="message" placeholder="{l s='Message'}" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
                    					</div>
                                        <div class="submit">
                            				<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium"><span>{l s='Send Email'}</span></button>
                            			</div>
                    				</div>
                    			</div>
                    			
                                
                                </div>
                    		</div>
                    	</form>
                        <!-- end contact layout 2-->
                        
                        
                        
        {elseif isset($tc_config.YBC_TC_CONTACT_FORM_LAYOUT) && $tc_config.YBC_TC_CONTACT_FORM_LAYOUT == 'layout3'}
            <!--  Contact form (Layout 3)  -->
        	<form action="{$request_uri}" method="post" class="contact-form-box contact-form-box-layout-3" enctype="multipart/form-data">
        		<div>
                    <div class="row">
        			<div class="clearfix">
                        {if isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) && $tc_config.YBC_TC_CONTACT_PAGE_TEXT}
                            <div class="col-xs-12{if isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE} col-sm-12 col-md-4{else} col-sm-6{/if} contact_infor">
                                <p>{$tc_config.YBC_TC_CONTACT_PAGE_TEXT}</p>
                                <div class="contact_store_information">
                                    <ul class="contact_store_information_list">
                                        <li class="contact_store_information_item">
                                            <div class="contact_store_information_left"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                            <div class="contact_store_information_right">
                                                <label>{l s='Address:'}</label>
                                                {if (isset($tc_config.BLOCKCONTACTINFOS_COMPANY) && $tc_config.BLOCKCONTACTINFOS_COMPANY)}
                                                    <div class="content">
                                                        {$tc_config.BLOCKCONTACTINFOS_COMPANY},{$tc_config.BLOCKCONTACTINFOS_ADDRESS}
                                                    </div>
                                                {/if}
                                            </div>
                                        </li>
                                        
                                        <li class="contact_store_information_item">
                                            <div class="contact_store_information_left"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                            <div class="contact_store_information_right">
                                                <label>{l s='Phone:'}</label>
                                                {if (isset($tc_config.BLOCKCONTACTINFOS_PHONE) && $tc_config.BLOCKCONTACTINFOS_PHONE)}
                                                    <div class="content">
                                                        {$tc_config.BLOCKCONTACTINFOS_PHONE},{$tc_config.BLOCKCONTACTINFOS_PHONE}
                                                    </div>
                                                {/if}
                                            </div>
                                        </li>
                                        
                                        
                                        <li class="contact_store_information_item">
                                            <div class="contact_store_information_left"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                            <div class="contact_store_information_right">
                                                <label>{l s='Email:'}</label>
                                                {if (isset($tc_config.BLOCKCONTACTINFOS_EMAIL) && $tc_config.BLOCKCONTACTINFOS_EMAIL)}
                                                    <div class="content">
                                                        {$tc_config.BLOCKCONTACTINFOS_EMAIL}
                                                    </div>
                                                {/if}
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        {/if}
                        {if isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                            <div class="col-xs-12{if isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) && $tc_config.YBC_TC_CONTACT_PAGE_TEXT} col-sm-6 col-md-4 ybc_delay03{else} col-sm-6 ybc_delay03{/if} embe_map_contact">
                                {$tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                            </div>
                        {/if}
                        
        				<div class="col-xs-12{if (isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && 
                                                    $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && 
                                                    (isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) && 
                                                    $tc_config.YBC_TC_CONTACT_PAGE_TEXT)} col-sm-6 col-md-4 ybc_delay06{elseif (($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE =='' && 
                                                    $tc_config.YBC_TC_CONTACT_PAGE_TEXT) ||
                                                    ($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE &&  
                                                    $tc_config.YBC_TC_CONTACT_PAGE_TEXT == ''))} col-sm-6 ybc_delay03 {elseif (isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && 
                                                    $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE == '' &&
                                                    isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) &&
                                                    $tc_config.YBC_TC_CONTACT_PAGE_TEXT == '')} col-sm-12{/if}">
        					<div class="form-group selector1">
        						<label for="id_contact">{l s='Subject Heading'}</label>
        					{if isset($customerThread.id_contact) && $customerThread.id_contact && $contacts|count}
        							{assign var=flag value=true}
        							{foreach from=$contacts item=contact}
        								{if $contact.id_contact == $customerThread.id_contact}
        									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contact.name|escape:'html':'UTF-8'}" readonly="readonly" />
        									<input type="hidden" name="id_contact" value="{$contact.id_contact|intval}" />
        									{$flag=false}
        								{/if}
        							{/foreach}
        							{if $flag && isset($contacts.0.id_contact)}
        									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contacts.0.name|escape:'html':'UTF-8'}" readonly="readonly" />
        									<input type="hidden" name="id_contact" value="{$contacts.0.id_contact|intval}" />
        							{/if}
        					</div>
        					{else}
        						<select id="id_contact" class="form-control" name="id_contact">
        							<option value="0">{l s='-- Choose --'}</option>
        							{foreach from=$contacts item=contact}
        								<option value="{$contact.id_contact|intval}"{if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact} selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
        							{/foreach}
        						</select>
        					</div>
        						<p id="desc_contact0" class="desc_contact{if isset($smarty.request.id_contact)} unvisible{/if}">&nbsp;</p>
        						{foreach from=$contacts item=contact}
        							<p id="desc_contact{$contact.id_contact|intval}" class="desc_contact contact-title{if !isset($smarty.request.id_contact) || $smarty.request.id_contact|intval != $contact.id_contact|intval} unvisible{/if}">
        								<i class="icon-comment-alt"></i>{$contact.description|escape:'html':'UTF-8'}
        							</p>
        						{/foreach}
        					{/if}
        					<p class="form-group">
        						<label for="email">{l s='Email address'}</label>
        						{if isset($customerThread.email)}
        							<input class="form-control grey" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
        						{else}
        							<input class="form-control grey validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
        						{/if}
        					</p>
        					{if !$PS_CATALOG_MODE}
        						{if (!isset($customerThread.id_order) || $customerThread.id_order > 0)}
        							<div id="contact_reference" class="form-group selector1">
        								<label>{l s='Order reference'}</label>
        								{if !isset($customerThread.id_order) && isset($is_logged) && $is_logged}
        									<select name="id_order" class="form-control">
        										<option value="0">{l s='-- Choose --'}</option>
        										{foreach from=$orderList item=order}
        											<option value="{$order.value|intval}"{if $order.selected|intval} selected="selected"{/if}>{$order.label|escape:'html':'UTF-8'}</option>
        										{/foreach}
        									</select>
        								{elseif !isset($customerThread.id_order) && empty($is_logged)}
        									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.id_order) && $customerThread.id_order|intval > 0}{$customerThread.id_order|intval}{else}{if isset($smarty.post.id_order) && !empty($smarty.post.id_order)}{$smarty.post.id_order|escape:'html':'UTF-8'}{/if}{/if}" />
        								{elseif $customerThread.id_order|intval > 0}
        									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.reference) && $customerThread.reference}{$customerThread.reference|escape:'html':'UTF-8'}{else}{$customerThread.id_order|intval}{/if}" readonly="readonly" />
        								{/if}
        							</div>
        						{/if}
        						{if isset($is_logged) && $is_logged}
        							<div id="contact_order_products" class="form-group selector1">
        								<label class="unvisible">{l s='Product'}</label>
        								{if !isset($customerThread.id_product)}
        									{foreach from=$orderedProductList key=id_order item=products name=products}
        										<select name="id_product" id="{$id_order}_order_products" class="unvisible product_select form-control"{if !$smarty.foreach.products.first} style="display:none;"{/if}{if !$smarty.foreach.products.first} disabled="disabled"{/if}>
        											<option value="0">{l s='-- Choose --'}</option>
        											{foreach from=$products item=product}
        												<option value="{$product.value|intval}">{$product.label|escape:'html':'UTF-8'}</option>
        											{/foreach}
        										</select>
        									{/foreach}
        								{elseif $customerThread.id_product > 0}
        									<input  type="hidden" name="id_product" id="id_product" value="{$customerThread.id_product|intval}" readonly="readonly" />
        								{/if}
        							</div>
        						{/if}
        					{/if}
        					{if $fileupload == 1}
        						<p class="form-group">
        							<label for="fileUpload">{l s='Attach File'}</label>
        							<input type="hidden" name="MAX_FILE_SIZE" value="{if isset($max_upload_size) && $max_upload_size}{$max_upload_size|intval}{else}2000000{/if}" />
        							<input type="file" name="fileUpload" id="fileUpload" class="form-control" />
        						</p>
        					{/if}
        					<div class="form-group message_contact">
        						
        						<textarea class="form-control" id="message" placeholder="{l s='Message'}" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
        					</div>
                            <div class="submit">
                				<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium"><span>{l s='Send Email'}</span></button>
                			</div>
        				</div>
        			</div>
        			
                    
                    </div>
        		</div>
        	</form>
            <!-- end contact layout 3-->
    
        {else}
            <!--  Contact form (Layout 1)  -->
        	<form action="{$request_uri}" method="post" class="contact-form-box" enctype="multipart/form-data">
        		<div>
                    <div class="row">
        			<div class="clearfix">
                        {if isset($tc_config.YBC_TC_CONTACT_PAGE_TEXT) && $tc_config.YBC_TC_CONTACT_PAGE_TEXT}
                            <div class="col-xs-12 contact_infor">
                                <p>{$tc_config.YBC_TC_CONTACT_PAGE_TEXT}</p>
                            </div>
                        {/if}
                        {if isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                            <div class="col-xs-12 col-sm-6 embe_map_contact">
                                {$tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE}
                            </div>
                        {/if}
                        
        				<div class="col-xs-12{if isset($tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE) && $tc_config.YBC_TC_GOOGLE_MAP_EMBED_CODE} ybc_delay03 col-md-6{/if}">
        					<div class="form-group selector1">
        						<label for="id_contact">{l s='Subject Heading'}</label>
        					{if isset($customerThread.id_contact) && $customerThread.id_contact && $contacts|count}
        							{assign var=flag value=true}
        							{foreach from=$contacts item=contact}
        								{if $contact.id_contact == $customerThread.id_contact}
        									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contact.name|escape:'html':'UTF-8'}" readonly="readonly" />
        									<input type="hidden" name="id_contact" value="{$contact.id_contact|intval}" />
        									{$flag=false}
        								{/if}
        							{/foreach}
        							{if $flag && isset($contacts.0.id_contact)}
        									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contacts.0.name|escape:'html':'UTF-8'}" readonly="readonly" />
        									<input type="hidden" name="id_contact" value="{$contacts.0.id_contact|intval}" />
        							{/if}
        					</div>
        					{else}
        						<select id="id_contact" class="form-control" name="id_contact">
        							<option value="0">{l s='-- Choose --'}</option>
        							{foreach from=$contacts item=contact}
        								<option value="{$contact.id_contact|intval}"{if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact} selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
        							{/foreach}
        						</select>
        					</div>
        						<p id="desc_contact0" class="desc_contact{if isset($smarty.request.id_contact)} unvisible{/if}">&nbsp;</p>
        						{foreach from=$contacts item=contact}
        							<p id="desc_contact{$contact.id_contact|intval}" class="desc_contact contact-title{if !isset($smarty.request.id_contact) || $smarty.request.id_contact|intval != $contact.id_contact|intval} unvisible{/if}">
        								<i class="icon-comment-alt"></i>{$contact.description|escape:'html':'UTF-8'}
        							</p>
        						{/foreach}
        					{/if}
        					<p class="form-group">
        						<label for="email">{l s='Email address'}</label>
        						{if isset($customerThread.email)}
        							<input class="form-control grey" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
        						{else}
        							<input class="form-control grey validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
        						{/if}
        					</p>
        					{if !$PS_CATALOG_MODE}
        						{if (!isset($customerThread.id_order) || $customerThread.id_order > 0)}
        							<div id="contact_reference" class="form-group selector1">
        								<label>{l s='Order reference'}</label>
        								{if !isset($customerThread.id_order) && isset($is_logged) && $is_logged}
        									<select name="id_order" class="form-control">
        										<option value="0">{l s='-- Choose --'}</option>
        										{foreach from=$orderList item=order}
        											<option value="{$order.value|intval}"{if $order.selected|intval} selected="selected"{/if}>{$order.label|escape:'html':'UTF-8'}</option>
        										{/foreach}
        									</select>
        								{elseif !isset($customerThread.id_order) && empty($is_logged)}
        									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.id_order) && $customerThread.id_order|intval > 0}{$customerThread.id_order|intval}{else}{if isset($smarty.post.id_order) && !empty($smarty.post.id_order)}{$smarty.post.id_order|escape:'html':'UTF-8'}{/if}{/if}" />
        								{elseif $customerThread.id_order|intval > 0}
        									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.reference) && $customerThread.reference}{$customerThread.reference|escape:'html':'UTF-8'}{else}{$customerThread.id_order|intval}{/if}" readonly="readonly" />
        								{/if}
        							</div>
        						{/if}
        						{if isset($is_logged) && $is_logged}
        							<div id="contact_order_products" class="form-group selector1">
        								<label class="unvisible">{l s='Product'}</label>
        								{if !isset($customerThread.id_product)}
        									{foreach from=$orderedProductList key=id_order item=products name=products}
        										<select name="id_product" id="{$id_order}_order_products" class="unvisible product_select form-control"{if !$smarty.foreach.products.first} style="display:none;"{/if}{if !$smarty.foreach.products.first} disabled="disabled"{/if}>
        											<option value="0">{l s='-- Choose --'}</option>
        											{foreach from=$products item=product}
        												<option value="{$product.value|intval}">{$product.label|escape:'html':'UTF-8'}</option>
        											{/foreach}
        										</select>
        									{/foreach}
        								{elseif $customerThread.id_product > 0}
        									<input  type="hidden" name="id_product" id="id_product" value="{$customerThread.id_product|intval}" readonly="readonly" />
        								{/if}
        							</div>
        						{/if}
        					{/if}
        					{if $fileupload == 1}
        						<p class="form-group">
        							<label for="fileUpload">{l s='Attach File'}</label>
        							<input type="hidden" name="MAX_FILE_SIZE" value="{if isset($max_upload_size) && $max_upload_size}{$max_upload_size|intval}{else}2000000{/if}" />
        							<input type="file" name="fileUpload" id="fileUpload" class="form-control" />
        						</p>
        					{/if}
        					<div class="form-group message_contact">
        						
        						<textarea class="form-control" id="message" placeholder="{l s='Message'}" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
        					</div>
                            <div class="submit">
        				<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium"><span>{l s='Send Email'}</span></button>
        			</div>
        				</div>
        			</div>
        			
                    <div class="contact_store_information contact_store_information_default">
                        <ul class="contact_store_information_list">
                            <li class="contact_store_information_item">
                                <div class="contact_store_information_left"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                <div class="contact_store_information_right">
                                    <label>{l s='Address:'}</label>
                                    {if (isset($tc_config.BLOCKCONTACTINFOS_COMPANY) && $tc_config.BLOCKCONTACTINFOS_COMPANY)}
                                        <div class="content">
                                            {$tc_config.BLOCKCONTACTINFOS_COMPANY},{$tc_config.BLOCKCONTACTINFOS_ADDRESS}
                                        </div>
                                    {/if}
                                </div>
                            </li>
                            
                            <li class="contact_store_information_item">
                                <div class="contact_store_information_left"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                <div class="contact_store_information_right">
                                    <label>{l s='Phone:'}</label>
                                    {if (isset($tc_config.BLOCKCONTACTINFOS_PHONE) && $tc_config.BLOCKCONTACTINFOS_PHONE)}
                                        <div class="content">
                                            {$tc_config.BLOCKCONTACTINFOS_PHONE},{$tc_config.BLOCKCONTACTINFOS_PHONE}
                                        </div>
                                    {/if}
                                </div>
                            </li>
                            
                            
                            <li class="contact_store_information_item">
                                <div class="contact_store_information_left"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                <div class="contact_store_information_right">
                                    <label>{l s='Email:'}</label>
                                    {if (isset($tc_config.BLOCKCONTACTINFOS_EMAIL) && $tc_config.BLOCKCONTACTINFOS_EMAIL)}
                                        <div class="content">
                                            {$tc_config.BLOCKCONTACTINFOS_EMAIL}
                                        </div>
                                    {/if}
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
        		</div>
        	</form>
            <!-- end contact layout 1-->
        {/if}

{/if}
{addJsDefL name='contact_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='contact_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
