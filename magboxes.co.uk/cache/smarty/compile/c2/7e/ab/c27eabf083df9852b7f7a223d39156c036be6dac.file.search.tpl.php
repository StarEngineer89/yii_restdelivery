<?php /* Smarty version Smarty-3.1.19, created on 2017-07-31 06:10:33
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1619843327597ebbc98963e3-56312691%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c27eabf083df9852b7f7a223d39156c036be6dac' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/search.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1619843327597ebbc98963e3-56312691',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'instant_search' => 0,
    'nbProducts' => 0,
    'search_query' => 0,
    'search_tag' => 0,
    'ref' => 0,
    'search_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_597ebbc994ae92_91600023',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_597ebbc994ae92_91600023')) {function content_597ebbc994ae92_91600023($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1
<?php if (isset($_smarty_tpl->tpl_vars['instant_search']->value)&&$_smarty_tpl->tpl_vars['instant_search']->value) {?>id="instant_search_results"<?php }?>
class="page-heading <?php if (!isset($_smarty_tpl->tpl_vars['instant_search']->value)||(isset($_smarty_tpl->tpl_vars['instant_search']->value)&&!$_smarty_tpl->tpl_vars['instant_search']->value)) {?> product-listing<?php }?>">
    <?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
&nbsp;
    <?php if ($_smarty_tpl->tpl_vars['nbProducts']->value>0) {?>
        <span class="lighter">
            "<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } elseif ($_smarty_tpl->tpl_vars['search_tag']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_tag']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } elseif ($_smarty_tpl->tpl_vars['ref']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ref']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
        </span>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['instant_search']->value)&&$_smarty_tpl->tpl_vars['instant_search']->value) {?>
        <a href="#" class="close">
            <?php echo smartyTranslate(array('s'=>'Return to the previous page'),$_smarty_tpl);?>

        </a>
    <?php } else { ?>
        <span class="heading-counter">
            <?php if ($_smarty_tpl->tpl_vars['nbProducts']->value==1) {?><?php echo smartyTranslate(array('s'=>'%d result has been found.','sprintf'=>intval($_smarty_tpl->tpl_vars['nbProducts']->value)),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'%d results have been found.','sprintf'=>intval($_smarty_tpl->tpl_vars['nbProducts']->value)),$_smarty_tpl);?>
<?php }?>
        </span>
    <?php }?>
</h1>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (!$_smarty_tpl->tpl_vars['nbProducts']->value) {?>
	<p class="alert alert-warning">
		<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?>
			<?php echo smartyTranslate(array('s'=>'No results were found for your search'),$_smarty_tpl);?>
&nbsp;"<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
		<?php } elseif (isset($_smarty_tpl->tpl_vars['search_tag']->value)&&$_smarty_tpl->tpl_vars['search_tag']->value) {?>
			<?php echo smartyTranslate(array('s'=>'No results were found for your search'),$_smarty_tpl);?>
&nbsp;"<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_tag']->value, ENT_QUOTES, 'UTF-8', true);?>
"
		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'Please enter a search keyword'),$_smarty_tpl);?>

		<?php }?>
	</p>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['instant_search']->value)&&$_smarty_tpl->tpl_vars['instant_search']->value) {?>
        <p class="alert alert-info">
            <?php if ($_smarty_tpl->tpl_vars['nbProducts']->value==1) {?><?php echo smartyTranslate(array('s'=>'%d result has been found.','sprintf'=>intval($_smarty_tpl->tpl_vars['nbProducts']->value)),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'%d results have been found.','sprintf'=>intval($_smarty_tpl->tpl_vars['nbProducts']->value)),$_smarty_tpl);?>
<?php }?>
        </p>
    <?php }?>
    <div class="content_sortPagiBar">
        <div class="sortPagiBar clearfix <?php if (isset($_smarty_tpl->tpl_vars['instant_search']->value)&&$_smarty_tpl->tpl_vars['instant_search']->value) {?> instant_search<?php }?>">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            
            <?php if (!isset($_smarty_tpl->tpl_vars['instant_search']->value)||(isset($_smarty_tpl->tpl_vars['instant_search']->value)&&!$_smarty_tpl->tpl_vars['instant_search']->value)) {?>
                <?php echo $_smarty_tpl->getSubTemplate ("./nbr-product-page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <?php }?>
            <?php echo $_smarty_tpl->getSubTemplate ("./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>

	</div>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['search_products']->value), 0);?>

    <div class="content_sortPagiBar">
    	<div class="bottom-pagination-content clearfix">
        	<?php if (!isset($_smarty_tpl->tpl_vars['instant_search']->value)||(isset($_smarty_tpl->tpl_vars['instant_search']->value)&&!$_smarty_tpl->tpl_vars['instant_search']->value)) {?>
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('paginationId'=>'bottom','no_follow'=>1), 0);?>

            <?php }?>
        </div>
    </div>
<?php }?>
<?php }} ?>
