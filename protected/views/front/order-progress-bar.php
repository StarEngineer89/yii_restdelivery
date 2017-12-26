<?php
$kr_merchant_slug=isset($_SESSION['kr_merchant_slug'])?$_SESSION['kr_merchant_slug']:'';

if (isset($_SESSION['search_type'])){
	switch ($_SESSION['search_type']) {
		case "kr_search_foodname":			
			$search_key='foodname';
			$search_str= isset($_SESSION['kr_search_foodname'])?$_SESSION['kr_search_foodname']:'';
			break;
			
		case "kr_search_category":			
			$search_key='category';
			$search_str=isset($_SESSION['kr_search_category'])?$_SESSION['kr_search_category']:'';
			break;
			
		case "kr_search_restaurantname":
			$search_str=isset($_SESSION['kr_search_restaurantname'])?$_SESSION['kr_search_restaurantname']:'';
			$search_key='restaurant-name';
			break;	
		
		case "kr_search_streetname":
			$search_str=isset($_SESSION['kr_search_streetname'])?$_SESSION['kr_search_streetname']:'';
			$search_key='street-name';
			break;	

		case "kr_postcode":	
		    $search_str=isset($_SESSION['kr_postcode'])?$_SESSION['kr_postcode']:'';
		    $search_key='zipcode';
			break;	
			
		default:
			$search_str=isset($_SESSION['kr_search_address'])?$_SESSION['kr_search_address']:'';
			$search_key='s';
			break;
	}
}
?>

<?php if ($show_bar):?>
<div class="order-progress-bar"<?php if(isset($_GET['iframe'])){echo ' style="position:fixed;z-index:999;width:100%"';}?>>
  <div class="container">
      <div class="row">
        <?php
        if(!isset($_GET['iframe'])):
        ?>
        <div class="col-md-2 col-xs-2 ">
          <a class="active" href="<?php echo Yii::app()->createUrl('/store')?>"><?php echo t("Search")?></a>  
        </div>
        
        <div class="col-md-2 col-xs-2 ">
           <a class="<?php echo $step>=2?"active":"inactive"; echo $step==2?" current":"";?>" 
           href="<?php echo Yii::app()->createUrl('store/searcharea',array($search_key=>$search_str))?>">
           <?php echo t("Browse Shops")?></a>
        </div>
        <?php
        endif;
        ?>
        <div class="col-md-2 col-xs-2">
        <a class="<?php echo $step>=3?"active":"inactive"; echo $step==3?" current":"";?> "
         href="<?php echo Yii::app()->createUrl('/menu-'.$kr_merchant_slug.((isset($_GET['iframe'])?'?iframe':'')))?>">
        <?php echo t("Create your order")?></a>
        </div>
        
        <div class="col-md-2 col-xs-2 ">
        <?php if(isset($guestcheckout) && $guestcheckout==TRUE):?>
        <a class="<?php echo $step>=4?"active":"inactive"; echo $step==4?" current":"";?> "
         href="<?php echo Yii::app()->createUrl('store/guestcheckout'.((isset($_GET['iframe'])?'?iframe':'')))?>"><?php echo t("Payment information")?></a>
        <?php else :?>
        <a class="<?php echo $step>=4?"active":"inactive"; echo $step==4?" current":"";?> "
         href="<?php echo Yii::app()->createUrl('store/paymentoption'.((isset($_GET['iframe'])?'?iframe':'')))?>"><?php echo t("Payment information")?></a>
        <?php endif;?>
        </div>
        
        <div class="col-md-2 col-xs-2 ">
        <a class="<?php echo $step>=5?"active":"inactive"; echo $step==5?" current":"";?> "
         href="javascript:;"><?php echo t("Confirm Order")?></a>
        </div>
        
        <div class="col-md-2 col-xs-2 ">
        <a class="<?php echo $step>=6?"active":"inactive"; echo $step==6?" current":"";?> "
         href="javascript:;"><?php echo t("Receipt")?></a>
        </div>
          <?php
          if(isset($_GET['iframe'])):
              ?>
              <div class="cart-mobile-handle border relative" style="top:-10px;">
                  <div class="badge cart_count" style="font-size: 11px;padding: 2px 4px;right: 15px;top:15px;"></div>
                  <a href="/cart?iframe" class="selected">
                      <i class="ion-ios-cart" style="color:#fff;"></i>
                  </a>
              </div>
              <?php
          endif;
          ?>
        
      </div><!-- row-->
  </div> <!--container-->
  
   <div class="border progress-dot mytable">
    <?php
    if(!isset($_GET['iframe'])):
    ?>
     <a href="<?php echo Yii::app()->createUrl('/store')?>" class="mycol selected" ><i class="ion-record"></i></a>
    <?php
        endif;
        ?>
     <a href="javascript:;" class="mycol 
     <?php echo $step>=2?"selected":'';?>" ><i class="ion-record"></i></a>
     
     <a href="javascript:;" class="mycol <?php echo $step>=3?"selected":'';?>" ><i class="ion-record"></i></a>
     
     <a href="javascript:;" class="mycol <?php echo $step>=4?"selected":'';?>"><i class="ion-record"></i></a>
    <?php
    if(isset($_GET['iframe'])):
    ?>
        <div class="cart-mobile-handle border relative" style="top:2px;">
            <div class="badge cart_count" style="font-size: 11px;padding: 2px 4px;right: 5px;"></div>
            <a href="/cart?iframe" class="selected">
                <i class="ion-ios-cart"></i>
            </a>
        </div>
    <?php
    endif;
    ?>
  </div> <!--end progress-dot-->
  
</div> <!--order-progress-bar-->
<?php endif;?>