<script src="https://pi-test.sagepay.com/api/v1/js/sagepay-dropin.js"></script>
<style>
    body * {
        font-family: sans-serif;
    }
    h1 {

    }
    input {
        font-size:12pt;
    }
    #main {
        width: 550px;
        margin: 0 auto;
    }
    #submit-container {
        padding-top:10px;
        float:right;
    }
    input[type=submit] {
        border:none;
        background:indigo;
        padding:10px;
        color:white;
        border-radius:5px;
    }
</style>


<script>
    sagepayCheckout({ merchantSessionKey: 'F42164DA-4A10-4060-AD04-F6101821EFC3' }).form();
</script>
<style type="text/css">
    .box{
        color: #000000;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    .red{ background: #fff; }

</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            var inputValue = $(this).attr("value");
            $("." + inputValue).toggle();
        });
    });
</script>


<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    specialKeys.push(9); //Tab
    specialKeys.push(46); //Delete
    specialKeys.push(36); //Home
    specialKeys.push(35); //End
    specialKeys.push(37); //Left
    specialKeys.push(39); //Right
    function IsAlphaNumeric(e) {
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) == 1 && e.charCode != e.keyCode));
        document.getElementById("error").style.display = ret ? "none" : "inline";
        return ret;
    }

    function validate(){
        var re = /^[A-Za-z]+$/;
        if(re.test(document.getElementById("street").value))
            alert('Valid Name.');
        else
            alert('Invalid Name.');
    }
</script>

<script>
    checkPwd = function () {
        var str = document.getElementById('street').value;
        //if (str.length < 6) {
        // alert("too_short");
        // return ("too_short");
        // }
        //if (str.length > 50) {
        //alert("too_long");
        // return ("too_long");
        //}
        if (str.search(/\d/) == -1) {
            alert("Please enter at least one numairic character and letters");
            //document.getElementById("msg").innerHTML="this is invalid name ";
            return ("Please enter at least one numairic character and letters");
        } else if (str.search(/[a-zA-Z]/) == -1) {
            alert("Please enter at least one numairic character and letters");
            return ("Please enter at least one numairic character and letters");
        } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+\.\,\;\:]/) != -1) {
            alert("Please enter at least one numairic character and letters");
            return ("Please enter at least one numairic character and letters");
        }
        alert("oukey!!");
        return ("ok");
    }

    checkStreetNum = function () {
        var re = /^([A-Za-z]+)+$/;
//        var re = /^([A-Za-z0-9]*)+$/;

        var result = false;
        var str = document.getElementById('street').value;
        if (str.search(/\d/) == -1) {
            result = true;
        } else if (str.search(/[a-zA-Z]/) == -1) {
            result = true;
        }

        if (result == true) {
            $('.street-tooltip').show();
        } else {
            $('.street-tooltip').hide();
        }
    }

    $(document).ready(function () {
        checkStreetNum();
        $('#street').keyup(function () {
            checkStreetNum();
        });
    });
</script>


<?php
if(!isset($_GET['iframe'])){
    $this->renderPartial('/front/default-header',array(
        'h1'=>t("Payment Option"),
        'sub_text'=>t("choose your payment")
    ));
}
else {
    Yii::app()->clientScript->registerScriptFile('/assets/vendor/iframeResizer/iframeResizer.contentWindow.min.js');
}
?>

<?php
$this->renderPartial('/front/order-progress-bar',array(
    'step'=>isset($step)?$step:4,
    'show_bar'=>true,
    'guestcheckout'=>isset($guestcheckout)?$guestcheckout:false
));

$s=$_SESSION;
$continue=false;

$merchant_address='';
if ($merchant_info=Yii::app()->functions->getMerchant($s['kr_merchant_id'])){
    $merchant_address=$merchant_info['street']." ".$merchant_info['city']." ".$merchant_info['state'];
    $merchant_address.=" "	. $merchant_info['post_code'];
}

$client_info='';
$authKey=$_GET['authKey'];
echo $authKey;



