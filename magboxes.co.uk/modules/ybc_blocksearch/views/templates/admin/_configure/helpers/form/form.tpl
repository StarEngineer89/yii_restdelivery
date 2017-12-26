{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {$smarty.block.parent}
	{if $input.type == 'file' &&  isset($input.display_img) && $input.display_img}
        <label class="control-label col-lg-3" style="font-style: italic;">{l s='Uploaded image: ' mod='ybc_blocksearch'}</label>
        <div class="col-lg-9">
    		<a  class="ybc_fancy" href="{$input.display_img}"><img title="{l s='Click to see full size image' mod='ybc_blocksearch'}" style="display: inline-block; max-width: 200px;" src="{$input.display_img}" /></a>
            {if isset($input.img_del_link) && $input.img_del_link && !(isset($input.required) && $input.required)}
                <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ybc_blocksearch'}');" style="display: inline-block; text-decoration: none!important;" href="{$input.img_del_link}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
            {/if}
        </div>
    {/if}
{/block}

{block name="footer"}
    {capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
	{if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}
		<div class="panel-footer">
            <script type="text/javascript">
                $(document).ready(function(){
                    if($('.ybc_fancy').length > 0)
                    {
                        $('.ybc_fancy').fancybox();
                    }
                });
            </script>
            {*{if isset($export_link) && $export_link}
                <a class="btn btn-default" href="{$export_link}"><i class="process-icon-export"></i>{l s='Export to .csv file' mod='ybc_blocksearch'}</a>
            {/if}*}
            {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
			</button>
			{/if}
            
		</div>
	{/if}
{/block}
