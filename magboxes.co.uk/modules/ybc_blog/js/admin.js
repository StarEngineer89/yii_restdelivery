$(document).ready(function(){
    //Skin
    $('input[name="YBC_BLOG_CUSTOM_COLOR"]').parents('.form-group').eq(1).addClass('ybc_custom_color');
    if($('#YBC_BLOG_SKIN').val()!='custom')
    {
        $('.ybc_custom_color').addClass('hide').hide();
    }
    else
        $('.ybc_custom_color').removeClass('hide').show();
    
    $('#YBC_BLOG_SKIN').change(function(){
        if($('#YBC_BLOG_SKIN').val()!='custom')
        {
            $('.ybc_custom_color').addClass('hide').hide();
        }
        else
            $('.ybc_custom_color').removeClass('hide').show();
    });
    //Tabs
    if(ybc_blog_is_config_page)
    {
        $.each(ybc_blog_tabs, function(i, item) {
            if($(item.input).parents('.form-group').length > 0)
            {
                $(item.input).parents('.form-group').eq(0).before('<div class="ybc-panel"><h2>'+(item.icon ? '<i class="'+item.icon+'"></i> ' : '')+item.title+'</h2></div>');
            }
        });
    }
    
    $('#title_'+ybc_blog_default_lang).change(function(){
        if(!ybc_blog_is_updating)
        {
            $('#url_alias').val(str2url($(this).val(), 'UTF-8')); 
        }        
        else
        if($('#url_alias').val() == '')
            $('#url_alias').val(str2url($(this).val(), 'UTF-8')); 
    });
    if($('.ybc_fancy').length > 0)
    {
        $('.ybc_fancy').fancybox();
    }
    $('#product_autocomplete_input').autocomplete(ybc_blog_ajax_url,{
		minChars: 1,
		autoFill: true,
		max:20,
		matchContains: true,
		mustMatch:true,
		scroll:false,
		cacheLength:0,
		formatItem: function(item) {
			return item[1]+' - '+item[0];
		}
	}).result(ybcAddAccessory);
    $('#product_autocomplete_input').setOptions({
		extraParams: {
			excludeIds : ybcGetAccessoriesIds()
		}
	});
});

function ybcGetAccessoriesIds()
{
    if ($('#inputAccessories').val() === undefined)
			return '';
		return $('#inputAccessories').val().replace(/\-/g,',');
}
var ybcAddAccessory = function(event, data, formatted)
{
	if (data == null)
		return false;
	var productId = data[1];
	var productName = data[0];

	var $divAccessories = $('#divAccessories');
	var $inputAccessories = $('#inputAccessories');
	var $nameAccessories = $('#nameAccessories');

	/* delete product from select + add product line to the div, input_name, input_ids elements */
	$divAccessories.html($divAccessories.html() + '<div class="form-control-static"><button type="button" onclick="ybcDelAccessory('+productId+');" class="btn btn-default" name="' + productId + '"><i class="icon-remove text-danger"></i></button>&nbsp;'+ productName +'</div>');
	$nameAccessories.val($nameAccessories.val() + productName + '¤');
	$inputAccessories.val($inputAccessories.val() + productId + '-');
	$('#product_autocomplete_input').val('');
	$('#product_autocomplete_input').setOptions({
		extraParams: {excludeIds : ybcGetAccessoriesIds()}
	});
};

function ybcDelAccessory(id)
{
	var div = getE('divAccessories');
	var input = getE('inputAccessories');
	var name = getE('nameAccessories');

	// Cut hidden fields in array
	var inputCut = input.value.split('-');
	var nameCut = name.value.split('¤');

	if (inputCut.length != nameCut.length)
		return jAlert('Bad size');

	// Reset all hidden fields
	input.value = '';
	name.value = '';
	div.innerHTML = '';
	for (i in inputCut)
	{
		// If empty, error, next
		if (!inputCut[i] || !nameCut[i])
			continue ;

		// Add to hidden fields no selected products OR add to select field selected product
		if (inputCut[i] != id)
		{
			input.value += inputCut[i] + '-';
			name.value += nameCut[i] + '¤';
			div.innerHTML += '<div class="form-control-static"><button type="button"  onclick="ybcDelAccessory('+inputCut[i]+');"  class="btn btn-default" name="' + inputCut[i] +'"><i class="icon-remove text-danger"></i></button>&nbsp;' + nameCut[i] + '</div>';
		}
		else
			$('#selectAccessories').append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
	}

	$('#product_autocomplete_input').setOptions({
		extraParams: {excludeIds : ybcGetAccessoriesIds()}
	});
};