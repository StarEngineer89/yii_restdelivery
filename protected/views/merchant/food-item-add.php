<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/FoodItem/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/FoodItem" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/FoodItem/Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
</div>


<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
&nbsp;<label><input value="yes" type="checkbox" name="apply_all" >&nbsp;Apply to all</label>
<?php echo CHtml::hiddenField('action','FoodItemAdd')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/FoodItem/Do/Add")?>
<?php endif;?>

<?php 
$addon_item='';
$price='';
$category='';
$cooking_ref_selected='';
$multi_option_Selected='';
$multi_option_value_selected='';
$ingredients_selected='';
$data='';

if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->getFoodItem2($_GET['id'])){
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	}		
	$addon_item=isset($data['addon_item'])?(array)json_decode($data['addon_item']):false;		
	$category=isset($data['category'])?(array)json_decode($data['category']):false;
	$price=isset($data['price'])?(array)json_decode($data['price']):false;
	$cooking_ref_selected=isset($data['cooking_ref'])?(array)json_decode($data['cooking_ref']):false;
	$multi_option_Selected=isset($data['multi_option'])?(array)json_decode($data['multi_option']):false;
	$multi_option_value_selected=isset($data['multi_option_value'])?(array)json_decode($data['multi_option_value']):false;	
	$test_column = isset($data['meal_selection'])?json_decode($data['meal_selection'], true):false;	
	
	$ingredients_selected=isset($data['ingredients'])?(array)json_decode($data['ingredients']):false;
	
	$two_flavors_position=isset($data['two_flavors_position'])?(array)json_decode($data['two_flavors_position']):false;	
	//dump($two_flavors_position);
	
	$require_addon=isset($data['require_addon'])?(array)json_decode($data['require_addon']):false;		
	
}

echo CHtml::hiddenField('merchant_tax',$merchant_tax);
?>                                 

