<?php
$row='';
$item_data='';
$price_select='';
$size_select='';
if (array_key_exists("row",(array)$this->data)){
    $row=$this->data['row'];
    $item_data=$_SESSION['kr_item'][$row];
    //dump($item_data);
    $price=Yii::app()->functions->explodeData($item_data['price']);
    if (is_array($price) && count($price)>=1){
        $price_select=isset($price[0])?$price[0]:'';
        $size_select=isset($price[1])?$price[1]:'';
    }
    $row++;
}
echo $size_select." ". $price_select;

$tp = $_GET['tp'];
$data=Yii::app()->functions->getItemById($this->data['item_id'],true,$tp);
$priceParam = $_GET['price'];
$size_Id = $_GET['size_id'];
if(empty($priceParam)){
    $priceParam = $size_select." £". $price_select;
}

$disabled_website_ordering=Yii::app()->functions->getOptionAdmin('disabled_website_ordering');
$hide_foodprice=Yii::app()->functions->getOptionAdmin('website_hide_foodprice');
echo CHtml::hiddenField('hide_foodprice',$hide_foodprice);
?>

<?php if (is_array($data) && count($data)>=1):?>
    <?php
    $data=$data[0];
    $food_item = Yii::app()->functions->getFoodItem($data['item_id']);
    $list_free_items = json_decode($food_item['free_item'],true);

    //dump($list_free_items);
    $mtid=$data['merchant_id'];
    $apply_tax=getOption($mtid,'merchant_apply_tax');
    $tax=FunctionsV3::getMerchantTax($mtid);
    ?>

    <form class="frm-fooditem" id="frm-fooditem" method="POST" onsubmit="return false;">
        <?php echo CHtml::hiddenField('action','addToCart')?>
        <?php echo CHtml::hiddenField('item_id',$this->data['item_id'])?>
        <?php echo CHtml::hiddenField('row',isset($row)?$row:"")?>
        <?php echo CHtml::hiddenField('merchant_id',isset($data['merchant_id'])?$data['merchant_id']:'')?>
        <?php echo CHtml::hiddenField('discount',isset($data['discount'])?$data['discount']:"" )?>
        <?php echo CHtml::hiddenField('currentController','store')?>

        <?php
        if (isset($item_data['category_id'])){
            echo CHtml::hiddenField('category_id', isset($item_data['category_id'])?$item_data['category_id']:'' );
        } else echo CHtml::hiddenField('category_id', isset($this->data['category_id'])?$this->data['category_id']:'' );
        ?>

        <?php
        //dump($data);
        /** two flavores */
        if ($data['two_flavors']==2){
            $data['prices'][0]=array(
                'price'=>0,
                'size'=>''
            );
            echo CHtml::hiddenField('two_flavors',$data['two_flavors']);
        }
        //dump($data);
        ?>

        <div class="container  view-food-item-wrap">
            <!--<div class="pull-right">
  <a href="javascript:close_fb();" class="center upper-text green-button inline"><?php echo t("X");?></a>
  </div>-->

            <!--ITEM NAME & DESCRIPTION-->
            <div class="row">
                <div class=" ">
                    <img src="<?php //echo FunctionsV3::getFoodDefaultImage($data['photo']);?>" alt="<?php //echo $data['item_name']?>" title="<?php //echo $data['item_name']?>" class="logo-small">
                </div> <!--col-->
                <div class="col-md-9 ">
                    <p class="bold"><?php echo qTranslate($data['item_name'],'item_name',$data)?></p>
                    <?php echo Widgets::displaySpicyIconNew($data['dish']);?>
                    <p><?php echo qTranslate($data['item_description'],'item_description',$data)?></p>
                </div> <!--col-->
                <div class="pull-right border into-row">
                    <a href="javascript:close_fb();" class="center upper-text green-button inline"><?php echo t("X")?></a>
                </div>
            </div> <!--row-->
            <!--ITEM NAME & DESCRIPTION--

            <!--FOOD ITEM GALLERY-->
            <?php if (getOption($data['merchant_id'],'disabled_food_gallery')!=2):?>
                <?php $gallery_photo=!empty($data['gallery_photo'])?json_decode($data['gallery_photo']):false; ?>
                <?php if (is_array($gallery_photo) && count($gallery_photo)>=1):?>
                    <div class="section-label">
                        <a class="section-label-a">
          <span class="bold">
          <?php echo t("Gallery")?></span>
                            <b></b>
                        </a>
                        <div class="food-gallery-wrap row ">
                            <?php foreach ($gallery_photo as $gal_val):?>
                                <div class="col-md-3 ">
                                    <a href="<?php echo websiteUrl()."/upload/$gal_val"?>">
                                        <div class="food-pic" style="background:url('<?php echo websiteUrl()."/upload/$gal_val"?>')"></div>
                                        <img style="display:none;" src="<?php echo websiteUrl()."/upload/$gal_val"?>" alt="" title="">
                                    </a>
                                </div> <!--col-->
                            <?php endforeach;?>
                        </div> <!--food-gallery-wrap-->
                    </div> <!--section-label-->
                <?php endif;?>
            <?php endif;?>
            <!--FOOD ITEM GALLERY-->

            <!--Food Item Price -->
            <?php $spliting = str_replace('&','and',"$priceParam");?>

            <?php $pieces = explode("£", $spliting);?>
            <div class="section-label">
                <a class="section-label-a">
                    <?php echo CHtml::radioButton('price',$size_select==$pieces[0]?true:false,array('value'=>$pieces[1]."|".str_replace('~',' ',"$pieces[0]"),'class'=>"price_cls item_price"))?>
                    <?php echo str_replace('~',' ',"$spliting");?>
                </a>
                <p><?php echo CHtml::hiddenField('size_id',$size_Id );?></p>
            </div>
            <!-- Food Item Price -->


            <!--QUANTITY-->
            <?php if (is_array($data['prices']) && count($data['prices'])>=1):?>
                <div class="section-label">
                    <a class="section-label-a">
      <span class="bold">
      <?php echo t("Quantity")?></span>
                        <b></b>
                    </a>
                    <div class="row">
                        <div class="col-md-1 col-xs-1 border into-row">
                            <a href="javascript:;" class="green-button inline qty-minus" ><i class="ion-minus"></i></a>
                        </div>
                        <div class="col-md-2 col-xs-2 border into-row">
                            <?php echo CHtml::textField('qty',
                                isset($item_data['qty'])?$item_data['qty']:1
                                ,array(
                                    'class'=>"uk-form-width-mini numeric_only qty",
                                    'maxlength'=>5
                                ))?>
                        </div>
                        <div class="col-md-1 col-xs-1 border into-row">
                            <a href="javascript:;" class="qty-plus green-button inline"><i class="ion-plus"></i></a>
                        </div>
                        <div class="col-md-6 col-xs-6 border into-row">
                            <!--<a href="javascript:;" class="special-instruction orange-button inline"><?php echo t("Special Instructions")?></a>-->
                        </div>
                    </div> <!--row-->
                </div> <!-- section-label-->

                <div class="notes-wrap">
                    <?php echo CHtml::textArea('notes',
                        isset($item_data['notes'])?$item_data['notes']:""
                        ,array(
                            'class'=>'uk-width-1-1',
                            'placeholder'=>Yii::t("default","Special Instructions")
                        ))?>
                </div> <!--notes-wrap-->

            <?php else :?>
                <!--do nothing-->
            <?php endif;?>
            <!--QUANTITY-->



            <!--COOKING REF-->
            <?php if (isset($data['cooking_ref'])):?>
                <?php if (is_array($data['cooking_ref']) && count($data['cooking_ref'])>=1):?>
                    <div class="section-label">
                        <a class="section-label-a">
      <span class="bold">
      <?php echo t("Cooking Preference")?></span>
                            <b></b>
                        </a>
                        <div class="row">
                            <?php foreach ($data['cooking_ref'] as $cooking_ref_id=>$val):?>

                                <div class="col-md-5 ">
                                    <?php $item_data['cooking_ref']=isset($item_data['cooking_ref'])?$item_data['cooking_ref']:''; ?>
                                    <?php echo CHtml::radioButton('cooking_ref',
                                        $item_data['cooking_ref']==$val?true:false
                                        ,array(
                                            'value'=>$val
                                        ))?>&nbsp;
                                    <?php
                                    $cooking_ref_trans=Yii::app()->functions->getCookingTranslation($val,$data['merchant_id']);
                                    echo qTranslate($val,'cooking_name',$cooking_ref_trans);
                                    ?>
                                </div> <!--col-->
                            <?php endforeach;?>
                        </div> <!--row-->
                    </div>  <!--section-label-->
                <?php endif;?>
            <?php endif;?>
            <!--COOKING REF-->

            <!--Ingredients-->
            <?php
            if (!isset($item_data['ingredients'])){
                $item_data['ingredients']='';
            }
            ?>
            <?php if (isset($data['ingredients'])):?>
                <?php if (is_array($data['ingredients']) && count($data['ingredients'])>=1):?>
                    <div class="section-label">
                        <a class="section-label-a">
      <span class="bold">
      <?php echo "Includes" //echo t("Ingredients");  ?></span>
                            <b></b>
                        </a>
                        <div class="row">

                            <?php foreach ($data['ingredients'] as $ingredients_id =>  $val):
                                $ingredients_name_trans='';
                                $_ingredienst=Yii::app()->functions->getIngredients($ingredients_id);
                                if ($_ingredienst){
                                    $ingredients_name_trans['ingredients_name_trans']=!empty($_ingredienst['ingredients_name_trans'])?json_decode($_ingredienst['ingredients_name_trans'],true):'';
                                }
                                ?>
                                <?php $item_data['ingredients_id']=isset($item_data['ingredients_id'])?$item_data['ingredients_id']:''; ?>
                                <div class="col-md-5 ">

                                    <?php //echo CHtml::checkbox('ingredients[]',
                                    //in_array($val,(array)$item_data['ingredients'])?true:false
                                    //,array(
                                    //'value'=>$val
                                    //))?>
                                    <?php echo CHtml::checkbox('ingredients[]'	,true
                                        ,array(
                                            'value'=>$val,
                                            'disabled'=>'disabled'
                                        ))?>
                                    <?php echo CHtml::checkbox('ingredients[]',
                                        in_array($val,(array)$item_data['ingredients'])?true:true
                                        ,array(
                                            'value'=>$val,
                                            'class'=>'ingredientsCheckboxDispalyNone'
                                        ))?>&nbsp;
                                    <?php echo qTranslate($val,'ingredients_name',$ingredients_name_trans);?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                <?php endif;?>
            <?php endif;?>
            <!--END Ingredients-->



            <!--FOOD ADDON-->
            <div class="sub-item-rows">
                <?php if (isset($data['addon_item'])):?>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
                        <?php if (is_array($data['addon_item']) && count($data['addon_item'])>=1):
                            $tuyen=0;
                            ?>
                            <?php foreach ($data['addon_item'] as $val): $tuyen++;?>
                            <div class="panel panel-default">
                                <?php echo CHtml::hiddenField('require_addon_'.$val['subcat_id'],$val['require_addons'],array(
                                    'class'=>"require_addon require_addon_".$val['subcat_id'],
                                    'data-id'=>$val['subcat_id'],
                                    'data-name'=>strtoupper($val['subcat_name'])
                                ))?>
                                <div class="panel-heading" role="tab" id="heading_<?php echo $val['subcat_id'];?>">
                                    <h4 class="panel-title">
                                        <a role="button"<?php if(count($data['addon_item']) > 1){echo ' data-toggle="collapse"';}?> data-parent="#accordion" class="collapse_addon_item" href="#collapse_<?php echo $val['subcat_id'];?>" aria-expanded="<?php if($tuyen==1){echo 'true';}?>" aria-controls="collapse_<?php echo $val['subcat_id'];?>">
                                            <?php echo qTranslate($val['subcat_name'],'subcat_name',$val)?>
                                            <?php if(count($data['addon_item']) > 1){echo ' <small style="font-size:13px;">(Click to view)</small>';}?>
                                            <?php
                                            if(isset($list_free_items[$val['subcat_id']]) && $list_free_items[$val['subcat_id']] > 0){
                                                echo '<span style="color:#f00;font-size:13px;">('.$list_free_items[$val['subcat_id']].' Free Item)</span>';
                                            }
                                            ?>
                                        </a>
                                        <?php $has_Desc = $val['hasDescription']; ?>
                                        <?php if ($has_Desc==true):?>
                                            <?php $addonId = $val['subcat_id'];?>
                                            <small style='float:right; color:blue; margin-top:6px; cursor:pointer;' id="<?php echo $addonId?>" onclick="myfunction(<?php echo $addonId?>)"><?php echo "Show Desc"?></small>
                                        <?php else :?>
                                            <span><?php //echo "false"; ?></span>
                                        <?php endif;?>
                                    </h4>
                                    <h4 class="panel-title">
                                    </h4>
                                </div>

                                <!-- <div class="section-label">
                                        <a class="section-label-a">
                                        <span class="bold">
                                        <?php echo qTranslate($val['subcat_name'],'subcat_name',$val)?><?php //echo $tp;?>
                                        </span>
                                        <?php $has_Desc = $val['hasDescription']; ?>
                                        <?php if ($has_Desc==true):?>
                                        <?php $addonId = $val['subcat_id'];?>
                                        <span style='float:right; color:blue; cursor:pointer;' id="<?php echo $addonId?>" onclick="myfunction(<?php echo $addonId?>)"><?php echo "Show Description"?></span>
                                        <?php else :?>
                                        <span><?php //echo "false"; ?></span>
                                        <?php endif;?>
                                        </a>
                                    </div>   -->
                                <div id="collapse_<?php echo $val['subcat_id'];?>" class="panel-collapse collapse<?php if($tuyen == 1){ echo ' in';}?>" role="tabpanel" aria-labelledby="heading_<?php echo $val['subcat_id'];?>">
                                    <div class="panel-body" style="padding:0px 10px;">
                                        <?php if (is_array($val['sub_item']) && count($val['sub_item'])>=1):?>
                                            <?php $x=0;?>
                                            <?php foreach ($val['sub_item'] as $val_addon):?>
                                                <?php
                                                $subcat_id=$val['subcat_id'];
                                                $sub_item_id=$val_addon['sub_item_id'];
                                                $multi_option_val=$val['multi_option'];

                                                /** fixed select only one addon*/
                                                if ( $val['multi_option']=="custom" || $val['multi_option']=="multiple"){
                                                    $sub_item_name="sub_item[$subcat_id][$x]";
                                                } else $sub_item_name="sub_item[$subcat_id][]";

                                                $sub_addon_selected='';
                                                $sub_addon_selected_id='';

                                                $item_data['sub_item']=isset($item_data['sub_item'])?$item_data['sub_item']:'';
                                                if (array_key_exists($subcat_id,(array)$item_data['sub_item'])){
                                                    $sub_addon_selected=$item_data['sub_item'][$subcat_id];
                                                    if (is_array($sub_addon_selected) && count($sub_addon_selected)>=1){
                                                        foreach ($sub_addon_selected as $val_addon_selected) {
                                                            $val_addon_selected=Yii::app()->functions->explodeData($val_addon_selected);
                                                            if (is_array($val_addon_selected)){
                                                                $sub_addon_selected_id[]=$val_addon_selected[0];
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="row top10" id="myDiv" style="margin-top: 0px;">

                                                    <div class="col-md-5 col-xs-5 border into-row">
                                                        <label>
                                                            <?php
                                                            if ( $val['multi_option']=="custom" || $val['multi_option']=="multiple"):

                                                                echo CHtml::checkBox($sub_item_name,
                                                                    in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
                                                                    ,array(
                                                                        'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],
                                                                        'data-id'=>$val['subcat_id'],
                                                                        'data-option'=>$val['multi_option_val'],
                                                                        'rel'=>$val['multi_option'],
                                                                        'class'=>'sub_item_name sub_item_name_'.$val['subcat_id']
                                                                    ));
                                                            else :
                                                                echo CHtml::radioButton($sub_item_name,
                                                                    in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
                                                                    ,array(
                                                                        'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],
                                                                        'class'=>'sub_item sub_item_name_'.$val['subcat_id']
                                                                    ));
                                                            endif;

                                                            echo "&nbsp;".qTranslate($val_addon['sub_item_name'],'sub_item_name',$val_addon);
                                                            // echo "<p style='display:none' class=".$val['subcat_id'].">".qTranslate($val_addon['item_description'],'item_description',$val_addon)."</p>";
                                                            ?>
                                                        </label>
                                                    </div>  <!--col-->

                                                    <div class="col-md-4 col-xs-4 border into-row myDiv">
                                                        <?php if ($val['multi_option']=="multiple"):?>
                                                            <?php
                                                            $qty_selected=1;
                                                            if (!isset($item_data['addon_qty'])){
                                                                $item_data['addon_qty']='';
                                                            }
                                                            if (array_key_exists($subcat_id,(array)$item_data['addon_qty'])){
                                                                $qty_selected=$item_data['addon_qty'][$subcat_id][$x];
                                                            }
                                                            ?>

                                                            <div class="row quantity-wrap-small myDiv">
                                                                <div class="col-md-3 col-xs-3 border ">
                                                                    <a href="javascript:;" class="green-button inline qty-addon-minus"><i class="ion-minus"></i></a>
                                                                </div>
                                                                <div class="col-md-5 col-xs-5 border">
                                                                    <?php echo CHtml::textField("addon_qty[$subcat_id][$x]",$qty_selected,array(
                                                                        'class'=>"numeric_only left addon_qty",
                                                                        'maxlength'=>5
                                                                    ))?>
                                                                </div>
                                                                <div class="col-md-3 col-xs-3 border ">
                                                                    <a href="javascript:;" class="green-button inline qty-addon-plus"><i class="ion-plus"></i></a>
                                                                </div>
                                                            </div>

                                                        <?php endif;?>
                                                    </div> <!--col-->

                                                    <?php
                                                    /*if ($apply_tax==1 && $tax>0){
                                                        $val_addon['price']=$val_addon['price']+($val_addon['price']*$tax);
                                                    }*/
                                                    ?>
                                                    <div class="col-md-3 col-xs-3 border text-right into-row">
                                                        <span class="hide-food-price">
                                                        <?php echo !empty($val_addon['price'])? FunctionsV3::prettyPrice($val_addon['price']) :"-";?>
                                                        </span>
                                                    </div> <!--col-->

                                                </div> <!--row-->
                                                <div>
                                                    <?php echo "<p style='display:none' class=".$val['subcat_id'].">".qTranslate($val_addon['item_description'],'item_description',$val_addon)."</p>"; ?>
                                                </div>
                                                <?php $x++;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                <?php endif;?>
            </div><!-- .sub-item-rows-->
            <!--FOOD ADDON-->

            <?php if ($disabled_website_ordering==""):?>
                <div class="section-label top25">
                    <a class="section-label-a">
                        <span class="bold">
                        &nbsp;
                        </span>
                        <b></b>
                    </a>
                </div>
                <div class="row food-item-actions">
                    <div class="col-md-4 col-xs-4 border into-row "></div>
                    <div class="col-md-4 col-xs-4 border into-row">
                        <a href="javascript:close_fb();" class="center upper-text green-button inline"><?php echo t("Close")?></a>
                    </div>
                    <div class="col-md-4 col-xs-4 border into-row">

                        <input type="submit" value="<?php echo empty($row)?Yii::t("default","add to cart"):Yii::t("default","update cart");?>"
                               class="add_to_cart orange-button upper-text">
                    </div>
                </div>
            <?php endif;?>

        </div> <!--view-item-wrap-->
    </form>
<?php else :?>
    <p class="text-danger"><?php echo Yii::t("default","Sorry but we cannot find what you are looking for.")?></p>
<?php endif;?>
<script type="text/javascript">

    function myfunction(obj){

        var val = $('#'+obj).text();
        if(val=="Show Desc"){
            $('#'+obj).text('Hide Desc');
        }
        else{
            $('#'+obj).text('Show Desc');
        }
        $('.'+obj).slideToggle(1000);
    }

    jQuery(document).ready(function() {


        var hide_foodprice=$("#hide_foodprice").val();
        if ( hide_foodprice=="yes"){
            $(".hide-food-price").hide();
            $("span.price").hide();
            $(".view-item-wrap").find(':input').each(function() {
                $(this).hide();
            });
        }


        var price_cls=$(".price_cls:checked").length;
        if ( price_cls<=0){
            var x=0
            $( ".price_cls" ).each(function( index ) {
                if ( x==0){
                    dump('set check');
                    $(this).attr("checked",true);
                }
                x++;
            });
        }


        if ( $(".food-gallery-wrap").exists()){
            $('.food-gallery-wrap').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                    verticalFit: true,
                    titleSrc: function(item) {
                        return '';
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                }
            });

        }

        $( document ).on( "change", ".qty", function() {
            var value = parseInt($(this).val());
            if ( value<=0){
                $(this).val(1);
            }
        });

    });	 /*END READY*/
</script>





<script>


    $('.myDiv').click(function ()
    {
        if($(this).find('div:first input:radio').is(':checked')){
            $(this).find('div:first input:radio').prop('checked', false)
        }
        else{
            $(this).find('div:first input:radio').prop('checked', true)
        }
    });

    $('.myDiv').click(function ()
    {
        if($(this).find('div:first input:checkbox').is(':checked')){
            $(this).find('div:first input:checkbox').prop('checked', false)
        }
        else{
            $(this).find('div:first input:checkbox').prop('checked', true)
        }
    });



    $('.myDiv').click(function ()
    {
        if($(this).find('div:first input:radio').is(':checked')){
            $(this).find('div:first input:radio').prop('checked', false)
        }
        else{
            $(this).find('div:first input:radio').prop('checked', true)
        }
    });


</script>