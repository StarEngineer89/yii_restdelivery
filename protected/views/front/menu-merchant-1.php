<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<script>


//if ($(window).width() < 1024) {
	//$(".items-row").hide();
//};

//$(window).on("resize", function() {
	//if ($(window).width() < 1024) {
		//$(".items-row").hide();
	//}
	//else {
		//$("items-row.").show();
	//}
//});
</script>

<script>

jQuery(document).ready(function(){
    
    
    if (jQuery(window).width() <= 1024) {
        jQuery(".items-row").css("display", "none");
       
       
        
    }  
});

jQuery(window).resize(function () {
        if (jQuery(window).width() <=1024) {
            jQuery(".items-row").append();
           
            
        }
        
         });
</script>


<style>



@media only screen and (max-width: 1024px) and (min-width: 300px) {
    /* For tablets: */
    .items-row{
    display:none;
    
    
    }
}

</style>


<style>
@media screen and (max-width: 1024px) and (min-width: 300px) {
   .mobi {
        background-color:#fff; 
       position:fixed;
       width: 100%;
       margin-top:-2px;
       padding-bottom:10px;
    }
}

@media screen and (max-width: 1024px) and (min-width: 300px) {
   .logomobi {
        
       margin-top:13px;
       
    }
    .log{
    margin-top:5px;
    }
    
    .menu-top-menu{
    
     margin-top:60px;
    }
    
    .logo-small, .logo-medium {
    margin: auto;
    max-width: 100px;
    min-width: 100px;
    margin-left: 5px;
    margin-top: 50px;
    }
}

@media only screen and (min-width:1024px) {
        .expand {
            display:none !important;
        }

 .rightdiv {
            font-size:30px;
            color:#F75D34;
            margin-top:0px;
        }
}

@media only screen and (max-width:1024px) {
        .rightdiv {
            font-size:30px;
            color:#F75D34;
            margin-top:-25px;
        }


}
</style>


<?php if(is_array($menu) && count($menu)>=1):?>

<?php 
/*dump($merchant_apply_tax);
dump($merchant_tax);*/
?>


