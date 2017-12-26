<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:24:37
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/front/execute.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1539339805988a25582f043-08569606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9719505b4c863d3be22f3b3f388c3f232dfdeb68' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/front/execute.tpl',
      1 => 1499174630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1539339805988a25582f043-08569606',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nbProducts' => 0,
    'img_ps_dir' => 0,
    'submit_url' => 0,
    'form_data' => 0,
    'k' => 0,
    'v' => 0,
    'shasign' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a25584be12_15930533',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a25584be12_15930533')) {function content_5988a25584be12_15930533($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/modifier.escape.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['nbProducts']->value)&&$_smarty_tpl->tpl_vars['nbProducts']->value<=0) {?>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'barclaysepdq'),$_smarty_tpl);?>
</p>
<?php } else { ?>
    <div id="barclaysepdq_loader">
        <p><img src="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['img_ps_dir']->value, 'UTF-8');?>
loadingAnimation.gif" alt="Loading..."/></p>
    </div>
    <form id="barclaysepdq_form" name="barclaysepdq_form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['submit_url']->value;?>
">
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['form_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"/>
        <?php } ?>
        <input type="hidden" name="SHASIGN" value="<?php echo $_smarty_tpl->tpl_vars['shasign']->value;?>
">
    </form>
    <script language='javascript'>
        $(function () {
            $('#barclaysepdq_form').submit();
        });
    </script>
<?php }?>
<?php }} ?>
