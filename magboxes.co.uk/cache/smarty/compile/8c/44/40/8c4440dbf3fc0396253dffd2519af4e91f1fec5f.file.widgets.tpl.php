<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:37
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_widget/views/templates/hook/widgets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2862167965979f27d4be421-95357145%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c4440dbf3fc0396253dffd2519af4e91f1fec5f' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_widget/views/templates/hook/widgets.tpl',
      1 => 1501157214,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2862167965979f27d4be421-95357145',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'widgets' => 0,
    'widget_hook' => 0,
    'page_name' => 0,
    'tc_config' => 0,
    'widget' => 0,
    'widget_module_path' => 0,
    'layouts' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27d8da7b8_07847855',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27d8da7b8_07847855')) {function content_5979f27d8da7b8_07847855($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['widgets']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['widget_hook']->value=="display-top-column") {?>
        <?php if ($_smarty_tpl->tpl_vars['page_name']->value=="index") {?>
            <div class="home_widget_top_column<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?> home_top_colum_layout3<?php }?>">
                    <div class="<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']!='LAYOUT4') {?>container<?php }?>">
                        <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
 row">
                            <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                                <li class="ybc-widget-item<?php if ((isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT2')) {?> ybc-widget-item-layout-2<?php }?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3']==1) {?> wow zoomIn<?php }?>">
                                    <div class="ybc-widget-item-wrap">
                                        <div class="ybc-widget-item-content">
                                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>><?php }?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                                    </a>
                                                <?php }?>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']||$_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                            <div class="ybc-widget-description-content"> 
                                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?>
                                                    <h4 class="ybc-widget-title">
                                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>

                                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?>
                                                    </h4>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                                    <div class="ybc-widget-description">
                                                        <?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>

                                                    </div>
                                                <?php }?>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>                        
            </div>
        <?php }?>
    <?php } elseif (($_smarty_tpl->tpl_vars['widget_hook']->value=="display-left-column"||$_smarty_tpl->tpl_vars['widget_hook']->value=="display-right-column")) {?>
        <div class="block">
            <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
 block_content">
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                    <li class="ybc-widget-item">
                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                        
                        
                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="display-footer") {?>
        <?php if (!isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_SIMPLE_FOOTER'])||isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_SIMPLE_FOOTER'])&&!$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_SIMPLE_FOOTER']) {?>
            <section class="ybc_widget_footer_block footer-block col-xs-12 col-sm-9">
                <h4 class=""><?php echo smartyTranslate(array('s'=>'Showrooms system','mod'=>'ybc_widget'),$_smarty_tpl);?>
</h4>
                <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
 row block_content toggle-footer">
                    <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                        <li class="ybc-widget-item col-sm-4">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h5 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h5><?php }?>
                            <div class="">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FACEBOOK_URL'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FACEBOOK_URL']) {?>
                <div id="fb-root"></div>
                <div id="facebook_block" class="footer-block col-xs-12 col-sm-3">
                	<h4 ><?php echo smartyTranslate(array('s'=>'Follow us on Facebook','mod'=>'blockfacebook'),$_smarty_tpl);?>
</h4>
                	<div class="facebook-fanbox block_content toggle-footer">
                        <div class="fb-page" data-href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FACEBOOK_URL'], ENT_QUOTES, 'UTF-8', true);?>
" data-tabs="timeline" data-width="270" data-height="265" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FACEBOOK_URL'], ENT_QUOTES, 'UTF-8', true);?>
" class="fb-xfbml-parse-ignore">
                            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FACEBOOK_URL'], ENT_QUOTES, 'UTF-8', true);?>
"></a>
                        </blockquote>
                        </div>
                	</div>
                </div>
                <div class="clearfix"></div>
            <?php }?>
        <?php }?>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-footer-links") {?>
            <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
">
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                    <li class="ybc-widget-item">
                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class=""><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                        <div class="block_content toggle-footer">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-ybcpaymentlogo-hook") {?>
        <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
">
            <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                <li class="ybc-widget-item">
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                    
                    
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                </li>
            <?php } ?>
        </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-4") {?>
        <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
">
            <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                <li class="ybc-widget-item">
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                    
                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                </li>
            <?php } ?>
        </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-3") {?>
        
             <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER']) {?><?php } else { ?> hidden-xs<?php }?>">
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" />
                                    </a>
                                <?php }?>
                            <?php }?>
                            <div class="ybc-widget-description-content">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                
                                <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?>
                                <?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['subtitle']) {?><h5 class="ybc-widget-subtitle"><?php echo $_smarty_tpl->tpl_vars['widget']->value['subtitle'];?>
</h5><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                    <div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div>
                                <?php }?>
                            </div>
                        </div>
                    </li>-->
