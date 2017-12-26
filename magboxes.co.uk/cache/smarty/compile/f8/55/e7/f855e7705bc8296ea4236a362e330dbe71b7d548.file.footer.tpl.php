<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7049001385979f27e6bf0f2-12185085%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f855e7705bc8296ea4236a362e330dbe71b7d548' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/footer.tpl',
      1 => 1500055792,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7049001385979f27e6bf0f2-12185085',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'right_column_size' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'tc_config' => 0,
    'tc_module_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27e76ee34_51632569',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27e76ee34_51632569')) {function content_5979f27e76ee34_51632569($_smarty_tpl) {?>

    <?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
    					</div><!-- #center_column -->
    					<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
    						<div id="right_column" class="col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
 column"><?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>
</div>
    					<?php }?>
    					</div><!-- .row -->
    				</div><!-- #columns -->
    			</div><!-- .columns-container -->
                
              
                <?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
    				<!-- Footer -->
                    <div class="footer-wrapper">
        				<div class="footer-container container">
        					<footer id="footer" <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_SIMPLE_FOOTER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_SIMPLE_FOOTER']) {?>class="simple-footer"<?php }?>>
        						<div class="row">
                                    <?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

                                </div>
        					</footer>
        				</div><!-- #footer -->
                        <div class="footer_middle">
                            <div class="container">
                                <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_PAYMENT_LOGO'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_PAYMENT_LOGO']) {?>
                                    <div class="payment_footer">                                       
                                        <ul class="payment_footer_img">
                                            <li>
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['tc_module_path']->value;?>
images/config/<?php echo $_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_PAYMENT_LOGO'];?>
" alt="<?php echo smartyTranslate(array('s'=>'Payment methods'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Payment methods'),$_smarty_tpl);?>
" />
                                            </li>
                                        </ul>
                                    </div>
                                <?php }?>
                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'ybccustom6'),$_smarty_tpl);?>

                            </div>
                        </div>
                        <div class="footer_bottom">
                            <div class="container">      
                                <div class="section_social">
                                    <ul>
                                		<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_FACEBOOK'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_FACEBOOK']!='') {?>
                                			<li class="facebook">
                                				<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_FACEBOOK'], ENT_QUOTES, 'UTF-8', true);?>
">
                                					<span><i class="icon-facebook"></i></span>
                                                    <span class="icon_hover"><i class="icon-facebook"></i></span>
                                				</a>
                                			</li>
                                		<?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_TWITTER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_TWITTER']!='') {?>
                                			<li class="twitter">
                                				<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_TWITTER'], ENT_QUOTES, 'UTF-8', true);?>
">
                                					<span><i class="icon-twitter"></i></span>
                                                    <span class="icon_hover"><i class="icon-twitter"></i></span>
                                				</a>
                                			</li>
                                		<?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_GOOGLE_PLUS'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_GOOGLE_PLUS']!='') {?>
                                        	<li class="google-plus">
                                        		<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_GOOGLE_PLUS'], ENT_QUOTES, 'UTF-8', true);?>
" rel="publisher">
                                        			<span><i class="fa fa-google-plus"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-google-plus"></i></span>
                                        		</a>
                                        	</li>
                                        <?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_INSTAGRAM'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_INSTAGRAM']!='') {?>
                                        	<li class="instagram">
                                        		<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_INSTAGRAM'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        			<span><i class="icon-instagram"></i></span>
                                                    <span class="icon_hover"><i class="icon-instagram"></i></span>
                                        		</a>
                                        	</li>
                                        <?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_YOUTUBE'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_YOUTUBE']!='') {?>
                                        	<li class="youtube">
                                        		<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_YOUTUBE'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        			<span><i class="fa fa-youtube-play"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-youtube-play"></i></span>
                                        		</a>
                                        	</li>
                                        <?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_LINKEDIN'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_LINKEDIN']!='') {?>
                                			<li class="linkedin">
                                				<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_LINKEDIN'], ENT_QUOTES, 'UTF-8', true);?>
">
                                					<span><i class="icon-linkedin"></i></span>
                                                    <span class="icon_hover"><i class="icon-linkedin"></i></span>
                                				</a>
                                			</li>
                                		<?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_VIMEO'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_VIMEO']!='') {?>
                                        	<li class="vimeo">
                                        		<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_VIMEO'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        			<span><i class="fa fa-vimeo"></i></span>
                                                    <span class="icon_hover"><i class="fa fa-vimeo"></i></span>
                                        		</a>
                                        	</li>
                                        <?php }?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_PINTEREST'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_PINTEREST']!='') {?>
                                        	<li class="pinterest">
                                        		<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_PINTEREST'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        			<span><i class="icon-pinterest-p"></i></span>
                                                    <span class="icon_hover"><i class="icon-pinterest-p"></i></span>
                                        		</a>
                                        	</li>
                                        <?php }?>
                                        
                                        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_RSS'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_RSS']!='') {?>
                                			<li class="rss">
                                				<a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKSOCIAL_RSS'], ENT_QUOTES, 'UTF-8', true);?>
">
                                					<span><i class="icon-rss"></i></span>
                                                    <span class="icon_hover"><i class="icon-rss"></i></span>
                                				</a>
                                			</li>
                                		<?php }?>
                                        
                                	</ul>
                                </div>
                                <div class="clearfix"></div>
                                <div class="coppyright_contact">              
                                    <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_COPYRIGHT_TEXT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_COPYRIGHT_TEXT']) {?>
                                        <div class="ybc_coppyright">
                                            <?php echo $_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_COPYRIGHT_TEXT'];?>

                                        </div>
                                    <?php }?> 
                                    <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_POWERED_TEXT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_POWERED_TEXT']) {?>
                                        <div class="content ybc_coppyright_bottom">
                                            <span><?php echo $_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_POWERED_TEXT'];?>

                                            </span>
                                        </div>
                                    <?php }?>
                                </div>                                
                                
                            </div>
                        </div>
                    </div>
    			<?php }?>
                
                <div class="scroll_top"><span><?php echo smartyTranslate(array('s'=>'TOP'),$_smarty_tpl);?>
</span></div>
            </div><!-- #page -->
    <?php }?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    

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
    
<?php }} ?>
