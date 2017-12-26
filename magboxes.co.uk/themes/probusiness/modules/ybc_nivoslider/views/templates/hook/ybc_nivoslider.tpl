{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}

{if $page_name =='index'}
<!-- Module ybc_nivoslider -->
    {if isset($homeslider_slides)}
		<div id="ybc-nivo-slider-wrapper" 
        class="theme-default" 
        style="">
			<div id="ybc-nivo-slider"{if isset($smarty.capture.height) && $smarty.capture.height} style="max-height:{$smarty.capture.height}px;"{/if}>
                {foreach from=$homeslider_slides item=slide}
                        {if $slide.active}
    						<a href="{if $slide.url}
                            {$slide.url|escape:'html':'UTF-8'}{else}#{/if}" 
                            title="{$slide.title|escape:'htmlall':'UTF-8'}">
    						  <img data-id-slide="{$slide.id_slide}" 
                                  data-caption-animate="{if $slide.caption_animate}{$slide.caption_animate}{else}random{/if}" 
                                  {if $slide.slide_effect!='random'}data-transition="{$slide.slide_effect}"{/if} 
                                  data-caption1="{$slide.title|escape:'htmlall':'UTF-8'}" 
                                  data-caption2="{$slide.legend|escape:'htmlall':'UTF-8'}" 
                                  data-caption3="{$slide.legend2|escape:'htmlall':'UTF-8'}" 
                                  data-text-direction="{$slide.caption_text_direction}" 
                                  data-caption-top="{$slide.caption_top}" 
                                  data-caption-left="{$slide.caption_left}" 
                                  data-caption-right="{$slide.caption_right}" 
                                  data-caption-width="{$slide.caption_width}" 
                                  data-caption-position="{$slide.caption_position}"   
                                  data-custom_class="{$slide.custom_class}"   
                                  data-button_link="{$slide.button_link}"    
                                  src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`ybc_nivoslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}" 
                                  alt="{$slide.title|escape:'htmlall':'UTF-8'}" 
                                  title="{$slide.title|escape:'htmlall':'UTF-8'}" 
                                  style="max-width: {$options.max_width}; max-height: {$options.max_height};" 
                                />						  
                            </a>
                        {/if}
                                   
                                                                                    
				{/foreach}
			</div>
            <div id="ybc-nivo-slider-loader">
                <div class="ybc-nivo-slider-loader">
                    <div id="ybc-nivo-slider-loader-img">
                        <img src="{$ybc_nivo_dir}img/loading.gif" alt="{l s='Loading' mod='ybc_nivoslider'}"/>
                    </div>
                </div>
            </div>
		</div>        
        <div class="caption-wrapper">
            {foreach from=$homeslider_slides item=slide}
				{if $slide.active}
					<div class="ybc-nivo-description-{$slide.id_slide}">{$slide.description}</div>
                {/if}
			{/foreach}
        </div> 
             
	{/if}
<!-- /Module ybc_nivoslider -->
{/if}