<div class="uk-grid">
    <div class="uk-width-1-2">
    
    <?php if ( Yii::app()->functions->multipleField()==2):?>
    
    <?php 
	Widgets::multipleFields(array(
	  'Food Item Name','Description'
	),array(
	  'item_name','item_description'
	),$data,array(true,false),array('text','textarea'));
	?>
	<div class="spacer"></div>

    <?php else :?>
	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Food Item Name")?></label>
	<?php echo CHtml::textField('item_name',
	isset($data['item_name'])?$data['item_name']:""
	,array(
	'class'=>'uk-form-width-large',
	'data-validation'=>"required"
	))?>
	</div>

	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Description")?></label>
	<?php echo CHtml::textArea('item_description',
	isset($data['item_description'])?$data['item_description']:""
	,array(
	'class'=>'uk-form-width-large big-textarea'	
	))?>
	</div>
	
	<?php endif;?>
	
	
    <div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Two Flavors")?></label>  
	  <div class="clear"></div>
	  <ul class="uk-list uk-list-striped">
	     <li>
	     <?php
	      if(!isset($data['two_flavors'])){
	      	$data['two_flavors']='';
	      }
		  echo CHtml::checkBox('two_flavors',
		  $data['two_flavors']==2?true:false
		  ,array(
		    'class'=>"two_flavors",
		    'value'=>2
		  ))
	     ?>
	     <?php echo t("Two Flavors")?>
	     </li>
	  </ul>
	</div>
    	
	<?php 
	Yii::app()->functions->data='list';
	$addon_list=Yii::app()->functions->getAddOnList(Yii::app()->functions->getMerchantID());		
	//dump($addon_list);
	?>
	<?php if (is_array($addon_list) && count($addon_list)>=1):?>
	<h3 class="uk-h3"><?php echo Yii::t("default","AddOn")?></h3>
	<ul class="uk-list uk-list-striped">
	<?php $size_list1=Yii::app()->functions->getSizeList(Yii::app()->functions->getMerchantID());
	$free_items = json_decode($data['free_item'],true);
	$list_exclude_items = json_decode($data['exclude_item'],true);
	?>
	 <?php foreach ($addon_list as $val):?>
	 
	 
	<?php		
		/*foreach ($size_list1 as $key1=>$val1) {
			if ($val1==$val['size_list']) $size_list_item = $key1;
		}*/
	?>
	
	 <?php $addonid=trim($val['addon_id']);?>	 
	 <?php
		$size1_item = $test_column["$addonid"][0]; 	 
	 if ( !$selected_item_array=getSelectedItemArray($addonid,$multi_option_Selected)){	 	
	 	$selected_item_array[]='one';
	 }	 
	 if ( !$multi_option_value_array=getSelectedItemArray($addonid,$multi_option_value_selected)){	 	
	 	$multi_option_value_array[]="";
	 }	
	 if(!isset($two_flavors_position)){
	 	$two_flavors_position='';
	 }
	 if ( !$selected_flavors_pos=getSelectedItemArray($addonid,$two_flavors_position)){	 	
	 	$selected_flavors_pos[]='';
	 }	 
	 if(!isset($require_addon)){
	 	$require_addon='';
	 }
	 if ( !$selected_require_addon=getSelectedItemArray($addonid,$require_addon)){	 	
	 	$selected_require_addon[]='';
	 }	 	 
	 ?>
	 <li>
	    <div class="uk-grid">
	      <div class="uk-width-1-3">
	      <?php echo $val['addon_item_name']?>

	      <div class="uk-form-row">
	      <label class="uk-form-label"><?php echo Yii::t("default","Free")?></label>
	      <?php
	      // tuyenphp

	      echo CHtml::textField("free_item[$addonid]",@$free_items[$addonid],array('class'=>'uk-form-width-medium numeric_only'));
	      ?>
	      </div>

	      </div>
	      <div class="uk-width-1-3">
	      <?php echo CHtml::dropDownList("multi_option[$addonid][]",$selected_item_array[0],(array)Yii::app()->functions->multiOptions(),array(
	        'class'=>"multi_option",
	        'data-id'=>$addonid,
			'style'=>"width:100%;"			
	      ) )?>	
	      <div style="width:100%;position: relative;border:1px solid #ddd;padding: 4px 6px;border-radius: 4px;background: #fff;margin-top: 10px;">
	      	<span style="display:block;cursor: pointer;" data-id="<?php echo $addonid;?>" class="show_exclude_item">Exclude</span>
	      	<span style="position: absolute;top:5px;right: 5px;display:block;font-size: 9px;">&#x25BC;</span>
	      	<div style="position:absolute;top:30px;left:0px;background: #fff;border: 1px solid #ddd;border-top:0px;width:100%;display:none;" id="exclude_item_<?php echo $addonid;?>" class="list_exclude_item">
	      		<?php if (is_array($val['item']) && count($val['item'])>=1):?>
			    <ul class="uk-list uk-list-striped" style="padding: 0px;">
			     <?php foreach ($val['item'] as $item_id => $val_item):?>
			     <li>
			      <?php	      	      	      	     	      
			      $add_on_price=Yii::app()->functions->getAddonItem2($item_id);	      
			      ?>
			      <?php echo CHtml::checkBox("exclude_item[$addonid][]",
			      in_array($item_id,(array)@$list_exclude_items[$addonid])?true:false
			      ,array('value'=>"$item_id",'class'=>"exclude_item_$addonid"))?>
			      <?php 
			      if ($merchant_apply_tax==1){
			      	  $price_w_tax=$add_on_price['price']+( $add_on_price['price'] * $merchant_tax );
			      	  echo ($val_item)." (".displayPrice(adminCurrencySymbol(),standardPrettyFormat($price_w_tax)).")";
			      } else {
			          echo ($val_item) ." (".displayPrice(adminCurrencySymbol(),prettyFormat($add_on_price['price'])).")";
			      }
			      ?>
			     </li>
			     <?php endforeach;?>
			    </ul>
			   <?php endif;?>
	      	</div>
	      </div>


	      </div>
		  <div class="uk-width-1-3"><?php echo CHtml::dropDownList("size1[$addonid][]",$size1_item,$size_list1,array('multiple'=>"true", 'class'=>"uk-form-width-medium", 'style'=>"width:100%;"))?></div>
	      <div class="uk-width-1-3">
	      <?php $visible=!empty($multi_option_value_array[0])?"visible":"";?>
	      <?php echo CHtml::textField("multi_option_value[$addonid][]",$multi_option_value_array[0],array(
	        'class'=>"numeric_only multi_option_value $visible"
	      ))?>
	      </div>
	      	      	      
	      <div class="uk-width-1-3">
	       <?php echo CHtml::dropDownList("two_flavors_position[$addonid][]",$selected_flavors_pos[0],array(
	         ''=>"",
	         'left'=>t("left"),
	         'right'=>t("Right")
	       ),array(
	        'class'=>'two_flavors_position',
	        'data-id'=>$addonid
	       ))?>
	      </div>
	    </div>
	 </li>
	 
	   <!--required add on-->	   
	   <li>
	   <?php echo t("Required")."? ";?>
	   <?php echo CHtml::checkBox("require_addon[$addonid][]",
	   in_array(2,$selected_require_addon)?true:false
	   ,array(
	     'class'=>"require_addon",
	     'value'=>2
	   ))?>

