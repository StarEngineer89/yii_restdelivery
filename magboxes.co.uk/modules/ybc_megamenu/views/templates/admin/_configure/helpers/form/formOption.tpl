{extends file="helpers/form/form.tpl"}
{if $input.type == 'manufacturers' || $input.type == 'cms_pages'}
    <ul style="float: left; padding: 0;">
        {if $input.manufacturers}
            {foreach from=$input.manufacturers item='mnft'}
                <li style="list-style: none;"><input style="padding-left: 10px;" type="checkbox" value="{$mnft.id_manufacturer}" name="mnfts[]" id="ybc_mm_mnft_{$mnft.id_manufacturer}" /><label for="ybc_mm_mnft_{$mnft.id_manufacturer}">{$mnft.name}</label></li>
            {/foreach}
        {/if}
    </ul>
{/if}