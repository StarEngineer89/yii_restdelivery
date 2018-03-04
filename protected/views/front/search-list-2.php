<style>
    @media only screen and (max-width: 1024px) and (min-width: 990pxpx)  {

        .filter-wrap {

            display:block;


        }
    }

    @media only screen and (max-width:990px) and (min-width:200px)  {

        #search-listgrid{

            display:block;

        }
        .Dskdiv {

            display:none;


        }


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
        }

    }

    @media only screen and (max-width: 1024px) and (min-width: 300px)  {

        .resname {
            font-size: 10px;
            width:100%;
            font-weight: bold;
            color:#EB1E78;

            margin-right:100px;

        }
        .cuisine{
            font-size: 9px;
            margin-top:-5px;
            margin-right:50px;;
        }

        .rat{

            margin-top:-20px;

        }


    }

    @media only screen and (max-width: 1024px) and (min-width:600px)  {
        .rat{

            margin-top:-10px;

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


</style>




<?php
$min_fees=FunctionsV3::getMinOrderByTableRates($merchant_id,
    $distance,
    $distance_type_orig,
    $val['minimum_order']
);

$show_delivery_info=false;
if($val['service']==1 || $val['service']==2  || $val['service']==4  || $val['service']==5 ){
    $show_delivery_info=true;
}

?>
<!--mbilediv-->

<!---endmobilediv-->

<div id="search-listgrid" class="infinite-item <?php echo $delivery_fee!=true?'free-wrap':'non-free'; ?>">
    <div class="inner list-view Dskdiv">

        <?php if ( $val['is_sponsored']==2):?>
            <div class="ribbon"><span><?php echo t("Sponsored")?></span></div>
        <?php endif;?>

        <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
            <div class="ribbon-offer"><span><?php echo $offer;?></span></div>
        <?php endif;?>

        <div class="row  ">
            <div class="col-md-2 border logo">
                <!--<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>">-->
                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
                    <img class="logo-small"src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>">
                </a>
                <?php echo FunctionsV3::displayServicesList($val['service']);?>
                <?php FunctionsV3::displayCashAvailable($merchant_id,true,$val['service'])?>
            </div> <!--col-->

            <div class="col-md-7 border">

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

                    <div class="mycol">
                        <!--<p><?php echo t("Minimum Order").": ".FunctionsV3::prettyPrice($val['minimum_order'])?></p>-->
                        <p><?php echo t("Minimum Order").": ".FunctionsV3::prettyPrice($min_fees)?></p>
                    </div>

                </div> <!--mytable-->

                <h5 style="color:#D73F89"><?php echo clearString($val['restaurant_name'])?></h5>
                <p class="merchant-address concat-text"><?php echo $val['merchant_address']?></p>

                <p class="cuisine">
                    <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
                </p>

                <p>
                    <?php
                    if(!$search_by_location){
                        if ($distance){
                            echo t("Distance").": ".number_format($distance,1)." $distance_type";
                        } else echo  t("Distance").": ".t("not available");
                    }
                    ?>
                </p>

                <?php //if($val['service']!=3):?>
                <?php if($show_delivery_info):?>
                    <p><?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
                <?php endif;?>

                <p>
                    <?php
                    //if($val['service']!=3){
                    if($show_delivery_info){
                        if (!empty($merchant_delivery_distance)){
                            echo t("Delivery Distance Covered").": ".$merchant_delivery_distance." $distance_type_orig";
                        } else echo  t("Delivery Distance Covered").": ".t("not available");
                    }
                    ?>
                </p>

                <p>
                    <?php
                    //if($val['service']!=3){
                    if($show_delivery_info){
                        if ($delivery_fee){
                            echo t("Delivery Fee").": ".FunctionsV3::prettyPrice($delivery_fee);
                        } else echo  t("Delivery Fee").": ".t("Free Delivery");
                    }
                    ?>
                </p>

                <p class="top15"><?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?></p>

            </div> <!--col-->

            <div class="col-md-3 relative border" style="margin-top:-14px">

                <!--<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" -->

                <!--        --><?php //$isMerchantOpen = Yii::app()->functions->isMerchantOpen($merchant_id) ?>
                <?php $isMerchantOpenPickup = Yii::app()->functions->isMerchantOpenPickup($merchant_id) ?>

                <?php $merchantServices = Yii::app()->functions->Services()[FunctionsV3::getMerchantServices($merchant_id)] ?>
                <?php $merchantServices = explode(' ', $merchantServices) ?>

                <?php if (in_array('Pickup', $merchantServices)): ?>
                    <?php if ($isMerchantOpenPickup): ?>
                        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=pickup"
                           class="orange-button rounded3 medium">
                            <i class="collection-btn"></i>
                            <span><?php echo t("Order A Collection")?></span>
                        </a>
                    <?php else: ?>
                        <?php $merchantPickupTimes = FunctionsV3::getMerchantPickupTime($merchant_id) ?>
                        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=pickup"
                           class="orange-button rounded3 medium">
                            <i class="collection-btn"></i>
                            <span>
                                <?php if ($merchantPickupTimes == "holiday"): ?>
                                    <?php echo t("Holiday")?>
                                <?php else: ?>
                                    <?php echo t("Collect From " . $merchantPickupTimes[0]) ?>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (in_array('Delivery', $merchantServices)): ?>
                    <?php $isMerchantOpenDelivery = Yii::app()->functions->isMerchantOpenDelivery($merchant_id) ?>
                    <?php if ($isMerchantOpenDelivery): ?>
                        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=delivery"
                           class="orange-button rounded3 medium">
                            <i class="delivery-btn"></i>
                            <span><?php echo t("Order A Delivery")?></span>
                        </a>
                    <?php else: ?>
                        <?php $merchantOpenTimes = FunctionsV3::getMerchantDeliveryTime($merchant_id) ?>
                        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=delivery"
                           class="orange-button rounded3 medium">
                            <i class="delivery-btn"></i>
                            <span>
                                <?php if ($merchantOpenTimes == "holiday"): ?>
                                    <?php echo t("Holiday")?>
                                <?php else: ?>
                                    <?php echo t("Delivery From " . $merchantOpenTimes[0])?>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Display the countdown timer in an element -->
                <?php $businessHours = FunctionsV3::getMerchantOpenTime($merchant_id) ?>
                <?php $closeTime = date('Y-m-d') . ' ' . $businessHours[1] ?>
                <?php $currentTime = date('Y-m-d H:i:s') ?>
                <?php if (isset($businessHours[1]) && (strtotime($closeTime) > strtotime($currentTime) && strtotime($closeTime) < strtotime($currentTime . '+1 hour'))): ?>
                    <p><?php echo Yii::t('default', 'Closing in ') ?>
                        <span id="countdown-timer_<?php echo $merchant_id ?>" class="countdown-timer" data-time="<?php echo $closeTime ?>"></span>
                        <i class="green-color ion-clock"></i>
                    </p>
                <?php endif; ?>

            </div>
        </div> <!--row-->
    </div> <!--inner-->
</div>  <!--infinite-item-->



<div id="search-listgrid" class="mbilediv infinite-item <?php echo $delivery_fee!=true?'free-wrap':'non-free'; ?>">
    <div class="inner list-view">
        <?php if ( $val['is_sponsored']==2):?>
            <div class="ribbon"><span><?php echo t("Sponsored")?></span></div>
        <?php endif;?>

        <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
            <div class="ribbon-offer"><span><?php echo $offer;?></span></div>
        <?php endif;?>
        <div class="row">
            <div class="col-md-4 col-xs-4 logo">
                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
                    <img align="center" style="width:100%;padding:5px" src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>" >
                </a>

                <p class="bold"  style="font-size:12px;width:100%">
                    <?php
                    if(!$search_by_location){
                        if ($distance){
                            echo t("Distance").": ".number_format($distance,1)." $distance_type";
                        } else echo  t("Distance").": ".t("not available");
                    }
                    ?>
                </p>
            </div>
            <div class="col-md-5 col-xs-8">
                <h5 align="left" class="resname bold"  style="font-size:14px;"><?php echo clearString($val['restaurant_name'])?></h5>
                <h5 align="left" class="resname" ><?php echo FunctionsV3::merchantOpenTag($merchant_id)?></h5>

                <h6 align="left" class="miniorder bold" style="font-size:12px;width:100%"><?php echo t("Minimum Order").": ".FunctionsV3::prettyPrice($val['minimum_order'])?></h6>
                <h6 align="left" class="cuisine bold cuisine" style="font-size:12px;width:100%">
                    <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
                </h6>

                <?php if($val['service']!=3):?>
                    <p class="top15 mobidiv bold "><?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?></p>
                <?php endif;?>

                <?php if($val['service']!=3):?>
                    <p class="mobidiv "><?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
                <?php endif;?>



                <p class="bold" style="font-size:12px;margin-top:-5px;width:100%;display: none;">
                    <?php
                    if($val['service']!=3){
                        if (!empty($merchant_delivery_distance)){
                            echo t("Delivery Distance").": ".$merchant_delivery_distance." $distance_type";
                        } else echo  t("Delivery Distance").": ".t("not available");
                    }
                    ?>
                </p>

                <p class="bold" style="font-size:12px;width:100%">

                    <?php
                    //if($val['service']!=3){
                    if($show_delivery_info){
                        if ($delivery_fee){
                            echo t("Delivery Fee").": ".FunctionsV3::prettyPrice($delivery_fee);
                        } else echo  t("Delivery Fee").": ".t("Free Delivery");
                    }
                    ?>
                </p>

                <p align="left" class="rating-stars pull-left" data-score="<?php echo $ratings['ratings']?>"></p><br/>

            </div>


            <div class="col-md-3 mapid col-xs-2" >
                <div class="browse-list-map active"
                     data-lat="<?php echo $val['latitude']?>" data-long="<?php echo $val['lontitude']?>" style="height:250px" >

                </div> <!--browse-list-map-->
            </div>

            <div class="col-md-12 col-xs-12 btn-box">

                <!--        --><?php //$isMerchantOpen = Yii::app()->functions->isMerchantOpen($merchant_id) ?>
                <?php $merchantServices = Yii::app()->functions->Services()[FunctionsV3::getMerchantServices($merchant_id)] ?>
                <?php $merchantServices = explode(' ', $merchantServices) ?>

                <center>
                    <div class="btns">
                        <?php if (in_array('Pickup', $merchantServices)): ?>
                            <?php $isMerchantOpenPickup = Yii::app()->functions->isMerchantOpenPickup($merchant_id) ?>
                            <?php if ($isMerchantOpenPickup): ?>
                                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=pickup"
                                   class="orange-button rounded3 medium">
                                    <i class="collection-btn"></i>
                                    <span><?php echo t("Order Collection")?></span>
                                </a>
                            <?php else: ?>
                                <?php $merchantPickupTimes = FunctionsV3::getMerchantPickupTime($merchant_id) ?>
                                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=pickup"
                                   class="orange-button rounded3 medium">
                                    <i class="collection-btn"></i>
                                    <span>
                            <?php if ($merchantPickupTimes == "holiday"): ?>
                                <?php echo t("Holiday")?>
                            <?php else: ?>
                                <?php echo t("Collect From " . $merchantPickupTimes[0]) ?>
                            <?php endif; ?>
                        </span>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (in_array('Delivery', $merchantServices)): ?>
                            <?php $isMerchantOpenDelivery = Yii::app()->functions->isMerchantOpenDelivery($merchant_id) ?>
                            <?php if ($isMerchantOpenDelivery): ?>
                                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=delivery"
                                   class="orange-button rounded3 medium">
                                    <i class="delivery-btn"></i>
                                    <span><?php echo t("Order Delivery")?></span>
                                </a>
                            <?php else: ?>
                                <?php $merchantOpenTimes = FunctionsV3::getMerchantDeliveryTime($merchant_id) ?>
                                <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>?option-type=delivery"
                                   class="orange-button rounded3 medium">
                                    <i class="delivery-btn"></i>
                                    <span>
                            <?php if ($merchantOpenTimes == "holiday"): ?>
                                <?php echo t("Holiday")?>
                            <?php else: ?>
                                <?php echo t("Delivery From " . $merchantOpenTimes[0])?>
                            <?php endif; ?>
                        </span>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </center>

                <!-- Display the countdown timer in an element -->
                <?php $businessHours = FunctionsV3::getMerchantOpenTime($merchant_id) ?>
                <?php $closeTime = date('Y-m-d') . ' ' . $businessHours[1] ?>
                <?php $currentTime = date('Y-m-d H:i:s') ?>
                <?php if (isset($businessHours[1]) && (strtotime($closeTime) > strtotime($currentTime) && strtotime($closeTime) < strtotime($currentTime . '+1 hour'))): ?>
                    <p><?php echo Yii::t('default', 'Restaurant closing in ') ?>
                        <span id="countdown-timer_<?php echo $merchant_id ?>" class="countdown-timer" data-time="<?php echo $closeTime ?>"></span>
                        <i class="green-color ion-clock"></i>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div> <!--inner-->
</div> <!--infinite-item-->

<!---endmobilediv-->

