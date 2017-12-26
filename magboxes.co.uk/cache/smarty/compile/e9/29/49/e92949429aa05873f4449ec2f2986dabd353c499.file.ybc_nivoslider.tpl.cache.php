<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_nivoslider/views/templates/hook/ybc_nivoslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:170253806597a0c0aee0608-53433278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e92949429aa05873f4449ec2f2986dabd353c499' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_nivoslider/views/templates/hook/ybc_nivoslider.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170253806597a0c0aee0608-53433278',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'homeslider_slides' => 0,
    'slide' => 0,
    'link' => 0,
    'options' => 0,
    'ybc_nivo_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0b0094a5_55672933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0b0094a5_55672933')) {function content_597a0c0b0094a5_55672933($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index') {?>
<!-- Module ybc_nivoslider -->
    <?php if (isset($_smarty_tpl->tpl_vars['homeslider_slides']->value)) {?>
		<div id="ybc-nivo-slider-wrapper" 
        class="theme-default" 
        style="">
			<div id="ybc-nivo-slider"<?php if (isset(Smarty::$_smarty_vars['capture']['height'])&&Smarty::$_smarty_vars['capture']['height']) {?> style="max-height:<?php echo Smarty::$_smarty_vars['capture']['height'];?>
px;"<?php }?>>
                <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['homeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['slide']->value['active']) {?>
    						<a href="<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']) {?>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>#<?php }?>" 
                            title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
    						  <img data-id-slide="<?php echo $_smarty_tpl->tpl_vars['slide']->value['id_slide'];?>
" 
                                  data-caption-animate="<?php if ($_smarty_tpl->tpl_vars['slide']->value['caption_animate']) {?><?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_animate'];?>
<?php } else { ?>random<?php }?>" 
                                  <?php if ($_smarty_tpl->tpl_vars['slide']->value['slide_effect']!='random') {?>data-transition="<?php echo $_smarty_tpl->tpl_vars['slide']->value['slide_effect'];?>
"<?php }?> 
                                  data-caption1="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
                                  data-caption2="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
                                  data-caption3="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend2'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
                                  data-text-direction="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_text_direction'];?>
" 
                                  data-caption-top="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_top'];?>
" 
                                  data-caption-left="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_left'];?>
" 
                                  data-caption-right="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_right'];?>
" 
                                  data-caption-width="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_width'];?>
" 
                                  data-caption-position="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_position'];?>
"   
                                  data-custom_class="<?php echo $_smarty_tpl->tpl_vars['slide']->value['custom_class'];?>
"   
                                  data-button_link="<?php echo $_smarty_tpl->tpl_vars['slide']->value['button_link'];?>
"    
                                  src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)@constant('_MODULE_DIR_'))."ybc_nivoslider/images/".((string)mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')));?>
" 
                                  alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
                                  title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" 
                                  style="max-width: <?php echo $_smarty_tpl->tpl_vars['options']->value['max_width'];?>
; max-height: <?php echo $_smarty_tpl->tpl_vars['options']->value['max_height'];?>
;" 
                                />						  
                            </a>
                        <?php }?>
                                   
                                                                                    
				<?php } ?>
			</div>
            <div id="ybc-nivo-slider-loader">
                <div class="ybc-nivo-slider-loader">
                    <div id="ybc-nivo-slider-loader-img">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['ybc_nivo_dir']->value;?>
img/loading.gif" alt="<?php echo smartyTranslate(array('s'=>'Loading','mod'=>'ybc_nivoslider'),$_smarty_tpl);?>
"/>
                    </div>
                </div>
            </div>
		</div>        
        <div class="caption-wrapper">
            <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['homeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']) {?>
					<div class="ybc-nivo-description-<?php echo $_smarty_tpl->tpl_vars['slide']->value['id_slide'];?>
"><?php echo $_smarty_tpl->tpl_vars['slide']->value['description'];?>
</div>
                <?php }?>
			<?php } ?>
        </div> 
             
	<?php }?>
<!-- /Module ybc_nivoslider -->
<?php }?>
<?php }} ?>
