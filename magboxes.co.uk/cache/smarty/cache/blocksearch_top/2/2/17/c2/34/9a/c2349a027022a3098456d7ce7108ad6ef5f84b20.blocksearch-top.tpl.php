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
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_59b194e3386956_27878857',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59b194e3386956_27878857')) {function content_59b194e3386956_27878857($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="has-categories-dropdown">
	<span class="toogle_search_top"></span>
    <div class="search_block_top_fixed">
        <div class="search_block_top_content">
            <span class="search_block_top_content_icon"></span>
            <div class="search_block_top_close in_content"></div>
            <form id="searchbox" method="get" action="//magboxes.co.uk/search" >
        		<input type="hidden" name="controller" value="search" />
        		<input type="hidden" name="orderby" value="position" />
        		<input type="hidden" name="orderway" value="desc" />
                <select class="searched_category" name="searched_category"><option value="0">All categories</option><option  class="search_depth_level_1" value="12">Mag254</option><option  class="search_depth_level_1" value="13">Mag 254 wifi built in</option><option  class="search_depth_level_1" value="14">Mag256</option><option  class="search_depth_level_1" value="15">Mag 256 wifi built in</option><option  class="search_depth_level_1" value="16">Zgemma Satellite</option><option  class="search_depth_level_1" value="17">Zgemma Cable</option><option  class="search_depth_level_1" value="18">Zgemma IPTV</option><option  class="search_depth_level_1" value="19">Storage Devices</option><option  class="search_depth_level_1" value="20">RF Connectors + Cable Splitters</option><option  class="search_depth_level_1" value="21">Zgemma 2S (Satellite)</option><option  class="search_depth_level_1" value="22">Zgemma H.2S (Satellite)</option><option  class="search_depth_level_1" value="23">Zgemma H5 (Satellite & Cable)</option><option  class="search_depth_level_1" value="24">Zgemma H5.2TC (Cable)</option><option  class="search_depth_level_1" value="25">Zgemma H.2H (Satellite & Cable)</option><option  class="search_depth_level_1" value="26">Zgemma 2S</option></select><span class="select-arrow"></span>        		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Search for products ..." value="" />
        		<button type="submit" name="submit_search" class="btn btn-default button-search">
    			<span>Search</span>
        		</button>
        	</form>
         </div>
     </div>
</div>
<!-- /Block search module TOP --><?php }} ?>
