{if isset($nbComments) && $nbComments > 0}
	<div class="comments_note">
		<div class="star_content clearfix">
			{section name="i" start=0 loop=5 step=1}
				{if $averageTotal le $smarty.section.i.index}
					<div class="star"></div>
				{else}
					<div class="star star_on"></div>
				{/if}
			{/section}            
		</div>
		<span class="nb-comments"><span itemprop="reviewCount">{$nbComments}</span> {l s='Review(s)' mod='ybc_megamenu'}</span>
	</div>
{/if}
