
<!-- Block search module TOP -->
<div id="search_block_top" class="{if $searched_categories}has-categories-dropdown{else}no-categories-dropdown{/if}">
	<span class="toogle_search_top"></span>
    <div class="search_block_top_fixed">
        <div class="search_block_top_content">
            <span class="search_block_top_content_icon"></span>
            <div class="search_block_top_close in_content"></div>
            <form id="searchbox" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" >
        		<input type="hidden" name="controller" value="search" />
        		<input type="hidden" name="orderby" value="position" />
        		<input type="hidden" name="orderway" value="desc" />
                {if $searched_categories}{$searched_categories}{/if}
        		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="{l s='Search for products ...' mod='blocksearch'}" value="{$search_query|escape:'htmlall':'UTF-8'|stripslashes}" />
        		<button type="submit" name="submit_search" class="btn btn-default button-search">
    			<span>{l s='Search' mod='blocksearch'}</span>
        		</button>
        	</form>
         </div>
     </div>
</div>
<!-- /Block search module TOP -->