
<div class="container">
<div class="row">
{hook h='displayCustomDiscount'}
    {if $posts}
        <div class="homeblog_wrapper col-sm-8 col-md-9">
            <div class="homeblog ybc_blog_skin_{$blog_skin}">        
                <h4 class="title-home"> <span>{l mod='ybc_blog' s='From our blog'}</span></h4>
                    <ul id="ybc-blog-posts-home-list" class="ybc_popular_posts">            
                        {foreach from=$posts item='post'}
                        <li class="{if isset($tc_config.YBC_TC_FLOAT_CSS3) && $tc_config.YBC_TC_FLOAT_CSS3 == 1} wow zoomIn{/if}">                             
                            <div class="ybc-blog-posts-home-list-item">
                                <div class="ybc-blog-posts-home-list-item-content">
                                    <div class="row">
                                        <div class="ybc-blog-home-post-wrapper col-md-5">                        
                                                {if $post.thumb}
                                                    <a class="ybc_item_img" href="{$post.link}">
                                                        <img src="{$post.thumb}" alt="{$post.title}" title="{$post.title}" />
                                                    </a>
                                                {/if}
                                        </div> 
                                        <div class="ybc-blog-home-content-show col-md-7">
                                            <a class="ybc_title_block" href="{$post.link}">{$post.title}</a>                                           
                                            <div class="post-date">
                                                <span class="ybc_m_y">
                                                    {date('F', strtotime($post.datetime_added))} {date('dS', strtotime($post.datetime_added))}, {date('Y', strtotime($post.datetime_added))}
                                                </span> 
                                            </div>
                                            {if $post.short_description}
                                                <p class="ybc-blog-shortdesc">{$post.short_description|strip_tags:'UTF-8'|truncate:600:'...'}</p>
                                            {/if}
                                            <a class="ybc_readmore" href="{$post.link}">{l mod='ybc_blog' s='Read More'} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> 
                                        </div> 
                                    </div>
                                    
                                </div> 
                            </div>
                        </li>
                        {/foreach}
                    </ul>
                <div class="clear"></div>
            </div>
        </div>
    {/if}

</div>
</div>