if (isset($is_guest_checkout)){
    $continue=true;
} else {
    $client_info = Yii::app()->functions->getClientInfo(Yii::app()->functions->getClientId());
    if (isset($s['kr_search_address'])){
        $temp=explode(",",$s['kr_search_address']);
        $temp2=explode(" ",$s['kr_search_address'],-2);
        if (is_array($temp) && count($temp)>=2){
            $street=isset($temp[0])?$temp[0]:'';
            $getcity=isset($temp[1])?$temp[1]:'';
            $citytemp = explode(" ",$getcity);

            $state = isset($temp[2])?$temp[2]:'';
            //print_r(explode(" ",$s['kr_search_address'], -2));
            //$postcode = implode(' ', array_slice($temp2,4,5));



            if ((count($citytemp)) >= 5){
                $city = ($citytemp[1]) . " " . ($citytemp[2]);
            }
            else{
                $city = ($citytemp[1]);
            }



            $postcode1 =  $temp2[sizeOf($temp2)-2];
            $postcode2 =  $temp2[sizeOf($temp2)-1];
            $postcode3 = $postcode1 . " " . $postcode2; //joins both parts of the postcode
            $postcode = str_replace(",","", $postcode3);



            //Ahmed - throughout this implementation, i have used the state textbox to hold the customers postcode, and the zipcode textbox to hold the customers country.
            //state and zipcode are default id's in the code. I used state as it was a requried field already, meaning we didnt have to code for a required field

        }
        if ( isset($client_info['street'])){
            if ( empty($client_info['street']) ){
                $client_info['street']=$street;
            }
        }
        if ( isset($client_info['city'])){
            if ( empty($client_info['city']) ){
                $client_info['city']=$city;
            }
        }

        if ( isset($client_info['zipcode'])){
            if ( empty($client_info['zipcode']) ){
                $client_info['zipcode']=$state;
            }
        }


        if ( isset($client_info['state'])){
            if ( empty($client_info['state']) ){
                $client_info['state']='';
            }
        }
    }

    if (isset($s['kr_merchant_id']) && Yii::app()->functions->isClientLogin() && is_array($merchant_info) ){
        $continue=true;
    }
}
echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));

echo CHtml::hiddenField('admin_currency_set',getCurrencyCode());

echo CHtml::hiddenField('admin_currency_position',
    Yii::app()->functions->getOptionAdmin("admin_currency_position"));

?>


