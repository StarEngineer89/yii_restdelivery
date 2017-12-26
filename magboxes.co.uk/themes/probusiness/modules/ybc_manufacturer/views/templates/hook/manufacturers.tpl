{if $manufacturers}
    <div id="ybc-mnf-block">
        <div class="container">
            <div class="ybc-mnf-block-content">
                <h4 class="ybc-mnf-block-title title-home">
                    <span>{$YBC_MF_TITLE}</span>
                </h4>
                <ul id="ybc-mnf-block-ul">
                	{foreach from=$manufacturers item=manufacturer}
                		<li class="ybc-mnf-block-li{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1} wow zoomIn{/if}">
                            <a class="ybc-mnf-block-a-img" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html'}"><img src="{$manufacturer.image}" alt="" /></a>
                            {if $YBC_MF_SHOW_NAME}<a class="ybc-mnf-block-a-name" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html'}">{$manufacturer.name|escape:'html':'UTF-8'}</a>{/if}
                        </li>
                	{/foreach}
                </ul>
            </div>
        </div>
    </div>
{/if}