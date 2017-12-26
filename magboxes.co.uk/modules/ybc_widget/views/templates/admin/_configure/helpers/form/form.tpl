{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {$smarty.block.parent}
	{if $input.type == 'file' && (!isset($input.imageType) || isset($input.imageType) && $input.imageType!='thumb')&&  isset($display_img) && $display_img}
        <label class="control-label col-lg-3" style="font-style: italic;">{l s='Uploaded image: ' mod='ybc_widget'}</label>
        <div class="col-lg-9">
    		<a  class="ybc_fancy" href="{$display_img}"><img title="{l s='Click to see full size image' mod='ybc_widget'}" style="display: inline-block; max-width: 200px;" src="{$display_img}" /></a>
            {if isset($img_del_link) && $img_del_link && !(isset($input.required) && $input.required)}
                <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ybc_widget'}');" style="display: inline-block; text-decoration: none!important;" href="{$img_del_link}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
            {/if}
        </div>
    {elseif $input.type == 'file' && isset($input.imageType) && $input.imageType=='thumb' &&  isset($display_thumb) && $display_thumb}
	    <label class="control-label col-lg-3" style="font-style: italic;">{l s='Uploaded image: ' mod='ybc_widget'}</label>
        <div class="col-lg-9">
    		<a  class="ybc_fancy" href="{$display_thumb}"><img title="{l s='Click to see full size image' mod='ybc_widget'}" style="display: inline-block; max-width: 200px;" src="{$display_thumb}" /></a>
            {if isset($thumb_del_link) && $thumb_del_link && !(isset($input.required) && $input.required)}
                <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ybc_widget'}');" style="display: inline-block; text-decoration: none!important;" href="{$thumb_del_link}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
            {/if}
        </div>
    {/if}
{/block}

{block name="footer"}
    {capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
	{if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}
		<div class="panel-footer">
            {if isset($cancel_url) && $cancel_url}
                <a class="btn btn-default" href="{$cancel_url}"><i class="process-icon-cancel"></i>{l s='Cancel' mod='ybc_widget'}</a>
            {/if}
            {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
			</button>
			{/if}
            
		</div>
	{/if}
{/block}