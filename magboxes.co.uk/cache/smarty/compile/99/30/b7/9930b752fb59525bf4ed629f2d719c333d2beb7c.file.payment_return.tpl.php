<?php /* Smarty version Smarty-3.1.19, created on 2017-08-07 18:25:56
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/hook/payment_return.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4078142595988a2a4e8ab63-46737006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9930b752fb59525bf4ed629f2d719c333d2beb7c' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/barclaysepdq/views/templates/hook/payment_return.tpl',
      1 => 1499174630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4078142595988a2a4e8ab63-46737006',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'status' => 0,
    'message_id' => 0,
    'amount' => 0,
    'order_id' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5988a2a4ed5813_04420154',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5988a2a4ed5813_04420154')) {function content_5988a2a4ed5813_04420154($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home4/yummytak/public_html/magboxes.co.uk/tools/smarty/plugins/modifier.escape.php';
?>

<?php if ($_smarty_tpl->tpl_vars['status']->value=='ok') {?>
    <?php if ($_smarty_tpl->tpl_vars['message_id']->value==1) {?>
        <div class="alert alert-success success"><?php echo smartyTranslate(array('s'=>'Thank you for shopping with us. Your credit card has been charged with amount %s and your transaction for order #%s is successful. We will be shipping your order to you soon.','sprintf'=>array($_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['order_id']->value),'mod'=>'barclaysepdq'),$_smarty_tpl);?>
</div>
    <?php } elseif ($_smarty_tpl->tpl_vars['message_id']->value==2) {?>
        <div class="alert alert-info success"><?php echo smartyTranslate(array('s'=>'Transaction for order cancelled.','sprintf'=>$_smarty_tpl->tpl_vars['order_id']->value,'mod'=>'barclaysepdq'),$_smarty_tpl);?>
</div>
    <?php } elseif ($_smarty_tpl->tpl_vars['message_id']->value==3) {?>
        <div class="alert alert-warning warning"><?php echo smartyTranslate(array('s'=>'Transaction for order #%s has been declined.','sprintf'=>$_smarty_tpl->tpl_vars['order_id']->value,'mod'=>'barclaysepdq'),$_smarty_tpl);?>
</div>
    <?php }?>
<?php } else { ?>
    <p class="warning">
        <?php echo smartyTranslate(array('s'=>'We have noticed that there is a problem with your order. If you think this is an error, you can contact our','mod'=>'barclaysepdq'),$_smarty_tpl);?>

        <a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'customer service department.','mod'=>'barclaysepdq'),$_smarty_tpl);?>
</a>.
    </p>
<?php }?>
<?php }} ?>
