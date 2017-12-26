    <div class="header-container">           
        <header id="header" class="header_style_2">
        {capture name='displayBanner'}{hook h='displayBanner'}{/capture}
        {if $smarty.capture.displayBanner}
        	<div class="banner">
        		<div class="container">
        			<div class="row">
        				{$smarty.capture.displayBanner}
        			</div>
        		</div>
        	</div>
        {/if}
        {capture name='displayNav'}{hook h='displayNav'}{/capture}
        {if $smarty.capture.displayNav}
			<div class="nav">
				<div class="container">
					<div class="row">
						<nav>
                            <div class="info_toggle_mobile">
                                <span class="info_toggle hidden-lg hidden-md hidden-sm">
                                    <i class="fa fa-info-circle"></i>{l s='Info'}
                                </span>
                                {hook h='ybcCustom4'}
                            </div>
                            {if isset($tc_display_settings) && $tc_display_settings}
                                <div class="toogle_nav_button">
                                    <span class="toogle_nav">
                                        <i class="fa fa-cog"></i>
                                        {l s='Settings' mod='blockuserinfo'}
                                    </span>
                                    <div class="toogle_nav_content">
                                        {$smarty.capture.displayNav}
                                    </div>
                                </div>
                            {/if}
                            <div class="ybc_myaccout">
                                <div class="toogle_user">
                                    <a class="my_account" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='My account' mod='blockuserinfo'}">
                                        <i class="fa fa-user"></i>
                                        {l s='Account' mod='blockuserinfo'}
                                    </a>
                                </div>
                                 
                                <div class="header_user_info blockuserinfo">
                                    <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">
                                        <span class="">{l s='My Account' mod='blockuserinfo'}</span>
                                    </a>                
                                    <a class="bt_wishlist_userinfor" href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My wishlists' mod='blockuserinfo'}">
                                        <span>{l s='My wishlists' mod='blockuserinfo'}</span>
                                    </a>
                                    <a class="bt_compare_userinfor" href="{$link->getPageLink('products-comparison')|escape:'html':'UTF-8'}" title="{l s='My comparison' mod='blockuserinfo'}">
                                        <span>{l s='My comparison' mod='blockuserinfo'}</span>
                                    </a>
                                </div>
                            </div>
                            {if $is_logged}
                            	<a class="logout userinfor" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
                            		<i class="icon icon-key"></i>
                                    {l s='Sign out' mod='blockuserinfo'}
                            	</a>
                            {else}
                            	<a class="login userinfor" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
                            		<i class="icon icon-key"></i>
                                    {l s='Sign in' mod='blockuserinfo'}
                            	</a>
                            {/if}
                            
                        </nav>
					</div>
				</div>
			</div>
		{/if}
        <div class="header_bottom{if isset($tc_config.YBC_TC_FLOAT_HEADER) && $tc_config.YBC_TC_FLOAT_HEADER} ybc_float_header{/if}">
			<div class="container">
				<div class="row">
					<div id="header_logo" class="">
						<a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}">
							<img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}/>
						</a>
					</div>
                    {if isset($HOOK_TOP)}
                        {$HOOK_TOP}
                    {/if}
                    {if isset($tc_config.BLOCKCONTACTINFOS_PHONE) && $tc_config.BLOCKCONTACTINFOS_PHONE != ''}
                        <div class="shop_text_nav">
                            <div class="shop_text_nav_config">
                                <b>{l s='Call us now'}</b><br />{$tc_config.BLOCKCONTACTINFOS_PHONE}
                            </div>
                        </div>
                    {/if}
				</div>
			</div>
            <div class="main-menu">
                <div class="container">
                    {hook h='custom'}
                </div>
            </div>
		</div>     
        </header>
                    
    </div>
	<div class="columns-container">
        <div id="slider_row" class="">
            {capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
			{if $smarty.capture.displayTopColumn}
				<div id="top_column" class="">
                    {$smarty.capture.displayTopColumn}
                    {if $page_name =='index'}
                        {hook h='ybccustom5'}
                    {/if}
                </div>
			{/if}
		</div>
        {if $page_name !='index' && $page_name !='pagenotfound'}
            <div class="ybc_full_bg_breadcrum">
                <div class="container">
                    
    					{include file="$tpl_dir./breadcrumb.tpl"}
    				
                </div>
            </div>
        {/if}
		<div id="columns" class="{if $page_name != 'index'}container{/if}">
			<div {if $page_name != 'index'}class="row"{/if}>
				{if isset($left_column_size) && !empty($left_column_size)}
				<div id="left_column" class="column col-xs-12 col-sm-{$left_column_size|intval}">{$HOOK_LEFT_COLUMN}</div>
				{/if}
				{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
				<div id="center_column" class="center_column col-xs-12 col-sm-{$cols|intval}">