<!--selectall-->

Select All<input type="checkbox" id="<?php echo "$addonid";?>" onclick="myFunc(<?php echo "$addonid";?>)" class = "chk" value = "2">

	   </li>




	   
	   <?php if (is_array($val['item']) && count($val['item'])>=1):?>

	    <ul class="uk-list uk-list-striped">

	     <?php foreach ($val['item'] as $item_id => $val_item):?>

	     <li>
	      <?php 	      	      	      	     	      
	      $selected_item_array=getSelectedItemArray($addonid,$addon_item);	      	      	      
	      $add_on_price=Yii::app()->functions->getAddonItem2($item_id);	      
	      ?>
	      <?php echo CHtml::checkBox("sub_item_id[$addonid][]",
	      in_array($item_id,(array)$selected_item_array)?true:false
	      ,array('value'=>"$item_id",'class'=>"$addonid"))?>
	      <?php 
	      if ($merchant_apply_tax==1){
	      	  $price_w_tax=$add_on_price['price']+( $add_on_price['price'] * $merchant_tax );
	      	  echo ($val_item)." (".displayPrice(adminCurrencySymbol(),standardPrettyFormat($price_w_tax)).")";
	      } else {
	          echo ($val_item) ." (".displayPrice(adminCurrencySymbol(),prettyFormat($add_on_price['price'])).")";
	      }
	      ?>
	     </li>
	     <?php endforeach;?>
	    </ul>
	   <?php endif;?>
	 <?php endforeach;?>
	</ul>
	<?php endif;?>
	
    </div> <!--END uk-width-1-2-->
    
    <div class="uk-width-1-2">
    
	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>
	<?php echo CHtml::dropDownList('status',
	isset($data['status'])?$data['status']:"",
	(array)statusList(),          
	array(
	'class'=>'uk-form-width-medium',
	'data-validation'=>"required"
	))?>
	</div>
	
	
	
<div class="uk-form-row"> 
 <label class="uk-form-label"><?php echo Yii::t('default',"Featured Image")?></label>
  <div style="display:inline-table;margin-left:1px;" class="button uk-button" id="photo"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="photo_chart_status" >
	<div id="percent_bar" class="photo_percent_bar"></div>
	<div id="progress_bar" class="photo_progress_bar">
	  <div id="status_bar" class="photo_status_bar"></div>
	</div>
  </DIV>		  
</div>

<?php if (!empty($data['photo'])):?>
<div class="uk-form-row"> 
<?php else :?>
<div class="input_block preview">
<?php endif;?>
<label><?php echo Yii::t('default',"Preview")?></label>
<div class="image_preview">
 <?php if (!empty($data['photo'])):?>
 <input type="hidden" name="photo" value="<?php echo $data['photo'];?>">
 <img class="uk-thumbnail uk-thumbnail-small" src="<?php echo Yii::app()->request->baseUrl."/upload/".$data['photo'];?>?>" alt="" title="">
 <p><a href="javascript:rm_preview();"><?php echo t('Remove image')?></a></p>
 <?php endif;?>
</div>
</div>


<!--GALLERY -->
<div class="uk-form-row"> 
 <label class="uk-form-label"><?php echo Yii::t('default',"Gallery Image")?></label>
  <div style="display:inline-table;margin-left:1px;" class="button uk-button" id="foodgallery"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="foodgallery_chart_status" >
	<div id="percent_bar" class="foodgallery_percent_bar"></div>
	<div id="progress_bar" class="foodgallery_progress_bar">
	  <div id="status_bar" class="foodgallery_status_bar"></div>
	</div>
  </DIV>		  
