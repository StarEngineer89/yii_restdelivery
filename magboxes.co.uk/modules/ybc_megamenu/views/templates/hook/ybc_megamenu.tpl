{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{if $menus}
    <div class="ybc-menu-wrapper {if $fixedPositionFull}fixed-full{/if} {$YBC_MM_DIRECTION} {if !$YBC_MM_ARROW}ybc-no-arrow{/if} {if isset($fixedPosition) && $fixedPosition}position-fixed{else}position-not-fixed{/if} {if $YBC_MOBILE_MM_TYPE}ybc-mm-mobile-type-{$YBC_MOBILE_MM_TYPE}{else}ybc-mm-mobile-type-default{/if} {if $YBC_MM_TYPE}ybc-menu-layout-{$YBC_MM_TYPE}{else}ybc-menu-layout-default{/if} {if $YBC_MM_SKIN}ybc-menu-skin-{$YBC_MM_SKIN}{else}ybc-menu-skin-default{/if} ybc-menu-{$effect}{if isset($customClass) && $customClass} {$customClass}{/if}{if isset($mobileImage) && !$mobileImage} ybc-menu-hide-image-on-mobile{/if} col-xs-12 col-sm-12">
    	{if isset($fixedPosition) && $fixedPosition}<div class="container">{/if}
        <div class="ybc-menu-toggle ybc-menu-btn">
          <div class="ybc-menu-button-toggle">            
            <span>{l s='Menu' mod='ybc_megamenu'}</span>
            <i class="fa fa-bars"></i>
          </div>
        </div>
        <div class="ybc-menu-blinder"></div>
        <div class="ybc-menu-main-content" id="ybc-menu-main-content">            
                <div class="ybc-sub-menu-header">
                    <span>{l s='Menu' mod='ybc_megamenu'}</span>
                    <span class="ybc-menu-btn"></span>
                </div>
                <ul class="ybc-menu">  
        			{foreach from=$menus item=menu}
                        {if $menu.enabled}
            				<li class="{if isset($menu.columns) && $menu.columns}ybc-menu-has-sub{/if} ybc-menu-item {if $menu.custom_class}{$menu.custom_class}{/if} ybc-menu-sub-type-{strtolower($menu.menu_type)}{if $menu.column_type} ybc-menu-column-type-{strtolower($menu.column_type)}{else} ybc-menu-column-type-left{/if} {if !$menu.wrapper_border}no-wrapper-border{/if} {if $menu.sub_type}sub-type-{strtolower($menu.sub_type)}{else}sub-type-title{/if}" id="ybc-menu-{$menu.id_menu}">	
                                    <!-- level 1 -->
                                    {if $menu.url}
                                	   <a class="ybc-menu-item-link" href="{$menu.url}">{if $menu.show_icon && $menu.icon}<i class="fa icon {$menu.icon} {str_replace('fa-','icon-',$menu.icon)}"></i> {/if}<span>{$menu.title}</span>{if isset($menu.columns) && $menu.columns} <span class="icon-submenu-exist"></span>{/if}</a>
                                    {else}
                                        <a class="ybc-menu-item-link ybc-menu-item-no-link" href="#" ><span class="">{if $menu.show_icon && $menu.icon}<i class="fa icon {$menu.icon} {str_replace('fa-','icon-',$menu.icon)}"></i> {/if}{$menu.title}</span></a>
                                    {/if}
                                    <!-- /leve 1 -->
                                    <!-- Columns -->
                                    {if isset($menu.columns) && $menu.columns || $menu.image}
                                        <span class="ybc-mm-control closed"></span>
                                        <div {if $menu.sub_menu_max_width && $menu.sub_menu_max_width}style="max-width: {(int)$menu.sub_menu_max_width}%;"{/if} class="ybc-menu-columns-wrapper ybc-mm-control-content" id="ybc-menu-columns-wrapper-{$menu.id_menu}">
                                            {if $menu.image && $menu.banner_position == 'top'}
                                                <div class="ybc-menu-banner position-top">
                                                    {if $menu.banner_link}<a href="{$menu.banner_link}"><img src="{$menu.image}" alt="{$menu.title}" /></a>{else}<img src="{$menu.image}" alt="{$menu.title}" />{/if}
                                                </div>
                                            {/if}
                                            {foreach from=$menu.columns item=column}
                                                {if $column.enabled}
                                    				<div class="ybc-menu-column-item ybc-menu-column-size-{$column.column_size} {if $column.custom_class}{$column.custom_class}{/if}" id="ybc-menu-column-{$column.id_column}">
                                                        <!-- Column content -->     
                                                        {if $column.show_title && $column.title || $column.show_image && $column.image || $column.show_description && $column.description}
                                                            <div class="ybc-menu-column-top">                                                 
                                                                {if $column.show_title && $column.title}<h6>{if $column.column_link}<a href="{$column.column_link}">{$column.title}</a>{else}{$column.title}{/if}</h6>{/if}
                                                                {if $column.show_image && $column.image}{if $column.column_link}<a href="{$column.column_link}"><img src="{$column.image}" alt="{$column.title}" /></a>{else}<img src="{$column.image}" alt="{$column.title}" />{/if}{/if}
                                                                {if $column.show_description && $column.description}<div class="ybc_description_block">{$column.description}</div>{/if}
                                                            </div>
                                                        {/if}  
                                                        <!-- /Column content -->                                                    	
                                                        <!-- Blocks -->
                                                        {if isset($column.blocks) && $column.blocks}                                                        
                                                                {foreach from=$column.blocks item=block}
                                                                    {if $block.enabled}
                                                                        <div class="ybc-menu-block {if $block.custom_class}{$block.custom_class}{/if} ybc-menu-block-type-{strtolower($block.block_type)}">
                                                                            {if $block.show_title && $block.title || $block.show_image && $block.image || $block.show_description && $block.description}
                                                                                <div class="ybc-menu-block-top ybc-menu-title-block">                                                 
                                                                                    {if $block.show_title && $block.title}<h6>{if $block.block_link}<a href="{$block.block_link}">{$block.title}</a>{else}{$block.title}{/if}</h6>{/if}
                                                                                    {if $block.show_image && $block.image}<div class="ybc-menu-block-img">{if $block.block_link}<a href="{$block.block_link}"><img src="{$block.image}" alt="{$block.title}" /></a>{else}<img src="{$block.image}" alt="{$block.title}" />{/if}</div>{/if}
                                                                                    {if $block.show_description && $block.description}<p>{$block.description}</p>{/if}
                                                                                </div>
                                                                            {/if} 
                                                                            {if $block.block_type=='HTML' && isset($block.html_block) && $block.html_block}
                                                                                <div class="ybc-menu-block-bottom ybc-menu-block-custom-html">
                                                                                    {$block.html_block}
                                                                                </div>
                                                                            {/if}  
                                                                            {if $block.block_type!='HTML' && isset($block.urls) && $block.urls}
                                                                                <div class="ybc-menu-block-bottom">
                                                                                    <ul class="ybc-menu-block-links {if $block.block_type=='CATEGORY'}ybc-ul-category{/if}">
                                                                                        {foreach from=$block.urls item='url'}                                                                                        
                                                                                            <li class="{if isset($url.info) && $url.info}ybc-mm-product-block{else}ybc-no-product-block{/if}">
                                                                                                {if isset($url.id)}
                                                                                                    {assign var="subcatId" value=$url.id}
                                                                                                {else}
                                                                                                    {assign var="subcatId" value=0}
                                                                                                {/if}
                                                                                                {if isset($url.info) && $url.info}
                                                                                                    <a class="ybc-mm-product-img-link" href="{$url.url}"><img src="{$url.info.img_url}" alt="{$url.title}" /></a>
                                                                                                {/if}
                                                                                                    <a class="{if isset($url.info) && $url.info}ybc-mm-product-link{else}ybc-mm-item-link{/if}" href="{$url.url}">{$url.title}</a>
                                                                                                    {if isset($block.subCategories.$subcatId) && $block.subCategories.$subcatId}<span class="ybc-mm-control closed"></span>{/if}
                                                                                                    
                                                                                                {if isset($url.info) && $url.info}
                                                                                                    <div itemtype="http://schema.org/Product" itemscope="" class="ybc-mm-product-review">{hook h='displayYbcReviews' product=$url.info.product}</div>
                                                                                                    <div class="ybc-mm-price-row">                                                                                                    
                                                                                                        {if $url.info.price != $url.info.old_price}                                                                                                    
                                                                                                                <span class="ybc-mm-old-price">{$url.info.old_price}</span>
                                                                                                                <span class="ybc-mm-price">{$url.info.price}</span>
                                                                                                                <span class="ybc-mm-discount-percent">-{$url.info.discount_percent}%</span>
                                                                                                                <span class="ybc-mm-discount-saveup">{l s='Save up' mod='ybc_megamenu'}<span class="ybc-mm-discount-saveup-amount">{$url.info.discount_amount}</span></span>                                                                                                        
                                                                                                        {else}
                                                                                                            <span class="ybc-mm-price">{$url.info.price}</span>
                                                                                                        {/if}
                                                                                                    </div>
                                                                                                    {if $url.info.description}
                                                                                                        <div class="ybc-mm-description">{strip_tags($url.info.description)|truncate:100:'...'|escape:'html':'UTF-8'}</div>
                                                                                                    {/if}
                                                                                                {/if}                                                                                            
                                                                                                {if isset($block.subCategories.$subcatId) && $block.subCategories.$subcatId}{$block.subCategories.$subcatId}{/if}                                                                                           
                                                                                            </li>
                                                                                        {/foreach}
                                                                                    </ul>
                                                                                </div>
                                                                            {/if}                                                      				
                                                                        </div>
                                                                    {/if}
                                                    			{/foreach}                                                        
                                                        {/if}
                                                       <!-- /Blocks -->	
                                    				</div>   
                                                 {/if}                                     
                                			{/foreach}
                                            {if $menu.image && $menu.banner_position != 'top'}
                                                <div class="ybc-menu-banner position-bottom">
                                                    {if $menu.banner_link}<a href="{$menu.banner_link}"><img src="{$menu.image}" alt="{$menu.title}" /></a>{else}<img src="{$menu.image}" alt="{$menu.title}" />{/if}
                                                </div>
                                            {/if}
                                        </div>
                                    {/if}
                                 <!-- /Columns  -->		
            				</li> 
                        {/if}                   
        			{/foreach}
        	   </ul>
        </div>
        {if isset($fixedPosition) && $fixedPosition}</div>{/if}
    </div>
{/if}