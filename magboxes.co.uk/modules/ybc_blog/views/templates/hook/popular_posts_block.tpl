{if $posts}
    {if !isset($date_format) || isset($date_format) && !$date_format}{assign var='date_format' value='F jS Y'}{/if}
    <div class="block ybc-blog-posts-popular sidebar-post-type-{$sidebar_post_type} ybc_blog_skin_{$blog_skin}">
        <h4 class="title_block">{l s='Popular posts' mod='ybc_blog'}</h4>
        <div class="block_content">
            <ul class="ybc-blog-posts-popular-list ybc_popular_posts" id="ybc_popular_posts">
                {foreach from=$posts item='post'}
                    <li> 
                        <div class="ybc-blog-posts-popular-list-wrapper">                          
                            {if $post.thumb}<a href="{$post.link}"><img src="{$post.thumb}" alt="{$post.title}" title="{$post.title}" /></a>{/if}                        
                            <div class="ybc-blog-popular-content"> 
                                <a class="ybc_title_block" href="{$post.link}">{$post.title}</a> 
                                <span class="post-date">{date('F jS, Y', strtotime($post.datetime_added))}</span>
                                {if $allowComments || $show_views || $allow_like}
                                    <div class="ybc-blog-latest-toolbar">                                         
                                        {if $show_views}
                                            <span class="ybc-blog-latest-toolbar-views">{$post.click_number} {if $post.click_number!=1}<span>{l s='views' mod='ybc_blog'}</span>{else}<span>{l s='view' mod='ybc_blog'}</span>{/if}</span> 
                                        {/if}                               
                                        {if $allow_like}
                                            <span class="ybc-blog-like-span ybc-blog-like-span-{$post.id_post} {if $post.liked}active{/if}"  data-id-post="{$post.id_post}">                        
                                                <span class="blog-post-like-text blog-post-like-text-{$post.id_post}">{l s='Liked' mod='ybc_blog'}</span>
                                                <span class="blog-post-total-like ben_{$post.id_post}">{$post.likes}</span>
                                            </span>  
                                        {/if}
                                        {if $allowComments}
                                            <span class="ybc-blog-latest-toolbar-comments">{$post.comments_num} {if $post.comments_num!=1}<span>{l s='comments' mod='ybc_blog'}</span>{else}<span>{l s='comment' mod='ybc_blog'}</span>{/if}</span> 
                                        {/if}
                                    </div>
                                {/if}                 
                                {if $post.short_description}
                                    <p>{$post.short_description|strip_tags:'UTF-8'|truncate:120:'...'}</p>
                                {elseif $post.description}
                                    <p>{$post.description|strip_tags:'UTF-8'|truncate:120:'...'}</p>
                                {/if}
                                
                                <div class="ybc-blog-sidear-post-meta">
                                    {if $post.categories}
                                        <div class="ybc-blog-categories">
                                            {assign var='ik' value=0}
                                            {assign var='totalCat' value=count($post.categories)}                        
                                            <div class="be-categories">
                                                <span class="be-label">{l s='Posted in' mod='ybc_blog'}: </span>
                                                {foreach from=$post.categories item='cat'}
                                                    {assign var='ik' value=$ik+1}                                        
                                                    <a href="{$cat.link}">{ucfirst($cat.title)}</a>{if $ik < $totalCat}, {/if}
                                                {/foreach}
                                            </div>
                                        </div>
                                    {/if}
                                    <span class="blog-posted-date">{date($date_format,strtotime($post.datetime_added))}</span>
                                </div>
                            </div>
                        </div> 
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="clear"></div>
    </div>
{/if}