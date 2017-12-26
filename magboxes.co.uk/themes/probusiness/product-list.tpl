{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($products) && $products}
	{*define number of products per line in other page for desktop*}
	{if $page_name !='index' && $page_name !='product'}
		{assign var='nbItemsPerLine' value=3}
		{assign var='nbItemsPerLineTablet' value=2}
		{assign var='nbItemsPerLineMobile' value=2}
	{else}
		{assign var='nbItemsPerLine' value=4}
		{assign var='nbItemsPerLineTablet' value=4}
		{assign var='nbItemsPerLineMobile' value=2}
	{/if}
	{*define numbers of product per line in other page for tablet*}
	{assign var='nbLi' value=$products|@count}
	{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
	<!-- Products list -->
	<ul{if isset($id) && $id} id="{$id}"{/if} class="product_list grid row{if isset($class) && $class} {$class}{/if}">
	{assign var='is' value=0}
    {foreach from=$products item=product name=products}        
        {if true || isset($ybcDev) && $ybcDev && isset($tc_dev_mode) && $tc_dev_mode && isset($tc_layout_products) && $tc_layout_products && in_array($product.id_product,$tc_layout_products) || !isset($ybcDev) || isset($ybcDev) && !$ybcDev || !isset($tc_layout_products) || isset($tc_layout_products) && !$tc_layout_products}
		{math equation="(total%perLine)" total=$smarty.foreach.products.total perLine=$nbItemsPerLine assign=totModulo}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
		{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
		{if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
		{if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}
        {assign var='is' value=$is+1}
		<li class="{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1}{if $is > 8}no-animation {else}wow zoomIn{/if}{/if} item ajax_block_product{if $page_name == 'index' || $page_name == 'product'} col-xs-12 col-sm-3 col-md-3{else} col-xs-12 col-sm-6 col-md-4{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLine == 1} first-in-line{/if}{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModulo)} last-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 0} last-item-of-tablet-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 1} first-item-of-tablet-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 0} last-item-of-mobile-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 1} first-item-of-mobile-line{/if}{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModuloMobile)} last-mobile-line{/if}">
            <div class="product-container" itemscope itemtype="https://schema.org/Product">
				<div class="left-block">
					<div class="product-image-container">
						{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
	                       {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
                                <span class="price-percent-reduction{if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0} {else} not-show{/if}">
                                    {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
        								{hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
        								{if $product.specific_prices.reduction_type == 'percentage'}
        									- {$product.specific_prices.reduction * 100}%
                                        {else}
                                            - {convertPrice price=$product.specific_prices.reduction}
        								{/if}
        							{/if}
                                </span>
                            {/if}
                        {/if}
                        <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
							<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
						      {hook h='productImageHover' id_product=$product.id_product}
                        </a>
						
						{if isset($product.new) && $product.new == 1}
							<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="new-label">{l s='New'}</span>
							</a>
						{/if}
						{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
							<a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="sale-label">{l s='Sale'}</span>
							</a>
						{/if}
                        <div class="button-container-product">
                            
                            {if isset($quick_view) && $quick_view}
        						<a class="quick-view" data-toggle="tooltip" title="{l s='Quick view'}" data-placement="left" href="{$product.link|escape:'html':'UTF-8'}" data-url="{$product.link|escape:'html':'UTF-8'}">
        							<span>{l s='Quick view'}</span>
        						</a>
    						{/if}
                            
                        </div>
					</div>
					{if isset($product.is_virtual) && !$product.is_virtual}{hook h="displayProductDeliveryTime" product=$product}{/if}
					{hook h="displayProductPriceBlock" product=$product type="weight"}
				</div>
				<div class="right-block">
					<h5 itemprop="name">
						{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
						<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
							{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
						</a>
					</h5>
					{*{capture name='displayProductListReviews'}{hook h='displayProductListReviews' product=$product}{/capture}*}
					{*{if $smarty.capture.displayProductListReviews}*}
					{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
    					<div class="content_price">
    						{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
    							{hook h="displayProductPriceBlock" product=$product type='before_price'}
    							<span class="price product-price">
    								{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
    							</span>
                                {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
    								{hook h="displayProductPriceBlock" product=$product type="old_price"}
    								<span class="old-price product-price">
    									{displayWtPrice p=$product.price_without_reduction}
    								</span>
                                {/if}
    							{if isset($tc_config.YBC_TC_LISTING_REVIEW) && $tc_config.YBC_TC_LISTING_REVIEW}
                                    <div class="hook-reviews">
                					      {hook h='displayYbcProductReview' product=$product}
                					</div>
                                {/if}                                
    							{hook h="displayProductPriceBlock" product=$product type="price"}
    							{hook h="displayProductPriceBlock" product=$product type="unit_price"}
    							{hook h="displayProductPriceBlock" product=$product type='after_price'}
    						{/if}
    					</div>
					{/if}
                    <div class="box_button">
                    
                    <div class="functional-buttons clearfix" data-toggle="tooltip" data-placement="left" title="{l s='Add to Wishlist'}">
        						{hook h='displayProductListFunctionalButtons' product=$product}
        					</div>
                    
                    {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
						<div class="button_addtocart">
                            {if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
    							{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
    							<a class="button ajax_add_to_cart_button btn btn-default" data-toggle="tooltip" data-placement="left" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
    								<span>{l s='Add to cart'}</span>
    							</a>
    						{else}
    							<span class="button ajax_add_to_cart_button btn btn-default disabled">
    								<span>{l s='Add to cart'}</span>
    							</span>
    						{/if}
                        </div>
					{/if}
                    
                    {if isset($comparator_max_item) && $comparator_max_item}
    							<div class="compare" data-toggle="tooltip" data-placement="left" title="{l s='Add to Compare'}">
    								<a class="add_to_compare" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">
                                        {l s='Add to Compare'}
                                    </a>
    							</div>
    						{/if}
                     </div>       
                            
					{*{/if}*}
                    <p class="product-desc" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
					</p>
				</div>

					

			</div><!-- .product-container> -->
		</li>
        {/if}
	{/foreach}
    
        {*if $page_name == 'index'}
            {if $is > 8}
                <li class="col-xs-12 view_more_products a_{$is}">
                    <div class="view_more">
                        <i class="fa fa-long-arrow-down"></i>
                        {l s='View more items'}
                        <i class="fa fa-long-arrow-down"></i>
                    </div>
                </li>
                <li class="col-xs-12 view_less_products" style="display:none">
                    <div class="view_more"><i class="fa fa-long-arrow-up"></i> {l s='View less items'} <i class="fa fa-long-arrow-up"></i></div>
                </li>
            {/if}
        {/if*}
	</ul>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