<div class="sections section-grey2 section-payment-option">


    <div class="container">
        <div class="row" style="margin-left:0px">
            <div class="col-md-3 border">

                <!--<a href="javascript: history.go(-1)" class="place_order green-button medium inline blocks"><i class="ion-ios-arrow-thin-left"></i> <?php echo t("Go Back")?></a>-->

                <a href="<?php echo Yii::app()->createUrl("/menu-". ucwords($merchant_info['restaurant_slug']))?>?option-type=<?php echo $s['kr_delivery_options']['delivery_type'] ?>"
                   class="backbuttononly orange-button rounded3 medium bottom10 inline-block">
                    <i class="ion-ios-arrow-thin-left"></i>
                    <?php echo t("Go Back")?>
                </a>
            </div>

            <div class="col-md-9 border">  </div>
        </div>

        <?php if ( $continue==TRUE):?>
            <?php
            $merchant_id=$s['kr_merchant_id'];
            echo CHtml::hiddenField('merchant_id',$merchant_id);
            ?>

            <div class="col-md-7 border">

                <div class="box-grey rounded">
                    <form id="frm-delivery" class="frm-delivery" method="POST" onsubmit="return false;" >
                        <?php
                        //echo CHtml::hiddenField('action','placeOrder');
                        echo CHtml::hiddenField('action','InitPlaceOrder');
                        //echo CHtml::hiddenField('authKey',$data['authKey']);
                        echo CHtml::hiddenField('country_code',$merchant_info['country_code']);
                        echo CHtml::hiddenField('currentController','store');
                        echo CHtml::hiddenField('delivery_type',$s['kr_delivery_options']['delivery_type']);
                        echo CHtml::hiddenField('cart_tip_percentage','');
                        echo CHtml::hiddenField('cart_tip_value','');
                        if(!isset($_GET['iframe'])){

                        }
                        else {
                            echo CHtml::hiddenField('iframe','true');
                        }
                        echo CHtml::hiddenField('client_order_sms_code');
                        echo CHtml::hiddenField('client_order_session');

                        echo CHtml::hiddenField('cart_tip_cash_percentage','');

                        if (isset($is_guest_checkout)){
                            echo CHtml::hiddenField('is_guest_checkout',2);
                        }

                        $transaction_type=$s['kr_delivery_options']['delivery_type'];
                        ?>

                        <?php if ( $transaction_type=="pickup" ||  $transaction_type=="dinein"):?>

                            <h3>
                                <?php
                                if($transaction_type=="pickup"){
                                    echo t("Pickup information");
                                } else echo t("Dine in information");
                                ?>
                            </h3>
                            <p>
                                <?php echo clearString(ucwords($merchant_info['restaurant_name']))?> <?php echo Yii::t("default","Restaurant")?>
                                <?php echo "<span class='bold'>".Yii::t("default",ucwords($s['kr_delivery_options']['delivery_type'])) . "</span> ";
                                if ($s['kr_delivery_options']['delivery_asap']==1){
                                    $s['kr_delivery_options']['delivery_date']." ".Yii::t("default","ASAP");
                                } else {
                                    echo '<span class="bold">'.Yii::app()->functions->translateDate(date("M d Y",strtotime($s['kr_delivery_options']['delivery_date']))).
                                        " ".t("at"). " ". $s['kr_delivery_options']['delivery_time']."</span> ".t("to");
                                }
                                ?>
                            </p>
                            <p class="uk-text-bold"><?php echo $merchant_address;?></p>

                            <?php if (!isset($is_guest_checkout)):?>
                                <?php //if ( getOptionA('mechant_sms_enabled')==""):?>
                                <?php //if ( getOption($merchant_id,'order_verification')==2):?>
                                <?php //$sms_balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);?>
                                <?php //if ( $sms_balance>=1):?>

                                <div class="row top10">
                                    <div class="col-md-10">
                                        <?php echo CHtml::textField('contact_phone',
                                            isset($client_info['contact_phone'])?$client_info['contact_phone']:''
                                            ,array(
                                                'class'=>'mobile_inputs grey-fields',
                                                'placeholder'=>Yii::t("default","Mobile Number"),
                                                'data-validation'=>"required",
                                                'maxlength'=>15
                                            ));?>
                                    </div>
                                </div>

                                <?php //endif;?>
                                <?php //endif;?>
                                <?php //endif;?>
                            <?php endif;?>


                            <?php if (isset($is_guest_checkout)):?> <!--PICKUP GUEST-->
                                <?php
                                $this->renderPartial('/front/guest-checkou-form',array(
                                    'merchant_id'=>$merchant_id,
                                    'transaction_type'=>$transaction_type
                                ));
                                ?>
                            <?php endif;?>  <!--PICKUP GUEST-->


                        <?php else :?> <!-- DELIVERY-->

                            <?php FunctionsV3::sectionHeader('Delivery information')?>
                            <p>
                                <?php echo clearString(ucwords($merchant_info['restaurant_name']))?> <?php echo Yii::t("default","Restaurant")?>
                                <?php echo "<span class='bold'>".Yii::t("default",ucwords($s['kr_delivery_options']['delivery_type'])) . "</span> ";
                                if ($s['kr_delivery_options']['delivery_asap']==1){
                                    $s['kr_delivery_options']['delivery_date']." ".Yii::t("default","ASAP");
                                } else {
                                    echo '<span class="bold">'.Yii::app()->functions->translateDate(date("M d Y",strtotime($s['kr_delivery_options']['delivery_date']))).
                                        " ".t("at"). " ". $s['kr_delivery_options']['delivery_time']."</span> ".t("to");
                                }
                                ?>
                            </p>

                            <div class="top10">

                                <?php FunctionsV3::sectionHeader('Address')?>

                                <?php if (isset($is_guest_checkout)):?>
                                    <div class="row top10">
                                        <div class="col-md-10">
                                            <?php echo CHtml::textField('first_name','',array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","First Name"),
                                                'data-validation'=>"required"
                                            ))?>
                                        </div>
                                    </div>

                                    <div class="row top10">
                                        <div class="col-md-10">
                                            <?php echo CHtml::textField('last_name','',array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","Last Name"),
                                                'data-validation'=>"required"
                                            ))?>
                                        </div>
                                    </div>
                                <?php endif;?> <!--$is_guest_checkout-->

                                <?php if (!$search_by_location):?>
                                    <?php if ( $website_enabled_map_address==2 ):?>
                                        <div class="top10">
                                            <?php Widgets::AddressByMap()?>
                                        </div>
                                    <?php endif;?>


                                    <?php if ( $address_book):?>
                                        <div class="address_book_wrap">
                                            <div class="row top10">
                                                <div class="col-md-10">
                                                    <?php
                                                    $address_list=Yii::app()->functions->addressBook(Yii::app()->functions->getClientId());
                                                    echo CHtml::dropDownList('address_book_id',$address_book['id'],
                                                        (array)$address_list,array(
                                                            'class'=>"grey-fields full-width"
                                                        ));
                                                    ?>
                                                    <a href="javascript:;" class="edit_address_book block top10">
                                                        <i class="ion-compose"></i> <?php echo t("Edit")?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> <!--address_book_wrap-->
                                    <?php endif;?>
                                <?php endif;?>

                                <div class="address-block">
                                    <div class="row top10">
                                        <div class="col-md-10">

                                            <?php echo CHtml::textField('street', isset($client_info['street'])?$client_info['street']:'' ,array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","Street"),
                                                'data-validation'=>"required",
//                                                'data-toggle' => 'tooltip',
//                                                'data-placement' => "top right",
//                                                'title' => "Enter door number if applicable",
                                                //'onkeypress'=>"return IsAlphaNumeric(event);"
                                                //'onblur'=>"checkStreetNum()"
                                            ))?>
                                            <a href="#" class="street-tooltip alert-warning" data-toggle="tooltip" role="tooltip" title="" style="display: none; float: right;">
                                                <?php echo t('Enter door number if applicable') ?>
                                            </a>
                                        </div>
                                    </div>

                                    <?php if (!$search_by_location):?>
                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php echo CHtml::textField('city',
                                                    isset($client_info['city'])?$client_info['city']:''
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'placeholder'=>Yii::t("default","City"),
                                                        'data-validation'=>"required"
                                                    ))?>

                                                <span class="help-block" style="color:#a94442;font-size:12px;"  id="msg"></span>
                                            </div>
                                        </div>

                                        <div class="row top10">
                                            <div class="col-md-10">

                                                <?php echo CHtml::textField('state',
                                                    isset($client_info['state'])?$client_info['state']:''
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'placeholder'=>Yii::t("default","Postcode"),
                                                        'data-validation'=>"required",
                                                        //'onkeyup'=>"Maxchrallow()",
                                                        'maxlength'=>"10",
                                                        'onfocus'=>"document.getElementById('retunmessage').style.display='block';",
                                                        'onblur'=>"document.getElementById('retunmessage').style.display='none';"



                                                    ))?>
                                                <span class="help-block" style="color:#a94442;font-size:12px;"  id="retunmessage"></span>
                                            </div>
                                        </div>

                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php echo CHtml::textField('zipcode',
                                                    isset($client_info['zipcode'])?$client_info['zipcode']:''
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'placeholder'=>Yii::t("default","Country")
                                                    ))?>
                                            </div>
                                        </div>

                                    <?php else :?>
                                        <!--ADDRESS BY LOCATION -->
                                        <?php
                                        echo CHtml::hiddenField('city');
                                        echo CHtml::hiddenField('state');
                                        echo CHtml::hiddenField('area_name');
                                        $country_id=getOptionA('location_default_country'); $state_ids='';
                                        $location_search_data=FunctionsV3::getSearchByLocationData();
                                        //dump($location_search_data);
                                        ?>
                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php
                                                echo CHtml::dropDownList('state_id','',
                                                    (array)FunctionsV3::ListLocationState($country_id)
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'data-validation'=>"required"
                                                    ));
                                                ?>

                                            </div>
                                        </div>

                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php
                                                echo CHtml::dropDownList('city_id','',
                                                    array(
                                                        ''=>t("Select City")
                                                    )
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'data-validation'=>"required"
                                                    ));
                                                ?>
                                            </div>
                                        </div>

                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php
                                                echo CHtml::dropDownList('area_id','',
                                                    array(
                                                        ''=>t("Select Distric/Area/neighborhood")
                                                    )
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'data-validation'=>"required"
                                                    ));
                                                ?>
                                            </div>
                                        </div>

                                        <div class="row top10">
                                            <div class="col-md-10">
                                                <?php echo CHtml::textField('zipcode',
                                                    isset($client_info['zipcode'])?$client_info['zipcode']:''
                                                    ,array(
                                                        'class'=>'grey-fields full-width',
                                                        'placeholder'=>Yii::t("default","Zip code")
                                                    ))?>
                                            </div>
                                        </div>

                                    <?php endif;?>




                                </div> <!--address-block-->

                                <div class="row top10">
                                    <div class="col-md-10">
                                        <?php echo CHtml::textField('contact_phone',
                                            isset($client_info['contact_phone'])?$client_info['contact_phone']:''
                                            ,array(
                                                'class'=>'grey-fields mobile_inputs full-width',
                                                'placeholder'=>Yii::t("default","Mobile Number"),
                                                'data-validation'=>"required",
                                                'maxlength'=>15
                                            ))?>
                                    </div>
                                </div>

                                <div class="row top10">
                                    <div class="col-md-10">
                                        <?php //echo CHtml::textField('delivery_instruction','',array(
                                        //'class'=>'grey-fields full-width',
                                        //'placeholder'=>Yii::t("default","Delivery instructions")
                                        //))?>
                                    </div>
                                </div>

                                <div class="row top10">
                                    <div class="col-md-10">
                                        <?php
                                        if(!isset($_GET['iframe'])) {
                                            echo CHtml::checkBox('saved_address', false, array('class' => "icheck", 'value' => 2));
                                            echo " " . t("Save to my address book");
                                        }


                                        if (isset($_POST['checkBox']))
                                            echo CHtml::textField('location_name',
                                                isset($client_info['location_name'])?$client_info['location_name']:''
                                                ,array(
                                                    'class'=>'grey-fields full-width',
                                                    'placeholder'=>Yii::t("default","Location Name - Saved to Address book - Not seen by merchant")
                                                ))

                                        ?>
                                    </div>
                                </div>





                                <div class="row top10">
                                    <div class="col-md-10">
                                        <?php
                                        echo CHtml::textField('location_name',
                                            isset($client_info['location_name'])?$client_info['location_name']:''
                                            ,array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","Location Name - Saved to Address book - Not seen by merchant")
                                            ))
                                        ?>
                                    </div>
                                </div>


                                <?php if (isset($is_guest_checkout)):?>
                                    <div class="row top10">
                                        <div class="col-md-10">
                                            <?php echo CHtml::textField('email_address','',array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","Email address"),
                                            ))?>
                                        </div>
                                    </div>

                                <?php endif;?>


                                <?php if (isset($is_guest_checkout)):?>
                                    <?php FunctionsV3::sectionHeader('Optional')?>
                                    <div class="row top10">
                                        <div class="col-md-10">
                                            <?php echo CHtml::passwordField('password','',array(
                                                'class'=>'grey-fields full-width',
                                                'placeholder'=>Yii::t("default","Password"),
                                            ))?>
                                        </div>
                                    </div>
                                <?php endif;?>

                            </div> <!--top10-->

                        <?php endif;?> <!-- ENDIF DELIVERY-->


                        <?php if($transaction_type=="dinein"):?>
                            <div class="top30"></div>
                            <?php FunctionsV3::sectionHeader('Table Information')?>

                            <div class="row top10">
                                <div class="col-md-10">
                                    <?php echo CHtml::textField('dinein_number_of_guest','',array(
                                        'class'=>'grey-fields numeric_only',
                                        'placeholder'=>Yii::t("default","Number of guest"),
                                        'data-validation'=>"required",
                                    ))?>
                                </div>
                            </div>

                            <div class="row top10">
                                <div class="col-md-10">
                                    <?php echo CHtml::textArea('dinein_special_instruction','',array(
                                        'class'=>'grey-fields full-width',
                                        'placeholder'=>Yii::t("default","Special instructions"),
                                    ))?>
                                </div>
                            </div>

                        <?php endif;?>

                        <div class="top25">
                            <?php
                            $this->renderPartial('/front/payment-list',array(
                                'merchant_id'=>$merchant_id,
                                'payment_list'=>FunctionsV3::getMerchantPaymentListNew($merchant_id),
                                'transaction_type'=>$s['kr_delivery_options']['delivery_type']
                            ));
                            ?>
                        </div>

                        <!--TIPS-->
                        <?php if ( Yii::app()->functions->getOption("merchant_enabled_tip",$merchant_id)==2):?>
                            <?php
                            $merchant_tip_default=Yii::app()->functions->getOption("merchant_tip_default",$merchant_id);
                            if ( !empty($merchant_tip_default)){
                                echo CHtml::hiddenField('default_tip',$merchant_tip_default);
                            }
                            $FunctionsK=new FunctionsK();
                            $tips=$FunctionsK->tipsList();
                            ?>
                            <div class="section-label top25">
                                <a class="section-label-a">
	      <span class="bold">
	        <?php echo t("Tip Amount")?> (<span class="tip_percentage">0%</span>)
	      </span>
                                    <b></b>
                                </a>
                            </div>

                            <div class="uk-panel uk-panel-box">
                                <ul class="tip-wrapper">
                                    <?php foreach ($tips as $tip_key=>$tip_val):?>
                                        <li>
                                            <a class="tips" href="javascript:;" data-type="tip" data-tip="<?php echo $tip_key?>">
                                                <?php echo $tip_val?>
                                            </a>

                                        </li>
                                    <?php endforeach;?>
                                    <li><a class="tips tip_cash" href="javascript:;" data-type="cash" data-tip="0"><?php echo t("Tip cash")?></a></li>
                                    <li><?php echo CHtml::textField('tip_value','',array(
                                            'class'=>"numeric_only grey-fields",
                                            'style'=>"width:70px;"
                                        ));?>
                                    </li>
                                    <li>
                                        <button type="button" class="apply_tip green-button"><?php echo t("Apply")?></button>
                                    </li>
                                </ul>
                            </div>
                        <?php endif;?>
                        <!--END TIPS-->

                    </form>

                    <!--CREDIT CART-->
                    <?php
                    $this->renderPartial('/front/credit-card',array(
                        'merchant_id'=>$merchant_id
                    ));
                    ?>

                    <!--END CREDIT CART-->

                </div> <!--box rounded-->

            </div> <!--left content-->

            <div class="col-md-5 border sticky-div"><!-- RIGHT CONTENT STARTS HERE-->

                <div class="box-grey rounded  relative top-line-green">

                    <i class="order-icon your-order-icon"></i>




                    <div class="order-list-wrap">

                        <p class="bold center"><?php echo t("Your Order")?></p>
                        <div class="item-order-wrap"></div>

                        <!--VOUCHER STARTS HERE-->
                        <?php Widgets::applyVoucher($merchant_id);?>
                        <!--VOUCHER STARTS HERE-->

                        <?php
                        if (FunctionsV3::hasModuleAddon("pointsprogram")){
                            /*POINTS PROGRAM*/
                            PointsProgram::redeemForm();
                        }
                        ?>

                        <?php
                        $minimum_order=Yii::app()->functions->getOption('merchant_minimum_order',$merchant_id);
                        $maximum_order=getOption($merchant_id,'merchant_maximum_order');
                        if ( $s['kr_delivery_options']['delivery_type']=="pickup"){

                            $minimum_order=Yii::app()->functions->getOption('merchant_minimum_order_pickup',$merchant_id);
                            $maximum_order=getOption($merchant_id,'merchant_maximum_order_pickup');

                        } elseif ( $s['kr_delivery_options']['delivery_type']=="dinein"){
                            $minimum_order=getOption($merchant_id,'merchant_minimum_order_dinein');
                            $maximum_order=getOption($merchant_id,'merchant_maximum_order_dinein');
                        }
                        ?>

                        <?php
                        if (!empty($minimum_order)){
                            echo CHtml::hiddenField('minimum_order',unPrettyPrice($minimum_order));
                            echo CHtml::hiddenField('minimum_order_pretty',baseCurrency().prettyFormat($minimum_order));
                            ?>
                            <p class="small center"><?php echo t("Subtotal must exceed")?>
                                <?php echo baseCurrency().prettyFormat($minimum_order,$merchant_id)?>
                            </p>
                            <?php
                        }
                        if($maximum_order>0){
                            echo CHtml::hiddenField('maximum_order',unPrettyPrice($maximum_order));
                            echo CHtml::hiddenField('maximum_order_pretty',baseCurrency().prettyFormat($maximum_order));
                        }
                        ?>

                        <?php //if ( getOptionA('captcha_order')==2 || getOptionA('captcha_customer_signup')==2):?>
                        <?php if ( getOptionA('captcha_order')==2):?>
                            <div class="top10 capcha-wrapper">
                                <?php //GoogleCaptcha::displayCaptcha()?>
                                <div id="kapcha-1"></div>
                            </div>
                        <?php endif;?>

                        <!--SMS Order verification-->
                        <?php if ( getOptionA('mechant_sms_enabled')==""):?>
                            <?php if ( getOption($merchant_id,'order_verification')==2):?>
                                <?php $sms_balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);?>
                                <?php if ( $sms_balance>=1):?>
                                    <?php $sms_order_session=Yii::app()->functions->generateCode(50);?>
                                    <p class="top20 center">
                                        <?php echo t("This merchant has required SMS verification")?><br/>
                                        <?php echo t("before you can place your order")?>.<br/>
                                        <?php echo t("Click")?> <a href="javascript:;" class="send-order-sms-code" data-session="<?php echo $sms_order_session;?>">
                                            <?php echo t("here")?></a>
                                        <?php echo t("receive your order sms code")?>
                                    </p>
                                    <div class="top10 text-center">
                                        <?php
                                        echo CHtml::textField('order_sms_code','',array(
                                            'placeholder'=>t("SMS Code"),
                                            'maxlength'=>8,
                                            'class'=>'grey-fields text-center'
                                        ));
                                        ?>
                                    </div>
                                <?php endif;?>
                            <?php endif;?>
                        <?php endif;?>
                        <!--END SMS Order verification-->

                        <div class="text-center top25">
                            <a href="javascript:;" class="place_order green-button medium inline block">
                                <?php echo t("Review My Order")?>
                            </a>
                        </div>

                    </div> <!-- order-list-wrap-->
                </div> <!--box-grey-->

            </div> <!--right content-->

        <?php else :?>
            <div class="box-grey rounded">
                <p class="text-danger">
                    <?php echo t("Something went wrong Either your visiting the page directly or your session has expired.")?></p>
            </div>
        <?php endif;?>

    </div>  <!--container-->
