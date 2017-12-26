<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:25:56
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/pdf/invoice.shipping-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15406517975988a2a414a7e3-23312951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb39890c57ed164f2e47c499a6508bca3695342c' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/pdf/invoice.shipping-tab.tpl',
      1 => 1497785606,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15406517975988a2a414a7e3-23312951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'carrier' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a2a4150c60_25103960',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a2a4150c60_25103960')) {function content_5988a2a4150c60_25103960($_smarty_tpl) {?>
<table id="shipping-tab" width="100%">
	<tr>
		<td class="shipping center small grey bold" width="44%"><?php echo smartyTranslate(array('s'=>'Carrier','pdf'=>'true'),$_smarty_tpl);?>
</td>
		<td class="shipping center small white" width="56%"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
	</tr>
</table>
<?php }} ?>
