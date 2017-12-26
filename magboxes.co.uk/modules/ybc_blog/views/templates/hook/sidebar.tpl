<div class="list-group">
    {if $list}
        {foreach from=$list item='tab'}
            <a class="{if $active == $tab.id}active{/if} list-group-item" href="{$tab.url}" id="{$tab.id}">{if isset($tab.icon)}<i class="{$tab.icon}"></i> {/if}{$tab.label}</a>
        {/foreach}
    {/if}
</div>