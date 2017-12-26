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

    {if !isset($content_only) || !$content_only}
    					</div><!-- #center_column -->
    					{if isset($right_column_size) && !empty($right_column_size)}
    						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
    					{/if}
    					</div><!-- .row -->
    				</div><!-- #columns -->
    			</div><!-- .columns-container -->
                
              {*if (isset($tc_config.YBC_TC_LAYOUT) && $tc_config.YBC_TC_LAYOUT != 'LAYOUT4')*}
                {if isset($HOOK_FOOTER)}
    				<!-- Footer -->
                    <div class="footer-wrapper">
        				<div class="footer-container container">
        					<footer id="footer" {if isset($tc_config.YBC_TC_SIMPLE_FOOTER) && $tc_config.YBC_TC_SIMPLE_FOOTER}class="simple-footer"{/if}>
        						<div class="row">
                                    {$HOOK_FOOTER}
                                </div>
        					</footer>
        				</div><!-- #footer -->
                        <div class="footer_middle">
                            <div class="container">
                                {if isset($tc_config.YBC_TC_PAYMENT_LOGO) && $tc_config.YBC_TC_PAYMENT_LOGO}
                                    <div class="payment_footer">                                       
                                        <ul class="payment_footer_img">
                                            <li>
                                                <img src="{$tc_module_path}images/config/{$tc_config.YBC_TC_PAYMENT_LOGO}" alt="{l s='Payment methods'}" title="{l s='Payment methods'}" />
                                            </li>
                                        </ul>
                                    </div>
                                {/if}
                                {hook h='ybccustom6'}
                            </div>
                        </div>
                        <div class="footer_bottom">
                            <div class="container">      
                                <div class="section_social">
                                    <ul>
                                		{if isset($tc_config.BLOCKSOCIAL_FACEBOOK) && $tc_config.BLOCKSOCIAL_FACEBOOK != ''}
                                			<li class="facebook">
                                				<a class="_blank" href="{$tc_config.BLOCKSOCIAL_FACEBOOK|escape:html:'UTF-8'}">
                                					<span><i class="icon-facebook"></i></span>
                                                    <span class="icon_hover"><i class="icon-facebook"></i></span>
                                				</a>
                                			</li>
                                		{/if}
                                        {if isset($tc_config.BLOCKSOCIAL_TWITTER) && $tc_config.BLOCKSOCIAL_TWITTER != ''}
                                			<li class="twitter">
                                				<a class="_blank" href="{$tc_config.BLOCKSOCIAL_TWITTER|escape:html:'UTF-8'}">
                                					<span><i class="icon-twitter"></i></span>
                                                    <span class="icon_hover"><i class="icon-twitter"></i></span>
                                				</a>
                                			</li>
                                		{/if}
                                        {if isset($tc_config.BLOCKSOCIAL_GOOGLE_PLUS) && $tc_config.BLOCKSOCIAL_GOOGLE_PLUS != ''}
                                        	<li class="google-plus">
                                        		<a class="_blank" href="{$tc_config.BLOCKSOCIAL_GOOGLE_PLUS|escape:html:'UTF-8'}" rel="publisher">
                                        			<span><i class="fa fa-google-plus"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-google-plus"></i></span>
                                        		</a>
                                        	</li>
                                        {/if}
                                        {if isset($tc_config.BLOCKSOCIAL_INSTAGRAM) && $tc_config.BLOCKSOCIAL_INSTAGRAM != ''}
                                        	<li class="instagram">
                                        		<a class="_blank" href="{$tc_config.BLOCKSOCIAL_INSTAGRAM|escape:html:'UTF-8'}">
                                        			<span><i class="icon-instagram"></i></span>
                                                    <span class="icon_hover"><i class="icon-instagram"></i></span>
                                        		</a>
                                        	</li>
                                        {/if}
                                        {if isset($tc_config.BLOCKSOCIAL_YOUTUBE) && $tc_config.BLOCKSOCIAL_YOUTUBE != ''}
                                        	<li class="youtube">
                                        		<a class="_blank" href="{$tc_config.BLOCKSOCIAL_YOUTUBE|escape:html:'UTF-8'}">
                                        			<span><i class="fa fa-youtube-play"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-youtube-play"></i></span>
                                        		</a>
                                        	</li>
                                        {/if}
                                        {if isset($tc_config.BLOCKSOCIAL_LINKEDIN) && $tc_config.BLOCKSOCIAL_LINKEDIN != ''}
                                			<li class="linkedin">
                                				<a class="_blank" href="{$tc_config.BLOCKSOCIAL_LINKEDIN|escape:html:'UTF-8'}">
                                					<span><i class="icon-linkedin"></i></span>
                                                    <span class="icon_hover"><i class="icon-linkedin"></i></span>
                                				</a>
                                			</li>
                                		{/if}
                                        {if isset($tc_config.BLOCKSOCIAL_VIMEO) && $tc_config.BLOCKSOCIAL_VIMEO != ''}
                                        	<li class="vimeo">
                                        		<a class="_blank" href="{$tc_config.BLOCKSOCIAL_VIMEO|escape:html:'UTF-8'}">
                                        			<span><i class="fa fa-vimeo"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-vimeo"></i></span>
                                        		</a>
                                        	</li>
                                        {/if}
                                        {if isset($tc_config.BLOCKSOCIAL_PINTEREST) && $tc_config.BLOCKSOCIAL_PINTEREST != ''}
                                        	<li class="pinterest">
                                        		<a class="_blank" href="{$tc_config.BLOCKSOCIAL_PINTEREST|escape:html:'UTF-8'}">
                                        			<span><i class="icon-pinterest-p"></i></span>
                                                    <span class="icon_hover"><i class="icon-pinterest-p"></i></span>
                                        		</a>
                                        	</li>
                                        {/if}
                                        
                                        {if isset($tc_config.BLOCKSOCIAL_RSS) && $tc_config.BLOCKSOCIAL_RSS != ''}
                                			<li class="rss">
                                				<a class="_blank" href="{$tc_config.BLOCKSOCIAL_RSS|escape:html:'UTF-8'}">
                                					<span><i class="icon-rss"></i></span>
                                                    <span class="icon_hover"><i class="icon-rss"></i></span>
                                				</a>
                                			</li>
                                		{/if}
                                        
                                	</ul>
                                </div>
                                <div class="clearfix"></div>
                                <div class="coppyright_contact">              
                                    {if isset($tc_config.YBC_TC_COPYRIGHT_TEXT) && $tc_config.YBC_TC_COPYRIGHT_TEXT}
                                        <div class="ybc_coppyright">
                                            {$tc_config.YBC_TC_COPYRIGHT_TEXT}
                                        </div>
                                    {/if} 
                                    {if isset($tc_config.YBC_TC_POWERED_TEXT) && $tc_config.YBC_TC_POWERED_TEXT}
                                        <div class="content ybc_coppyright_bottom">
                                            <span>{$tc_config.YBC_TC_POWERED_TEXT}
                                            </span>
                                        </div>
                                    {/if}
                                </div>                                
                                
                            </div>
                        </div>
                    </div>
    			{/if}
                
                <div class="scroll_top"><span>{l s='TOP'}</span></div>
            </div><!-- #page -->
    {/if}
    {include file="$tpl_dir./global.tpl"}
    

<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '7ae889b3556126f6fe09112420b4f7e9e346fa6a');
</script>

    	</body>
    	

    </html>
    
