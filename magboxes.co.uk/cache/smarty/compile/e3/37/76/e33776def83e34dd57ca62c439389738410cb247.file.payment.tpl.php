<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:24:28
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/hook/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18509386955988a24c877f47-90009796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e33776def83e34dd57ca62c439389738410cb247' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/hook/payment.tpl',
      1 => 1499174630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18509386955988a24c877f47-90009796',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a24c8851e1_93148990',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a24c8851e1_93148990')) {function content_5988a24c8851e1_93148990($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/modifier.escape.php';
?>

<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="barclaysepdq" href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getModuleLink('barclaysepdq','payment'), 'UTF-8');?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by Barclays ePDQ','mod'=>'barclaysepdq'),$_smarty_tpl);?>
">
                <?php echo smartyTranslate(array('s'=>'Pay by Debit/Credit Card','mod'=>'barclaysepdq'),$_smarty_tpl);?>

            </a>
        </p>
    </div>
</div>
<?php }} ?>
