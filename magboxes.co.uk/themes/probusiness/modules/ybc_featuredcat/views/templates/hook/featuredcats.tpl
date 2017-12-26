{if $page_name =='index'}
{if ($layouts == 'default')}
{if $featuredCats}
    <div class="container">
        <ul class="ybc_featuredcats">
            {foreach from=$featuredCats item='cat'}
                <li class="col-md-4 col-sm-4 ybc-fc-item-frontend {if $cat.categories}has-cat{else}no-cat{/if} {if isset($cat.image) && $cat.image}ybc-fc-has-cat-image-display{else}ybc-fc-no-cat-image{/if}">
                    {if $cat.banner_position=='TOP' && ($cat.banner1 || $cat.banner2 || $cat.banner3)}
                        <div class="ybc-fc-banners banner-{$cat.bannerClass}">
                            {if $cat.banner1}{if $cat.banner1_link}<a href="{$cat.banner1_link}">{/if}<figure><img src="{$cat.banner1}" alt="{$cat.title}" /></figure>{if $cat.banner1_link}</a>{/if}{/if}
                            {if $cat.banner2}{if $cat.banner2_link}<a href="{$cat.banner2_link}">{/if}<figure><img src="{$cat.banner2}" alt="{$cat.title}" /></figure>{if $cat.banner2_link}</a>{/if}{/if}
                            {if $cat.banner3}{if $cat.banner3_link}<a href="{$cat.banner3_link}">{/if}<figure><img src="{$cat.banner3}" alt="{$cat.title}" /></figure>{if $cat.banner3_link}</a>{/if}{/if}
                        </div>
                    {/if}
                    <ul class="fc-content-frontend">
                        <!--<h4>{if $cat.link}<a class="title_cat" href="{$cat.link}">{/if}{$cat.title}{if $cat.link}</a>{/if}</h4>-->
                        {foreach from=$cat.categories item='c'}
                            <li class="wow zoomIn">
                                <a class="ybc_featuredcat_banner" href="{$c.url}">
                                     {if $cat.banner_position!='TOP' && ($cat.banner1 || $cat.banner2 || $cat.banner3)}
                                        {if $cat.banner1}{if $cat.banner1_link}<a href="{$cat.banner1_link}">{/if}<img src="{$cat.banner1}" alt="{$cat.title}" />{if $cat.banner1_link}</a>{/if}{/if}
                                         
                                    {/if}  
                                </a>
                                <a class="ybc_featuredcat_name" href="{$c.url}">
                                    <span> {$c.name} </span> 
                                </a>
                            </li>
                        {/foreach}
                    </ul> 
                                
                </li>
            {/foreach}
        </ul>
    </div>     
{else}
    <div class="clearfix"></div>
    <div class="container">
        <p id="ybc-featured-cats-warning" class="alert alert-warning">{l s='You have no featured categories. Please add some from backoffice'}</p>
    </div>
{/if}
{/if}
{/if}  
