<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blockbestsellers/blockbestsellers-home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1819742520597a0c0ab0b9b3-02902942%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f7fed6b8c5774278f8a566c7e364ae5b30d238b' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blockbestsellers/blockbestsellers-home.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1819742520597a0c0ab0b9b3-02902942',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'best_sellers' => 0,
    'tc_dev_mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0ab1dc46_36717262',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0ab1dc46_36717262')) {function content_597a0c0ab1dc46_36717262($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['best_sellers']->value)&&$_smarty_tpl->tpl_vars['best_sellers']->value) {?>
    <div class="home-block-section">
        <h4 class="title-home"><span><?php echo smartyTranslate(array('s'=>'Best selling products','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</span></h4>
	   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('products'=>$_smarty_tpl->tpl_vars['best_sellers']->value,'class'=>'blockbestsellers tab-pane','id'=>'blockbestsellers','ybcDev'=>isset($_smarty_tpl->tpl_vars['tc_dev_mode']->value)&&$_smarty_tpl->tpl_vars['tc_dev_mode']->value), 0);?>

    </div>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'ybccustom3'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
