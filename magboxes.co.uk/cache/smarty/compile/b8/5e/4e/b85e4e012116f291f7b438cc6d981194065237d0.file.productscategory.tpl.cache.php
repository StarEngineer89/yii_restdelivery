<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 16:52:51
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/productscategory/productscategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74913427597a0c5334a581-95421825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b85e4e012116f291f7b438cc6d981194065237d0' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/productscategory/productscategory.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74913427597a0c5334a581-95421825',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryProducts' => 0,
    'categoryProduct' => 0,
    'link' => 0,
    'quick_view' => 0,
    'ProdDisplayPrice' => 0,
    'restricted_country_mode' => 0,
    'PS_CATALOG_MODE' => 0,
    'tc_config' => 0,
    'static_token' => 0,
    'comparator_max_item' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597a0c5344d6c4_57941675',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597a0c5344d6c4_57941675')) {function content_597a0c5344d6c4_57941675($_smarty_tpl) {?>

<?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>0&&$_smarty_tpl->tpl_vars['categoryProducts']->value!==false) {?>
<section class="page-product-box blockproductscategory">
	<h3 class="productscategory_h3 page-product-heading">
		
        <span><?php echo smartyTranslate(array('s'=>'Related products','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
	</h3>
	<div id="productscategory_list" class="clearfix">
		<ul id="bxslider1" class="bxslider1 clearfix product_list">
		<?php  $_smarty_tpl->tpl_vars['categoryProduct'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categoryProduct']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categoryProducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categoryProduct']->key => $_smarty_tpl->tpl_vars['categoryProduct']->value) {
$_smarty_tpl->tpl_vars['categoryProduct']->_loop = true;
?>
			<li class="product-box item">
                <div class="product-box-content product-container">
                    <div class="left-block">
                        <div class="product-image-container">
            				<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'],$_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['category'],$_smarty_tpl->tpl_vars['categoryProduct']->value['ean13']);?>
" class="lnk_img product-image product_img_link" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
">
                                <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
" />
                            </a>
                            <?php if (isset($_smarty_tpl->tpl_vars['categoryProduct']->value['new'])&&$_smarty_tpl->tpl_vars['categoryProduct']->value['new']==1) {?>
    							<a class="new-box" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
    								<span class="new-label"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
    							</a>
    						<?php }?>
                            <div class="button-container-product">
                                <?php if (isset($_smarty_tpl->tpl_vars['quick_view']->value)&&$_smarty_tpl->tpl_vars['quick_view']->value) {?>
                					<a class="quick-view" data-toggle="tooltip" data-placement="left" title="<?php echo smartyTranslate(array('s'=>'Quick view','mod'=>'productscategory'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
                						<span><?php echo smartyTranslate(array('s'=>'Quick view','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
                					</a>
                				<?php }?>
                            </div>
                        </div>
                    </div>
                <div class="right-block">
    				<h5 itemprop="name" class="product-name">
    					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'],$_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['category'],$_smarty_tpl->tpl_vars['categoryProduct']->value['ean13']), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
    				</h5>
    				<?php if ($_smarty_tpl->tpl_vars['ProdDisplayPrice']->value&&$_smarty_tpl->tpl_vars['categoryProduct']->value['show_price']==1&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
    					<p class="content_price">
        					<?php if (isset($_smarty_tpl->tpl_vars['categoryProduct']->value['specific_prices'])&&$_smarty_tpl->tpl_vars['categoryProduct']->value['specific_prices']&&(number_format($_smarty_tpl->tpl_vars['categoryProduct']->value['displayed_price'],2)!==number_format($_smarty_tpl->tpl_vars['categoryProduct']->value['price_without_reduction'],2))) {?>
                                <span class="price product-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['categoryProduct']->value['displayed_price']),$_smarty_tpl);?>
</span>
        						<span class="old-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['categoryProduct']->value['price_without_reduction']),$_smarty_tpl);?>
</span>
        						<?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LISTING_REVIEW'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LISTING_REVIEW']) {?>
                                    <div class="hook-reviews">
                					      <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayYbcProductReview','product'=>$_smarty_tpl->tpl_vars['categoryProduct']->value),$_smarty_tpl);?>

                					</div>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['categoryProduct']->value['specific_prices']['reduction']&&$_smarty_tpl->tpl_vars['categoryProduct']->value['specific_prices']['reduction_type']=='percentage') {?>
        							<span class="price-percent-reduction">-<?php echo $_smarty_tpl->tpl_vars['categoryProduct']->value['specific_prices']['reduction']*100;?>
%</span>
        						<?php }?>
        
        					<?php } else { ?>
        						<span class="price product-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['categoryProduct']->value['displayed_price']),$_smarty_tpl);?>
</span>
                                <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LISTING_REVIEW'])&&$_smarty_tpl->tpl_vars['tc_config']->value['YBC_TC_LISTING_REVIEW']) {?>
                                    <div class="hook-reviews">
                					      <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayYbcProductReview','product'=>$_smarty_tpl->tpl_vars['categoryProduct']->value),$_smarty_tpl);?>

                					</div>
                                <?php }?>
        					<?php }?>
    					</p>
                        <div class="box_button">
                            <div class="functional-buttons clearfix" title="<?php echo smartyTranslate(array('s'=>'Add to whishlist','mod'=>'productscategory'),$_smarty_tpl);?>
">
            					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListFunctionalButtons','product'=>$_smarty_tpl->tpl_vars['categoryProduct']->value),$_smarty_tpl);?>

            				</div>
                            <div title="<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'productscategory'),$_smarty_tpl);?>
" class="ybc_add_to_cart">
            					<?php if (!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value&&($_smarty_tpl->tpl_vars['categoryProduct']->value['allow_oosp']||$_smarty_tpl->tpl_vars['categoryProduct']->value['quantity']>0)) {?>
            						<div class="no-print">
            							<a class="exclusive button ajax_add_to_cart_button" href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
<?php $_tmp1=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"qty=1&amp;id_product=".$_tmp1."&amp;token=".((string)$_smarty_tpl->tpl_vars['static_token']->value)."&amp;add"), ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'productscategory'),$_smarty_tpl);?>
">
            								<span><?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
            							</a>
            						</div>
            					<?php }?>
            				</div>
                            <?php if (isset($_smarty_tpl->tpl_vars['comparator_max_item']->value)&&$_smarty_tpl->tpl_vars['comparator_max_item']->value) {?>
        						<div data-id-product="<?php echo $_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'];?>
" class="add_to_compare compare" title="<?php echo smartyTranslate(array('s'=>'Add to Compare','mod'=>'productscategory'),$_smarty_tpl);?>
">
        							<a class="add_compare" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'];?>
">
                                        <?php echo smartyTranslate(array('s'=>'Add to Compare','mod'=>'productscategory'),$_smarty_tpl);?>

                                    </a>
        						</div>
        					<?php }?>
                        </div>
    				<?php }?>                        
                </div>
                </div>
			</li>
		<?php } ?>
		</ul>
	</div>
</section>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'min_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'max_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparator_max_item'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparedProductsIds'=>$_smarty_tpl->tpl_vars['compared_products']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
