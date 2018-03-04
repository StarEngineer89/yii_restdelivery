<style type="text/css">
    .box {
        color: #000000;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    .red {
        background: #fff;
    }
    .required {
        clear: both;
        display: inline-block;
        font-size: 12px;
        color: red;
        white-space: nowrap;
    }
</style>
<?php
if(!isset($_GET['iframe'])){
    $this->renderPartial('/front/default-header', array(
        'h1'       => t("Confirm & Pay"),
        'sub_text' => t("please review your order below")
    ));
}
else {
	Yii::app()->clientScript->registerScriptFile('/assets/vendor/iframeResizer/iframeResizer.contentWindow.min.js');
}
?>
<?php
$this->renderPartial('/front/order-progress-bar', array(
    'step'          => isset($step) ? $step : 5,
    'show_bar'      => true,
    'guestcheckout' => isset($guestcheckout) ? $guestcheckout : false
));


?>
<form id="frm-delivery" class="frm-delivery" method="POST" onsubmit="return false;">
    <?php
    //dump($data);
    $mtid = isset($data['merchant_id']) ? $data['merchant_id'] : '' && ($data['authKey']) ? $data['authKey'] : 'authKey';
    
   
    //$mtid=isset($data['authKey'])?$data['authKey']:'';
    echo CHtml::hiddenField('action', 'placeOrder');
    foreach ($data as $key => $val) {
        switch ($key) {
            case "authKey":
                echo CHtml::inputfield($key, true, array(
                    'value' => $val,
                    'class' => "hide_inputs"
                ));
                break;

            case "payment_opt":
                echo CHtml::radioButton($key, true, array(
                    'value' => $val,
                    'class' => "payment_option hide_inputs"
                ));
                break;

            case "payment_provider_name":
                echo CHtml::radioButton($key, true, array(
                    'value' => $val,
                    'class' => "hide_inputs"
                ));
                break;
                break;

            case "cc_id":
                echo CHtml::radioButton($key, true, array(
                    'value' => $val,
                    'class' => "cc_id hide_inputs"
                ));
                break;

            case "card_fee":
                $cs = Yii::app()->getClientScript();
                $cs->registerScript(
                    'card_fee',
                    "var card_fee='$val';",
                    CClientScript::POS_HEAD
                );
                break;

            default:
                echo CHtml::hiddenField($key, $val);
                break;
        }
    }

    $transaction_type = isset($data['delivery_type']) ? $data['delivery_type'] : '';

    switch ($transaction_type) {
        case "delivery":
            $header_1 = 'Delivery information';
            $header_2 = 'Delivery Address';
            $label_1 = 'Delivery Date';
            $label_2 = 'Delivery Time';

            $address = $data['street'];
            if (isset($data['area_name']) && $data['area_name']) {
                $address .= ' ' . $data['area_name'];
            }
            if (isset($data['city']) && $data['city']) {
                $address .= ' ' . $data['city'];
            }
            if (isset($data['state']) && $data['state']) {
                $address .= ' ' . $data['state'];
            }
            if (isset($data['zipcode']) && $data['zipcode']) {
                $address .= ' ' . $data['zipcode'];
            }

            if (isset($data['address_book_id'])) {
                if ($address_book = Yii::app()->functions->getAddressBookByID($data['address_book_id'])) {
                    $address = $address_book['street'];
                    $address .= " " . $address_book['city'];
                   $address .= " " . $address_book['state'];
                   $address .= " " . $address_book['zipcode'];
                   $address .= " " . $address_book['country_code'];
                    
                }
            }
            

            if (isset($data['map_address_lat'])) {
                if (!empty($data['map_address_lat'])) {
                    $lat_res = FunctionsV3::latToAdress($data['map_address_lat'], $data['map_address_lng']);
                    if ($lat_res) {
                        $address = $lat_res['formatted_address'];
                    }
                }
            }

            break;

        case "pickup":
            $header_1 = 'Pickup information';
            $header_2 = 'Pickup Address';
            $label_1 = 'Pickup Date';
            $label_2 = 'Pickup Time';

          //$address = '';
           //if ($merchant_info = FunctionsV3::getMerchantInfo($mtid)) {
              // $address = $merchant_info['complete_address'];
           // }
            
           
$merchant_address='';		
if ($merchant_info=Yii::app()->functions->getMerchant($s['kr_merchant_id'])){	

	$merchant_address=$merchant_info['street']." ".$merchant_info['city']." ".$merchant_info['state'];
	$merchant_address.=" "	. $merchant_info['post_code'];
}

//echo $merchant_address;
           
            
            
            break;

        case "dinein":
            $header_1 = 'Dine in information';
            $header_2 = 'Dine in Address';
            $label_1 = 'Dine in Date';
            $label_2 = 'Dine in Time';
            $address = '';
            if ($merchant_info = FunctionsV3::getMerchantInfo($mtid)) {
                $address = $merchant_info['complete_address'];
            }
            break;

        default:
            break;
    }
    if (!isset($s['kr_delivery_options'])) {
        $s['kr_delivery_options'] = '';
    }

    if (!isset($data['is_guest_checkout'])) {
        $data['is_guest_checkout'] = '';
    }

    //dump($data);
    ?>
    <div class="sections section-grey2 section-confirmorder">
        <div class="container">
        <div class="row" style="margin-left:-15px">
       <div class="col-md-3 border">

