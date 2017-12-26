{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {if $input.type != 'manufacturers' && $input.type != 'cms_pages' && $input.type != 'products_search' && $input.type != 'manufacturer_menu' && $input.type != 'cms_page_menu'}
        {$smarty.block.parent}
    	{if $input.type == 'file' &&  isset($display_img) && $display_img}
            <label class="control-label col-lg-3" style="font-style: italic;">{l s='Uploaded image: ' mod='ybc_megamenu'}</label>
            <div class="col-lg-9">
        		<a  class="ybc_fancy" href="{$display_img}"><img title="{l s='Click to see full size image' mod='ybc_megamenu'}" style="display: inline-block; max-width: 200px;" src="{$display_img}" /></a>
                {if isset($img_del_link) && $img_del_link}
                    <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ybc_megamenu'}');" style="display: inline-block; text-decoration: none!important;" href="{$img_del_link}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
                {/if}
            </div>
    	{/if}
    {else}
        {if $input.type == 'manufacturers'}
            <div class="col-lg-9">
                <ul style="float: left; padding: 0; margin-top: 5px;">
                    {if $input.manufacturers}
                        {foreach from=$input.manufacturers item='mnft'}
                            <li style="list-style: none;"><input {if in_array($mnft.id_manufacturer, $input.selected_mnfts)} checked="checked" {/if} style="margin: 2px 7px 0 5px; float: left;" type="checkbox" value="{$mnft.id_manufacturer}" name="mnfts[]" id="ybc_mm_mnft_{$mnft.id_manufacturer}" /><label for="ybc_mm_mnft_{$mnft.id_manufacturer}">{$mnft.name}</label></li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/if}
        {if $input.type == 'manufacturer_menu'}
            <div class="col-lg-9">
                <ul style="float: left; padding: 0; margin-top: 5px;">
                    {if $input.manufacturers}
                        {foreach from=$input.manufacturers item='mnft'}
                            <li style="list-style: none;"><input {if $mnft.id_manufacturer == $input.selected_mnft} checked="checked" {/if} style="margin: 2px 7px 0 5px; float: left;" type="radio" value="{$mnft.id_manufacturer}" name="id_manufacturer" id="ybc_mm_mnft_{$mnft.id_manufacturer}" /><label for="ybc_mm_mnft_{$mnft.id_manufacturer}">{$mnft.name}</label></li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/if}
        {if $input.type == 'cms_pages'}
            <div class="col-lg-9">
                <ul style="float: left; padding: 0; margin-top: 5px;">
                    {if $input.pages}
                        {foreach from=$input.pages item='page'}
                            <li style="list-style: none;"><input {if in_array($page.id_cms, $input.selected_pages)} checked="checked" {/if}  style="margin: 2px 7px 0 5px; float: left;" type="checkbox" value="{$page.id_cms}" name="cms_pages[]" id="ybc_mm_cms_{$page.id_cms}" /><label for="ybc_mm_cms_{$page.id_cms}">{$page.meta_title}</label></li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/if}
        {if $input.type == 'cms_page_menu'}
            <div class="col-lg-9">
                <ul style="float: left; padding: 0; margin-top: 5px;">
                    {if $input.pages}
                        {foreach from=$input.pages item='page'}
                            <li style="list-style: none;"><input {if $page.id_cms == $input.selected_page} checked="checked" {/if}  style="margin: 2px 7px 0 5px; float: left;" type="radio" value="{$page.id_cms}" name="id_cms" id="ybc_mm_cms_{$page.id_cms}" /><label for="ybc_mm_cms_{$page.id_cms}">{$page.meta_title}</label></li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/if}
        {if $input.type == 'products_search'}
            <div class="col-lg-9">
                <div id="ajax_choose_product">
                    <input type="hidden" name="inputAccessories" id="inputAccessories" value="{if $input.selected_products}{foreach from=$input.selected_products item=accessory}{$accessory.id_product}-{/foreach}{/if}" />
			        <input type="hidden" name="nameAccessories" id="nameAccessories" value="{if $input.selected_products}{foreach from=$input.selected_products item=accessory}{$accessory.name|escape:'html':'UTF-8'}¤{/foreach}{/if}" />
			
    				<div class="input-group">
    					<input type="text" id="product_autocomplete_input" name="product_autocomplete_input" />
    					<span class="input-group-addon"><i class="icon-search"></i></span>
    				</div>
                    <div id="divAccessories">
                        {if $input.selected_products}    
                            {foreach from=$input.selected_products item=accessory}
                    			<div class="form-control-static">
                    				<button type="button" class="btn btn-default" onclick="ybcDelAccessory({$accessory.id_product});" name="{$accessory.id_product}">
                    					<i class="icon-remove text-danger"></i>
                    				</button>
                    				{$accessory.name|escape:'html':'UTF-8'}{if !empty($accessory.reference)}{$accessory.reference}{/if}
                    			</div>
                			{/foreach}    		     	
                        {/if}		
        			</div>
    			</div>
            </div>
        {/if}
    {/if}
{/block}

{block name="footer"}
    {capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
	{if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}
		<div class="panel-footer">
            {if isset($cancel_url) && $cancel_url}
                <a class="btn btn-default" href="{$cancel_url}"><i class="process-icon-cancel"></i>{l s='Back' mod='ybc_megamenu'}</a>
            {/if}
            {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
			</button>
			{/if}
            
		</div>
	{/if}
{/block}