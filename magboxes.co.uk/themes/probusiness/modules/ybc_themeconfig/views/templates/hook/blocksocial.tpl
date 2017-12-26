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
<section id="social_block" class="footer-block col-xs-12 col-md-4 col-sm-4">
     <h4>{l s='Connect with us' mod='blocksocial'}</h4>
     <div class="toggle-footer">
     <p>{l s='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero' mod='blocksocial'} </p>
	<ul>
		{if isset($facebook_url) && $facebook_url != ''}
			<li class="facebook">
				<a class="_blank" href="{$facebook_url|escape:html:'UTF-8'}">
					<span><i class="icon-facebook" aria-hidden="true"></i>{l s='Facebook' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
		
        {if isset($google_plus_url) && $google_plus_url != ''}
        	<li class="google-plus">
        		<a class="_blank" href="{$google_plus_url|escape:html:'UTF-8'}" rel="publisher">
        			<span><i class="fa fa-google" aria-hidden="true"></i>{l s='Google Plus' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($twitter_url) && $twitter_url != ''}
			<li class="twitter">
				<a class="_blank" href="{$twitter_url|escape:html:'UTF-8'}">
					<span><i class="icon-twitter" aria-hidden="true"></i>{l s='Twitter' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
        {if isset($linkedin_url) && $linkedin_url != ''}
			<li class="linkedin">
				<a class="_blank" href="{$linkedin_url|escape:html:'UTF-8'}">
					<span><i class="icon-linkedin" aria-hidden="true"></i>{l s='Linkedin' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
        {if isset($youtube_url) && $youtube_url != ''}
        	<li class="youtube">
        		<a class="_blank" href="{$youtube_url|escape:html:'UTF-8'}">
        			<span><i class="fa fa-youtube-play" aria-hidden="true"></i>{l s='Youtube' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
		{if isset($rss_url) && $rss_url != ''}
			<li class="rss">
				<a class="_blank" href="{$rss_url|escape:html:'UTF-8'}">
					<span><i class="icon-rss" aria-hidden="true"></i>{l s='RSS' mod='blocksocial'}</span>
				</a>
			</li>
		{/if}
     
        
        {if isset($pinterest_url) && $pinterest_url != ''}
        	<li class="pinterest">
        		<a class="_blank" href="{$pinterest_url|escape:html:'UTF-8'}">
        			<span><i class="icon-pinterest-p" aria-hidden="true"></i>{l s='Pinterest' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($vimeo_url) && $vimeo_url != ''}
        	<li class="vimeo">
        		<a class="_blank" href="{$vimeo_url|escape:html:'UTF-8'}">
        			<span><i class="icon-vimeo-square" aria-hidden="true"></i>{l s='Vimeo' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
        {if isset($instagram_url) && $instagram_url != ''}
        	<li class="instagram">
        		<a class="_blank" href="{$instagram_url|escape:html:'UTF-8'}">
        			<span><i class="icon-instagram" aria-hidden="true"></i>{l s='Instagram' mod='blocksocial'}</span>
        		</a>
        	</li>
        {/if}
	</ul>
   </div>
</section>
<div class="clearfix"></div>
