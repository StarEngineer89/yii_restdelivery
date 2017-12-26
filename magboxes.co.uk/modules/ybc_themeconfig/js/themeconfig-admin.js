$(document).ready(function(){
    var activeTab = $('input[name="submited_tab"]').val();
    if($('#'+activeTab).length > 0)
    {
        $('#'+activeTab).addClass('active');
        $('.'+activeTab).addClass('active');
    }
    else
    {
        $('#ybc_tab_general').addClass('active');
        $('.ybc_tab_general').addClass('active');
    }    
    $('.ybc_tab > li').click(function(){
        $('.ybc_tab > li').removeClass('active');
        $('.ybc-form-group').removeClass('active');
        $(this).addClass('active');
        $('.'+$(this).data('tab')).addClass('active');
        $('input[name="submited_tab"]').val($(this).attr('id'));
    });
    
    $('#module_form_submit_btn').click(function(){
        ybcFileUpload = false;
        $('input[type="file"]').each(function(){
            if($(this).val())
                ybcFileUpload = true;
                
        });
        if(!ybcFileUpload && !$(this).hasClass('active'))
        {
            $('.ybc-udpate-message').html('');
            $('.bootstrap > .alert').remove();
            $(this).addClass('active');
            $('.ybc-tc-loading').addClass('active');
            $('.ybc-update-success-msg').remove();
            $('.ybc-update-error-msg').remove();
            $.ajax({
                url: $('#module_form').attr('action')+'&ajax=1',
                type: 'post',
                dataType: 'json',
                data: $('#module_form').serialize(),
                success: function(json)
                {
                    $('#module_form_submit_btn').removeClass('active');
                    $('.ybc-tc-loading').removeClass('active');
                    if(json.error)
                    {
                        $('.ybc-udpate-message').html(json.error);
                        $('.ybc-tc-loading').after('<div class="ybc-update-error-msg" style="display: none;">'+json.errorAlert+'</div>');
                        $('.ybc-update-success-msg').fadeIn().delay(3000).fadeOut();
                    }
                    else
                    if(json.success)
                    {
                        $('.ybc-tc-loading').after('<div class="ybc-update-success-msg" style="display: none;">'+json.success+'</div>');
                        $('.ybc-update-success-msg').fadeIn().delay(3000).fadeOut();
                        if(json.reload)
                            location.reload();
                    }
                },
                error: function()
                {
                    $('#module_form_submit_btn').removeClass('active');
                    $('.ybc-tc-loading').removeClass('active');
                }
            });
            return false;
        }
        
    });
    
    //Custom color
    if($('#YBC_TC_SKIN').val()=='CUSTOM')
    {
        $('.ybc_custom_color').addClass('active').removeClass('color-off');
    }
    else
        $('.ybc_custom_color').removeClass('active').addClass('color-off');
    $('#YBC_TC_SKIN').change(function(){
        if($(this).val()=='CUSTOM')
        {
            $('.ybc_custom_color').addClass('active').removeClass('color-off');
        }
        else
        {
            $('.ybc_custom_color').removeClass('active').addClass('color-off');
        } 
    });
    
    $('#ybc_submit_import').click(function(){
        if(!$('#ybc_submit_import').hasClass('active') && confirm($('#ybc_import_warning_msg').text()))
        {
            $('#ybc_submit_import').addClass('active');
            $('.ybc-tc-import-loading').addClass('active');
            $('.ybc-import-error-msg').remove();
            $('.ybc-import-success-msg').remove();
            $.ajax({
                url: $('#module_form').attr('action')+'&import_data=1',
                type: 'post',
                dataType: 'json',
                data: $('#module_form').serialize(),
                success: function(json)
                {
                    $('#ybc_submit_import').removeClass('active');
                    $('.ybc-tc-import-loading').removeClass('active');
                    if(json.error)
                    {
                        $('.ybc-tc-import-loading').after('<div class="ybc-import-error-msg alert alert-danger" style="display: none;">'+json.error+'</div>');
                        $('.ybc-import-error-msg').fadeIn();
                    }
                    else
                    if(json.success)
                    {
                        $('.ybc-tc-import-loading').after('<div class="ybc-import-success-msg alert alert-success" style="display: none;">'+json.success+'</div>');
                        $('.ybc-import-success-msg').fadeIn().delay(3000).fadeOut();
                        if(json.reload)
                            location.reload();
                    }
                },
                error: function()
                {
                    $('#ybc_submit_import').removeClass('active');
                    $('.ybc-tc-import-loading').removeClass('active');
                },
            });
        }        
        return false;
    });
    
    $('#ybc_submit_export').click(function(){
        if(!$('#ybc_submit_export').hasClass('active') && confirm($('#ybc_export_warning_msg').text()))
        {
            $('#ybc_submit_export').addClass('active');
            $('.ybc-tc-import-loading').addClass('active');
            $('.ybc-import-error-msg').remove();
            $('.ybc-import-success-msg').remove();
            $.ajax({
                url: $('#module_form').attr('action'),
                type: 'post',
                dataType: 'json',
                data: 'export_data=1',
                success: function(json)
                {
                    $('#ybc_submit_export').removeClass('active');
                    $('.ybc-tc-import-loading').removeClass('active');
                    if(json.error)
                    {
                        $('.ybc-tc-import-loading').after('<div class="ybc-import-error-msg alert alert-danger" style="display: none;">'+json.error+'</div>');
                        $('.ybc-import-error-msg').fadeIn();
                    }
                    else
                    if(json.success)
                    {
                        $('.ybc-tc-import-loading').after('<div class="ybc-import-success-msg alert alert-success" style="display: none;">'+json.success+'</div>');
                        $('.ybc-import-success-msg').fadeIn().delay(3000).fadeOut();
                        if(json.reload)
                            location.reload();
                    }
                },
                error: function()
                {
                    $('#ybc_submit_export').removeClass('active');
                    $('.ybc-tc-import-loading').removeClass('active');
                },
            });
        }        
        return false;
    });
});