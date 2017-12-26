<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blocknewproducts/views/templates/hook/blocknewproducts_home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:369630136597a0c0ac99d44-42806603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba7d2da98472769b5cf78af6a9e765eac7220fc6' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blocknewproducts/views/templates/hook/blocknewproducts_home.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '369630136597a0c0ac99d44-42806603',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'new_products' => 0,
    'tc_dev_mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0acab8c4_46312595',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0acab8c4_46312595')) {function content_597a0c0acab8c4_46312595($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['new_products']->value)&&$_smarty_tpl->tpl_vars['new_products']->value) {?>
    <div class="home-block-section">
        <h4 class="title-home"><span><?php echo smartyTranslate(array('s'=>'New products','mod'=>'blocknewproducts'),$_smarty_tpl);?>
</span></h4>
	   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('products'=>$_smarty_tpl->tpl_vars['new_products']->value,'class'=>'blocknewproducts tab-pane','id'=>'blocknewproducts','ybcDev'=>isset($_smarty_tpl->tpl_vars['tc_dev_mode']->value)&&$_smarty_tpl->tpl_vars['tc_dev_mode']->value), 0);?>

    </div>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'ybccustom2'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
