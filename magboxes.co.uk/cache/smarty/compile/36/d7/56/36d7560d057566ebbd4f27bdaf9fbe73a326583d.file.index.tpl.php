<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:756502090597a0c0ae6eb92-01046363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36d7560d057566ebbd4f27bdaf9fbe73a326583d' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/index.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '756502090597a0c0ae6eb92-01046363',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_HOME_TAB_CONTENT' => 0,
    'HOOK_HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0ae7d680_91287150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0ae7d680_91287150')) {function content_597a0c0ae7d680_91287150($_smarty_tpl) {?>

<div class="container">
    <?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)) {?>
        
    	<div class="tab-content"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value;?>
</div>
    <?php }?>
</div>
<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME']->value)) {?>
	<div class="clearfix bg_home"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>
</div>
<?php }?><?php }} ?>
