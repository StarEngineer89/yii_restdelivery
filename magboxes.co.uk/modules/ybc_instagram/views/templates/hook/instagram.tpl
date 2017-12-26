<script type="text/javascript">
    $(".ybc_instagram_fancy").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
</script>
<div class="ybc_instagram footer-block block_instagram col-sm-3 col-xs-12">
    <h4 class="">{l s='Instagram' mod='ybc_instagram'}</h4>
    {if $IMGs}
        <ul class="instagram_list_img toggle-footer">
            {assign var='ik' value=0}
            {foreach from=$IMGs item='img'}
                {assign var='ik' value=$ik+1}
                {if $ik <= $YBC_INSTAGRAM_IMG_NUMBER}
                    <li class="instagram_item_img col-xs-4 col-sm-4">
                        <a class="ybc_instagram_fancy" href="{$img.standard_resolution}">
                            <img {if $img.caption}alt="{$img.caption}"{/if} src="{$img.thumbnail}" alt=""/>
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    {/if}
</div>