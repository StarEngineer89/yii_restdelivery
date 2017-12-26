<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:24:36
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/front/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2373965025988a254ab3f44-77366535%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5285095a71f690a22fead7fa69f0867ed685b578' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/front/payment.tpl',
      1 => 1499174630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2373965025988a254ab3f44-77366535',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a254aeba50_13715390',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a254aeba50_13715390')) {function content_5988a254aeba50_13715390($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/modifier.escape.php';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Payment','mod'=>'barclaysepdq'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'Payment','mod'=>'barclaysepdq'),$_smarty_tpl);?>
</h1>

<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<iframe id="payment-execute" src="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getModuleLink('barclaysepdq','execute',array('content_only'=>1)), 'UTF-8');?>
" height="500" width="100%"></iframe>
<?php }} ?>
