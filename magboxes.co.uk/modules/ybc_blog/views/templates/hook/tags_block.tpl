{if $tags}
    <div class="block ybc_blog_skin_{$blog_skin} ybc-blog-tags">
        <h4 class="title_block">{l s='Blog tags' mod='ybc_blog'}</h4>
            {assign var='totalTags' value=count($tags)}
            {assign var='ik' value=0}
            <div class="block_content">
                <div class="blog_tag">
                    {foreach from=$tags item='tag'}
                        {assign var='ik' value=$ik+1}
                        <a class="{if $tag.viewed > 10000}tag_10000{elseif $tag.viewed > 1000}tag_1000{elseif $tag.viewed > 500}tag_500{elseif $tag.viewed > 100}tag_100{elseif $tag.viewed > 10}tag_10{elseif $tag.viewed > 5}tag_5{elseif $tag.viewed > 1}tag_1{elseif $tag.viewed <= 0}tag_0{/if} ybc-blog-tag-a" href="{$tag.link}">{$tag.tag}</a>{*if $ik < $totalTags}, {/if*}                        
                    {/foreach}
                </div>
                <!-- Tags: 10000, 1000, 500, 100, 10, 5, 1, 0 -->
            </div>
    </div>
{/if}