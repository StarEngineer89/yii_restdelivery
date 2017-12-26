<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/homefeatured/homefeatured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:317996299597a0c0a6fa0d1-15334935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6259f160839fd21590698624b31e8cbff62def6' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/homefeatured/homefeatured.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317996299597a0c0a6fa0d1-15334935',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'tc_dev_mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0a712eb2_64400284',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0a712eb2_64400284')) {function content_597a0c0a712eb2_64400284($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
    <div class="home-block-section">
        <h4 class="title-home"><span><?php echo smartyTranslate(array('s'=>'Popular products','mod'=>'homefeatured'),$_smarty_tpl);?>
</span></h4>
    	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('class'=>'homefeatured','id'=>'homefeatured','ybcDev'=>isset($_smarty_tpl->tpl_vars['tc_dev_mode']->value)&&$_smarty_tpl->tpl_vars['tc_dev_mode']->value), 0);?>

    </div>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'ybccustom1'),$_smarty_tpl);?>

<?php }?><?php }} ?>
