<script type="text/javascript">
    ybc_blog_report_url = '{$report_url}';
    ybc_blog_report_warning = '{l s='Do you want to report this comment?' mod='ybc_blog'}';
    ybc_blog_error = '{l s='There was a problem while submitting your report. Try again later' mod='ybc_blog'}';
</script>
<div class="ybc_blog_layout_{$blog_layout} ybc_blog_skin_{$blog_skin} ybc-blog-wrapper-detail" itemscope itemType="http://schema.org/BlogPosting">
    {if $blog_post.image}
        {if $enable_slideshow}<a href="{$blog_post.image}" class="prettyPhoto">{/if}<img title="{$blog_post.title}" src="{$blog_post.image}" alt="{$blog_post.title}" />{if $enable_slideshow}</a>{/if}
        {if $enable_slideshow}
            <script type="text/javascript">    
                prettySkin = '{$prettySkin}';
                prettyAutoPlay = false;
                {literal}
                    $(document).ready(function(){            
                        $("a[class^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:prettySkin,slideshow:3000, autoplay_slideshow: prettyAutoPlay, social_tools: '',deeplinking: false});
                    });
                {/literal}
            </script>
        {/if}
     {/if}
     <div class="ybc-blog-wrapper-content">
    {if $blog_post}
        <h1 class="page-heading product-listing"><span class="title_cat">{$blog_post.title}</span></h1>
        <div class="post-details">
            <div class="blog-extra">
                {if $show_categories && $blog_post.categories}
                    <div class="blog-extra-item be-categories-block">
                        {assign var='ik' value=0}
                        {assign var='totalCat' value=count($blog_post.categories)}                        
                        <div class="be-categories">
                            <span class="be-label">{l s='Posted in' mod='ybc_blog'}: </span>
                            {foreach from=$blog_post.categories item='cat'}
                                {assign var='ik' value=$ik+1}                                        
                                <a href="{$cat.link}">{ucfirst($cat.title)}</a>{if $ik < $totalCat}, {/if}
                            {/foreach}
                        </div>
                    </div>
                {/if} 
                {if $show_date}
                    {if !$date_format}{assign var='date_format' value='F jS Y'}{/if}
                    <div class="blog-extra-item be-date-block">
                        <span class="blog-posted-date">{date($date_format,strtotime($blog_post.datetime_added))}</span>
                    </div>
                {/if}
                {if $show_author && ($blog_post.firstname || $blog_post.lastname)}
                    <div class="blog-extra-item be-author-block">
                        <span class="blog-post-author">
                            <span class="post-author-label">{l s='Posted by: ' mod='ybc_blog'}</span>
                                <a href="{$blog_post.author_link}">
                                    <span class="post-author-name">
                                        {ucfirst($blog_post.firstname)} {ucfirst($blog_post.lastname)}
                                    </span>
                                </a>                                
                            
                        </span>
                    </div>
                {/if}
                <div class="ybc-blog-view-like-rate">
                    {if $show_views}
                        <div class="blog-extra-item be-view-block">                        
                            <span title="{l s='Page views' mod='ybc_blog'}" class="be-view-span">{$blog_post.click_number} {if $blog_post.click_number != 1}<span>{l s='Views' mod='ybc_blog'}</span>{else}<span>{l s='View' mod='ybc_blog'}</span>{/if}</span>
                        </div>
                        {/if} 
                        {if $allow_like}
                            <div class="blog-extra-item be-like-block">
                                <span title="{l s='Liked' mod='ybc_blog'}" class="ybc-blog-like-span ybc-blog-like-span-{$blog_post.id_post} {if $likedPost}active{/if}"  data-id-post="{$blog_post.id_post}">                        
                                    <span class="blog-post-total-like ben_{$blog_post.id_post}">{$blog_post.likes}</span>
                                    <span class="blog-post-like-text blog-post-like-text-{$blog_post.id_post}"><span>{l s='Liked' mod='ybc_blog'}</span></span>
                                </span>                        
                            </div>
                        {/if}
                        {if $allow_rating && $everage_rating}
                        <div class="blog-extra-item be-rating-block" itemprop="comment" itemscope itemtype="http://schema.org/UserComments">                        
                            <div class="blog_rating_wrapper"   itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">                            
                                <div  title="{l s='Everage rating' mod='ybc_blog'}" class="ybc_blog_review">
                                    <span>{l s='Rating: ' mod='ybc_blog'}</span> 
                                    {for $i = 1 to $everage_rating}
                                        <div class="star star_on"></div>
                                    {/for}
                                    {if $everage_rating<5}
                                        {for $i = $everage_rating + 1 to 5}
                                            <div class="star"></div>
                                        {/for}
                                    {/if}
                                    <span class="ybc-blog-rating-value"  itemprop="ratingValue">{number_format((float)$everage_rating, 1, '.', '')}</span>
                                </div>
                                {if $total_review}
                                    <span title="{l s='Comments' mod='ybc_blog'}" class="blog__rating_reviews">
                                         <span class="total_views" itemprop="reviewCount">{$total_review}</span>
                                         <span>
                                            {if $total_review != 1}
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
                <div class="ybc-blog-tags-social"> 
                {if $use_google_share || $use_facebook_share || $use_twitter_share}
                    <div class="blog-extra-item blog-extra-facebook-share">
                        {if $use_facebook_share}
                            <div class="ybc_blog_button_share">
                                <div id="fb-root"></div>
                                {literal}
                                    <script>(function(d, s, id) {
                                      var js, fjs = d.getElementsByTagName(s)[0];
                                      if (d.getElementById(id)) return;
                                      js = d.createElement(s); js.id = id;
                                      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3";
                                      fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));</script>
                                {/literal}
                                <div class="fb-like" data-href="{$post_url}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                            </div>
                        {/if}
                        {if $use_google_share}
                            <div class="ybc_blog_button_share">
                                <script src="https://apis.google.com/js/platform.js" async defer></script>                   
                                <div class="g-plusone" data-size="medium" data-href="{$post_url}"></div>
                            </div>
                        {/if}
                        {if $use_twitter_share}
                            <div class="ybc_blog_button_share">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="{$post_url}">{l s='Tweet' mod='ybc_blog'}</a>
                                {literal}
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                {/literal}
                            </div>
                        {/if}
                    </div>   
                {/if}          
            </div>               
            </div>                           
            <div class="blog-content">
                {if $blog_post.description}
                    {$blog_post.description}
                {else}
                    {$blog_post.short_description}
                {/if}
            </div>
            <div class="ybc-blog-tags">
                {if $show_tags && $blog_post.tags}
                <div class="blog-extra-item be-tag-block">
                    {assign var='ik' value=0}
                    {assign var='totalTag' value=count($blog_post.tags)}
                    <span class="be-label"> {if $totalTag > 1}{l s='Tags' mod='ybc_blog'}{else}{l s='Tag' mod='ybc_blog'}{/if}: </span>
                    <div class="be-tags">
                        {foreach from=$blog_post.tags item='tag'}
                            {assign var='ik' value=$ik+1}                                        
                            <a href="{$tag.link}">{ucfirst($tag.tag)}</a>{if $ik < $totalTag}, {/if}
                        {/foreach}
                    </div>
                </div>
            {/if} 
            </div>  
            
            {if $display_related_products && $blog_post.products}
                <div id="ybc-blog-related-products" class="">
                    <h4 class="title_block"><span class="title_cat">{if count($blog_post.products) > 1}{l s='Related products ' mod='ybc_blog'}{else}{l s='Related product ' mod='ybc_blog'}{/if}</span></h4>
                    <div class="ybc-blog-related-products-wrapper ybc-blog-related-products-list">
                        <ul class="blog-product-list product_list grid row ybc_related_products_type_{if $blog_related_product_type}{$blog_related_product_type}{else}default{/if}">
                            {foreach from=$blog_post.products item='product'}
                                <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3">
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="{$product.link}"><img src="{$product.img_url}" alt="{$product.name}" /></a>
                                        </div>
                                        <div class="right-block">
                                            <h5><a href="{$product.link}">{$product.name}</a></h5>
                                            <div class="blog-product-extra content_price">
                                                {if $product.price!=$product.old_price}
                                                    <span class="bp-price-old old-price"><span class="bp-price-old-label">{l s='Old price: ' mod='ybc_blog'}</span><span class="bp-price-old-display">{$product.old_price}</span></span>
                                                {/if}
                                                <span class="bp-price price product-price"><span class="bp-price-label">{l s='Price:  ' mod='ybc_blog'}</span><span class="bp-price-display">{$product.price}</span></span>
                                                {if $product.price!=$product.old_price}
                                                    <span class="bp-percent price-percent-reduction"><span class="bp-percent-label">{l s='Discount: ' mod='ybc_blog'}</span><span class="bp-percent-display">-{$product.discount_percent}{l s='%' mod='ybc_blog'}</span></span>
                                                    <span class="bp-save"><span class="bp-save-label">{l s='Save up: ' mod='ybc_blog'}</span><span class="bp-save-display">-{$product.discount_amount}</span></span>
                                                {/if}
                                            </div>
                                            {*if $product.short_description}
                                                <div class="blog-product-desc">
                                                    {$product.short_description|strip_tags:'UTF-8'|truncate:80:'...'}
                                                </div>
                                            {/if*}
                                        </div>
                                    </div>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            {/if}
            <div class="ybc-blog-wrapper-comment">          
                {if $allowComments}
                    <div class="ybc_comment_form_blog">
                        <h4 class="title_block"><span class="title_cat">{l s='Leave a comment' mod='ybc_blog'}</span></h4>
                        <div class="ybc-blog-form-comment">                   
                            {if $hasLoggedIn}
                                <form action="{$blogCommentAction}" method="post">
                                    <div class="blog-comment-row blog-title">
                                        <label for="bc-subject">{l s='Subject ' mod='ybc_blog'}</label>
                                        <input class="form-control" name="subject" id="bc-subject" type="text" value="{if isset($subject)}{$subject}{/if}" />
                                    </div>                                
                                    <div class="blog-comment-row blog-content-comment">
                                        <label for="bc-comment">{l s='Comment ' mod='ybc_blog'}</label>
                                        <textarea   class="form-control" name="comment" id="bc-comment">{if isset($comment)}{$comment}{/if}</textarea>
                                    </div>
                                    {if $allow_rating}                            
                                        <div class="blog-comment-row blog-rate-post">
                                            <label>{l s='Rate this post ' mod='ybc_blog'}</label>
                                                <div class="blog_rating_box">
                                                    {if $default_rating > 0 && $default_rating <5}
                                                        <input id="blog_rating" type="hidden" name="rating" value="{$default_rating}" />
                                                        {for $i = 1 to $default_rating}
                                                            <div rel="{$i}" class="star star_on blog_rating_star blog_rating_star_{$i}"></div>
                                                        {/for}
                                                        {for $i = $default_rating + 1 to 5}
                                                            <div rel="{$i}" class="star blog_rating_star blog_rating_star_{$i}"></div>
                                                        {/for}
                                                    {else}
                                                        <input id="blog_rating" type="hidden" name="rating" value="5" />
                                                        {for $i = 1 to 5}
                                                            <div rel="{$i}" class="star star_on blog_rating_star blog_rating_star_{$i}"></div>
                                                        {/for}
                                                    {/if}
                                                </div>
                                        </div>
                                    {/if}
                                    {if $use_capcha}
                                        <div class="blog-comment-row blog-capcha">
                                            <label for="bc-capcha">{l s='Security code ' mod='ybc_blog'}</label>
                                            <span class="bc-capcha-wrapper">
                                                <img rel="{$blog_random_code}" id="ybc-blog-capcha-img" src="{$capcha_image}" /><span id="ybc-blog-capcha-refesh" title="{l s='Refresh code' mod='ybc_blog'}">{*l s='Refresh code'*}</span>
                                                <input class="form-control" name="capcha_code" type="text" id="bc-capcha" value="" />
                                            </span>
                                        </div>
                                    {/if}
                                    <div class="blog-comment-row blog-submit">
                                        <input class="button" type="submit" value="{l s='Submit' mod='ybc_blog'}" name="bcsubmit" />
                                    </div>                       
                                    {if $blog_errors && is_array($blog_errors)}
                                        <ul class="alert alert-danger ybc_alert-danger">
                                            {foreach from=$blog_errors item='error'}
                                                <li>{$error}</li>
                                            {/foreach}
                                        </ul>
                                    {/if}
                                    {if $blog_success}
                                        <p class="alert alert-success ybc_alert-success">{$blog_success}</p>
                                    {/if}
                                </form>
                            {else}
                                <p class="alert alert-warning">{l s='Log in to post comments' mod='ybc_blog'}</p>
                            {/if}
                        </div> 
                    </div>
                    {if count($comments)}
                        <div class="ybc_blog-comments-list">
                        {if count($comments)>1}
                            <h4><span class="title_cat">{l s='Comments ' mod='ybc_blog'}</span></h4>
                        {else}
                            <h4><span class="title_cat">{l s='Comment ' mod='ybc_blog'}</span></h4>
                        {/if}
                        <ul class="blog-comments-list">
                            {foreach from=$comments item='comment'}
                                
                                    <li class="blog-comment-line">
                                    <div class="ybc-blog-detail-comment">
                                        <h5 class="comment-subject">{$comment.subject}</h5>
                                        {if $comment.firstname || $comment.lastname}<span class="comment-by">{l s='By : ' mod='ybc_blog'}<b>{ucfirst($comment.firstname)} {ucfirst($comment.lastname)}</b></span>{/if}
                                        <span class="comment-time"><span>{l s='On' mod='ybc_blog'} </span>{date($date_format,strtotime($comment.datetime_added))}</span>
                                        {if $allow_rating && $comment.rating > 0}
                                            <div class="comment-rating"  itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                                <span>{l s='Rating: ' mod='ybc_blog'}</span>
                                                <div class="ybc_blog_review">
                                                    {for $i = 1 to $comment.rating}
                                                        <div class="star star_on"></div>
                                                    {/for}
                                                    {if $comment.rating<5}
                                                        {for $i = $comment.rating + 1 to 5}
                                                            <div class="star"></div>
                                                        {/for}
                                                    {/if} 
                                                    {*<span class="ybc-blog-everage-rating"> {$comment.rating}</span>  *}                                     
                                                </div>
                                            </div>
                                        {/if} 
                                        {if $comment.comment}<p class="comment-content">{$comment.comment}</p>{/if}
                                        {if $allow_report_comment && $hasLoggedIn}
                                            {if !($reportedComments && is_array($reportedComments) && in_array($comment.id_comment, $reportedComments))}
                                                <span class="ybc-block-comment-report comment-report-{$comment.id_comment}" rel="{$comment.id_comment}">{l s='Report abuse' mod='ybc_blog'}</span>
                                            {/if}
                                        {/if}
                                        {if $comment.reply}<p class="comment-reply">
                                            {if $comment.elastname || $comment.efirstname}
                                                <span class="ybc-blog-replied-by">
                                                    {l s='Replied by : ' mod='ybc_blog'}
                                                    <span class="ybc-blog-replied-by-name">
                                                        {ucfirst($comment.efirstname)} {ucfirst($comment.elastname)}
                                                    </span>
                                                </span>
                                            {/if}
                                            <span class="ybc-blog-reply-content">
                                                {$comment.reply}
                                            </span></p>
                                        {/if}
                                    </div>
                                    </li>
                                
                            {/foreach}
                        </ul> 
                        </div>                 
                    {/if}
                {/if}
            </div>            
        </div>
        {else}
            <p class="warning">{l s='No posts found' mod='ybc_blog'}</p>
        {/if}
        {if $blog_post.related_posts}
            <div class="ybc-blog-related-posts ybc_blog_related_posts_type_{if $blog_related_posts_type}{$blog_related_posts_type}{else}default{/if}">
                <h4 class="title_block"><span class="title_cat">{l s='Related posts' mod='ybc_blog'}</span></h4>
                <div class="ybc-blog-related-posts-wrapper">
                    <ul class="ybc-blog-related-posts-list">
                        {foreach from=$blog_post.related_posts item='rpost'}
                            
                            <li class="ybc-blog-related-posts-list-li">
                                <div class="">
                                    {if $rpost.thumb}
                                        <a class="ybc_item_img" href="{$rpost.link}">
                                            <img src="{$rpost.thumb}" alt="{$rpost.title}" />
                                            <div>			
            									{*if $allowComments || $show_views || $allow_like}
                                                    <div class="ybc-blog-latest-toolbar">                                         
                                                        {if $show_views}
                                                            <span class="ybc-blog-latest-toolbar-views">{$rpost.click_number}</span> 
                                                        {/if} 
                                                        <div class="ybc-blog-latest-toolbar-bottom">                        
                                                            {if $allow_like}
                                                                <span class="ybc-blog-like-span ybc-blog-like-span-{$rpost.id_post} {if $rpost.liked}active{/if}"  data-id-post="{$rpost.id_post}">                        
                                                                    <span class="blog-post-total-like ben_{$rpost.id_post}">{$rpost.likes}</span>
                                                                </span>  
                                                            {/if}
                                                            {if $allowComments}
                                                                <span class="ybc-blog-latest-toolbar-comments">{$rpost.comments_num}</span> 
                                                            {/if}
                                                        </div> 
                                                    </div>
                                                {/if*}   
            									<div class="curl-bottom-left"></div>
            								</div>
                                            
                                        </a>
                                    {/if}
                                    <h3><a href="{$rpost.link}">{$rpost.title}</a></h3>
                                    <div class="ybc-blog-related-posts-meta">
                                        {*if $rpost.categories}
                                            {assign var='ik' value=0}
                                            {assign var='totalCat' value=count($rpost.categories)}                        
                                            <div class="ybc-blog-related-posts-meta-categories">
                                                <span class="be-label">{l s='Posted in' mod='ybc_blog'}: </span>
                                                {foreach from=$rpost.categories item='cat'}
                                                    {assign var='ik' value=$ik+1}                                        
                                                    <a href="{$cat.link}">{ucfirst($cat.title)}</a>{if $ik < $totalCat}, {/if}
                                                {/foreach}
                                            </div>
                                        {/if*}
                                        <div class="ybc-blog-related-posts-meta-post-date">
                                            <span class="be-label">{l s='Posted on' mod='ybc_blog'}: </span>
                                            <span>{date($date_format,strtotime($rpost.datetime_added))}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        {/foreach}                        
                    </ul>
                </div>
            </div>
        {/if}
    </div>        
</div>