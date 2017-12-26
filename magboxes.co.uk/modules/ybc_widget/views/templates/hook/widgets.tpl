{if $widgets}
    {if $widget_hook == "display-top-column" }
        {if $page_name == "index"}
            <div class="home_widget_top_column">
                <div class="container">
                    <ul class="ybc-widget-{$widget_hook} row">
                        {foreach from=$widgets item='widget'}
                            <li class="ybc-widget-item">
                                {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                                {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}                                
                                {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        {/if}
    {else if ($widget_hook == "display-left-column" || $widget_hook == "display-right-column")}
        <div class="block">
            <ul class="ybc-widget-{$widget_hook} block_content">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                        {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                        {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                    </li>
                {/foreach}
            </ul>
        </div>
    {else if $widget_hook == "display-footer"}
        <section class="footer-block col-xs-12 col-sm-2">
            <ul class="ybc-widget-{$widget_hook}">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        <div class="block_content toggle-footer">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                            {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                        </div>
                    </li>
                {/foreach}
            </ul>
        </section>
    
    {else if $widget_hook == "ybc-ybcpaymentlogo-hook"}
        <ul class="ybc-widget-{$widget_hook}">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                        {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                        
                        
                        {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                    </li>
                {/foreach}
            </ul>
    {else if $widget_hook == "ybc-footer-links"}
        <ul class="ybc-widget-{$widget_hook}">
            {foreach from=$widgets item='widget'}
                <li class="ybc-widget-item">
                    {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                    {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                    {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                    
                    {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                </li>
            {/foreach}
        </ul>
    {else if $widget_hook == "ybc-custom-3"}
        <ul class="ybc-widget-{$widget_hook}">
                
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                        <div class="content_toggle">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                            {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        </div>
                        </button>
                    </li>
                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">  
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <div class="modal-body">
                            {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                            {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                          </div>
                        </div>
                      </div>
                    </div>
                {/foreach}
            </ul>
    {else if $widget_hook == "ybc-custom-2"}
        <ul class="ybc-widget-{$widget_hook}">                
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {*<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">*}
                        <div class="content_toggle ybc_links_page_home">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{/if}
                            {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                            {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        </div>
                        
                    </li>
                    {*
                    <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">  
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <div class="modal-body">
                            {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                            {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                          </div>
                        </div>
                      </div>
                    </div>
                    *}
                {/foreach}
            </ul>
    
    {else}
        <ul class="ybc-widget-{$widget_hook}">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                        {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                        {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        
                        {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                    </li>
                {/foreach}
            </ul>
    {/if}
{/if}