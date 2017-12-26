<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_megamenu/views/templates/hook/ybc_megamenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20768154795979f27e3e9ed7-96228090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4974563ab135b8800452115234b2fad194cd12f2' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_megamenu/views/templates/hook/ybc_megamenu.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20768154795979f27e3e9ed7-96228090',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menus' => 0,
    'fixedPositionFull' => 0,
    'YBC_MM_DIRECTION' => 0,
    'YBC_MM_ARROW' => 0,
    'tc_config' => 0,
    'fixedPosition' => 0,
    'YBC_MOBILE_MM_TYPE' => 0,
    'YBC_MM_TYPE' => 0,
    'YBC_MM_SKIN' => 0,
    'effect' => 0,
    'customClass' => 0,
    'mobileImage' => 0,
    'menu' => 0,
    'is' => 0,
    'column' => 0,
    'block' => 0,
    'url' => 0,
    'subcatId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27e637491_64639889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27e637491_64639889')) {function content_5979f27e637491_64639889($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['menus']->value) {?>
    <div class="ybc-menu-wrapper<?php if ($_smarty_tpl->tpl_vars['fixedPositionFull']->value) {?> fixed-full<?php }?> 
        <?php echo $_smarty_tpl->tpl_vars['YBC_MM_DIRECTION']->value;?>
 <?php if (!$_smarty_tpl->tpl_vars['YBC_MM_ARROW']->value) {?>ybc-no-arrow<?php }?> 
        <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_HEADER'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_FLOAT_HEADER']) {?>menu_header_fix <?php } else { ?> 
        <?php if (isset($_smarty_tpl->tpl_vars['fixedPosition']->value)&&$_smarty_tpl->tpl_vars['fixedPosition']->value) {?>position-fixed<?php } else { ?>position-not-fixed<?php }?>
        <?php }?> 
        <?php if ($_smarty_tpl->tpl_vars['YBC_MOBILE_MM_TYPE']->value) {?>ybc-mm-mobile-type-<?php echo $_smarty_tpl->tpl_vars['YBC_MOBILE_MM_TYPE']->value;?>
<?php } else { ?>ybc-mm-mobile-type-default<?php }?> 
        <?php if ($_smarty_tpl->tpl_vars['YBC_MM_TYPE']->value) {?>ybc-menu-layout-<?php echo $_smarty_tpl->tpl_vars['YBC_MM_TYPE']->value;?>
<?php } else { ?>ybc-menu-layout-default<?php }?> 
        <?php if ($_smarty_tpl->tpl_vars['YBC_MM_SKIN']->value) {?>ybc-menu-skin-<?php echo $_smarty_tpl->tpl_vars['YBC_MM_SKIN']->value;?>
<?php } else { ?>ybc-menu-skin-default<?php }?> ybc-menu-<?php echo $_smarty_tpl->tpl_vars['effect']->value;?>

        <?php if (isset($_smarty_tpl->tpl_vars['customClass']->value)&&$_smarty_tpl->tpl_vars['customClass']->value) {?> <?php echo $_smarty_tpl->tpl_vars['customClass']->value;?>
<?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['mobileImage']->value)&&!$_smarty_tpl->tpl_vars['mobileImage']->value) {?> ybc-menu-hide-image-on-mobile<?php }?> col-xs-12 col-sm-12">
        
    	<?php if (isset($_smarty_tpl->tpl_vars['fixedPosition']->value)&&$_smarty_tpl->tpl_vars['fixedPosition']->value) {?><div class="container"><?php }?>
        <div class="ybc-menu-blinder"></div>
        <div class="ybc-menu-toggle ybc-menu-btn<?php if ((isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='DEFAULT'||$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3'||$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT6')) {?> allway_show<?php }?>">
          <div class="ybc-menu-button-toggle">            
            <span>
                <?php if ((isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='DEFAULT'||$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT3'||$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LAYOUT']=='LAYOUT6')) {?>
                    <?php echo smartyTranslate(array('s'=>'Categories','mod'=>'ybc_megamenu'),$_smarty_tpl);?>

                <?php } else { ?>
                    <?php echo smartyTranslate(array('s'=>'Menu','mod'=>'ybc_megamenu'),$_smarty_tpl);?>

                <?php }?>
                <span class="ybc-menu-button-toggle_icon">
                    <i class="icon-bar"></i>
                    <i class="icon-bar"></i>
                    <i class="icon-bar"></i>
                </span>
            </span>
          </div>
        </div>
        
        <div class="ybc-menu-main-content" id="ybc-menu-main-content">            

                <ul class="ybc-menu">  
                    <?php $_smarty_tpl->tpl_vars['is'] = new Smarty_variable(0, null, 0);?>
        			<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['menu']->value['enabled']) {?>
                            <?php $_smarty_tpl->tpl_vars['is'] = new Smarty_variable($_smarty_tpl->tpl_vars['is']->value+1, null, 0);?>
            				<li class="<?php if ($_smarty_tpl->tpl_vars['is']->value>9) {?>ybc-menu-item-not-show <?php }?><?php if (isset($_smarty_tpl->tpl_vars['menu']->value['columns'])&&$_smarty_tpl->tpl_vars['menu']->value['columns']) {?>ybc-menu-has-sub<?php }?> ybc-menu-item <?php if ($_smarty_tpl->tpl_vars['menu']->value['custom_class']) {?><?php echo $_smarty_tpl->tpl_vars['menu']->value['custom_class'];?>
<?php }?> ybc-menu-sub-type-<?php echo strtolower($_smarty_tpl->tpl_vars['menu']->value['menu_type']);?>
<?php if ($_smarty_tpl->tpl_vars['menu']->value['column_type']) {?> ybc-menu-column-type-<?php echo strtolower($_smarty_tpl->tpl_vars['menu']->value['column_type']);?>
<?php } else { ?> ybc-menu-column-type-left<?php }?> <?php if (!$_smarty_tpl->tpl_vars['menu']->value['wrapper_border']) {?>no-wrapper-border<?php }?> <?php if ($_smarty_tpl->tpl_vars['menu']->value['sub_type']) {?>sub-type-<?php echo strtolower($_smarty_tpl->tpl_vars['menu']->value['sub_type']);?>
<?php } else { ?>sub-type-title<?php }?>" id="ybc-menu-<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
">	
                                    <!-- level 1 -->
                                    <?php if ($_smarty_tpl->tpl_vars['menu']->value['url']) {?>
                                	   <a class="ybc-menu-item-link" href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['url'];?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['menu']->value['show_icon']&&$_smarty_tpl->tpl_vars['menu']->value['icon']) {?><i class="fa icon <?php echo $_smarty_tpl->tpl_vars['menu']->value['icon'];?>
 <?php echo str_replace('fa-','icon-',$_smarty_tpl->tpl_vars['menu']->value['icon']);?>
"></i> <?php }?>
                                            <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['icon_image'])&&$_smarty_tpl->tpl_vars['menu']->value['icon_image']!=null) {?>
                                                <span class="ybc_icon_image">
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['menu']->value['icon_image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
" /> 
                                                </span>
                                            <?php }?>
                                            <span class="ybc_menu_item_link_content"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</span>
                                            <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['columns'])&&$_smarty_tpl->tpl_vars['menu']->value['columns']) {?> <span class="fa fa-submenu-exist"></span><?php }?>
                                        </a>
                                    <?php } else { ?>
                                        <a class="ybc-menu-item-link ybc-menu-item-no-link" href="#"><span class=""><?php if ($_smarty_tpl->tpl_vars['menu']->value['show_icon']&&$_smarty_tpl->tpl_vars['menu']->value['icon']) {?><i class="fa icon <?php echo $_smarty_tpl->tpl_vars['menu']->value['icon'];?>
 <?php echo str_replace('fa-','icon-',$_smarty_tpl->tpl_vars['menu']->value['icon']);?>
"></i> <?php }?><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</span></a>
                                    <?php }?>
                                    <!-- /leve 1 -->
                                    <!-- Columns -->
                                    <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['columns'])&&$_smarty_tpl->tpl_vars['menu']->value['columns']||$_smarty_tpl->tpl_vars['menu']->value['image']) {?>
                                        <span class="ybc-mm-control closed"></span>
                                        <div <?php if ($_smarty_tpl->tpl_vars['menu']->value['sub_menu_max_width']&&$_smarty_tpl->tpl_vars['menu']->value['sub_menu_max_width']) {?>style="width: <?php echo (int)$_smarty_tpl->tpl_vars['menu']->value['sub_menu_max_width'];?>
%;"<?php }?> class="ybc-menu-columns-wrapper ybc-mm-control-content" id="ybc-menu-columns-wrapper-<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['menu']->value['image']&&$_smarty_tpl->tpl_vars['menu']->value['banner_position']=='top') {?>
                                                <div class="ybc-menu-banner position-top">
                                                    <?php if ($_smarty_tpl->tpl_vars['menu']->value['banner_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['banner_link'];?>
">
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['menu']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
" /></a><?php } else { ?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['menu']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
" /><?php }?>
                                                </div>
                                            <?php }?>
                                            <?php  $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['column']->key => $_smarty_tpl->tpl_vars['column']->value) {
$_smarty_tpl->tpl_vars['column']->_loop = true;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['column']->value['enabled']) {?>
                                    				<div class="ybc-menu-column-item ybc-menu-column-size-<?php echo $_smarty_tpl->tpl_vars['column']->value['column_size'];?>
 <?php if ($_smarty_tpl->tpl_vars['column']->value['custom_class']) {?><?php echo $_smarty_tpl->tpl_vars['column']->value['custom_class'];?>
<?php }?>" id="ybc-menu-column-<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
">
                                                        <!-- Column content -->     
                                                        <?php if ($_smarty_tpl->tpl_vars['column']->value['show_title']&&$_smarty_tpl->tpl_vars['column']->value['title']||$_smarty_tpl->tpl_vars['column']->value['show_image']&&$_smarty_tpl->tpl_vars['column']->value['image']||$_smarty_tpl->tpl_vars['column']->value['show_description']&&$_smarty_tpl->tpl_vars['column']->value['description']) {?>
                                                            <div class="ybc-menu-column-top">                                                 
                                                                <?php if ($_smarty_tpl->tpl_vars['column']->value['show_title']&&$_smarty_tpl->tpl_vars['column']->value['title']) {?><h6><?php if ($_smarty_tpl->tpl_vars['column']->value['column_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['column']->value['column_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['column']->value['title'];?>
</a><?php } else { ?><?php echo $_smarty_tpl->tpl_vars['column']->value['title'];?>
<?php }?></h6><?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['column']->value['show_image']&&$_smarty_tpl->tpl_vars['column']->value['image']) {?><?php if ($_smarty_tpl->tpl_vars['column']->value['column_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['column']->value['column_link'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['column']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['column']->value['title'];?>
" /></a><?php } else { ?><img src="<?php echo $_smarty_tpl->tpl_vars['column']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['column']->value['title'];?>
" /><?php }?><?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['column']->value['show_description']&&$_smarty_tpl->tpl_vars['column']->value['description']) {?><div class="ybc_description_block"><?php echo $_smarty_tpl->tpl_vars['column']->value['description'];?>
</div><?php }?>
                                                            </div>
                                                        <?php }?>  
                                                        <!-- /Column content -->                                                    	
                                                        <!-- Blocks -->
                                                        <?php if (isset($_smarty_tpl->tpl_vars['column']->value['blocks'])&&$_smarty_tpl->tpl_vars['column']->value['blocks']) {?>                                                        
                                                                <?php  $_smarty_tpl->tpl_vars['block'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['block']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['column']->value['blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['block']->key => $_smarty_tpl->tpl_vars['block']->value) {
$_smarty_tpl->tpl_vars['block']->_loop = true;
?>
                                                                    <?php if ($_smarty_tpl->tpl_vars['block']->value['enabled']) {?>
                                                                        <div class="ybc-menu-block <?php if ($_smarty_tpl->tpl_vars['block']->value['custom_class']) {?><?php echo $_smarty_tpl->tpl_vars['block']->value['custom_class'];?>
<?php }?> ybc-menu-block-type-<?php echo strtolower($_smarty_tpl->tpl_vars['block']->value['block_type']);?>
">
                                                                            <?php if ($_smarty_tpl->tpl_vars['block']->value['show_title']&&$_smarty_tpl->tpl_vars['block']->value['title']||$_smarty_tpl->tpl_vars['block']->value['show_image']&&$_smarty_tpl->tpl_vars['block']->value['image']||$_smarty_tpl->tpl_vars['block']->value['show_description']&&$_smarty_tpl->tpl_vars['block']->value['description']) {?>
                                                                                <div class="ybc-menu-block-top ybc-menu-title-block">                                                 
                                                                                    <?php if ($_smarty_tpl->tpl_vars['block']->value['show_title']&&$_smarty_tpl->tpl_vars['block']->value['title']) {?><h6><?php if ($_smarty_tpl->tpl_vars['block']->value['block_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['block']->value['block_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['block']->value['title'];?>
</a><?php } else { ?><?php echo $_smarty_tpl->tpl_vars['block']->value['title'];?>
<?php }?></h6><?php }?>
                                                                                    <?php if ($_smarty_tpl->tpl_vars['block']->value['show_image']&&$_smarty_tpl->tpl_vars['block']->value['image']) {?><div class="ybc-menu-block-img"><?php if ($_smarty_tpl->tpl_vars['block']->value['block_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['block']->value['block_link'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['block']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['block']->value['title'];?>
" /></a><?php } else { ?><img src="<?php echo $_smarty_tpl->tpl_vars['block']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['block']->value['title'];?>
" /><?php }?></div><?php }?>
                                                                                    <?php if ($_smarty_tpl->tpl_vars['block']->value['show_description']&&$_smarty_tpl->tpl_vars['block']->value['description']) {?><p><?php echo $_smarty_tpl->tpl_vars['block']->value['description'];?>
</p><?php }?>
                                                                                </div>
                                                                            <?php }?> 
                                                                            <?php if ($_smarty_tpl->tpl_vars['block']->value['block_type']=='HTML'&&isset($_smarty_tpl->tpl_vars['block']->value['html_block'])&&$_smarty_tpl->tpl_vars['block']->value['html_block']) {?>
                                                                                <div class="ybc-menu-block-bottom ybc-menu-block-custom-html">
                                                                                    <?php echo $_smarty_tpl->tpl_vars['block']->value['html_block'];?>

                                                                                </div>
                                                                            <?php }?>     
                                                                            <?php if ($_smarty_tpl->tpl_vars['block']->value['block_type']!='HTML'&&isset($_smarty_tpl->tpl_vars['block']->value['urls'])&&$_smarty_tpl->tpl_vars['block']->value['urls']) {?>
                                                                                <div class="ybc-menu-block-bottom">
                                                                                    <ul class="ybc-menu-block-links <?php if ($_smarty_tpl->tpl_vars['block']->value['block_type']=='CATEGORY') {?>ybc-ul-category<?php }?>">
                                                                                        <?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['block']->value['urls']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->_loop = true;
?>                                                                                        
                                                                                            <li class="<?php if (isset($_smarty_tpl->tpl_vars['url']->value['info'])&&$_smarty_tpl->tpl_vars['url']->value['info']) {?>ybc-mm-product-block<?php } else { ?>ybc-no-product-block<?php }?>">
                                                                                                <?php if (isset($_smarty_tpl->tpl_vars['url']->value['id'])) {?>
                                                                                                    <?php $_smarty_tpl->tpl_vars["subcatId"] = new Smarty_variable($_smarty_tpl->tpl_vars['url']->value['id'], null, 0);?>
                                                                                                <?php } else { ?>
                                                                                                    <?php $_smarty_tpl->tpl_vars["subcatId"] = new Smarty_variable(0, null, 0);?>
                                                                                                <?php }?>
                                                                                                <?php if (isset($_smarty_tpl->tpl_vars['url']->value['info'])&&$_smarty_tpl->tpl_vars['url']->value['info']) {?>
                                                                                                    <a class="ybc-mm-product-img-link" href="<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value['info']['img_url'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['url']->value['title'];?>
" /></a>
                                                                                                <?php }?>
                                                                                                    <a class="<?php if (isset($_smarty_tpl->tpl_vars['url']->value['info'])&&$_smarty_tpl->tpl_vars['url']->value['info']) {?>ybc-mm-product-link<?php } else { ?>ybc-mm-item-link<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['url']->value['title'];?>
</a>
                                                                                                    
                                                                                				
                                                                                				
                                                                                                    <?php if (isset($_smarty_tpl->tpl_vars['block']->value['subCategories'][$_smarty_tpl->tpl_vars['subcatId']->value])&&$_smarty_tpl->tpl_vars['block']->value['subCategories'][$_smarty_tpl->tpl_vars['subcatId']->value]) {?><span class="ybc-mm-control closed"></span><?php }?>
                                                                                                    
                                                                                                <?php if (isset($_smarty_tpl->tpl_vars['url']->value['info'])&&$_smarty_tpl->tpl_vars['url']->value['info']) {?>
                                                                                                    <?php if ($_smarty_tpl->tpl_vars['url']->value['info']['description']) {?>
                                                                                                        <div class="ybc-mm-description"><?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['url']->value['info']['description']),50,'...'), ENT_QUOTES, 'UTF-8', true);?>
</div>
                                                                                                    <?php }?>
                                                                                                    <div itemtype="http://schema.org/Product" itemscope="" class="ybc-mm-product-review"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayYbcReviews','product'=>$_smarty_tpl->tpl_vars['url']->value['info']['product']),$_smarty_tpl);?>
</div>
                                                                                                    <div class="ybc-mm-price-row">                                                                                                    
                                                                                                        <?php if ($_smarty_tpl->tpl_vars['url']->value['info']['price']!=$_smarty_tpl->tpl_vars['url']->value['info']['old_price']) {?>
                                                                                                                <span class="ybc-mm-price price product-price"><?php echo $_smarty_tpl->tpl_vars['url']->value['info']['price'];?>
</span>
                                                                                                                <span class="ybc-mm-old-price old-price product-price"><?php echo $_smarty_tpl->tpl_vars['url']->value['info']['old_price'];?>
</span>
                                                                                                                <span class="ybc-mm-discount-percent">-<?php echo $_smarty_tpl->tpl_vars['url']->value['info']['discount_percent'];?>
%</span>
                                                                                                                                                                                                                   
                                                                                                        <?php } else { ?>
                                                                                                            <span class="ybc-mm-price price product-price"><?php echo $_smarty_tpl->tpl_vars['url']->value['info']['price'];?>
</span>
                                                                                                        <?php }?>
                                                                                                    </div>
                                                                                                    
                                                                                                <?php }?>
                                                                                                <?php if (isset($_smarty_tpl->tpl_vars['url']->value['info'])&&$_smarty_tpl->tpl_vars['url']->value['info']) {?>
                                                                                                    <a class="ybc-mm-product-viewmore" href="<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
"><?php echo smartyTranslate(array('s'=>"View More",'mod'=>'ybc_megamenu'),$_smarty_tpl);?>
</a>
                                                                                                <?php }?>
                                                                                                                                                                                            
                                                                                                <?php if (isset($_smarty_tpl->tpl_vars['block']->value['subCategories'][$_smarty_tpl->tpl_vars['subcatId']->value])&&$_smarty_tpl->tpl_vars['block']->value['subCategories'][$_smarty_tpl->tpl_vars['subcatId']->value]) {?><?php echo $_smarty_tpl->tpl_vars['block']->value['subCategories'][$_smarty_tpl->tpl_vars['subcatId']->value];?>
<?php }?>                                                                                           
                                                                                            </li>
                                                                                        <?php } ?>
                                                                                    </ul>
                                                                                </div>
                                                                            <?php }?>                                                      				
                                                                        </div>
                                                                    <?php }?>
                                                    			<?php } ?>                                                        
                                                        <?php }?>
                                                       <!-- /Blocks -->	
                                    				</div>   
                                                 <?php }?>                                     
                                			<?php } ?>
                                            <?php if ($_smarty_tpl->tpl_vars['menu']->value['image']&&$_smarty_tpl->tpl_vars['menu']->value['banner_position']!='top') {?>
                                                <div class="ybc-menu-banner position-bottom">
                                                    <?php if ($_smarty_tpl->tpl_vars['menu']->value['banner_link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['banner_link'];?>
">
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['menu']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
" /></a><?php } else { ?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['menu']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
" /><?php }?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                 <!-- /Columns  -->		
            				</li> 
                        <?php }?>                   
        			<?php } ?>
                    <?php if ($_smarty_tpl->tpl_vars['is']->value>9) {?>
                    <li class="view_more_menu active"><a href="#"><?php echo smartyTranslate(array('s'=>'View more categories','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
</a></li>
                    <li class="view_less_menu"><a href="#"><?php echo smartyTranslate(array('s'=>'View less categories','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
</a></li>
                    <?php }?>
        	   </ul>
        </div>
        <?php if (isset($_smarty_tpl->tpl_vars['fixedPosition']->value)&&$_smarty_tpl->tpl_vars['fixedPosition']->value) {?></div><?php }?>
    </div>
<?php }?><?php }} ?>
