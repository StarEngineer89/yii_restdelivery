<?php /* Smarty version Smarty-3.1.19, created on 2017-07-29 06:37:57
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/products-comparison.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1896984031597c1f359d7b66-45457767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e6d7a40c029c5660d7b76e0f44e6ae83b490454' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/products-comparison.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1896984031597c1f359d7b66-45457767',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hasProduct' => 0,
    'HOOK_COMPARE_EXTRA_INFORMATION' => 0,
    'use_taxes' => 0,
    'priceDisplay' => 0,
    'products' => 0,
    'product' => 0,
    'link' => 0,
    'restricted_country_mode' => 0,
    'PS_CATALOG_MODE' => 0,
    'taxes_behavior' => 0,
    'add_prod_display' => 0,
    'static_token' => 0,
    'ordered_features' => 0,
    'classname' => 0,
    'feature' => 0,
    'product_id' => 0,
    'product_features' => 0,
    'feature_id' => 0,
    'tab' => 0,
    'HOOK_EXTRA_PRODUCT_COMPARISON' => 0,
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597c1f35b81574_19807405',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597c1f35b81574_19807405')) {function content_597c1f35b81574_19807405($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/function.cycle.php';
?>
<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Product Comparison'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'Product Comparison'),$_smarty_tpl);?>
</h1>
<?php if ($_smarty_tpl->tpl_vars['hasProduct']->value) {?>
	<div class="products_block table-responsive">
		<table id="product_comparison" class="table table-bordered">
			<tr>
				<td class="td_empty compare_extra_information">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_COMPARE_EXTRA_INFORMATION']->value;?>

					<span><?php echo smartyTranslate(array('s'=>'Features:'),$_smarty_tpl);?>
</span>
				</td>
				<?php $_smarty_tpl->tpl_vars['taxes_behavior'] = new Smarty_variable(false, null, 0);?>
				<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value&&(!$_smarty_tpl->tpl_vars['priceDisplay']->value||$_smarty_tpl->tpl_vars['priceDisplay']->value==2)) {?>
					<?php $_smarty_tpl->tpl_vars['taxes_behavior'] = new Smarty_variable(true, null, 0);?>
				<?php }?>
				<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
					<?php $_smarty_tpl->tpl_vars['replace_id'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->value->id).('|'), null, 0);?>
					<td class="ajax_block_product comparison_infos product-block product-<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
">
						<div class="remove">
							<a class="cmp_remove" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('products-comparison',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
">
								<i class="icon-trash"></i>
							</a>
						</div>
						<div class="product-image-block">
							<a
							class="product_image"
							href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->getLink(), ENT_QUOTES, 'UTF-8', true);?>
"
							title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
">
								<img
								class="img-responsive"
								src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['product']->value->id_image,'home_default'), ENT_QUOTES, 'UTF-8', true);?>
"
								alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" />
							</a>
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value->new)&&$_smarty_tpl->tpl_vars['product']->value->new==1) {?>
								<a class="new-box" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->getLink(), ENT_QUOTES, 'UTF-8', true);?>
">
									<span class="new-label"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
								</a>
							<?php }?>
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value->show_price)&&$_smarty_tpl->tpl_vars['product']->value->show_price&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
								<?php if ($_smarty_tpl->tpl_vars['product']->value->on_sale) {?>
									<a class="sale-box" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->getLink(), ENT_QUOTES, 'UTF-8', true);?>
">
										<span class="sale-label"><?php echo smartyTranslate(array('s'=>'Sale!'),$_smarty_tpl);?>
</span>
									</a>
								<?php }?>
							<?php }?>
						</div> <!-- end product-image-block -->
						<h5>
							<a class="product-name"	href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->getLink(), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value->name,32,'...'), ENT_QUOTES, 'UTF-8', true);?>
">
								<?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value->name,45,'...'), ENT_QUOTES, 'UTF-8', true);?>

							</a>
						</h5>
						<div class="prices-container">
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value->show_price)&&$_smarty_tpl->tpl_vars['product']->value->show_price&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
								<span class="price product-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value->getPrice($_smarty_tpl->tpl_vars['taxes_behavior']->value)),$_smarty_tpl);?>
</span>
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'id_product'=>$_smarty_tpl->tpl_vars['product']->value->id,'type'=>"price"),$_smarty_tpl);?>

								<?php if (isset($_smarty_tpl->tpl_vars['product']->value->specificPrice)&&$_smarty_tpl->tpl_vars['product']->value->specificPrice) {?>
									<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['product']->value->specificPrice['reduction_type']=='percentage';?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1) {?>
										<span class="old-price product-price">
											<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>($_smarty_tpl->tpl_vars['product']->value->getPrice(true,null,6,null,false,false))),$_smarty_tpl);?>

										</span>
										
									<?php } else { ?>
										<span class="old-price product-price">
											<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>($_smarty_tpl->tpl_vars['product']->value->getPrice($_smarty_tpl->tpl_vars['taxes_behavior']->value)+$_smarty_tpl->tpl_vars['product']->value->specificPrice['reduction'])),$_smarty_tpl);?>

										</span>
										
									<?php }?>
									<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl);?>

								<?php }?>
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"price"),$_smarty_tpl);?>

								
							<?php }?>
						</div> <!-- end prices-container -->
						<div class="product_desc">
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['product']->value->description_short),60,'...');?>

						</div>
						<div class="comparison_product_infos">
							<p class="comparison_availability_statut">
								<?php if (!(($_smarty_tpl->tpl_vars['product']->value->quantity<=0&&!$_smarty_tpl->tpl_vars['product']->value->available_later)||($_smarty_tpl->tpl_vars['product']->value->quantity!=0&&!$_smarty_tpl->tpl_vars['product']->value->available_now)||!$_smarty_tpl->tpl_vars['product']->value->available_for_order||$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value)) {?>
									<span class="availability_label"><?php echo smartyTranslate(array('s'=>'Availability:'),$_smarty_tpl);?>
</span>
									<span class="availability_value"<?php if ($_smarty_tpl->tpl_vars['product']->value->quantity<=0) {?> class="warning-inline"<?php }?>>
										<?php if ($_smarty_tpl->tpl_vars['product']->value->quantity<=0) {?>
											<?php if ($_smarty_tpl->tpl_vars['product']->value->allow_oosp) {?>
												<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->available_later, ENT_QUOTES, 'UTF-8', true);?>

											<?php } else { ?>
												<?php echo smartyTranslate(array('s'=>'This product is no longer in stock.'),$_smarty_tpl);?>

											<?php }?>
										<?php } else { ?>
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->available_now, ENT_QUOTES, 'UTF-8', true);?>

										<?php }?>
									</span>
								<?php }?>
							</p>
							<?php if (!$_smarty_tpl->tpl_vars['product']->value->is_virtual) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductDeliveryTime",'product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>
<?php }?>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"weight"),$_smarty_tpl);?>

							<div class="clearfix">
								<div class="button-container">
									<?php if ((!$_smarty_tpl->tpl_vars['product']->value->hasAttributes()||(isset($_smarty_tpl->tpl_vars['add_prod_display']->value)&&($_smarty_tpl->tpl_vars['add_prod_display']->value==1)))&&$_smarty_tpl->tpl_vars['product']->value->minimal_quantity==1&&$_smarty_tpl->tpl_vars['product']->value->customizable!=2&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
										<?php if (($_smarty_tpl->tpl_vars['product']->value->quantity>0||$_smarty_tpl->tpl_vars['product']->value->allow_oosp)) {?>
											<a class="button ajax_add_to_cart_button btn btn-default button" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"qty=1&amp;id_product=".((string)$_smarty_tpl->tpl_vars['product']->value->id)."&amp;token=".((string)$_smarty_tpl->tpl_vars['static_token']->value)."&amp;add"), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
">
												<span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
											</a>
										<?php } else { ?>
											<span class="ajax_add_to_cart_button button btn btn-default disabled ">
												<span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
											</span>
										<?php }?>
									<?php }?>
									
								</div>
							</div>
						</div> <!-- end comparison_product_infos -->
					</td>
				<?php } ?>
			</tr>
			<?php if ($_smarty_tpl->tpl_vars['ordered_features']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['feature']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ordered_features']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->key => $_smarty_tpl->tpl_vars['feature']->value) {
$_smarty_tpl->tpl_vars['feature']->_loop = true;
?>
					<tr>
						<?php echo smarty_function_cycle(array('values'=>'comparison_feature_odd,comparison_feature_even','assign'=>'classname'),$_smarty_tpl);?>

						<td class="<?php echo $_smarty_tpl->tpl_vars['classname']->value;?>
 feature-name" >
							<strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feature']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</strong>
						</td>
						<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
							<?php $_smarty_tpl->tpl_vars['product_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value->id, null, 0);?>
							<?php $_smarty_tpl->tpl_vars['feature_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['feature']->value['id_feature'], null, 0);?>
							<?php if (isset($_smarty_tpl->tpl_vars['product_features']->value[$_smarty_tpl->tpl_vars['product_id']->value])) {?>
								<?php $_smarty_tpl->tpl_vars['tab'] = new Smarty_variable($_smarty_tpl->tpl_vars['product_features']->value[$_smarty_tpl->tpl_vars['product_id']->value], null, 0);?>
								<td class="<?php echo $_smarty_tpl->tpl_vars['classname']->value;?>
 comparison_infos product-<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
"><?php if ((isset($_smarty_tpl->tpl_vars['tab']->value[$_smarty_tpl->tpl_vars['feature_id']->value]))) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value[$_smarty_tpl->tpl_vars['feature_id']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></td>
							<?php } else { ?>
								<td class="<?php echo $_smarty_tpl->tpl_vars['classname']->value;?>
 comparison_infos product-<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
"></td>
							<?php }?>
						<?php } ?>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td></td>
					<td colspan="<?php echo count($_smarty_tpl->tpl_vars['products']->value);?>
" class="text-center"><?php echo smartyTranslate(array('s'=>'No features to compare'),$_smarty_tpl);?>
</td>
				</tr>
			<?php }?>
			<?php echo $_smarty_tpl->tpl_vars['HOOK_EXTRA_PRODUCT_COMPARISON']->value;?>

		</table>
	</div> <!-- end products_block -->
<?php } else { ?>
	<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'There are no products selected for comparison.'),$_smarty_tpl);?>
</p>
<?php }?>
<ul class="footer_link">
	<li>
		<a class="button lnk_view btn btn-default" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>">
			<span><i class="icon-chevron-left left"></i><?php echo smartyTranslate(array('s'=>'Continue Shopping'),$_smarty_tpl);?>
</span>
		</a>
	</li>
</ul>
<?php }} ?>
