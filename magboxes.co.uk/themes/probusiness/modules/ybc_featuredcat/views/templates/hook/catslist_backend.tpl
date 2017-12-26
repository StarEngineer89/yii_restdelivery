{if $featuredCats}
    <ul class="ybc_featuredcats_backend">
        {foreach from=$featuredCats item='cat'}
            <li class="ybc_fc_item" rel="{$cat.id_category}">
                <div class="fc-content">
                    <h6>{if $cat.link}<a href="{$cat.link}" target="_blank">{/if}{$cat.title}{if $cat.link}</a>{/if}</h6>
                    <div class="cats">
                        {if $cat.image}{if $cat.link}<a href="{$cat.link}" target="_blank">{/if}<img style="max-width: 100px;" src="{$cat.image}" title="{$cat.title}" />{if $cat.link}</a>{/if}{/if}
                        {if $cat.categories}
                            <ul class="categories_list">
                                {foreach from=$cat.categories item='c'}
                                    <li><a target="_blank" href="{$c.url}">{$c.name}</a></li>
                                {/foreach}
                            </ul>
                        {/if}
                        {if $cat.products}
                            <div id="ybc_products_list">
                                <table class="products_list">
                                    <tbody>
                                        {foreach from=$cat.products item='product'}
                                            <td>
                                                <a target="_blank" class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
                        							<img  src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" />
                        						</a>
                                                <h6>
                                                    <a target="_blank" class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
                            							{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
                            						</a>
                                                </h6>
                                                <span>{convertPrice price=$product.price}</span>
                                            </td>
                                        {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        {/if}
                    </div>
                </div>
                <div class="fc_button">
                    <ul>
                        <li><a href="{$cat.enabled_link}"> {if !$cat.enabled}<i title="{l s='Disable this item'}" class="icon-remove"></i>{else}<i title="{l s='Enable this item'}" class="icon-check"></i>{/if}</a></li>
                        <li><a href="{$cat.edit_link}"><i class="icon-pencil"></i> {*l s='Edit'*}</a></li>
                        <li><a class="delete" href="{$cat.delete_link}" onclick="return confirm('{l s='Do you want to delete this item?'}');"><i class="icon-trash"></i> {*l s='Delete'*}</a></li>
                    </ul>
                </div>
            </li>
        {/foreach}
    </ul>
{/if}