    <div id="ybc_gallery_home" class="block">
        <h4 class="title_block"><a href="{$gallery_link}"><span class="title_cat">{l s='Blog gallery' mod='ybc_blog'}</span></a></h4>
        <div class="ybc-blog-galleryr">
            <div class="ybc-blog-galleryr-content">
                {if $galleries}
                    <ul id="ybc_gallery_home_content">
                        {foreach from=$galleries item='gallery'}            
                            <li class="col-xs-3">
                                <a {if $gallery.description}title="{strip_tags($gallery.description)}"{/if}  rel="prettyPhotoBlock[galleryblock]" href="{$gallery.image}">
                                    <img src="{$gallery.thumb}" title="{$gallery.title}"  alt="{$gallery.title}"  />
                                </a>   
                                <h3>{if strlen($gallery.title) > 50}{substr($gallery.title,0,49)}...{else}{$gallery.title}{/if}</h3>                                           
                            </li>
                        {/foreach}
                    </ul>
                    <script type="text/javascript">
                        prettySkinBlock = '{$prettySkinBlock}';
                        prettyAutoPlayBlock = '{$prettyAutoPlayBlock}';                
                        {literal}
                            $(document).ready(function(){
                                $("a[rel^='prettyPhotoBlock']").prettyPhoto({animation_speed:'normal',theme:prettySkinBlock,slideshow:3000, autoplay_slideshow: prettyAutoPlayBlock,social_tools: '',deeplinking: false});
                            });
                        {/literal}
                    </script>
                {else}
                    <p>{l s='No featured images' mod='ybc_blog'}</p>
                {/if}
                <a class="view_all" href="{$gallery_link}">{l s='View gallery' mod='ybc_blog'}</a>
            </div>
        </div>
    </div>