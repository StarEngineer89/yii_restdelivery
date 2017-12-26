<form class="uk-form uk-form-horizontal admin-settings-page forms" id="forms">
<?php echo CHtml::hiddenField('action','emailSettings')?>

<?php 
$email_provider=Yii::app()->functions->getOptionAdmin('email_provider');
?>
  

<h3><?php echo t("Select Provider")?></h3>

  <div class="uk-form-row">  
  <ul class="email-provider-list">
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="phpmail"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>"phpmail"
   ));
   echo "<span>".t("php mail functions")."</span>";
   ?>
   </li>
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="smtp"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>'smtp'
   ));
   echo "<span>".t("SMTP")."</span>";
   ?></li>
   
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="mandrill"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>'mandrill'
   ));
   echo "<span>".t("Mandrill API")."</span>";
   ?></li>
   
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="sendgrid"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>'sendgrid'
   ));
   echo "<span>".t("SendGrid")."</span>";
   ?></li>
   
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="mailjet"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>'mailjet'
   ));
   echo "<span>".t("MailJet")."</span>";
   ?></li>
   
   <li><?php 
   echo CHtml::radioButton('email_provider',
   $email_provider=="elasticemail"?true:false
   ,array(
    'class'=>"icheck",
    'value'=>'elasticemail'
   ));
   echo "<span>".t("Elastic Email")."</span>";
   ?></li>
   
  </ul>
</div>



<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","SMTP host")?></label>  
  <?php 
  echo CHtml::textField('smtp_host',
  Yii::app()->functions->getOptionAdmin('smtp_host'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","SMTP port")?></label>  
  <?php 
  echo CHtml::textField('smtp_port',
  Yii::app()->functions->getOptionAdmin('smtp_port'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Username")?></label>  
  <?php 
  echo CHtml::textField('smtp_username',
  Yii::app()->functions->getOptionAdmin('smtp_username'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Password")?></label>  
  <?php 
  echo CHtml::textField('smtp_password',
  Yii::app()->functions->getOptionAdmin('smtp_password'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<p class="uk-text-danger"><?php echo t("Note: When using SMTP make sure the port number is open in your server")?>.<br/>
<?php echo t("You can ask your hosting to open this for you")?>.
</p>

<hr>

<h3><?php echo t("Mandrill API")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","API KEY")?></label>  
  <?php 
  echo CHtml::textField('mandrill_api_key',
  Yii::app()->functions->getOptionAdmin('mandrill_api_key'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<hr>

<h3><?php echo t("SendGrid")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","API KEY")?></label>  
  <?php 
  echo CHtml::textField('sendgrid_api_key',
  getOptionA('sendgrid_api_key'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<hr>

<h3><?php echo t("MailJet")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","API KEY")?></label>  
  <?php 
  echo CHtml::textField('mailjet_api_key',
  getOptionA('mailjet_api_key'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","SECRET KEY")?></label>  
  <?php 
  echo CHtml::textField('mailjet_secret_key',
  getOptionA('mailjet_secret_key'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<hr>

<h3><?php echo t("Elastic Email")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","API KEY")?></label>  
  <?php 
  echo CHtml::textField('elastic_email_apikey',
  getOptionA('elastic_email_apikey'),
  array(
    'class'=>"uk-form-width-large"    
  ))
  ?> 
</div>

<hr>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
<a href="javascript:;" class="test-email uk-button"><?php echo t("Click here to send Test Email")?></a>
</div>

</form>