<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:25:55
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/pdf/invoice.addresses-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18207061555988a2a3ea4dd6-32169141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7cba6c5d77e7391167f975559fe1d66a8366e4a' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/pdf/invoice.addresses-tab.tpl',
      1 => 1497785602,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18207061555988a2a3ea4dd6-32169141',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_invoice' => 0,
    'delivery_address' => 0,
    'invoice_address' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a2a3eb2b56_85602106',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a2a3eb2b56_85602106')) {function content_5988a2a3eb2b56_85602106($_smarty_tpl) {?>
<table id="addresses-tab" cellspacing="0" cellpadding="0">
	<tr>
		<td width="33%"><span class="bold"> </span><br/><br/>
			<?php if (isset($_smarty_tpl->tpl_vars['order_invoice']->value)) {?><?php echo $_smarty_tpl->tpl_vars['order_invoice']->value->shop_address;?>
<?php }?>
		</td>
		<td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Delivery Address','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

			<?php }?>
		</td>
		<td width="33%"><span class="bold"><?php echo smartyTranslate(array('s'=>'Billing Address','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

		</td>
	</tr>
</table>
<?php }} ?>