<?php } ?>
            </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-2") {?>
        <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER']) {?><?php } else { ?> hidden-xs<?php }?>">                
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                   <!--<li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" />
                                    </a>
                                <?php }?>
                            <?php }?>
                            <div class="ybc-widget-description-content">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                    <div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div>
                                <?php }?>
                            </div>
                        </div>
                    </li>-->
                <?php } ?>
            </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-1") {?>
        
            <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER']) {?><?php } else { ?> hidden-xs<?php }?>">                
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" />
                                    </a>
                                <?php }?>
                            <?php }?>
                            <div class="ybc-widget-description-content">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                    <div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div>
                                <?php }?>
                            </div>
                        </div>
                    </li>-->
                <?php } ?>
            </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-6") {?>
        <section class="footer-block">
            <h4 class="" style="display: none;"><?php echo smartyTranslate(array('s'=>'Company','mod'=>'ybc_widget'),$_smarty_tpl);?>
</h4>
            <ul class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
 block_content toggle-footer">                
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                    <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" />
                                    </a>
                                <?php }?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php } else { ?><span class="title"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php } else { ?></span><?php }?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                <div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div>
                            <?php }?>
                        </div>
                    </li>
                <?php } ?>
            </ul>  
        </section>      
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="ybc-custom-5") {?>
        <ul class="ybc-widget-ybc-custom-1<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_ENABLE_BANNER']) {?><?php } else { ?> hidden-xs<?php }?>">                
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                   <!-- <li class="ybc-widget-item">
                        <div class="ybc-widget-item-content">
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                    <a class="ybc_widget_link_img" href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3') {?>style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
);"<?php }?><?php }?>>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" />
                                    </a>
                                <?php }?>
                            <?php }?>
                            <div class="ybc-widget-description-content">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                    <div class="ybc-widget-description"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div>
                                <?php }?>
                            </div>
                        </div>
                    </li>-->
                <?php } ?>
            </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['widget_hook']->value=="display-home") {?>
        <div class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
">
            <div class="container">
                <ul id="parala">
                    <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                        <li class="ybc-widget-item<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3']==1) {?> wow zoomIn<?php }?>">
                            <div class="ybc-widget-item-content">
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                                <div class="parala_content" <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_PARALLAX_NEWSLETTER_ON_OFF'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_PARALLAX_NEWSLETTER_ON_OFF']==1) {?>data-top-bottom="top: 0%;" data-bottom-top="top: -75%;"<?php }?> 
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?> style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
)"<?php }?>> </div>
                            
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?><h4 class="ybc-widget-title"><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
<?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?></h4><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?><div class="ybc-widget-description <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?> ybc-widget-description-white<?php }?>"><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</div><?php }?>
                            </div>  
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } else { ?>
            <div class="container">
            <?php if (($_smarty_tpl->tpl_vars['layouts']->value=='layout2')) {?> <div class="row"><?php }?>
            <ul  class="ybc-widget-<?php echo $_smarty_tpl->tpl_vars['widget_hook']->value;?>
">
                <?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
                    <li class="ybc-widget-item<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_CSS3']==1) {?> wow zoomIn<?php }?>">
                        <div class="ybc-widget-item-content"> 
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['icon']) {?><i class="fa <?php echo $_smarty_tpl->tpl_vars['widget']->value['icon'];?>
"></i><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_image']&&$_smarty_tpl->tpl_vars['widget']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['widget_module_path']->value;?>
images/widget/<?php echo $_smarty_tpl->tpl_vars['widget']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
" /><?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?><?php }?>
                            
                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']||$_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                <div class="ybc-widget-description-content"> 
                                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_title']&&$_smarty_tpl->tpl_vars['widget']->value['title']) {?>
                                        <h4 class="ybc-widget-title">
                                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['widget']->value['link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>

                                            <?php if ($_smarty_tpl->tpl_vars['widget']->value['link']) {?></a><?php }?>
                                        </h4>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['widget']->value['show_description']&&$_smarty_tpl->tpl_vars['widget']->value['description']) {?>
                                        <div class="ybc-widget-description">
                                            <?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>

                                        </div>
                                    <?php }?>
                                </div>
                            <?php }?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
          <?php if (($_smarty_tpl->tpl_vars['layouts']->value=='layout2')) {?></div><?php }?>
            </div>
    <?php }?>
<?php }?><?php }} ?>
