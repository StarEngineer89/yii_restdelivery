{if $categories}
    <div class="block ybc-blog-categories">
        <h4 class="title_block">{l s='Blog categories' mod='ybc_blog'}</h4>    
            <div class="block_content list-block">
                <ul class="tree dynamized">
                    {foreach from=$categories item='cat'}
                        <li {if $cat.id_category==$active}class="active"{/if}>
                            <a href="{$cat.link}">{$cat.title}</a>
                        </li>
                    {/foreach}
                </ul>
            </div>    
    </div>
{/if}