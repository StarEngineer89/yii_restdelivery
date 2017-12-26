<?php /* Smarty version Smarty-3.1.19, created on 2017-07-27 15:02:29
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_themeconfig/views/templates/hook/modulelinks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19273994255979f275c353d3-13067292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b058519aea9ebcf57f322147ba4bd6617afce046' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/themes/probusiness/modules/ybc_themeconfig/views/templates/hook/modulelinks.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19273994255979f275c353d3-13067292',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modules' => 0,
    'module' => 0,
    'active_module' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5979f275c4ea22_36926753',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5979f275c4ea22_36926753')) {function content_5979f275c4ea22_36926753($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['modules']->value) {?>
    <script type="text/javascript">
        $(document).ready(function(){
            var ybc_tc_links = '<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['module']->value['installed']) {?><li <?php if ($_smarty_tpl->tpl_vars['module']->value['id']==$_smarty_tpl->tpl_vars['active_module']->value) {?> class="active" <?php }?> id="ybc_tc_<?php echo $_smarty_tpl->tpl_vars['module']->value['id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['module']->value['link'];?>
"><?php echo addslashes($_smarty_tpl->tpl_vars['module']->value['name']);?>
</a></li><?php }?><?php } ?>';
            if($('#subtab-AdminYbcTC').length > 0)
            {
                $('#subtab-AdminYbcTC').after(ybc_tc_links);
            }
            else
            if($('#subtab-AdminPayment').length > 0)
            {
                $('#subtab-AdminPayment').after(ybc_tc_links);
            }
            else 
            if($('#subtab-AdminModules').length > 0)
            {
                $('#subtab-AdminModules').after(ybc_tc_links);
            }
        });
    </script>
<?php }?><?php }} ?>
