{if $widgets}
    {if $widget_hook == "display-top-column" }
        {if $page_name == "index"}
            <div class="home_widget_top_column{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'} home_top_colum_layout3{/if}">
                    <div class="{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT != 'LAYOUT4'}container{/if}">
                        <ul class="ybc-widget-{$widget_hook} row">
                            {foreach from=$widgets item='widget'}
                                <li class="ybc-widget-item{if (isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT2')} ybc-widget-item-layout-2{/if}{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1} wow zoomIn{/if}">
                                    <div class="ybc-widget-item-wrap">
                                        <div class="ybc-widget-item-content">
                                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                                                {if $widget.show_image && $widget.image}{if $widget.link}
                                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                                    {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>{/if}
                                                    <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}
                                                    </a>
                                                {/if}
                                            {/if}
                                            {if $widget.show_title && $widget.title || $widget.show_description && $widget.description}
                                            <div class="ybc-widget-description-content"> 
                                                {if $widget.show_title && $widget.title}
                                                    <h4 class="ybc-widget-title">
                                                        {if $widget.link}
                                                        <a href="{$widget.link}">{/if}{$widget.title}
                                                        {if $widget.link}</a>{/if}
                                                    </h4>
                                                {/if}
                                                {if $widget.show_description && $widget.description}
                                                    <div class="ybc-widget-description">
                                                        {$widget.description}
                                                    </div>
                                                {/if}
                                            </div>
                                            {/if}
                                        </div>
                                    </div>
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
        {if !isset($tc_config.YBC_TC_SIMPLE_FOOTER) || isset($tc_config.YBC_TC_SIMPLE_FOOTER) && !$tc_config.YBC_TC_SIMPLE_FOOTER}
            <section class="ybc_widget_footer_block footer-block col-xs-12 col-sm-9">
                <h4 class="">{l s='Showrooms system' mod='ybc_widget'}</h4>
                <ul class="ybc-widget-{$widget_hook} row block_content toggle-footer">
                    {foreach from=$widgets item='widget'}
                        <li class="ybc-widget-item col-sm-4">
                            {if $widget.show_title && $widget.title}<h5 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h5>{/if}
                            <div class="">
                                {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                                {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                                {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                            </div>
                        </li>
                    {/foreach}
                </ul>
            </section>
            {if isset($tc_config.YBC_TC_FACEBOOK_URL) && $tc_config.YBC_TC_FACEBOOK_URL}
                <div id="fb-root"></div>
                <div id="facebook_block" class="footer-block col-xs-12 col-sm-3">
                	<h4 >{l s='Follow us on Facebook' mod='blockfacebook'}</h4>
                	<div class="facebook-fanbox block_content toggle-footer">
                        <div class="fb-page" data-href="{$tc_config.YBC_TC_FACEBOOK_URL|escape:'html':'UTF-8'}" data-tabs="timeline" data-width="270" data-height="265" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="{$tc_config.YBC_TC_FACEBOOK_URL|escape:'html':'UTF-8'}" class="fb-xfbml-parse-ignore">
                            <a href="{$tc_config.YBC_TC_FACEBOOK_URL|escape:'html':'UTF-8'}"></a>
                        </blockquote>
                        </div>
                	</div>
                </div>
                <div class="clearfix"></div>
            {/if}
        {/if}
    {else if $widget_hook == "ybc-footer-links"}
            <ul class="ybc-widget-{$widget_hook}">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        {if $widget.show_title && $widget.title}<h4 class="">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                        <div class="block_content toggle-footer">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                            {if $widget.show_description && $widget.description}<div class="ybc-widget-description">{$widget.description}</div>{/if}
                        </div>
                    </li>
                {/foreach}
            </ul>
        
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
    {else if $widget_hook == "ybc-custom-4"}
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
        
             <ul class="ybc-widget-{$widget_hook}{if isset($tc_config.YBC_TC_ENABLE_BANNER) && $tc_config.YBC_TC_ENABLE_BANNER}{else} hidden-xs{/if}">
                {foreach from=$widgets item='widget'}
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}
                                {if $widget.link}
                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                        {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>
                                        <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />
                                    </a>
                                {/if}
                            {/if}
                            <div class="ybc-widget-description-content">
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}
                                
                                <a href="{$widget.link}">{/if}
                                {$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                                {if $widget.subtitle}<h5 class="ybc-widget-subtitle">{$widget.subtitle}</h5>{/if}
                                {if $widget.show_description && $widget.description}
                                    <div class="ybc-widget-description">{$widget.description}</div>
                                {/if}
                            </div>
                        </div>
                    </li>-->
{/foreach}
            </ul>
    {else if $widget_hook == "ybc-custom-2"}
        <ul class="ybc-widget-{$widget_hook}{if isset($tc_config.YBC_TC_ENABLE_BANNER) && $tc_config.YBC_TC_ENABLE_BANNER}{else} hidden-xs{/if}">                
                {foreach from=$widgets item='widget'}
                   <!--<li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}
                                {if $widget.link}
                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                        {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>
                                        <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />
                                    </a>
                                {/if}
                            {/if}
                            <div class="ybc-widget-description-content">
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}
                                <a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                                {if $widget.show_description && $widget.description}
                                    <div class="ybc-widget-description">{$widget.description}</div>
                                {/if}
                            </div>
                        </div>
                    </li>-->
                {/foreach}
            </ul>
    {else if $widget_hook == "ybc-custom-1"}
        
            <ul class="ybc-widget-{$widget_hook}{if isset($tc_config.YBC_TC_ENABLE_BANNER) && $tc_config.YBC_TC_ENABLE_BANNER}{else} hidden-xs{/if}">                
                {foreach from=$widgets item='widget'}
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}
                                {if $widget.link}
                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                        {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>
                                        <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />
                                    </a>
                                {/if}
                            {/if}
                            <div class="ybc-widget-description-content">
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}
                                <a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                                {if $widget.show_description && $widget.description}
                                    <div class="ybc-widget-description">{$widget.description}</div>
                                {/if}
                            </div>
                        </div>
                    </li>-->
                {/foreach}
            </ul>
    {else if $widget_hook == "ybc-custom-6"}
        <section class="footer-block">
            <h4 class="" style="display: none;">{l s='Company' mod='ybc_widget'}</h4>
            <ul class="ybc-widget-{$widget_hook} block_content toggle-footer">                
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}
                                {if $widget.link}
                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                        {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>
                                        <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />
                                    </a>
                                {/if}
                            {/if}
                            {if $widget.show_title && $widget.title}
                                {if $widget.link}<a href="{$widget.link}">{else}<span class="title">{/if}{$widget.title}{if $widget.link}</a>{else}</span>{/if}
                            {/if}
                            {if $widget.show_description && $widget.description}
                                <div class="ybc-widget-description">{$widget.description}</div>
                            {/if}
                        </div>
                    </li>
                {/foreach}
            </ul>  
        </section>      
    {else if $widget_hook == "ybc-custom-5"}
        <ul class="ybc-widget-ybc-custom-1{if isset($tc_config.YBC_TC_ENABLE_BANNER) && $tc_config.YBC_TC_ENABLE_BANNER}{else} hidden-xs{/if}">                
                {foreach from=$widgets item='widget'}
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}
                                {if $widget.link}
                                    <a class="ybc_widget_link_img" href="{$widget.link}"
                                        {if $widget.show_image && $widget.image}{if isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT == 'LAYOUT3'}style="background-image:url({$widget_module_path}images/widget/{$widget.image});"{/if}{/if}>
                                        <img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />
                                    </a>
                                {/if}
                            {/if}
                            <div class="ybc-widget-description-content">
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}
                                <a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                                {if $widget.show_description && $widget.description}
                                    <div class="ybc-widget-description">{$widget.description}</div>
                                {/if}
                            </div>
                        </div>
                    </li>-->
                {/foreach}
            </ul>
    {else if $widget_hook == "display-home"}
        <div class="ybc-widget-{$widget_hook}">
            <div class="container">
                <ul id="parala">
                    {foreach from=$widgets item='widget'}
                        <li class="ybc-widget-item{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1} wow zoomIn{/if}">
                            <div class="ybc-widget-item-content">
                                {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                                <div class="parala_content" {if isset($tc_config.YBC_TC_PARALLAX_NEWSLETTER_ON_OFF) && $tc_config.YBC_TC_PARALLAX_NEWSLETTER_ON_OFF == 1}data-top-bottom="top: 0%;" data-bottom-top="top: -75%;"{/if} 
                                {if $widget.show_image && $widget.image} style="background-image: url({$widget_module_path}images/widget/{$widget.image})"{/if}> </div>
                            
                                {if $widget.show_title && $widget.title}<h4 class="ybc-widget-title">{if $widget.link}<a href="{$widget.link}">{/if}{$widget.title}{if $widget.link}</a>{/if}</h4>{/if}
                                {if $widget.show_description && $widget.description}<div class="ybc-widget-description {if $widget.show_image && $widget.image} ybc-widget-description-white{/if}">{$widget.description}</div>{/if}
                            </div>  
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    {else}
            <div class="container">
            {if ($layouts == 'layout2')} <div class="row">{/if}
            <ul  class="ybc-widget-{$widget_hook}">
                {foreach from=$widgets item='widget'}
                    <li class="ybc-widget-item{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1} wow zoomIn{/if}">
                        <div class="ybc-widget-item-content"> 
                            {if $widget.icon}<i class="fa {$widget.icon}"></i>{/if}
                            {if $widget.show_image && $widget.image}{if $widget.link}<a href="{$widget.link}">{/if}<img src="{$widget_module_path}images/widget/{$widget.image}" alt="{$widget.title}" />{if $widget.link}</a>{/if}{/if}
                            
                            {if $widget.show_title && $widget.title || $widget.show_description && $widget.description}
                                <div class="ybc-widget-description-content"> 
                                    {if $widget.show_title && $widget.title}
                                        <h4 class="ybc-widget-title">
                                            {if $widget.link}
                                            <a href="{$widget.link}">{/if}{$widget.title}
                                            {if $widget.link}</a>{/if}
                                        </h4>
                                    {/if}
                                    {if $widget.show_description && $widget.description}
                                        <div class="ybc-widget-description">
                                            {$widget.description}
                                        </div>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    </li>
                {/foreach}
            </ul>
          {if ($layouts == 'layout2')}</div>{/if}
            </div>
    {/if}
{/if}