<?php /* Smarty version Smarty-3.1.19, created on 2017-07-28 14:25:48
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/admin6232kmhrf/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211094095597b3b5c96c0c3-91548069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '364857c08afa72f1920d7383febac41cdeccad94' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/admin6232kmhrf/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1497797241,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211094095597b3b5c96c0c3-91548069',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597b3b5c977135_54648351',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597b3b5c977135_54648351')) {function content_597b3b5c977135_54648351($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