</div> <!--section-payment-option-->
<script>
    sagepayCheckout({ merchantSessionKey: 'F42164DA-4A10-4060-AD04-F6101821EFC3' }).form();
</script>



<?php
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/merchant-session-keys",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{ "vendorName": "sandbox" }',
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic aEpZeHN3N0hMYmo0MGNCOHVkRVM4Q0RSRkxodUo4RzU0TzZyRHBVWHZFNmhZRHJyaWE6bzJpSFNyRnliWU1acG1XT1FNdWhzWFA1MlY0ZkJ0cHVTRHNocktEU1dzQlkxT2lONmh3ZDlLYjEyejRqNVVzNXU=",
        "Cache-Control: no-cache",
        "Content-Type: application/json"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#specialinstructions").change(function() { EnviarCorreo(); });
    });

    function EnviarCorreo()
    {
        jQuery.ajax({
            type: "POST",
            url: 'AjaxAdmin.php',
            data: {functionname: 'specialInstrucitonsSelectionChange', arguments: [$("#specialinstructions").val()]},
            success:function(data) {
                alert(data);
            }
        });
    }

    $(function()
    {
        debugger;
        //$("#retunmessage")[0].innerText = "Maximum Chracters Are Allowed "+ parseInt($("#state")[0].maxLength);
    });
    function Maxchrallow()
    {
        debugger;
        $("#retunmessage")[0].innerText = "Maximum Chracters Are Allowed"+" = "+ parseInt($("#state")[0].maxLength - $("#state").val().length);

    }




</script>

<div id="confirm" style="background-position: top right; background-repeat: no-repeat; padding-top: 10px; display: none;"></div>