<a class="backbuttononly orange-button rounded3 medium bottom10 inline-block" href="<?php echo $guestcheckout == true ? Yii::app()->createUrl('/store/guestcheckout') : Yii::app()->createUrl('/store/paymentoption')?>"><i class="ion-ios-arrow-thin-left"></i> <?php echo t("Go Back")?></a>

<!--<a href="javascript: history.go(-1)" class="place_order green-button medium inline blocks"><i class="ion-ios-arrow-thin-left"></i> <?php echo t("Go Back")?></a>-->
</div> 

 
 
 <div class="col-md-9 border">  </div> 
 </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="box-grey rounded">

                        <?php if ($data['is_guest_checkout'] == 2): ?>
                            <?php FunctionsV3::sectionHeader("Customer Information") ?>
                            <table class="table-order-details">
                                <tr>
                                    <td class="a"><?php echo t("Name") ?></td>
                                    <td class="b">: <?php echo $data['first_name'] . " " . $data['last_name'] ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>

                        <?php FunctionsV3::sectionHeader($header_1) ?>
                        <table class="table-order-details">
                            <tr>
                                <td class="a"><?php echo t("Merchant Name") ?></td>
                                <td class="b">: <?php echo clearString($merchant_info['restaurant_name']) ?></td>

                                <!--<td class="b">: <?php echo clearString($merchant_info['authKey']) ?></td>-->                                
                            </tr>

                            <?php if (isset($s['kr_delivery_options']['delivery_date'])): ?>
                                <?php if (!empty($s['kr_delivery_options']['delivery_date'])): ?>
                                    <tr>
                                        <td class="a"><?php echo t($label_1) ?></td>
                                        <td class="b">: <?php echo FunctionsV3::prettyDate($s['kr_delivery_options']['delivery_date']) ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (isset($s['kr_delivery_options']['delivery_time'])): ?>
                                <?php if (!empty($s['kr_delivery_options']['delivery_time'])): ?>
                                    <tr>
                                        <td class="a"><?php echo t($label_2) ?></td>
                                        <td class="b">: <?php echo FunctionsV3::prettyTime($s['kr_delivery_options']['delivery_time']) ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($transaction_type == "dinein"): ?>
                                <tr>
                                    <td class="a"><?php echo t("Number of guest") ?></td>
                                    <td class="b">: <?php echo $data['dinein_number_of_guest'] ?></td>
                                </tr>
                                <?php if (!empty($data['dinein_special_instruction'])): ?>
                                    <tr>
                                        <td class="a"><?php echo t("Special instructions") ?></td>
                                        <td class="b">: <?php echo $data['dinein_special_instruction'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (isset($s['kr_delivery_options']['delivery_asap'])): ?>
                                <?php if (!empty($s['kr_delivery_options']['delivery_asap'])): ?>
                                    <tr>
                                        <td class="a"><?php echo t("Delivery Time") ?></td>
                                        <td class="b">: <?php echo t("ASAP") ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        </table>
                        <?php FunctionsV3::sectionHeader($header_2) ?>
                       
                        <?php
                        $merchant_address='';		
if ($merchant_info=Yii::app()->functions->getMerchant($s['kr_merchant_id'])){	

	$merchant_address=$merchant_info['street']." ".$merchant_info['city']." ".$merchant_info['state'];
	$merchant_address.=" "	. $merchant_info['post_code'];
}

                        if($transaction_type == 'pickup'){ ?>
                        
                       <p class="spacer3"><?php echo $merchant_address; ?></p> 
                       <?php } else { ?>
                        <?php $_SESSION['cust_Address'] = $address; ?>
                        <p class="spacer3"><?php echo $address; ?></p>
                       <?php } ?>
                        <?php FunctionsV3::sectionHeader('Payment Information') ?>
                        <p>
                            <?php
                            // $data['payment_opt'] =sap
                            if (array_key_exists($data['payment_opt'], $paymentlist)) {
                                switch ($data['payment_opt']) {
                                    case "cod":
                                        if ($data['delivery_type'] == "pickup") {
                                            echo t("Cash On Pickup");
                                        } elseif ($data['delivery_type'] == "dinein") {
                                            echo t("Pay in person");
                                        } else {
                                            echo t($paymentlist[$data['payment_opt']]);
                                        }
                                        echo '<br><br>';
                                        break;

                                    case "pyr":
                                        if ($data['delivery_type'] == "pickup") {
                                            echo t("Pay On Pickup");
                                        } else {
                                            echo t($paymentlist[$data['payment_opt']]);
                                        }
                                        break;

                                    default:
                                        echo t($paymentlist[$data['payment_opt']]);
                                        break;
                                }
                            } else {
                                echo t($data['payment_opt']);
                            }

                            switch ($data['payment_opt']) {
                                case "cod":
                                    if (!isset($data['order_change'])) {
                                        $data['order_change'] = 0;
                                    }
                                    if ($data['order_change'] > 0) {
                                        echo '<p class="text-muted text-small">' . t("change for") .
                                            " " . FunctionsV3::prettyPrice($data['order_change']) . '</p>';
                                    }
                                    break;
                                case "ocr":
                                    if ($card_info = Yii::app()->functions->getCreditCardInfo($data['cc_id'])) {
                                        echo "<p class=\"text-muted text-small\">" . $card_info['card_name'] . "</p>";
                                        echo "<p class=\"text-muted text-small\">" .
                                            Yii::app()->functions->maskCardnumber($card_info['credit_card_number']) . "</p>";
                                    }
                                    break;

                                default:
                                    break;
                            }
                            ?>
                        </p>
                        <div id="main">
                            <?php if ($data['payment_opt'] == 'sap') { ?>
                                <h2>Add Card Details</h2>
                                <div id="sp-container"></div>
                                <label style="width: 100%;">
                                <?php
                                if($data['delivery_type'] == 'pickup' && $data['payment_opt'] == 'sap'):
                                ?>
                                <div class="section-label"><a class="section-label-a"><span class="bold">Billing Address</span><b></b></a></div>
                                <?php
                                else:
                                ?>
                                <input id="toggle-billing-address" type="checkbox" checked> Billing Address : (<?php
                                    echo $address; ?>) <span class="red">Tick the checkbox to change your billing address</span></label>
                                <?php
                                endif;
                                ?>
                                <div id="billing-address" class="top10">
                                    <div class="form-group row">
                                        <label for="billing-address-1" class="col-sm-4 col-form-label">Address Line 1:</label>
                                        <div class="col-sm-8">
                                            <input id="billing-address-1" type="text" class="form-control" name="billing-address-1">
                                            <span class="required" style="display:none;">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="billing-address-2" class="col-sm-4 col-form-label">Address Line 2:</label>
                                        <div class="col-sm-8">
                                            <input id="billing-address-2" type="text" class="form-control" name="billing-address-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="billing-city" class="col-sm-4 col-form-label">City:</label>
                                        <div class="col-sm-8">
                                            <input id="billing-city" type="text" class="form-control" name="billing-city">
                                            <span class="required" style="display:none;">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="billing-postcode" class="col-sm-4 col-form-label">Postcode:</label>
                                        <div class="col-sm-8">
                                            <input id="billing-postcode" type="text" class="form-control" name="billing-postcode" maxlength="10">
                                            <span class="required" style="display:none;">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- box-grey-->
                   <!-- <a href="<?php echo $guestcheckout == true ? Yii::app()->createUrl('/store/guestcheckout') : Yii::app()->createUrl('/store/paymentoption') ?>" 
                     class="place_order green-button medium inline blocks">
                        <i class="ion-ios-arrow-thin-left"></i> <?php echo t("Go Back") ?>
                    </a>-->
                </div> <!--col-->
                <div class="col-md-5 sticky-div">
                    <div class="box-grey rounded  relative top-line-green">
                        <i class="order-icon your-order-icon"></i>
                        <div class="order-list-wrap">
                            <p class="bold center"><?php echo t("Your Order") ?></p>
                            <div class="item-order-wrap"></div>
                            <div class="text-center top25">
                                <?php if ($data['payment_opt'] == 'sap') { ?>
                                    <button id="submit-card-details" type="button" class="green-button medium inline block">
                                        <?php echo t("Confirm & Pay") ?>
                                    </button>
                                <?php } else { ?>
                                    <a href="javascript:;" class="place_order green-button medium inline block">
                                        <?php echo t("Confirm Order"); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div> <!--order-list-wrap-->
                    </div> <!--box-grey sticky-div-->
                </div> <!--col-->
            </div> <!--row-->
        </div> <!--container-->
    </div><!-- sections-->
</form>
<?php if ($data['payment_opt'] == 'sap') {
    $sagePayToken = FunctionsV3::sagePayToken();
    $merchantSessionKey = '';
    /* get session key */
    $vendor = json_encode(array('vendorName' => $sagePayToken['vendorName']));
    $request = FunctionsV3::sagePayRequest('https://pi-' . $sagePayToken['mode'] . '.sagepay.com/api/v1/merchant-session-keys', $vendor, 'Basic ' . $sagePayToken['basicAuth']);
    $merchantSessionKey = $request['body']['merchantSessionKey']; ?>
    <script src="https://pi-<?= $sagePayToken['mode'] ?>.sagepay.com/api/v1/js/sagepay-dropin.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            var sapValid = true,
                merchantSessionKey = '<?= $merchantSessionKey ?>';

            const checkout = sagepayCheckout({
                merchantSessionKey: merchantSessionKey,
                onTokenise: function (tokenisationResult) {
                    if (tokenisationResult.success) {

                        $('#hdn-billing-different').val(+$('#toggle-billing-address').prop('checked'));
                        $('#hdn-billing-address-1').val($('#billing-address-1').val());
                        $('#hdn-billing-address-2').val($('#billing-address-2').val());
                        $('#hdn-billing-city').val($('#billing-city').val());
                        $('#hdn-billing-postcode').val($('#billing-postcode').val());
                        $('#hdn-merchant-session').val(merchantSessionKey);
                        $('#hdn-card-identifier').val(tokenisationResult.cardIdentifier);

                        $('#frm-delivery').submit();
                    } else {
                        if (tokenisationResult.error.errorMessage == 'Authentication failed') {
                            alert('Reloading page due to session expiration.');
                            location.reload();
                        } else {
                            alert(tokenisationResult.error.errorMessage);
                        }
                    }
                }
            });
            $('#toggle-billing-address')
                .click(function () {
                    if ($(this).prop('checked')) {
                        $('#billing-address').show();
                    } else {
                        $('#billing-address').hide();

                        var billingAddress1 = $('#billing-address-1'),
                            billingCity = $('#billing-city'),
                            billingPostcode = $('#billing-postcode');

                        removeError(billingAddress1);
                        removeError(billingCity);
                        removeError(billingPostcode);

                        sapValid = true;
                    }
                })
                .trigger('click');
            $('#submit-card-details').click(function (e) {
                e.preventDefault();

                if ($('#toggle-billing-address').prop('checked')) {
                    var billingAddress1 = $('#billing-address-1'),
                        billingCity = $('#billing-city'),
                        billingPostcode = $('#billing-postcode');

                    removeError(billingAddress1);
                    if (billingAddress1.val() == '') {
                        addError(billingAddress1);
                        sapValid = false;
                    } else {
                        sapValid = true;
                    }

                    removeError(billingCity);
                    if (billingCity.val() == '') {
                        addError(billingCity);
                        sapValid = false;
                    } else {
                        sapValid = true;
                    }

                    removeError(billingPostcode);
                    if (billingPostcode.val() == '') {
                        addError(billingPostcode);
                        sapValid = false;
                    } else {
                        sapValid = true;
                    }
                }

                if (sapValid) {
                    if ($('#hdn-merchant-session').val() != '') {
                        merchantSessionKey = $('#hdn-new-merchant-session').val();
                    }

                    checkout.tokenise({newMerchantSessionKey: merchantSessionKey});
                }
            });

            function addError(field) {
                field.css({'border-color': 'red'});
                field.next().show();
            }

            function removeError(field) {
                field.css({'border-color': ''});
                field.next().hide();
            }
        });
    </script>
<?php } ?>
