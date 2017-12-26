{if $modules}
    <script type="text/javascript">
        $(document).ready(function(){
            var ybc_tc_links = '{foreach from=$modules item='module'}{if $module.installed}<li {if $module.id==$active_module} class="active" {/if} id="ybc_tc_{$module.id}"><a href="{$module.link}">{addslashes($module.name)}</a></li>{/if}{/foreach}';
            if($('#subtab-AdminYbcTC').length > 0)
            {
                $('#subtab-AdminYbcTC').after(ybc_tc_links);
            }
            else
            if($('#subtab-AdminPayment').length > 0)
            {
                $('#subtab-AdminPayment').after(ybc_tc_links);
            }
            else 
            if($('#subtab-AdminModules').length > 0)
            {
                $('#subtab-AdminModules').after(ybc_tc_links);
            }
        });
    </script>
{/if}