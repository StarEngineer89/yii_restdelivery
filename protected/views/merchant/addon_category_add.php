<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnCategory/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnCategory" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnCategory?Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
</div>

<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','addAddOnCategory')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/AddOnCategory/Do/Add")?>
<?php endif;?>

<?php 
if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->getAddonCategory2($_GET['id'])){
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	}	
}
?>                                 
<?php if ( Yii::app()->functions->multipleField()==2):?>

<?php 
Widgets::multipleFields(array(
  'AddOn Name','Description'
),array(
  'subcategory_name','subcategory_description'
),$data,array(
  true,false
));
?>
<div class="spacer"></div>

<?php else :?>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","AddOn Name")?></label>
  <?php echo CHtml::textField('subcategory_name',
  isset($data['subcategory_name'])?stripslashes($data['subcategory_name']):""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Description")?></label>
  <?php echo CHtml::textField('subcategory_description',
  isset($data['subcategory_description'])?stripslashes($data['subcategory_description']):""
  ,array(
  'class'=>'uk-form-width-large',  
  ))?>
</div>
<?php endif;?>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>
  <?php echo CHtml::dropDownList('status',
  isset($data['status'])?$data['status']:"",
  (array)statusList(),          
  array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>





<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 1")?></label>
  <?php
  //'price2'='2.10';
  echo CHtml::textField('price1',isset($data['price1'])?$data['price1']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>
  </div>
  
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 2")?></label>
  <?php
  //'price2'='2.10';
  echo CHtml::textField('price2',isset($data['price2'])?$data['price2']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 3")?></label>
  <?php
  echo CHtml::textField('price3',isset($data['price3'])?$data['price3']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 4")?></label>
  <?php
  echo CHtml::textField('price4',isset($data['price4'])?$data['price4']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 5")?></label>
  <?php
  echo CHtml::textField('price5',isset($data['price5'])?$data['price5']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 6")?></label>
  <?php
  echo CHtml::textField('price6',isset($data['price6'])?$data['price6']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>


<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 7")?></label>
  <?php
  echo CHtml::textField('price7',isset($data['price7'])?$data['price7']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price 8")?></label>
  <?php
  echo CHtml::textField('price8',isset($data['price8'])?$data['price8']:"",array(
   'class'=>"numeric_only addon_price"
  ))
  ?>    
</div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>