<?php foreach ($menu as $val):?>
<div class="menu-1 box-grey rounded " style="margin-top:0;">

  <div class="menu-cat cat-<?php echo $val['category_id']?>"  >
     <a href="javascript:;">  
     <div class="row">     
       <span class="bold pull-left" style="mergin-left:30px">
   
         
         <?php echo qTranslate($val['category_name'],'category_name',$val)?>
         
          </span>
        
        
         <span style="text-align:center;" class="expand"><p id="<?php echo $val['category_id']?>" onclick="hide_expand(<?php echo $val['category_id']?>);" style="text-align:center;margin-top:-20px">Tap To Expand </p>  </span>
         
         
          <span class="bold pull-right rightdiv">
         
        <i class="<?php echo $tc==2?"ion-ios-arrow-up":'ion-ios-arrow-down'?>" style="font-size:30px;color:#F75D34;"></i>
       </span>
       </div>
       </a>
          
     <?php $x=0?>
     
    
     

      <div class="items-row <?php echo $tc==2?"hide":''?>">
    
     <?php if (!empty($val['category_description'])):?>
     <p class="small">
       <?php echo qTranslate($val['category_description'],'category_description',$val)?>
     </p>
     <?php endif;?>
     <?php echo Widgets::displaySpicyIconNew($val['dish'],"dish-category")?>
     
     <?php if (is_array($val['item']) && count($val['item'])>=1):?>
     <?php foreach ($val['item'] as $val_item):?>
     

     	<?php if(is_array($val_item['prices']) && count($val_item['prices'])>1):?>
     	<div class="row   even <?php echo $x%2?'odd':'even'?>" id="myP1">
    
        <div class="col-md-12 col-xs-12 border">
          <b><?php echo qTranslate($val_item['item_name'],'item_name',$val_item)?></b>
          <p><?php echo stripslashes($val_item['item_description'])?></p>
        </div>
        </div>
        <?php endif;?>
        <?php $tp=1;?>
        <?php $y = 0; $sizes = $val_item['prices']; ?>
        <?php $arrayOfList = FunctionsV3::getItemFirstPrice($val_item['prices'],$val_item['discount'],$merchant_apply_tax,$merchant_tax); ?>
        <?php if(is_array($arrayOfList) && count($arrayOfList)>=1):?>
        <?php foreach ($arrayOfList as $vallistitem):?>
        <?php  $size_Id=$sizes[$y]['size_id'];//Functions::getSizeTranslation($sizes[$y]['size'],$val_item['merchant_id']); //echo $sizes[$y]['size'];  ?>
        <?php $y++;?>
		<?php $pieces = explode("£", $vallistitem);?>
        <div class="row">
        	<?php if(is_array($arrayOfList) && count($arrayOfList)>1):?>	
        	<div class="col-sm-7 col-xs-7 food-price-wrap border">
        		<?php echo $pieces[0]; //echo "$vallistitem"; ?>
				<?php $tp=(strpos(strtoupper($vallistitem), 'SIMPLE') !== false)?11:$tp;?>
			
        	</div>
			<div class="col-sm-3 col-xs-3 food-price-wrap border">
        		<?php echo "£".$pieces[1]; //echo "$vallistitem"; ?>				
			
        	</div>
			<?php else :?>			
				<div class="<?php echo $x%2?'odd':'even'?>" >
    
				<div class="col-md-7 col-xs-7 border" >
					<b><?php echo qTranslate($val_item['item_name'],'item_name',$val_item)?></b>
					<p><?php echo stripslashes($val_item['item_description'])?></p>
				</div>
				<div class="col-sm-3 col-xs-3 food-price-wrap border">
        		<?php echo "$vallistitem"; ?>
				<?php $tp=(strpos(strtoupper($vallistitem), 'SIMPLE') !== false)?11:$tp;?>
				
				</div>
				</div>
			<?php endif;?>
            <?php
            $atts='';
            if ( $val_item['single_item']==2){
                $atts.='data-price="'.$pieces[1].'"';
                $atts.=" ";
                $atts.='data-size="'.$pieces[0].'"';
            }
            ?>
            <div class="col-sm-2 col-xs-2 relative food-price-wrap border">
          <?php if ( $disabled_addcart==""):?>
          
          <a href="javascript:;" class="dsktop menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?>" 
            rel="<?php echo $val_item['item_id']?>" sizeid="<?php echo $size_Id;//FunctionsV3::encryptIt($size_Id);?>" tp="<?php echo $tp?>" price="<?php echo str_replace(' ','~',"$vallistitem");?>"
            data-single="<?php echo $val_item['single_item']?>" 
            <?php echo $atts;?>
            data-category_id="<?php echo $val['category_id']?>"
           >
          
           <i class="ion-ios-plus-outline green-color bold"></i>
          </a>
         
          <a href="javascript:;" class="mbile menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?>" 
            rel="<?php echo $val_item['item_id']?>" tp="<?php echo $tp?>" sizeid="<?php echo $size_Id;//FunctionsV3::encryptIt($size_Id);?>" price="<?php echo str_replace(' ','~',"$vallistitem");?>"
            data-single="<?php echo $val_item['single_item']?>" 
            <?php echo $atts;?>
            data-category_id="<?php echo $val['category_id']?>"
          >
           <i class="ion-ios-plus-outline green-color bold"></i>
          </a>
         
          <?php endif;?>
        </div>
        </div> <!--row-->
        <?php $tp++;?>
        <?php endforeach;?>
        <?php endif;?>
       <?php $tp=0;?>
        
     
     <?php $x++?>
     <?php endforeach;?>
    <?php else :?> 
      <p class="small text-danger"><?php echo t("no item found on this category")?></p>
     <?php endif;?>
    </div> 
    
  </div> <!--menu-cat-->

</div> <!--menu-1-->
<?php endforeach;?>

<?php else :?>
<p class="text-danger"><?php echo t("This restaurant has not published their menu yet.")?></p>
<?php endif;?>