</div>

<div class="uk-form-row"> 
  <div class="input_block foodgallery_preview">
  <?php if (!empty($data['gallery_photo'])): $gallery_photo=json_decode($data['gallery_photo']);?> 
  <?php if (is_array($gallery_photo) && count($gallery_photo)>=1):?>  
  <?php foreach ($gallery_photo as $val_gal):  $class_gal = time().Yii::app()->functions->generateRandomKey(10);?>
    <li class="<?php echo $class_gal?>"> 
      <img class="uk-thumbnail uk-thumbnail-mini" src="<?php echo websiteUrl()."/upload/$val_gal"?>">
      <?php echo CHtml::hiddenField('gallery_photo[]',$val_gal)?>
      <p><a href="javascript:rm_foodGallery('<?php echo $class_gal?>')"><?php echo t("Remove image")?></a></p>
    </li>
  <?php endforeach;?>
  <?php endif;?>
  <?php endif;?>
  </div>
</div>
<!--GALLERY -->
	
	<?php 	
	Yii::app()->functions->data='list';
	$category_list=Yii::app()->functions->getCategoryList(Yii::app()->functions->getMerchantID());		
	?>
	<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Food Category")?></label>  
	  <div class="clear"></div>
	  <?php if (is_array($category_list) && count($category_list)>=1):?>
	  <ul class="uk-list uk-list-striped">
	  <?php foreach ($category_list as $key=>$val):?>
	    <li>
	    <?php echo CHtml::checkBox('category[]',
	    in_array($key,(array)$category)?true:false,array(
	      'value'=>$key,
	      'data-validation'=>"checkbox_group",
	      'data-validation-qty'=>'min1'
	    ))?>
	    <?php echo clearString($val);?>
	    </li>
	  <?php endforeach;?>
	  </ul>
	  <?php endif;?>
	</div>	
	&nbsp;<label class="pull-right"><input value="yes" type="checkbox" name="apply_all_Sizes" >&nbsp;Apply to all Sizes</label>
	<?php 
	$size_list=Yii::app()->functions->getSizeList(Yii::app()->functions->getMerchantID());
	
	$new_size_list='';
	if(is_array($size_list) && count($size_list)>=1){
		foreach ($size_list as $size_id=>$size_name) {
			$size_info_trans=Yii::app()->functions->getSizeTranslation($size_name,Yii::app()->functions->getMerchantID());
			$temp=qTranslate($size_name,'size_name',$size_info_trans,'kr_merchant_lang_id');
			$new_size_list[$size_id]=$temp;
		}	
		$size_list=$new_size_list;	
	}
	?>
	
	<?php if (is_array($size_list) && count($size_list)>=1):?>
	<ul class="uk-list uk-list-striped price_wrap_parent">
	<li>
	  <div class="uk-grid">
	    <?php if ($merchant_apply_tax==1):?>
	    <div class="uk-width-1-3"><?php echo Yii::t("default","Size")?></div>
	    <div class="uk-width-1-4"><?php echo Yii::t("default","Price")?></div>
	    <div class="uk-width-1-4"><?php echo Yii::t("default","Price With Tax")?></div>
	    <div class="uk-width-1-4">&nbsp;</div>
	    <?php else :?> 
	    <div class="uk-width-1-2"><?php echo Yii::t("default","Size")?></div>
	    <div class="uk-width-1-2"><?php echo Yii::t("default","Price")?></div>
	    <?php endif;?>
	  </div>
	</li>	
	
	<?php 
	/*dump($size_list); dump($price);
	dump($merchant_apply_tax);	*/
	?>
	
	<?php if ( is_array($price) && count($price)>=1):?>
	
	    <?php $x=1;?>
		<?php foreach ($price as $price_key=>$val_price):?>			
		<li class="<?php echo $x==count($price)?"price_wrap":"";?>">
		  <div class="uk-grid">
		    
		    <?php if ($merchant_apply_tax==1):?>
		  
		     <div class="uk-width-1-3">
		    <?php echo CHtml::dropDownList('size[]',$price_key,$size_list,array('class'=>"uk-form-width-medium"))?>
		     </div>
		     <div class="uk-width-1-4">
		      <?php echo CHtml::textField('price[]',$val_price,
		      array('class'=>'uk-form-width-medium numeric_only food_price'))?>
		    </div>
		    
		    <div class="uk-width-1-4">
		    <span class="price_with_tax">
		      <?php echo standardPrettyFormat($val_price+($val_price*$merchant_tax))?>
		    </span>
		    </div>
		    
		    <div class="uk-width-1-6">
		    <a href="javascript:;" class="removeprice"><i class="fa fa-minus-square"></i></a>
		    </div>
		    
		    <?php else:?>
		    
		     <div class="uk-width-1-3">
		    <?php echo CHtml::dropDownList('size[]',$price_key,$size_list,array('class'=>"uk-form-width-medium"))?>
		     </div>
		     <div class="uk-width-1-3">
		      <?php echo CHtml::textField('price[]',$val_price,
		      array('class'=>'uk-form-width-medium numeric_only'))?>
		    </div>
		    		
		    <div class="uk-width-1-3">
		    <a href="javascript:;" class="removeprice"><i class="fa fa-minus-square"></i></a>
		    </div>
		    
		    <?php endif;?>
		    
		  </div>
	    </li>
		<?php $x++;?>
		<?php endforeach;?>
	<?php else :?>
	<li class="price_wrap">
	  <div class="uk-grid">
	  
	    <?php if ($merchant_apply_tax==1):?>
	    
	        <div class="uk-width-1-3">
		    <?php echo CHtml::dropDownList('size[]','',$size_list,array('class'=>"uk-form-width-medium"))?>
		     </div>
		     <div class="uk-width-1-4">
		      <?php echo CHtml::textField('price[]','',
		      array('class'=>'uk-form-width-medium numeric_only food_price'))?>
		    </div>
		    
		    <div class="uk-width-1-4">
		    <span class="price_with_tax">&nbsp;</span>
		    </div>
		    
		    <div class="uk-width-1-6">
		    <a href="javascript:;" class="removeprice"><i class="fa fa-minus-square"></i></a>
		    </div>
	    
	    <?php else :?>
		     <div class="uk-width-1-3">
		    <?php echo CHtml::dropDownList('size[]','',$size_list,array('class'=>"uk-form-width-medium"))?>
		     </div>
		     <div class="uk-width-1-3">
		      <?php echo CHtml::textField('price[]','',
		      array('class'=>'uk-form-width-medium numeric_only'))?>
		    </div>
		    <div class="uk-width-1-3">
		    <a href="javascript:;" class="removeprice"><i class="fa fa-minus-square"></i></a>
		    </div>
	    <?php endif;?>
	    
	  </div>
    </li>
    <?php endif;?>
    
    <li>
      <a href="javascript:;" class="addnewprice"><i class="fa fa-plus-circle"></i></a>
    </li>
   
	</ul>
	<?php else :?>
	<p class="uk-text-danger"><?php echo Yii::t("default","Please add different size in order to add price.")?></p>
	<?php endif;?>
	
	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Discount (numeric value)")?></label>
	<?php echo CHtml::textField('discount',
	isset($data['discount'])?$data['discount']:""
	,array(
	'class'=>'uk-form-width-medium numeric_only'	
	))?>
	</div>
		
	<?php 
	$cooking_ref=Yii::app()->functions->getCookingRefList(Yii::app()->functions->getMerchantID());	
	?>
	<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Cooking Reference")?></label>  
	  <div class="clear"></div>
	  <?php if (is_array($cooking_ref) && count($cooking_ref)>=1):?>
	  <ul class="uk-list uk-list-striped">
	  <?php foreach ($cooking_ref as $key=>$val):?>
	    <li>
	    <?php echo CHtml::checkBox('cooking_ref[]',
	    in_array($key,(array)$cooking_ref_selected)?true:false,array(
	      'value'=>$key
	    ))?>
	    <?php echo ($val);?>
	    </li>
	  <?php endforeach;?>
	  </ul>
	  <?php endif;?>
	</div>	
	

    <?php 
	$ingredients=Yii::app()->functions->getIngredientsList(Yii::app()->functions->getMerchantID());	
	?>
	<?php if (is_array($ingredients) && count($ingredients)>=1):?>
	<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Ingredients")?></label>  
	  <div class="clear"></div>
	  <?php if (is_array($ingredients) && count($ingredients)>=1):?>
	  <ul class="uk-list uk-list-striped">
	  <?php foreach ($ingredients as $key=>$val):?>
	    <li>
	    <?php echo CHtml::checkBox('ingredients[]',
	    in_array($key,(array)$ingredients_selected)?true:false,array(
	      'value'=>$key
	    ))?>
	    <?php echo ($val);?>
	    </li>
	  <?php endforeach;?>
	  </ul>
	  <?php endif;?>
	</div>		
	<?php endif;?>
	
	
	<!--<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Spicy Dish")?></label>  
	  <div class="clear"></div>
	  <ul class="uk-list uk-list-striped">
	  <li><?php echo CHtml::checkBox('spicydish',
	  $data['spicydish']==2?true:false
	  ,array(
	   'class'=>"icheck",
	   'value'=>2
	  ))?>
	  <?php echo t("Spicy Dish")?>
	  </li>
	  </ul>
	</div>--> <!--end form uk-->
	  
   <?php $dish=Yii::app()->functions->GetDishList();?>
   <?php $dish_selected=isset($data['dish'])?json_decode($data['dish'],true):'';?>
   <?php if (is_array($dish) && count($dish)>=1):?>
	  <div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo Yii::t("default","Dish")?></label>  
	  <div class="clear"></div>
	  <ul class="uk-list uk-list-striped">
	  
	  <?php foreach ($dish as $dish_val):?>
	  <li>
	  <?php echo CHtml::checkBox('dish[]',
	  in_array($dish_val['dish_id'],(array)$dish_selected)?true:false
	  ,array(
	   'class'=>"icheck",
	   'value'=>$dish_val['dish_id']
	  ))?>	  
	  <?php echo $dish_val['dish_name']?>
	  <?php endforeach;?>
	  
	  </li>
	  </ul>
	</div>
	<?php endif;?>
	
	<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo t("Tax")?></label>  
	<div class="clear"></div>
		
	  <ul class="uk-list uk-list-striped">
	  	  
	  <li>
	  <?php 
	  if(!isset($data['non_taxable'])){
	  	$data['non_taxable']='';
	  }
	  echo CHtml::checkBox('non_taxable',
	  $data['non_taxable']==2?true:false
	  ,array(
	   'class'=>"icheck",
	   'value'=>2
	  ))?>	  	  	  
	  <?php echo t("Non taxable")?>
	  </li>
	  </ul>	
	</div>		
	
	<!--POINTS PROGRAM-->
	<?php if (FunctionsV3::hasModuleAddon("pointsprogram")):?>
	<div class="uk-form-row">
	  <label class="uk-form-label uk-h3"><?php echo t("Points earned")?></label>  
	<div class="clear"></div>		
	  <ul class="uk-list uk-list-striped">	  	  
	  <li>
	  <?php 
	  if(!isset($data['points_earned'])){
	  	 $data['points_earned']='';
	  }
	  echo CHtml::textField('points_earned',
	  $data['points_earned']>0?$data['points_earned']:''
	  ,array(
	    'class'=>"numeric_only"
	  ))?>
	  </li>
	  
	  <li>
	  <?php 
	  if(!isset($data['points_disabled'])){
	  	 $data['points_disabled']='';
	  }
	  echo CHtml::checkBox('points_disabled',
	  $data['points_disabled']==2?true:false
	  ,array(
	   'class'=>"icheck",
	   'value'=>2
	  ))?>	  	  	  
	  <?php echo t("Disabled Points on this item")?>
	  </li>
	  
	  </ul>	
	</div>
	<?php endif;?>
	
    </div><!-- END uk-width-1-2-->
</div> <!--END uk-grid-->

<div class="spacer"></div>


<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>



 
<script type = "text/javascript" src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
function myFunc(id){
debugger;
var select_id = document.getElementById("<?php echo "$addonid"; ?>");
var select_all = document.getElementById(id); //select all checkbox
var checkboxes = document.getElementsByClassName(id); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) { 
        checkboxes[i].checked = select_all.checked;
    }
});


for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){
            select_all.checked = false;
        }
        //check "select all" if all checkbox items are checked
        if(document.querySelectorAll('.<?php echo "$addonid";?>:checked'+id+'').length == checkboxes.length){
            select_all.checked = true;
        }
    });
}
}
</script>
