$(document).ready(function(){
    $('input[name="YBC_MM_CUSTOM_COLOR"]').parents('.form-group').eq(1).addClass('ybc_custom_color');
    $('input[name="YBC_MM_CUSTOM_COLOR_HOVER"]').parents('.form-group').eq(1).addClass('ybc_custom_color');
    $('input[name="YBC_MM_CUSTOM_TEXT_COLOR"]').parents('.form-group').eq(1).addClass('ybc_custom_color');
    $('input[name="YBC_MM_CUSTOM_BORDER_COLOR"]').parents('.form-group').eq(1).addClass('ybc_custom_color');
    if($('#YBC_MM_SKIN').val()!='custom')
    {
        $('.ybc_custom_color').addClass('hide').hide();
    }
    else
        $('.ybc_custom_color').removeClass('hide').show();
    
    $('#YBC_MM_SKIN').change(function(){
        if($('#YBC_MM_SKIN').val()!='custom')
        {
            $('.ybc_custom_color').addClass('hide').hide();
        }
        else
            $('.ybc_custom_color').removeClass('hide').show();
    });
    //Sort menu item
    $( ".sortable" ).sortable({
            placeholder: "ybc-place-holder",
            update: function(){
                $.ajax({
                    url : ybc_mm_menu_url,
                    type: 'POST',
                    data: getMenuSortOrder(),
                    dataType : 'json',
                    success: function()
                    {
                        
                    },
                    error: function(){
                        
                    }                    
                });
            }
    });
    $( ".sortable" ).disableSelection();
    //Handle block types
    if($('.ybc_block_type').length > 0)
    {
        if($('.ybc-right-panel .form-wrapper').children('.form-group').length > 0)
        {
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(4).addClass('ybc_block_CATEGORY');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(5).addClass('ybc_block_CATEGORY');        
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(6).addClass('ybc_block_MNFT');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(7).addClass('ybc_block_CMS');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(8).addClass('ybc_block_PRODUCT');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(9).addClass('ybc_block_HTML');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(10).addClass('ybc_block_CUSTOM');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(11).addClass('ybc_block_CUSTOM'); 
            for(i = 4; i <= 11; i++)
            {
                $('.ybc-right-panel .form-wrapper').children('.form-group').eq(i).hide();
            }
            if($('.ybc_block_'+$('.form-group #block_type').val()).length > 0)
                $('.ybc_block_'+$('.form-group #block_type').val()).show();
            $('.form-group #block_type').change(function(){
                for(i = 4; i <= 11; i++)
                {
                    $('.ybc-right-panel .form-wrapper').children('.form-group').eq(i).hide();
                }
                $('.ybc_block_'+$('.form-group #block_type').val()).show();
            });
        }
        else
        {
            $('.ybc-right-panel .panel').children('.form-group').eq(4).addClass('ybc_block_CATEGORY');
            $('.ybc-right-panel .panel').children('.form-group').eq(5).addClass('ybc_block_CATEGORY');        
            $('.ybc-right-panel .panel').children('.form-group').eq(6).addClass('ybc_block_MNFT');
            $('.ybc-right-panel .panel').children('.form-group').eq(7).addClass('ybc_block_CMS');
            $('.ybc-right-panel .panel').children('.form-group').eq(8).addClass('ybc_block_PRODUCT');
            $('.ybc-right-panel .panel').children('.form-group').eq(9).addClass('ybc_block_HTML');
            $('.ybc-right-panel .panel').children('.form-group').eq(10).addClass('ybc_block_CUSTOM');
            $('.ybc-right-panel .panel').children('.form-group').eq(11).addClass('ybc_block_CUSTOM'); 
            for(i = 4; i <= 11; i++)
            {
                $('.ybc-right-panel .panel').children('.form-group').eq(i).hide();
            }
            if($('.ybc_block_'+$('.form-group #block_type').val()).length > 0)
                $('.ybc_block_'+$('.form-group #block_type').val()).show();
            $('.form-group #block_type').change(function(){
                for(i = 4; i <= 11; i++)
                {
                    $('.ybc-right-panel .panel').children('.form-group').eq(i).hide();
                }
                $('.ybc_block_'+$('.form-group #block_type').val()).show();
            });
        }
    }
    
    //Handle category types
    
    if($('.ybc_menu_type').length > 0)
    {
        if($('.ybc-right-panel .form-wrapper').children('.form-group').length > 0)
        {
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(2).addClass('ybc_menu_CATEGORY');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(3).addClass('ybc_menu_MNFT');
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(4).addClass('ybc_menu_CMS');       
            $('.ybc-right-panel .form-wrapper').children('.form-group').eq(5).addClass('ybc_menu_CUSTOM');
            
            for(i = 2; i <= 5; i++)
            {
                $('.ybc-right-panel .form-wrapper').children('.form-group').eq(i).hide();
            }
            if($('.ybc_menu_'+$('.form-group #menu_type').val()).length > 0)
                $('.ybc_menu_'+$('.form-group #menu_type').val()).show();
            $('.form-group #menu_type').change(function(){
                for(i = 2; i <= 5; i++)
                {
                    $('.ybc-right-panel .form-wrapper').children('.form-group').eq(i).hide();
                }
                $('.ybc_menu_'+$('.form-group #menu_type').val()).show();
            });
        }
        else
        {
            $('.ybc-right-panel .panel').children('.form-group').eq(2).addClass('ybc_menu_CATEGORY');
            $('.ybc-right-panel .panel').children('.form-group').eq(3).addClass('ybc_menu_MNFT');
            $('.ybc-right-panel .panel').children('.form-group').eq(4).addClass('ybc_menu_CMS');       
            $('.ybc-right-panel .panel').children('.form-group').eq(5).addClass('ybc_menu_CUSTOM');
            
            for(i = 2; i <= 5; i++)
            {
                $('.ybc-right-panel .panel').children('.form-group').eq(i).hide();
            }
            if($('.ybc_menu_'+$('.form-group #menu_type').val()).length > 0)
                $('.ybc_menu_'+$('.form-group #menu_type').val()).show();
            $('.form-group #menu_type').change(function(){
                for(i = 2; i <= 5; i++)
                {
                    $('.ybc-right-panel .panel').children('.form-group').eq(i).hide();
                }
                $('.ybc_menu_'+$('.form-group #menu_type').val()).show();
            });
        }
        
    }
    
    if($('.ybc_fancy').length > 0)
    {
        $('.ybc_fancy').fancybox();
    }
    $('#product_autocomplete_input').autocomplete(ybc_mm_ajax_url,{
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

/**
 * Sorting 
 */
function getMenuSortOrder()
{
    var sortOrder = '';
    if($('.ybc-menu-item').length > 0)
    {
        var menu_ik = 0;
        $('.ybc-menu-item').each(function(){
            menu_ik++;
            sortOrder += 'menu['+$(this).attr('rel')+']='+menu_ik+'&';
            if($(this).find('.ybc-column-item').length > 0)
            {
                var column_ik = 0;
                $(this).find('.ybc-column-item').each(function(){
                    column_ik++;
                    sortOrder += 'colunn['+$(this).attr('rel')+']='+column_ik+'&';
                    if($(this).find('.ybc-block-item').length > 0)
                    {
                        var block_ik = 0;
                        $(this).find('.ybc-block-item').each(function(){
                            block_ik++;
                            sortOrder +=  'block['+$(this).attr('rel')+']='+block_ik+'&';                      
                        });   
                    }
                });
            }
        });
    }
    return sortOrder;
}

