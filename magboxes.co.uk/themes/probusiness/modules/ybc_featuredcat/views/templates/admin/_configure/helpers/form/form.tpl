{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {if $input.type != 'blog_categories' && $input.type != 'products_search' && $input.name !='url_alias'}
        {$smarty.block.parent}
    	{if $input.type == 'file' &&  isset($input.display_img) && $input.display_img}
            <label class="control-label col-lg-3" style="font-style: italic;">{l s='Uploaded image: '}</label>
            <div class="col-lg-9">
        		<a  class="ybc_fancy" href="{$input.display_img}"><img title="{l s='Click to see full size image'}" style="display: inline-block; max-width: 200px;" src="{$input.display_img}" /></a>
                {if isset($input.img_del_link) && $input.img_del_link && !(isset($input.required) && $input.required)}
                    <a onclick="return confirm('{l s='Do you want to delete this image?'}');" style="display: inline-block; text-decoration: none!important;" href="{$input.img_del_link}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
                {/if}
            </div>
        {/if}
    {else}
        {if $input.type == 'blog_categories'}
            <div class="col-lg-9">
                <ul style="float: left; padding: 0; margin-top: 5px;">
                    {if $input.categories}
                        {foreach from=$input.categories item='cat'}
                            {if $cat.title}
                                <li style="list-style: none;"><input {if in_array($cat.id_category, $input.selected_categories)} checked="checked" {/if} style="margin: 2px 7px 0 5px; float: left;" type="checkbox" value="{$cat.id_category}" name="categories[]" id="ybc_input_blog_category_{$cat.id_category}" /><label for="ybc_input_blog_category_{$cat.id_category}">{$cat.title}</label></li>
                            {/if}                            
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/if}
        {if $input.name == "url_alias"}
    		<script type="text/javascript">
        		{if isset($PS_ALLOW_ACCENTED_CHARS_URL) && $PS_ALLOW_ACCENTED_CHARS_URL}
        			var PS_ALLOW_ACCENTED_CHARS_URL = 1;
        		{else}
        			var PS_ALLOW_ACCENTED_CHARS_URL = 0;
        		{/if}
            </script>
            {$smarty.block.parent}
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
                <a class="btn btn-default" href="{$cancel_url}"><i class="process-icon-cancel"></i>Cancel</a>
            {/if}
            {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
			</button>
			{/if}
            
		</div>
	{/if}
{/block}