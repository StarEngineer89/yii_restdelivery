{if $posts}
    <div class="homeblog ybc_blog_skin_{$blog_skin}">
        <h4 class="title_block title_news">{l s='Latest from our blog' mod='ybc_blog'}</h4>
        <div class="row">
            <ul id="ybc-blog-posts-home-list" class="ybc_popular_posts">
                {assign var='i' value=0}
                {foreach from=$posts item='post' $i++}
                    
                    <li class="col-xs-12{if ($i%2 == 0)} smallwidth{else} largeblog{/if} ybc-blog-posts-home-list-item"> 
                        <div class="ybc-blog-posts-home-list-item-content">
                            <div class="ybc-blog-home-post-wrapper">                        
                                    {if $post.thumb}<a class="ybc_item_img" href="{$post.link}"><img src="{$post.thumb}" alt="{$post.title}" title="{$post.title}" /></a>{/if}
                            </div> 
                            <div class="ybc-blog-home-content-show">
                                <a class="ybc_title_block" href="{$post.link}">{$post.title}</a>
                                {*<span class="post-date">{date('F jS, Y', strtotime($post.datetime_added))}</span>*} 
                                {if $post.short_description}
                                    <p>{$post.short_description|strip_tags:'UTF-8'|truncate:120:'...'}</p>
                                {elseif $post.description}
                                    <p>{$post.description|strip_tags:'UTF-8'|truncate:120:'...'}</p>
                                {/if}
                                <a class="read_more" href="{$post.link}">{l s='Read more ...' mod='ybc_blog'}</a>
                            </div> 
                        </div> 
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="clear"></div>
    </div>
{/if}