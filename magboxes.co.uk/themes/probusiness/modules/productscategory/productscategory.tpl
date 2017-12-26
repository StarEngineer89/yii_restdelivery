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

{if count($categoryProducts) > 0 && $categoryProducts !== false}
<section class="page-product-box blockproductscategory">
	<h3 class="productscategory_h3 page-product-heading">
		{*if $categoryProducts|@count == 1}
			{l s='%s other product in the same category:' sprintf=[$categoryProducts|@count] mod='productscategory'}
		{else}
			{l s='%s other products in the same category:' sprintf=[$categoryProducts|@count] mod='productscategory'}
		{/if*}
        <span>{l s='Related products' mod='productscategory'}</span>
	</h3>
	<div id="productscategory_list" class="clearfix">
		<ul id="bxslider1" class="bxslider1 clearfix product_list">
		{foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}
			<li class="product-box item">
                <div class="product-box-content product-container">
                    <div class="left-block">
                        <div class="product-image-container">
            				<a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)}" class="lnk_img product-image product_img_link" title="{$categoryProduct.name|htmlspecialchars}">
                                <img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{$categoryProduct.name|htmlspecialchars}" />
                            </a>
                            {if isset($categoryProduct.new) && $categoryProduct.new == 1}
    							<a class="new-box" href="{$categoryProduct.link|escape:'html':'UTF-8'}">
    								<span class="new-label">{l s='New'}</span>
    							</a>
    						{/if}
                            <div class="button-container-product">
                                {if isset($quick_view) && $quick_view}
                					<a class="quick-view" data-toggle="tooltip" data-placement="left" title="{l s='Quick view' mod='productscategory'}" href="{$categoryProduct.link|escape:'html':'UTF-8'}" rel="{$categoryProduct.link|escape:'html':'UTF-8'}">
                						<span>{l s='Quick view' mod='productscategory'}</span>
                					</a>
                				{/if}
                            </div>
                        </div>
                    </div>
                <div class="right-block">
    				<h5 itemprop="name" class="product-name">
    					<a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)|escape:'html':'UTF-8'}" title="{$categoryProduct.name|htmlspecialchars}">{$categoryProduct.name|escape:'html':'UTF-8'}</a>
    				</h5>
    				{if $ProdDisplayPrice && $categoryProduct.show_price == 1 && !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
    					<p class="content_price">
        					{if isset($categoryProduct.specific_prices) && $categoryProduct.specific_prices
        					&& ($categoryProduct.displayed_price|number_format:2 !== $categoryProduct.price_without_reduction|number_format:2)}
                                <span class="price product-price">{convertPrice price=$categoryProduct.displayed_price}</span>
        						<span class="old-price">{displayWtPrice p=$categoryProduct.price_without_reduction}</span>
        						{if isset($tc_config.YBC_TC_LISTING_REVIEW) && $tc_config.YBC_TC_LISTING_REVIEW}
                                    <div class="hook-reviews">
                					      {hook h='displayYbcProductReview' product=$categoryProduct}
                					</div>
                                {/if}
                                {if $categoryProduct.specific_prices.reduction && $categoryProduct.specific_prices.reduction_type == 'percentage'}
        							<span class="price-percent-reduction">-{$categoryProduct.specific_prices.reduction * 100}%</span>
        						{/if}
        
        					{else}
        						<span class="price product-price">{convertPrice price=$categoryProduct.displayed_price}</span>
                                {if isset($tc_config.YBC_TC_LISTING_REVIEW) && $tc_config.YBC_TC_LISTING_REVIEW}
                                    <div class="hook-reviews">
                					      {hook h='displayYbcProductReview' product=$categoryProduct}
                					</div>
                                {/if}
        					{/if}
    					</p>
                        <div class="box_button">
                            <div class="functional-buttons clearfix" title="{l s='Add to whishlist' mod='productscategory'}">
            					{hook h='displayProductListFunctionalButtons' product=$categoryProduct}
            				</div>
                            <div title="{l s='Add to cart' mod='productscategory'}" class="ybc_add_to_cart">
            					{if !$PS_CATALOG_MODE && ($categoryProduct.allow_oosp || $categoryProduct.quantity > 0)}
            						<div class="no-print">
            							<a class="exclusive button ajax_add_to_cart_button" href="{$link->getPageLink('cart', true, NULL, "qty=1&amp;id_product={$categoryProduct.id_product|intval}&amp;token={$static_token}&amp;add")|escape:'html':'UTF-8'}" data-id-product="{$categoryProduct.id_product|intval}" title="{l s='Add to cart' mod='productscategory'}">
            								<span>{l s='Add to cart' mod='productscategory'}</span>
            							</a>
            						</div>
            					{/if}
            				</div>
                            {if isset($comparator_max_item) && $comparator_max_item}
        						<div data-id-product="{$categoryProduct.id_product}" class="add_to_compare compare" title="{l s='Add to Compare' mod='productscategory'}">
        							<a class="add_compare" href="{$categoryProduct.link|escape:'html':'UTF-8'}" data-id-product="{$categoryProduct.id_product}">
                                        {l s='Add to Compare' mod='productscategory'}
                                    </a>
        						</div>
        					{/if}
                        </div>
    				{/if}                        
                </div>
                </div>
			</li>
		{/foreach}
		</ul>
	</div>
</section>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
