<style>
@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.Dskdiv {

display:none;


}
</style>

<style>

@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.mapid,.Delivery {

display:none;


}

}


@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.mapid,.Delivery {

display:none;


}

}

@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.mobidiv {

display:none;


}

}


@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.miniorder {
margin-top:-5px;
font-size: 9px;
color:#F75D34;


}

}

@media only screen and (max-width: 1024px) and (min-width: 300px)  {

.resname {

font-size: 10px;
font-weight: bold;
color:#EB1E78;

margin-right:100px;

}
.cuisine{
font-size: 9px;
margin-top:-5px;

margin-right:50px;;
color:#00B279;
}

.rat{

    margin-top: -10px;
    margin-left: -75px;

}


}

@media only screen and (max-width: 1024px) and (min-width:600px)  {
.rat{

margin-top:-10px;
margin-left:-20px;

}
}

@media screen and (min-width:480px) and (max-width:600px) {
.mbilediv{
display:none;

}
}

@media screen and (min-width:800px) {
.mbilediv{
display:none;
}
}

@media only screen and (max-width: 1024px) and (min-width: 600px)  {
.rat{

    margin-top: -10px;
    margin-left: -240px;

}
}

</style>
<div class="result-merchant infinite-container" id="restuarant-list">
<?php foreach ($list['list'] as $val):?>
<?php
$merchant_id=$val['merchant_id'];
$ratings=Yii::app()->functions->getRatings($merchant_id);   
$merchant_delivery_distance=getOption($merchant_id,'merchant_delivery_miles');
$distance_type='';

/*fallback*/
if ( empty($val['latitude'])){
	if ($lat_res=Yii::app()->functions->geodecodeAddress($val['merchant_address'])){        
		$val['latitude']=$lat_res['lat'];
		$val['lontitude']=$lat_res['long'];
	} 
}
?>
<div class="infinite-item">
   <div class="inner Dskdiv">
   
   <?php if ( $val['is_sponsored']==2):?>
       <div class="ribbon"><span><?php echo t("Sponsored")?></span></div>
    <?php endif;?>
    
    <div class="ribbons">
        <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
            <div class="ribbon-offer">
                <span><?php echo $offer;?></span>
            </div>
        <?php endif;?>

        <?php if (Yii::app()->functions->getOption("merchant_enabled_voucher",$merchant_id) == true): ?>
            <div class="ribbon-voucher">
                <span class="map-label-voucher"><?php echo "Voucher"; ?></span>
            </div>
        <?php endif; ?>
    </div>
   
     <div class="row"> 
        <div class="col-md-6 borderx">
        
         <div class="row borderx" style="padding: 10px;padding-bottom:0;">
             <div class="col-md-3 borderx ">
		       <!--<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>">-->
		       <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
		        <img class="logo-small"src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>">
		       </a>
		       <div class="top10"><?php echo FunctionsV3::displayServicesList($val['service'])?></div>		               
		       
		       <div class="top10">
		         <?php FunctionsV3::displayCashAvailable($merchant_id,true,$val['service'])?>
		       </div>
		       
		     </div> <!--col-->
		     <div class="col-md-9 borderx">		     
		     <div class="mytable">
		         <div class="mycol">
		            <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>   
		         </div>
		         <div class="mycol">
		            <p><?php echo $ratings['votes']." ".t("Reviews")?></p>
		         </div>
		         <div class="mycol">
		            <?php echo FunctionsV3::merchantOpenTag($merchant_id)?>                
		         </div>		         		         		         
		      </div> <!--mytable-->
	       
		      <h5><?php echo clearString($val['restaurant_name'])?></h5>
	          <p class="merchant-address concat-text"><?php echo $val['merchant_address']?></p>   
	          <?php //echo $_SESSION["testQuery"] ?>
                  <?php //echo $_SESSION["testQuery1"] ?>
                  <?php //echo $_SESSION["testQuery2"] ?>
	          <p class="cuisine bold">
              <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
              </p>                
		     
              <p><?php echo t("Minimum Order").": ".FunctionsV3::prettyPrice($val['minimum_order'])?></p>
              
              <?php if($val['service']!=3):?>
              <p><?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
              <?php endif;?>
              
              <p>
		        <?php 
		        if($val['service']!=3){
			        if (!empty($merchant_delivery_distance)){
			        	echo t("Delivery Distance").": ".$merchant_delivery_distance." $distance_type";
			        } else echo  t("Delivery Distance").": ".t("not available");
		        }
		        ?>
		       </p>
		       		       
		       <?php if($val['service']!=3):?>
		        <p class="top15"><?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?></p>
		       <?php endif;?>
		        
		        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>" 
		        class="orange-button rounded3 medium bottom10 inline-block">
		        <?php echo t("View menu")?>
		        </a>
		                      
		     </div> <!--col-->
         </div> <!--row-->         
         
        </div> <!--col-->
        
        <!--MAP-->
        <div class="col-md-6 with-padleft" style="padding-left:0; border-left:1px solid #C9C7C7;" >
          <div class="browse-list-map active" 
		        data-lat="<?php echo $val['latitude']?>" data-long="<?php echo $val['lontitude']?>">
             
          </div> <!--browse-list-map-->
        </div> <!--col-->
        
     </div> <!--row-->
     
      <!--mbilediv-->
