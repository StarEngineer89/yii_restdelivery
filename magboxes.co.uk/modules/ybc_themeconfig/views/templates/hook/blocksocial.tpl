{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<section id="ybc_social_block" class="ybc_social_config">
    <h4 style="display: none;">{l s='Social' mod='ybc_themeconfig'}</h4>
	<ul>
		{if isset($facebook_url) && $facebook_url != ''}
			<li class="facebook">
				<a class="_blank" href="{$facebook_url|escape:html:'UTF-8'}">
					<span><i class="icon-facebook"></i>{l s='Facebook' mod='ybc_themeconfig'}</span>
				</a>
			</li>
		{/if}
		{if isset($twitter_url) && $twitter_url != ''}
			<li class="twitter">
				<a class="_blank" href="{$twitter_url|escape:html:'UTF-8'}">
					<span><i class="icon-twitter"></i>{l s='Twitter' mod='ybc_themeconfig'}</span>
				</a>
			</li>
		{/if}
        {if isset($google_plus_url) && $google_plus_url != ''}
        	<li class="google-plus">
        		<a class="_blank" href="{$google_plus_url|escape:html:'UTF-8'}" rel="publisher">
        			<span><i class="icon-google-plus"></i>{l s='Google Plus' mod='ybc_themeconfig'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($linkedin_url) && $linkedin_url != ''}
			<li class="linkedin">
				<a class="_blank" href="{$linkedin_url|escape:html:'UTF-8'}">
					<span><i class="icon-linkedin" ></i>{l s='Linkedin' mod='ybc_themeconfig'}</span>
				</a>
			</li>
		{/if}
		{if isset($rss_url) && $rss_url != ''}
			<li class="rss">
				<a class="_blank" href="{$rss_url|escape:html:'UTF-8'}">
					<span><i class="icon-rss"></i>{l s='RSS' mod='ybc_themeconfig'}</span>
				</a>
			</li>
		{/if}
        {if isset($youtube_url) && $youtube_url != ''}
        	<li class="youtube">
        		<a class="_blank" href="{$youtube_url|escape:html:'UTF-8'}">
        			<span><i class="icon-youtube"></i>{l s='Youtube' mod='ybc_themeconfig'}</span>
        		</a>
        	</li>
        {/if}
        
        {if isset($pinterest_url) && $pinterest_url != ''}
        	<li class="pinterest">
        		<a class="_blank" href="{$pinterest_url|escape:html:'UTF-8'}">
        			<span><i class="icon-pinterest-p"></i>{l s='Pinterest' mod='ybc_themeconfig'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($vimeo_url) && $vimeo_url != ''}
        	<li class="vimeo">
        		<a class="_blank" href="{$vimeo_url|escape:html:'UTF-8'}">
        			<span><i class="icon-vimeo-square"></i>{l s='Vimeo' mod='ybc_themeconfig'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($instagram_url) && $instagram_url != ''}
        	<li class="instagram">
        		<a class="_blank" href="{$instagram_url|escape:html:'UTF-8'}">
        			<span><i class="icon-instagram" ></i>{l s='Instagram' mod='ybc_themeconfig'}</span>
        		</a>
        	</li>
        {/if}
	</ul>
   
</section>
<div class="clearfix"></div>
