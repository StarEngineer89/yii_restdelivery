<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:52:26
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_productimagehover/views/templates/hook/image.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1728870764597a0c3a9f0319-23613827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '245fe8802308b9c4af31a876a865b4bcd1427e1d' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_productimagehover/views/templates/hook/image.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1728870764597a0c3a9f0319-23613827',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_name' => 0,
    'img_url' => 0,
    'YBC_PI_TRANSITION_EFFECT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c3aa07769_73598799',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c3aa07769_73598799')) {function content_597a0c3aa07769_73598799($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['product_name']->value)&&isset($_smarty_tpl->tpl_vars['img_url']->value)) {?>
    <img class="<?php if ($_smarty_tpl->tpl_vars['YBC_PI_TRANSITION_EFFECT']->value) {?><?php echo $_smarty_tpl->tpl_vars['YBC_PI_TRANSITION_EFFECT']->value;?>
<?php } else { ?>fade<?php }?> replace-2x img-responsive ybc_img_hover" src="<?php echo $_smarty_tpl->tpl_vars['img_url']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product_name']->value;?>
" itemprop="image" title="<?php echo $_smarty_tpl->tpl_vars['product_name']->value;?>
" />
<?php }?><?php }} ?>