<div class="infinite-item mbilediv">
   <div class="inner" style="padding-bottom: 0px;">
   
   <?php if ( $val['is_sponsored']==2):?>
       <div class="ribbon"><span><?php echo t("Sponsored")?></span></div>
    <?php endif;?>
    
    <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
       <div class="ribbon-offer"><span><?php echo $offer;?></span></div>
    <?php endif;?>
   <div class="row">
   <div class="col-md-3 col-xs-3">
   <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
		        <img align="center" style="width:60px; height:60px; padding:5px" src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>" >
		       </a>
   </div>
   <div class="col-md-6 col-xs-9">
    <h5 align="left" class="resname"><?php echo clearString($val['restaurant_name'])?></h5>
    
    <h6 align="left" class="miniorder"><?php echo t("Minimum Order").": ".FunctionsV3::prettyPrice($val['minimum_order'])?></h6>
     <h6 align="left" class="cuisine bold cuisine">
              <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
              </h6>
                              
		     
              <?php if($val['service']!=3):?>
		        <p class="top15 mobidiv "><?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?></p>
		       <?php endif;?>
              
              <?php if($val['service']!=3):?>
              <p class="mobidiv "><?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
              <?php endif;?>
              
              
              
              <p class="mobidiv ">
		        <?php 
		        if($val['service']!=3){
			        if (!empty($merchant_delivery_distance)){
			        	echo t("Delivery Distance").": ".$merchant_delivery_distance." $distance_type";
			        } else echo  t("Delivery Distance").": ".t("not available");
		        }
		        ?>
		       </p>
              
               
              <div class="inline" style="margin-top:5px;"> <p align="left" class="rating-stars pull-left" data-score="<?php echo $ratings['ratings']?>"></p>   <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>" 
		       class="btn btn-danger btn-xs  inline-block  pull-right" style="margin-right:45px;">
		        <?php echo t("View menu")?>
		        </a>
              
              
           </div>
   </div>
   <div class="col-md-3 mapid col-xs-2" >
   <div class="browse-list-map active" 
		        data-lat="<?php echo $val['latitude']?>" data-long="<?php echo $val['lontitude']?>" style="height:250px" >
             
          </div> <!--browse-list-map-->
   </div>

     </div> 
   </div> <!--inner-->
</div> <!--infinite-item-->

<!---endmobilediv-->
   </div> <!--inner-->
   

</div> <!--infinite-item-->
<?php endforeach;?>
</div> <!--result-merchant-->

<div class="search-result-loader">
    <i></i>
    <p><?php echo t("Loading more restaurant...")?></p>
 </div> <!--search-result-loader-->

<?php             
if (isset($cuisine_page)){
	//$page_link=Yii::app()->createUrl('store/cuisine/'.$category.'/?');
	$page_link=Yii::app()->createUrl('store/cuisine/?category='.urlencode($_GET['category']));
} else $page_link=Yii::app()->createUrl('store/browse/?tab='.$tabs);

 echo CHtml::hiddenField('current_page_url',$page_link);
 require_once('pagination.class.php'); 
 $attributes                 =   array();
 $attributes['wrapper']      =   array('id'=>'pagination','class'=>'pagination');			 
 $options                    =   array();
 $options['attributes']      =   $attributes;
 $options['items_per_page']  =   FunctionsV3::getPerPage();
 $options['maxpages']        =   1;
 $options['jumpers']=false;
 $options['link_url']=$page_link.'&page=##ID##';			
 $pagination =   new pagination( $list['total'] ,((isset($_GET['page'])) ? $_GET['page']:1),$options);		
 $data   =   $pagination->render();
 ?>             