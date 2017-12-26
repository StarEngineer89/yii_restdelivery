{addJsDefL name='day'}{l s='day' js=1}{/addJsDefL}
{addJsDefL name='hr'}{l s='hour' js=1}{/addJsDefL}
{addJsDefL name='min'}{l s='min' js=1}{/addJsDefL}
{addJsDefL name='sec'}{l s='sec' js=1}{/addJsDefL}
{addJsDefL name='days'}{l s='days' js=1}{/addJsDefL}
{addJsDefL name='hrs'}{l s='hours' js=1}{/addJsDefL}
{addJsDefL name='mins'}{l s='mins' js=1}{/addJsDefL}
{addJsDefL name='secs'}{l s='secs' js=1}{/addJsDefL}
<div id="ybc_countdown" class="ybc_countdown col-sm-4 col-md-3">
<div class="countdown-content">
    <h2>{$YBC_SHOPMSG_TITLE}</h2>
    <div class="discount_slider">
    {if !isset($priceDisplayPrecision)}
		{assign var='priceDisplayPrecision' value=2}
	{/if}
            {foreach from=$products_list item=product}    
            	{if !$priceDisplay || $priceDisplay == 2}
            		{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, 6)}
            		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
            	{elseif $priceDisplay == 1}
            		{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, 6)}
            		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
            	{/if}        
        	<!-- prices -->
            <div class="item" itemscope itemtype="https://schema.org/Product">
            	<div class="countdown_content_wrapper">
            		<p class="our_price_display" itemprop="offers" itemscope itemtype="https://schema.org/Offer">{strip}
							{if $product->quantity > 0}<link itemprop="availability" href="https://schema.org/InStock"/>{/if}
							{if $priceDisplay >= 0 && $priceDisplay <= 2}
								<span class="price" itemprop="price" content="{$productPrice}">{convertPrice price=$productPrice|floatval}</span>
								{if $tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) || !isset($display_tax_label))}
									{if $priceDisplay == 1} {l s='tax excl.'}{else} {l s='tax incl.'}{/if}
								{/if}
								<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
								{hook h="displayProductPriceBlock" product=$product type="price"}
							{/if}
						{/strip}</p>
                    {if $product->specificPrice && $product->specificPrice.reduction && $productPriceWithoutReduction > $productPrice}
                    <p class="reduction_percent" {if $productPriceWithoutReduction <= 0 || !$product->specificPrice || $product->specificPrice.reduction_type != 'percentage'} style="display:none;"{/if}>{strip}
            			<span class="reduction_percent_display">
            				{if $product->specificPrice && $product->specificPrice.reduction_type == 'percentage'}-{$product->specificPrice.reduction*100}%{/if}
            			</span>
            		{/strip}
                    </p>
            		<p class="reduction_amount" {if $productPriceWithoutReduction <= 0 || !$product->specificPrice || $product->specificPrice.reduction_type != 'amount' || $product->specificPrice.reduction|floatval ==0} style="display:none"{/if}>{strip}
            			<span class="reduction_amount_display">
            			{if $product->specificPrice && $product->specificPrice.reduction_type == 'amount' && $product->specificPrice.reduction|floatval !=0}
            				-{convertPrice price=$productPriceWithoutReduction|floatval-$productPrice|floatval}
            			{/if}
            			</span>
            		{/strip}</p>  
                    {/if}  	
            		{if $priceDisplay == 2}
            			<br />
            			<span id="pretaxe_price">{strip}
            				<span id="pretaxe_price_display">{convertPrice price=$product->getPrice(false, $smarty.const.NULL)}</span> {l s='tax excl.'}
            			{/strip}</span>
            		{/if}
            	</div> <!-- end prices -->
                {assign var='image' value=Product::getCover($product->id)}
                {if $image}
                    <a href="{$link->getProductLink($product)}" title="{$product->name|escape:'html':'UTF-8'}">                    
                        <img src="{$link->getImageLink($product->link_rewrite,$product->id|cat:'-'|cat:$image.id_image,'home_default')}" title="{$product->name|escape:'html':'UTF-8'}" alt="{$product->name|escape:'html':'UTF-8'}" />
                    </a>
                {/if}
                <h4 class="cd_name_product">
                    <a href="{$link->getProductLink($product)}" title="{$product->name|escape:'html':'UTF-8'}">
                       {$product->name|escape:'html':'UTF-8'}
                    </a>
                </h4>
                {if $product->specificPrice && $product->specificPrice.reduction && $productPriceWithoutReduction > $productPrice && isset($product->specificPrice.to) && $product->specificPrice.to!='0000-00-00 00:00:00'}
                <div id="ets_clock_{$product->id}" class="ets_clock"></div>
                    <script type="text/javascript">
                    var id_ets_product = '{$product->id}';
                    var date_to = '{$product->specificPrice.to}';
                    {literal}
                    $('#ets_clock_'+id_ets_product).countdown(date_to).on('update.countdown', function(event) {
                      var d = (event.offset.totalDays > 1 ? event.offset.totalDays+' <span class="number">'+days+'</span> ':event.offset.totalDays+' <span class="number">'+day+'</span>');
                      var h = (event.offset.hours > 1 ? event.offset.hours+' <span class="number">'+hrs+'</span> ':event.offset.hours+' <span class="number">'+hr+'</span>');
                      var m = (event.offset.minutes > 1 ? event.offset.minutes+' <span class="number">'+mins+'</span> ':event.offset.minutes+' <span class="number">'+min+'</span>');
                      var s = (event.offset.seconds > 1 ? event.offset.seconds+' <span class="number">'+secs+'</span> ':event.offset.seconds+' <span class="number">'+sec+'</span>');
                      var $this = $(this).html(event.strftime(''
                        + '<span class = "ybc_cd_item">'+d+'</span> '
                        + '<span class = "ybc_cd_item">'+h+'</span> '
                        + '<span class = "ybc_cd_item">'+m+'</span> '
                        + '<span class = "ybc_cd_item">'+s+'</span> '));
                    });
                    {/literal}
                    </script>
                {/if}
            </div>      
    {/foreach} 
    </div>   
</div>
</div>