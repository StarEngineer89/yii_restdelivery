<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:51:38
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_nivoslider/views/templates/hook/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74791559597a0c0a3863a6-96695635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '927a39cae82c8bb6fd71bc3bf0e4d07f530819c6' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_nivoslider/views/templates/hook/header.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74791559597a0c0a3863a6-96695635',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ybcnivo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c0a3d26b9_59199014',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c0a3d26b9_59199014')) {function content_597a0c0a3d26b9_59199014($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['ybcnivo']->value)) {?>
<script type="text/javascript">
     var YBCNIVO_WIDTH='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_WIDTH'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
     var YBCNIVO_HEIGHT='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_HEIGHT'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
     var YBCNIVO_SPEED=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SPEED']);?>
;
     var YBCNIVO_PAUSE=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE']);?>
;
     var YBCNIVO_LOOP=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_LOOP']);?>
;
     var YBCNIVO_START_SLIDE=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_START_SLIDE']);?>
;
     var YBCNIVO_PAUSE_ON_HOVER=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE_ON_HOVER']);?>
;
     var YBCNIVO_SHOW_CONTROL=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_CONTROL']);?>
;
     var YBCNIVO_SHOW_PREV_NEXT=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_PREV_NEXT']);?>
;
     var YBCNIVO_BUTTON_IMAGE=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_BUTTON_IMAGE']);?>
;
     var YBCNIVO_CAPTION_SPEED=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_CAPTION_SPEED']);?>
;
     var YBCNIVO_FRAME_WIDTH='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_FRAME_WIDTH'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
</script>
<?php }?><?php }} ?>
