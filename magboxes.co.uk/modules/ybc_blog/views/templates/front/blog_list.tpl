<div class="ybc_blog_layout_{$blog_layout} ybc_blog_skin_{$blog_skin} ybc-blog-wrapper ybc-blog-wrapper-blog-list {if $blog_latest}ybc-page-latest{elseif $blog_category}ybc-page-category{elseif $blog_tag}ybc-page-tag{elseif $blog_search}ybc-page-search{elseif $author}ybc-page-author{else}ybc-page-home{/if}">
    {if $is_main_page}
        {hook h='blogSlidersBlock'}
    {/if}
    {if $blog_category}
        <div class="blog-category {if $blog_category.image}has-blog-image{/if}">
            {if $blog_category.image}
                <img src="{$blog_dir}images/category/{$blog_category.image}" alt="{$blog_category.title}" title="{$blog_category.title}" />
            {/if}
            <h2 class="page-heading product-listing"><span class="title_cat">{$blog_category.title}</span></h2>            
            {if $blog_category.description}
                <div class="blog-category-desc">
                    {$blog_category.description}
                </div>
            {/if}
        </div>
    {elseif $blog_latest}
       <h1 class="page-heading product-listing"><span class="title_cat">{l s='Latest posts' mod='ybc_blog'}</span></h1>
    {elseif $blog_tag}
        <h1 class="page-heading product-listing"><span class="title_cat">{l s='Tag: ' mod='ybc_blog'}"{ucfirst($blog_tag)}"</span></h1>
    {elseif $blog_search}
        <h1 class="page-heading product-listing"><span class="title_cat">{l s='Search: ' mod='ybc_blog'}"{ucfirst($blog_search)}"</span></h1>
    {elseif $author}
        <h1 class="page-heading product-listing"><span class="title_cat">{l s='Author: ' mod='ybc_blog'}"{$author}"</span></h1>
    {elseif $show_featured_post}        
        <h1 class="page-heading product-listing" style="display:none"><span class="title_cat">{l s='Featured posts' mod='ybc_blog'}</span></h1>
    {/if}
    {if $show_featured_post || $blog_category || $blog_tag || $blog_search}
        {if isset($blog_posts)}
            <ul class="ybc-blog-list row">
                {assign var='first_post' value=true}
                {foreach from=$blog_posts item='post'}            
                    <li itemscope itemtype="http://schema.org/LiveBlogPosting">                         
                        <div class="post-wrapper">
                            {if $is_main_page && $first_post && ($blog_layout == 'large_list' || $blog_layout == 'large_grid')}
                                {if $post.image}
                                    <a class="ybc_item_img" href="{$post.link}">
                                        <img title="{$post.title}" src="{$post.image}" alt="{$post.title}" />
                                    </a>                              
                                {elseif $post.thumb}
                                    <a class="ybc_item_img" href="{$post.link}">
                                        <img title="{$post.title}" src="{$post.thumb}" alt="{$post.title}" />
                                    </a>
                                {/if}
                                {assign var='first_post' value=false}
                            {elseif $post.thumb}
                                <a class="ybc_item_img" href="{$post.link}">
                                    <img title="{$post.title}" src="{$post.thumb}" alt="{$post.title}" />
                                </a>
                            {/if}
                            <div class="ybc-blog-wrapper-content">
                            <div class="ybc-blog-wrapper-content-main">
                                <h2><a href="{$post.link}">{$post.title}</a></h2> 
                                {*if $show_date || $show_categories && $post.categories}
                                    <div class="ybc-blog-post-meta"> 
                                        {if !$date_format}{assign var='date_format' value='F jS Y'}{/if}
                                        {if $show_categories && $post.categories}
                                            <div class="blog-extra-item be-categories-block">
                                                {assign var='ik' value=0}
                                                {assign var='totalCat' value=count($post.categories)}
                                                <span class="be-label">{l s='Posted in' mod='ybc_blog'}: </span>
                                                <div class="be-categories">
                                                    {foreach from=$post.categories item='cat'}
                                                        {assign var='ik' value=$ik+1}                                        
                                                        <a href="{$cat.link}">{ucfirst($cat.title)}</a>{if $ik < $totalCat}, {/if}
                                                    {/foreach}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $show_date}                                
                                            <span class="blog-posted-date">{date($date_format,strtotime($post.datetime_added))}</span>                                
                                        {/if} 
                                    </div> 
                                {/if*}
                                <div class="ybc-blog-latest-toolbar">	
									{if $show_views}
                                        <div class="item blog-extra-item be-view-block" title="{l s='Page views' mod='ybc_blog'}">                        
                                            <span class="be-view-span">{$post.click_number} {if $post.click_number !=1}<span>{l s='Views' mod='ybc_blog'}</span>{else}<span>{l s='View' mod='ybc_blog'}</span>{/if}</span>
                                        </div>
                                    {/if} 
                                    {if $allow_like}
                                        <span title="{l s='Liked' mod='ybc_blog'}" class="item ybc-blog-like-span ybc-blog-like-span-{$post.id_post} {if $post.liked}active{/if}"  data-id-post="{$post.id_post}">                        
                                            <span class="blog-post-total-like ben_{$post.id_post}">{$post.likes}</span>
                                            <span class="blog-post-like-text blog-post-like-text-{$post.id_post}"><span>{l s='Liked' mod='ybc_blog'}</span></span>
                                        </span> 
                                    {/if}                     
                                    {if $allow_rating && isset($post.everage_rating) && $post.everage_rating}
                                        {assign var='everage_rating' value=$post.everage_rating}
                                        <div class="blog-extra-item be-rating-block item">
                                            <span>{l s='Rating: ' mod='ybc_blog'}</span>
                                            <div class="blog_rating_wrapper">
                                                <div class="ybc_blog_review" title="{l s='Everage rating' mod='ybc_blog'}">
                                                    {for $i = 1 to $everage_rating}
                                                        <div class="star star_on"></div>
                                                    {/for}
                                                    {if $everage_rating<5}
                                                        {for $i = $everage_rating + 1 to 5}
                                                            <div class="star"></div>
                                                        {/for}
                                                    {/if}
                                                    <span  class="ybc-blog-rating-value"  itemprop="ratingValue">{number_format((float)$everage_rating, 1, '.', '')}</span>
                                                </div>
                                                {if $post.total_review}
                                                    <span title="{l s='Comments' mod='ybc_blog'}" class="blog__rating_reviews">
                                                         {$post.total_review}
                                                         <span>
                                                            {if $post.total_review != 1}
                                                                {l s='Reviews' mod='ybc_blog'}
                                                            {else}
                                                                {l s='Review' mod='ybc_blog'}
                                                            {/if}
                                                        </span>
                                                    </span>
                                                {/if}
                                            </div>
                                        </div>
                                    {/if}   
                                </div>
                                <div class="blog-content">
                                    {if $post.short_description}
                                        <p>{$post.short_description|strip_tags:'UTF-8'|truncate:500:'...'}</p>
                                    {elseif $post.description}
                                        <p>{$post.description|strip_tags:'UTF-8'|truncate:500:'...'}</p>
                                    {/if}                                
                                </div>
                                <div class="ybc-blog-post-footer">
                                    <a class="read_more" href="{$post.link}">{l s='Read More' mod='ybc_blog'}</a>
                                    
                                </div>
                              </div>
                            </div>
                        </div>
                        
                    </li>
                {/foreach}
            </ul>
            {if $blog_paggination}
                <div class="blog-paggination">
                    {$blog_paggination}
                </div>
            {/if}
        {else}
            <p>{l s='No posts found' mod='ybc_blog'}</p>
        {/if}
    {/if}
    {if $is_main_page}
        {hook h='blogGalleryBlock'}
    {/if}
</div>