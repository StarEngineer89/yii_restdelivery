<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:37
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_themeconfig/views/templates/hook/panel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6884292865979f27db323c3-40404515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f72b5e3b5353ea6477574dd3e13f08cd9687a74' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_themeconfig/views/templates/hook/panel.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6884292865979f27db323c3-40404515',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tc_display_panel' => 0,
    'modules_dir' => 0,
    'skins' => 0,
    'skin' => 0,
    'configs' => 0,
    'ybcDev' => 0,
    'layouts' => 0,
    'layout' => 0,
    'float_header' => 0,
    'bgs' => 0,
    'bg' => 0,
    'moduleDirl' => 0,
    'tc_comparison_link' => 0,
    'YBC_TC_FLOAT_CSS3' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27dbc4f75_45927819',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27dbc4f75_45927819')) {function content_5979f27dbc4f75_45927819($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['tc_display_panel']->value) {?>
<div class="ybc-theme-panel closed">
    <div class="ybc-theme-panel-medium">
        <div class="ybc-theme-panel-btn" title="<?php echo smartyTranslate(array('s'=>'Theme Option','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
"></div>
        <div class="ybc-theme-panel-loading">
            <div class="ybc-theme-panel-loading-setting">
                <h2>
                    <img alt="<?php echo smartyTranslate(array('s'=>'Loading','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
" class="ybc-theme-panel-loading-logo" src="<?php echo $_smarty_tpl->tpl_vars['modules_dir']->value;?>
ybc_themeconfig/img/loading.gif" /> 
                    <br/>
                    <span><?php echo smartyTranslate(array('s'=>'Updating...','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</span>
                </h2>
            </div>
        </div>
        <div class="ybc-theme-panel-wrapper">
            <h2><?php echo smartyTranslate(array('s'=>'Theme options','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</h2>
            <div class="ybc-theme-panel-box tc-separator"><h3><?php echo smartyTranslate(array('s'=>'Theme color','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</h3></div>
            <div class="ybc-theme-panel-inner">
                <div class="ybc-theme-panel-box">                    
                    <ul class="ybc-skin ybc_tc_skin ybc_select_option" id="ybc_tc_skin">
                        <?php if ($_smarty_tpl->tpl_vars['skins']->value) {?>
                            <?php  $_smarty_tpl->tpl_vars['skin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skin']->key => $_smarty_tpl->tpl_vars['skin']->value) {
$_smarty_tpl->tpl_vars['skin']->_loop = true;
?>
                                <li style="background: <?php echo $_smarty_tpl->tpl_vars['skin']->value['main_color'];?>
;" <?php if ($_smarty_tpl->tpl_vars['configs']->value['YBC_TC_SKIN']==$_smarty_tpl->tpl_vars['skin']->value['id_option']) {?>class="active"<?php }?> data-val="<?php echo $_smarty_tpl->tpl_vars['skin']->value['id_option'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['skin']->value['name'];?>
</li>
                            <?php } ?>
                        <?php }?>
                    </ul>
                </div>
                <?php if (isset($_smarty_tpl->tpl_vars['ybcDev']->value)&&$_smarty_tpl->tpl_vars['ybcDev']->value) {?>  
                    <div class="ybc-theme-panel-box tc-separator"><h3><?php echo smartyTranslate(array('s'=>'Layout type','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</h3></div>
                    <div class="ybc-theme-panel-box">                    
                        <ul id="ybc_tc_layout" class="ybc_tc_layout ybc_select_option">
                            <?php if ($_smarty_tpl->tpl_vars['layouts']->value) {?>
                                <?php  $_smarty_tpl->tpl_vars['layout'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['layout']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['layouts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['layout']->key => $_smarty_tpl->tpl_vars['layout']->value) {
$_smarty_tpl->tpl_vars['layout']->_loop = true;
?>
                                    <li <?php if ($_smarty_tpl->tpl_vars['configs']->value['YBC_TC_LAYOUT']==$_smarty_tpl->tpl_vars['layout']->value['id_option']) {?>class="active"<?php }?> data-val="<?php echo $_smarty_tpl->tpl_vars['layout']->value['id_option'];?>
"><?php echo $_smarty_tpl->tpl_vars['layout']->value['name'];?>
</li>
                                <?php } ?>
                            <?php }?>
                        </ul>
                    </div>
                <?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['float_header']->value)&&$_smarty_tpl->tpl_vars['float_header']->value) {?>
                    <div class="ybc-theme-panel-box tc-separator"><h3><?php echo smartyTranslate(array('s'=>'Float header','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</h3></div>
                    <div class="ybc-theme-panel-box">                    
                        <ul id="ybc_tc_float_header" class="ybc_tc_float_header ybc_select_option">
                            <li <?php if ($_smarty_tpl->tpl_vars['configs']->value['YBC_TC_FLOAT_HEADER']) {?>class="active"<?php }?> data-val="1"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</li>
                            <li <?php if (!$_smarty_tpl->tpl_vars['configs']->value['YBC_TC_FLOAT_HEADER']) {?>class="active"<?php }?> data-val="0"><?php echo smartyTranslate(array('s'=>'No','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</li>
                        </ul>
                    </div>
                <?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['bgs']->value)&&$_smarty_tpl->tpl_vars['bgs']->value) {?>              
                    <div class="ybc-theme-panel-box tc-separator"><h3><?php echo smartyTranslate(array('s'=>'Background image','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</h3></div>
                    <div class="ybc-theme-panel-box tc-ul">
                        <?php if ($_smarty_tpl->tpl_vars['bgs']->value) {?>
                            <ul class="ybc-theme-panel-bg-list">
                                <?php  $_smarty_tpl->tpl_vars['bg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bg']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bgs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bg']->key => $_smarty_tpl->tpl_vars['bg']->value) {
$_smarty_tpl->tpl_vars['bg']->_loop = true;
?>
                                    <li><span rel='<?php echo $_smarty_tpl->tpl_vars['bg']->value;?>
' class="ybc-theme-panel-bg<?php if ($_smarty_tpl->tpl_vars['configs']->value['YBC_TC_BG_IMG']==$_smarty_tpl->tpl_vars['bg']->value) {?> active<?php }?>" style="background: url('<?php echo $_smarty_tpl->tpl_vars['moduleDirl']->value;?>
bgs/<?php echo $_smarty_tpl->tpl_vars['bg']->value;?>
.png');"></span></li>
                                <?php } ?>
                            </ul>
                        <?php }?>
                    </div>
                <?php }?>
                <div class="ybc-theme-panel-box tc-reset">
                    <span id="tc-reset"><?php echo smartyTranslate(array('s'=>'Reset to default','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</span>
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
                    url : '<?php echo $_smarty_tpl->tpl_vars['moduleDirl']->value;?>
ajax.php',
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
                url : '<?php echo $_smarty_tpl->tpl_vars['moduleDirl']->value;?>
ajax.php',
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
                url : '<?php echo $_smarty_tpl->tpl_vars['moduleDirl']->value;?>
ajax.php',
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
<?php }?>
<div class="tc_comparison_msg tc_comparison_success">
    <p><?php echo smartyTranslate(array('s'=>'The product has been successfully added to comparison','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</p>
    <a href="<?php echo $_smarty_tpl->tpl_vars['tc_comparison_link']->value;?>
" class="button"><?php echo smartyTranslate(array('s'=>'View all products','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</a>
</div>
<div class="tc_comparison_msg tc_comparison_failed">
    <p><?php echo smartyTranslate(array('s'=>'The product has been removed from comparison','mod'=>'ybc_themeconfig'),$_smarty_tpl);?>
</p>
</div>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('YBC_TC_FLOAT_CSS3'=>$_smarty_tpl->tpl_vars['YBC_TC_FLOAT_CSS3']->value),$_smarty_tpl);?>
<?php }} ?>
