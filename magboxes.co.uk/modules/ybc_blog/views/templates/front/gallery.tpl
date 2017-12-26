<div class="ybc_blog_layout_{$blog_layout} ybc_blog_skin_{$blog_skin} ybc-blog-wrapper ybc-blog-wrapper-gallery">
    <h1 class="page-heading"><span class="cat-name title_cat">{l s='Blog gallery' mod='ybc_blog'}</span></h1>
    {if isset($blog_galleries)}
        <div class="row">
        <ul class="ybc-gallery">
            {foreach from=$blog_galleries item='gallery'}            
                <li class="col-xs-3">
                    <a  {if $gallery.description}title="{strip_tags($gallery.description)}"{/if} rel="prettyPhoto[gallery]" href="{$gallery.image}"><img src="{$gallery.thumb}" title="{$gallery.title}" alt="{$gallery.title}" /></a>                    
                </li>
            {/foreach}
        </ul>
        </div>
        {if $blog_paggination}
            <div class="blog-paggination">
                {$blog_paggination}
            </div>
        {/if}
    {else}
        <p>{l s='No item found' mod='ybc_blog'}</p>
    {/if}
</div>
<script type="text/javascript">    
    prettySkin = '{$prettySkin}';
    prettyAutoPlay = {$prettyAutoPlay};
    {literal}
        $(document).ready(function(){            
            $("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:prettySkin,slideshow:3000, autoplay_slideshow: prettyAutoPlay, social_tools: '',deeplinking: false});
        });
    {/literal}
</script>