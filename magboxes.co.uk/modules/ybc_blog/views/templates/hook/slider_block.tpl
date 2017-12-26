{if $slides}
    <div class="bybc-blog-slider">
        <div class="block_content">
            <div class="ybc-blog-slider loading slider-wrapper theme-{$nivoTheme}">
                <div class="loading_img">
                <img src="{$loading_img}" alt="{l s='loading' mod='ybc_blog'}" /></div>
                <div id="ybc_slider">                     
                    {foreach from=$slides item='slide'}
                        {if $slide.url}<a href="{$slide.url}">{/if}
                        <img src="{$slide.image}" alt="{$slide.caption}" title="{$slide.caption}" />
                        {if $slide.url}</a>{/if}
                    {/foreach}                
                </div>                
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var sliderAutoPlay = {if $nivoAutoPlay}true{else}false{/if};
        {literal}
            $(window).load(function() {
                $('#ybc_slider').nivoSlider({
                    manualAdvance : !sliderAutoPlay,
                    afterLoad: function(){   
                        $('.ybc-blog-slider').removeClass('loading');
                    }
                });
            });
        {/literal}
    </script>
{/if}