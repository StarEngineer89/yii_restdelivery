<?php /*%%SmartyHeaderCode:13792333875979f27d974146-48343786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd24af307afb5531debeb00127048fe65af882e58' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blockmyaccountfooter/blockmyaccountfooter.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13792333875979f27d974146-48343786',
  'variables' => 
  array (
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_BLOCK_MY_ACCOUNT' => 0,
    'is_logged' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27d9df545_48640934',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27d9df545_48640934')) {function content_5979f27d9df545_48640934($_smarty_tpl) {?>
<!-- Block myaccount module -->

<section class="myaccount-footer footer-block col-xs-12 col-sm-3">
	<h4 class="">My account</h4>
	<div class="block_content toggle-footer">
		<ul class="bullet">
            <li><a href="http://magboxes.co.uk/my-account" title="Manage my customer account" rel="nofollow"> My account</a></li>
			<li><a href="http://magboxes.co.uk/order-history" title="My orders" rel="nofollow"> My orders</a></li>
						<li><a href="http://magboxes.co.uk/credit-slip" title="My credit slips" rel="nofollow"> My credit slips</a></li>
			<li><a href="http://magboxes.co.uk/addresses" title="My addresses" rel="nofollow"> My addresses</a></li>
			<li><a href="http://magboxes.co.uk/identity" title="Manage my personal information" rel="nofollow"> My personal info</a></li>
						
            <li><a href="http://magboxes.co.uk/?mylogout" title="Sign out" rel="nofollow"> Sign out</a></li>		</ul>
	</div>
</section>

<!-- /Block myaccount module -->
<?php }} ?>
