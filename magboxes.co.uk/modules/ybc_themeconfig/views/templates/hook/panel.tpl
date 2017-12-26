{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{if $tc_display_panel}
<div class="ybc-theme-panel closed">
    <div class="ybc-theme-panel-medium">
        <div class="ybc-theme-panel-btn" title="{l s='Theme Option' mod='ybc_themeconfig'}">{*l s='Setting' mod='ybc_themeconfig'*}</div>
        <div class="ybc-theme-panel-loading">
            <div class="ybc-theme-panel-loading-setting">
                <h2>
                    <img alt="{l s='Loading' mod='ybc_themeconfig'}" class="ybc-theme-panel-loading-logo" src="{$modules_dir}ybc_themeconfig/img/loading.gif" /> 
                    <br/>
                    <span>{l s='Updating...' mod='ybc_themeconfig'}</span>
                </h2>
            </div>
        </div>
        <div class="ybc-theme-panel-wrapper">
            <h2>{l s='Theme options' mod='ybc_themeconfig'}</h2>
            <div class="ybc-theme-panel-box tc-separator"><h3>{l s='Theme color' mod='ybc_themeconfig'}</h3></div>
            <div class="ybc-theme-panel-inner">
                <div class="ybc-theme-panel-box">                    
                    <ul class="ybc-skin ybc_tc_skin ybc_select_option" id="ybc_tc_skin">
                        {if $skins}
                            {foreach from=$skins item='skin'}
                                <li style="background: {$skin.main_color};" {if $configs.YBC_TC_SKIN==$skin.id_option}class="active"{/if} data-val="{$skin.id_option}" title="{$skin.name}">{$skin.name}</li>
                            {/foreach}
                        {/if}
                    </ul>
                </div>
                {if isset($ybcDev) && $ybcDev}  
                    <div class="ybc-theme-panel-box tc-separator"><h3>{l s='Layout type' mod='ybc_themeconfig'}</h3></div>
                    <div class="ybc-theme-panel-box">                    
                        <ul id="ybc_tc_layout" class="ybc_tc_layout ybc_select_option">
                            {if $layouts}
                                {foreach from=$layouts item='layout'}
                                    <li {if $configs.YBC_TC_LAYOUT==$layout.id_option}class="active"{/if} data-val="{$layout.id_option}">{$layout.name}</li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>
                {/if}
                {if isset($float_header) && $float_header}
                    <div class="ybc-theme-panel-box tc-separator"><h3>{l s='Float header' mod='ybc_themeconfig'}</h3></div>
                    <div class="ybc-theme-panel-box">                    
                        <ul id="ybc_tc_float_header" class="ybc_tc_float_header ybc_select_option">
                            <li {if $configs.YBC_TC_FLOAT_HEADER}class="active"{/if} data-val="1">{l s='Yes' mod='ybc_themeconfig'}</li>
                            <li {if !$configs.YBC_TC_FLOAT_HEADER}class="active"{/if} data-val="0">{l s='No' mod='ybc_themeconfig'}</li>
                        </ul>
                    </div>
                {/if}
                {if isset($bgs) && $bgs}              
                    <div class="ybc-theme-panel-box tc-separator"><h3>{l s='Background image' mod='ybc_themeconfig'}</h3></div>
                    <div class="ybc-theme-panel-box tc-ul">
                        {if $bgs}
                            <ul class="ybc-theme-panel-bg-list">
                                {foreach from=$bgs item='bg'}
                                    <li><span rel='{$bg}' class="ybc-theme-panel-bg{if $configs.YBC_TC_BG_IMG==$bg} active{/if}" style="background: url('{$moduleDirl}bgs/{$bg}.png');"></span></li>
                                {/foreach}
                            </ul>
                        {/if}
                    </div>
                {/if}
                <div class="ybc-theme-panel-box tc-reset">
                    <span id="tc-reset">{l s='Reset to default' mod='ybc_themeconfig'}</span>
                </div>
            </div>        
        </div>       
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.ybc_select_option li').click(function(){
            var clickObj = $(this);
            if(!$(this).parent('ul').hasClass('active'))
            {
                $(this).parent('ul').addClass('active');
                $('.ybc-theme-panel-loading').show();
                $.ajax({
                    url : '{$moduleDirl}ajax.php',
                    type : 'post',
                    dataType : 'json',
                    data : {                    
                        'newConfigVal' : $(this).data('val'),
                        'configName' : $(this).parent('ul').attr('id')
                    },
                    success: function(json)
                    {                    
                        if(json['success'])
                        {
                            clickObj.parent('ul').find('li').removeClass('active');
                            clickObj.addClass('active');
                            if($('body').hasClass(json['oldClass']) && !json['noReplace'])
                            {
                                $('body').removeClass(json['oldClass']);
                                $('body').addClass(json['newClass']); 
                            } 
                            if(json.logo)
                            {
                                $('#header_logo a img.logo').attr('src',json.logo);
                            } 
                            if(json['reload'])
                                location.reload();                                          
                        }
                        else
                            alert(json['error']);
                        $('.ybc-theme-panel-loading').fadeOut();
                        $('.ybc_select_option').removeClass('active');
                    },
                    error: function()
                    {
                        $('.ybc-theme-panel-loading').fadeOut();
                        $('.ybc_select_option').removeClass('active');
                    }
                });
            }
        });
        
        //Update bg
        $('.ybc-theme-panel-bg').click(function(){
            clickObj = this;
            $('.ybc-theme-panel-loading').show();
            $.ajax({
                url : '{$moduleDirl}ajax.php',
                type : 'post',
                dataType : 'json',
                data : {                    
                    'newConfigVal' : $(this).attr('rel'),
                    'configName' : 'YBC_TC_BG_IMG'
                },
                success: function(json)
                {                    
                    if(json['success'])
                    {
                        if($('body').hasClass(json['oldClass']))
                        {
                            $('body').removeClass(json['oldClass']);
                            $('body').addClass(json['newClass']);
                            $('.ybc-theme-panel-bg').removeClass('active'); 
                            $(clickObj).addClass('active');
                        }                                            
                    }
                    else
                        alert(json['error']);
                    $('.ybc-theme-panel-loading').fadeOut();
                },
                error: function()
                {
                    $('.ybc-theme-panel-loading').fadeOut();
                }
            });
        });
        
        //Reset button
        $('#tc-reset').click(function(){
            $('.ybc-theme-panel-loading').show();
            $.ajax({
                url : '{$moduleDirl}ajax.php',
                type : 'post',
                dataType : 'json',
                data : {                    
                    tcreset : 'yes'
                },
                success: function(json)
                {                    
                    
                    $('.ybc-theme-panel-loading').fadeOut();
                    location.reload();
                },
                error: function()
                {
                    $('.ybc-theme-panel-loading').fadeOut();
                    location.reload();
                }
            });
        });
        //Settings button
        $('.ybc-theme-panel-btn').click(function(){          
            if(!$('.ybc-theme-panel').hasClass('moving'))
            {
                if($('.ybc-theme-panel').hasClass('closed'))
                {                        
                    $('.ybc-theme-panel').addClass('moving');
                    $('.ybc-theme-panel').animate({
                        'left' : 0
                    }, 1000,function(){
                        $('.ybc-theme-panel').removeClass('moving');
                        $('.ybc-theme-panel').removeClass('closed');
                    });
                }
                else
                {
                    $('.ybc-theme-panel').addClass('moving');
                    $('.ybc-theme-panel').animate({
                        'left' : '-302px'
                    }, 1000,function(){
                        $('.ybc-theme-panel').removeClass('moving');
                        $('.ybc-theme-panel').addClass('closed');
                    });
                }   
            }                
        });
    });  
</script> 
{/if}
<div class="tc_comparison_msg tc_comparison_success">
    <p>{l s='The product has been successfully added to comparison' mod='ybc_themeconfig'}</p>
    <a href="{$tc_comparison_link}" class="button">{l s='View all products' mod='ybc_themeconfig'}</a>
</div>
<div class="tc_comparison_msg tc_comparison_failed">
    <p>{l s='The product has been removed from comparison' mod='ybc_themeconfig'}</p>
</div>
{addJsDef YBC_TC_FLOAT_CSS3=$YBC_TC_FLOAT_CSS3}