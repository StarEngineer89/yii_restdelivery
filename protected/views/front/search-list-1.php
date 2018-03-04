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

<div id="search-listview" class="col-md-6 border infinite-item <?php echo $delivery_fee!=true?'free-wrap':'non-free'; ?>">
    <div class="inner">

        <?php if ( $val['is_sponsored']==2):?>
            <div class="ribbon"><span><?php echo t("Sponsored")?></span></div>
        <?php endif;?>

        <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
            <div class="ribbon-offer"><span><?php echo $offer;?></span></div>
        <?php endif;?>

        <!--<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" >-->
        <a href="<?php echo Yii::app()->createUrl("/menu-". trim($val['restaurant_slug']))?>">
            <img class="logo-medium"src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>">
        </a>

        <h2 class="concat-text"><?php echo clearString($val['restaurant_name'])?></h2>
        <p class="merchant-address concat-text"><?php echo $val['merchant_address']?></p>

        <div class="mytable">
            <div class="mycol a">
                <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>
                <p><?php echo $ratings['votes']." ".t("Reviews")?></p>
            </div>
            <div class="mycol b">
                <?php //echo FunctionsV3::prettyPrice($val['minimum_order'])?>
                <?php echo FunctionsV3::prettyPrice($min_fees)?>
                <p><?php echo t("Minimum Order")?></p>
            </div>
        </div> <!--mytable-->

        <div class="top25"></div>

        <?php echo FunctionsV3::merchantOpenTag($merchant_id)?>

        <?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?>

        <p class="top15 cuisine concat-text">
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

        <?php  if($show_delivery_info):// if($val['service']!=3):?>
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

        <?php echo FunctionsV3::displayServicesList($val['service'])?>
<!--        --><?php //$isMerchantOpen = Yii::app()->functions->isMerchantOpen($merchant_id) ?>

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

        <?php $merchantServices = Yii::app()->functions->Services()[FunctionsV3::getMerchantServices($merchant_id)] ?>
        <?php $merchantServices = explode(' ', $merchantServices) ?>

        <?php if (in_array('Pickup', $merchantServices)): ?>
            <div class="">
                <?php $isMerchantOpenPickup = Yii::app()->functions->isMerchantOpenPickup($merchant_id) ?>
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
            </div>
        <?php endif; ?>

        <?php if (in_array('Delivery', $merchantServices)): ?>
            <div class="">
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
            </div>
        <?php endif; ?>


    </div> <!--inner-->
</div> <!--col-->