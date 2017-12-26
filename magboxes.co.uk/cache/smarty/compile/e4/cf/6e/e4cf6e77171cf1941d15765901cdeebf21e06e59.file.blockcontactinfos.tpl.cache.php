<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:37
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blockcontactinfos/blockcontactinfos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6536773565979f27d919688-81392961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4cf6e77171cf1941d15765901cdeebf21e06e59' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/blockcontactinfos/blockcontactinfos.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6536773565979f27d919688-81392961',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockcontactinfos_company' => 0,
    'blockcontactinfos_address' => 0,
    'blockcontactinfos_phone' => 0,
    'blockcontactinfos_email' => 0,
    'tc_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f27d950dc5_31829632',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f27d950dc5_31829632')) {function content_5979f27d950dc5_31829632($_smarty_tpl) {?><?php if (!is_callable('smarty_function_mailto')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/function.mailto.php';
?>

<!-- MODULE Block contact infos -->
<section id="block_contact_infos" class="footer-block col-xs-12 col-sm-3">
        <h4 class=""><?php echo smartyTranslate(array('s'=>'Contact us','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
</h4>
        <ul class="toggle-footer">
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_company']->value!=''||$_smarty_tpl->tpl_vars['blockcontactinfos_address']->value!='') {?>
            	<li><i aria-hidden="true" class="icon_pin_alt"></i>
            		<?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value!='') {?> <span><?php echo smartyTranslate(array('s'=>'Address','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value, ENT_QUOTES, 'UTF-8', true);?>
 </span><?php }?>
            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value!='') {?>
            	<li>            		
                    <i aria-hidden="true" class="icon_phone"></i>
            		<span><?php echo smartyTranslate(array('s'=>'Phone','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value!='') {?>
            	<li>            		
                    <i aria-hidden="true" class="icon_mail_alt"></i>
            		<span><?php echo smartyTranslate(array('s'=>'Email','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
: <?php echo smarty_function_mailto(array('address'=>htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value, ENT_QUOTES, 'UTF-8', true),'encode'=>"hex"),$_smarty_tpl);?>
</span>
            	</li>
            <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['tc_config']->value['BLOCKCONTACTINFOS_SKYPE'])&&$_smarty_tpl->tpl_vars['tc_config']->value['BLOCKCONTACTINFOS_SKYPE']) {?>
                <li>            		
                    <i aria-hidden="true" class="social_skype"></i>
            		<span><?php echo smartyTranslate(array('s'=>'Skye','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['tc_config']->value['BLOCKCONTACTINFOS_SKYPE'];?>
</span>
        	   </li>            
            
            <?php }?>
        </ul>
    
    
</section>

<!-- /MODULE Block contact infos -->
<?php }} ?>
