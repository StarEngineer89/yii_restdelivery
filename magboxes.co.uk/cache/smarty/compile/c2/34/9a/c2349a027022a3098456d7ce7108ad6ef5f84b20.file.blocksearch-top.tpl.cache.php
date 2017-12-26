<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:37
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_blocksearch/blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5625767745979f27d03bb88-03545368%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2349a027022a3098456d7ce7108ad6ef5f84b20' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_blocksearch/blocksearch-top.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5625767745979f27d03bb88-03545368',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'searched_categories' => 0,
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27d0889a5_60646869',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27d0889a5_60646869')) {function content_5979f27d0889a5_60646869($_smarty_tpl) {?>
<!-- Block search module TOP -->
<div id="search_block_top" class="<?php if ($_smarty_tpl->tpl_vars['searched_categories']->value) {?>has-categories-dropdown<?php } else { ?>no-categories-dropdown<?php }?>">
	<span class="toogle_search_top"></span>
    <div class="search_block_top_fixed">
        <div class="search_block_top_content">
            <span class="search_block_top_content_icon"></span>
            <div class="search_block_top_close in_content"></div>
            <form id="searchbox" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
        		<input type="hidden" name="controller" value="search" />
        		<input type="hidden" name="orderby" value="position" />
        		<input type="hidden" name="orderway" value="desc" />
                <?php if ($_smarty_tpl->tpl_vars['searched_categories']->value) {?><?php echo $_smarty_tpl->tpl_vars['searched_categories']->value;?>
<?php }?>
        		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search for products ...','mod'=>'blocksearch'),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
        		<button type="submit" name="submit_search" class="btn btn-default button-search">
    			<span><?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
</span>
        		</button>
        	</form>
         </div>
     </div>
</div>
<!-- /Block search module TOP --><?php }} ?>
