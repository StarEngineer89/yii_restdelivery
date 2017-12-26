<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '78e680d8f3fb24b2a7dec1e6dc67d26c469c9910');
</script>
<?php
unset($_SESSION['pts_earn']);
unset($_SESSION['pts_redeem_amt']);

if(!isset($_GET['iframe'])){
    $this->renderPartial('/front/banner-receipt',array(
        'h1'=>t("Thank You"),
        'sub_text'=>t("Your order has been placed.")
    ));
}
else {
	Yii::app()->clientScript->registerScriptFile('/assets/vendor/iframeResizer/iframeResizer.contentWindow.min.js');
}

$ok=false;
//$data='';
//if ( $data=Yii::app()->functions->getOrder2($_GET['id'])){
if (is_array($data) && count($data)>=1){
	$merchant_id=$data['merchant_id'];
	$json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false;
	if ( $json_details !=false){
		Yii::app()->functions->displayOrderHTML(array(
		  'merchant_id'=>$data['merchant_id'],
		  'delivery_type'=>$data['trans_type'],
		  'delivery_charge'=>$data['delivery_charge'],
		  'packaging'=>$data['packaging'],
		  'cart_tip_value'=>$data['cart_tip_value'],
		  'cart_tip_percentage'=>$data['cart_tip_percentage']/100,
		  'card_fee'=>$data['card_fee'],
		  'tax'=>$data['tax'],
                  'special_instructions'=>$_SESSION['kr_specialinstructions']['specialinstructions'],
		  'points_discount'=>isset($data['points_discount'])?$data['points_discount']:'' /*POINTS PROGRAM*/,
		  'voucher_amount'=>$data['voucher_amount'],
		  'voucher_type'=>$data['voucher_type']
		  ),$json_details,true);
		if ( Yii::app()->functions->code==1){
			$ok=true;
		}
		unset($_SESSION['kr_specialinstructions']['specialinstructions']);
		/*ITEM TAXABLE*/
		$mtid = $merchant_id;
		$apply_tax = $data['apply_food_tax'];
	    $tax_set = $data['tax'];
		if ( $apply_tax==1 && $tax_set>0){
		    Yii::app()->functions->details['html']=Yii::app()->controller->renderPartial('/front/cart-with-tax',array(
    		   'data'=>Yii::app()->functions->details['raw'],
    		   'tax'=>$tax_set,
    		   'receipt'=>true,
    		   'merchant_id'=>$mtid
    		),true);
		}

		/*dump(Yii::app()->functions->details['raw']);
		die();*/
	}
}
unset($_SESSION['kr_item']);
unset($_SESSION['kr_merchant_id']);
unset($_SESSION['voucher_code']);
unset($_SESSION['less_voucher']);
unset($_SESSION['shipping_fee']);

$print='';

$order_ok=true;

$merchant_info=Yii::app()->functions->getMerchant(isset($merchant_id)?$merchant_id:'');
$full_merchant_address=$merchant_info['street']." ".$merchant_info['city']. " ".$merchant_info['state'].
" ".$merchant_info['post_code'];

$transaction_type=$data['trans_type'];
?>

<div class="sections section-grey2 section-receipt">
    <input style="display:none;" id="order_id" value="<?php echo $_GET['id'];?>"></input>
   <div class="container">
        <script>

                                    var timerText = ''
                                    var seconds = 60;
                                    function secondPassed() {
                                        document.getElementById("order_id").style.display = "none";
                                        var minutes = Math.round((seconds - 30) / 60);
                                        var remainingSeconds = seconds % 60;
                                        if (remainingSeconds < 10) {
                                            remainingSeconds = "0" + remainingSeconds;
                                        }

                                        document.getElementById('countdown').innerHTML = timerText + "<br/><b style='font-size: 60px;'>" + minutes + ":" + remainingSeconds + "s</b>";
                                        if(seconds == 50){
                                            //document.getElementById('countdown1').innerHTML = "<br/>30 Seconds are left."
                                            //doAction();
                                            var countdownTimer1 = setInterval('doAction()', 10000);
                                            
                                        }
                                        if (seconds == 0) {
                                            clearInterval(countdownTimer);
                                            document.getElementById("msg1").style.display = "none";
                                            document.getElementById("msg2").style.display = "none";
                                            document.getElementById("imgagerotate").style.display = "none";
                                            
                                            document.getElementById('countdown').innerHTML = "<br/><b><h3>Thank you for your order. You order has been received and will be processed shortly.</b></h3>";
                                        } else {
                                            seconds--;
                                        }
                                    }

                                    var countdownTimer = setInterval('secondPassed()', 1000);
                                   function doAction(){
                                       debugger;
                                        var params = "orderid="+$("#order_id").val();
                                         $.ajax({
                                                type: "POST", //or "GET", if you want that
                                                url: ajax_url,
                                                data: "action=getOrderDeliveryTime&currentController=store&tbl=getOrderDeliveryTime&"+params, //here goes the data you want to send to your server. In this case, you're sending your A and B inputs.
                                                dataType: "json", //here goes the return's expected format. You should read more about that on the jQuery documentation
                                                success: function(response) { //function called if your request succeeds
                                                    //do whatever you want with your response json;
                                                    //as you're learning, try that to see on console:
                                                    //console.log(response);
                                                    //alert(response.msg);
                                                    if(!(response.msg==="")){
                                                         document.getElementById("displayMessage").innerHTML = "<b>GREAT NEWS! Your order is now being prepared and will be delivered  : " + response.msg + " min</b>";
                                                    
                                                        document.getElementById("msg1").style.display = "none";
                                                        document.getElementById("msg2").style.display = "none";
                                                        document.getElementById("countdown").style.display = "none";
                                                        document.getElementById("imgagerotate").style.display = "none";
                                                        document.getElementById("clickIcon").style.display = "block";
                                                        $('#clickIcon').show();
                                                    } else if(response.msg===""){
                                                        if(response.code===2){
                                                            document.getElementById("displayMessage").innerHTML = "<b>Sorry! Your Order Has Been Cancelled by the shop.</b>";
                                                            document.getElementById("msg1").style.display = "none";
                                                            document.getElementById("msg2").style.display = "none";
                                                            document.getElementById("countdown").style.display = "none";
                                                            document.getElementById("imgagerotate").style.display = "none";
                                                            //document.getElementById("clickIcon").style.display = "block";
                                                        //$('#clickIcon').show();
                                                        }
                                                    }
                                                   
                                                },
                                                error: function(response) { //function called if your request failed
                                                 //do whatever you want with your error :/
                                                }
                                             
                                         });
                                   }
                                  
 

                                </script>
                                

                          

   <?php if ($ok==TRUE):?>
   <div class="inner" id="receipt-content">
	   <h1><?php echo t("Order Details")?></h1>
	   <div class="box-grey">

	   <div class="text-center bottom10">
	       <div id="imgagerotate" style="text-align: center; vertical-align: middle;">
 <img style="margin-left: auto;width:10%; height:10%;margin-right: auto;" src="../assets/images/Yummy-Takeaways-Order.gif" alt="Please wait..." /></div>
 
<p style="text-align:center; font-size: 20%;" id="countdown"></p>
<p style="font-size: 110%;text-align:center;" id="msg1">Please Stay On This Page</p>
                           
                            <p style="font-size: 110%;text-align:center;" id="msg2">Until You Receive a Response From Us.</p>
	   <i class="ion-ios-checkmark-outline i-big-extra green-text" style="display:none" id="clickIcon"></i>
	   </div>
<p style="text-align:center;" id="displayMessage"></p>
	   <table class="table table-striped">
	    <tbody>

	       <tr>
	         <td><?php echo Yii::t("default","Customer Name")?></td>
	         <td class="text-right"><?php echo $data['full_name']?></td>
	       </tr>
	        <tr>
		         <td><?php echo Yii::t("default","Contact Number")?></td>
		         <td class="text-right">
		         <?php
		         if ( !empty($data['contact_phone1'])){
		         	$data['contact_phone']=$data['contact_phone1'];
		         }
		         echo $data['contact_phone'];?>
		         </td>
		       </tr>
	       <?php $print[]=array( 'label'=>Yii::t("default","Customer Name"), 'value'=>$data['full_name'] );?>
	       <tr>
	         <td><?php echo Yii::t("default","Merchant Name")?></td>
	         <td class="text-right"><?php echo clearString($data['merchant_name'])?></td>
	       </tr>
	       <?php $print[]=array( 'label'=>Yii::t("default","Merchant Name"), 'value'=>$data['merchant_name']); ?>

	       <?php if (isset($data['abn']) && !empty($data['abn'])):?>
	       <tr>
	         <td><?php echo Yii::t("default","ABN")?></td>
	         <td class="text-right"><?php echo $data['abn']?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","ABN"),
	         'value'=>$data['abn']
	       );
	       ?>
	       <?php endif;?>

	       <tr>
	         <td><?php echo Yii::t("default","Telephone")?></td>
	         <td class="text-right"><?php echo $data['merchant_contact_phone']?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Telephone"),
	         'value'=>$data['merchant_contact_phone']
	       );
	       ?>

	       <tr>
	         <td><?php echo Yii::t("default","Address")?></td>
	         <td class="text-right"><?php echo $full_merchant_address?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Address"),
	         'value'=>$full_merchant_address
	       );
	       ?>

	       <tr>
	         <td><?php echo Yii::t("default","Order Type")?></td>
	         <td class="text-right"><?php echo Yii::t("default",$data['trans_type'])?></td>
	       </tr>

	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Order Type"),
	         'value'=>t($data['trans_type'])
	       );
	       ?>

	       <tr>
	         <td><?php echo Yii::t("default","Payment Type")?></td>
	         <!--<td class="text-right"><?php echo strtoupper(t($data['payment_type']))?></td>-->
	         <td class="text-right">
	         <?php //echo FunctionsV3::prettyPaymentType('payment_order',
	         //$data['payment_type'],//$_GET['id'],$data['trans_type'])

	         if(FunctionsV3::prettyPaymentType('payment_order',
	         $data['payment_type'],$_GET['id'],$data['trans_type'])=="COD") {
	         echo " Cash On Delivery";



	         }

	         else
	         {
	          echo "Card";
	         }

	         ?>
	         </td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Payment Type"),
	         'value'=>FunctionsV3::prettyPaymentType('payment_order',$data['payment_type'],$_GET['id'],$data['trans_type'])
	       );
	       ?>

	       <?php if ( $data['payment_provider_name']):?>
	       <tr>
	         <td><?php echo Yii::t("default","Card#")?></td>
	         <td class="text-right"><?php echo $data['payment_provider_name']?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Card#"),
	         'value'=>strtoupper($data['payment_provider_name'])
	       );
	       ?>
	       <?php endif;?>

	       <?php if ( $data['payment_type'] =="pyp"):?>
	       <?php
	       $paypal_info=Yii::app()->functions->getPaypalOrderPayment($data['order_id']);
	       ?>
	       <tr>
	         <td><?php echo Yii::t("default","Paypal Transaction ID")?></td>
	         <td class="text-right"><?php echo isset($paypal_info['TRANSACTIONID'])?$paypal_info['TRANSACTIONID']:'';?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Paypal Transaction ID"),
	         'value'=>isset($paypal_info['TRANSACTIONID'])?$paypal_info['TRANSACTIONID']:''
	       );
	       ?>
	       <?php endif;?>

	       <tr>
	         <td><?php echo Yii::t("default","Reference No")?></td>
	         <td class="text-right"><?php echo Yii::app()->functions->formatOrderNumber($data['order_id'])?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Reference #"),
	         'value'=>Yii::app()->functions->formatOrderNumber($data['order_id'])
	       );
	       ?>

	       <?php if ( !empty($data['payment_reference'])):?>
	       <tr>
	         <td><?php echo Yii::t("default","Payment Ref")?></td>
	         <td class="text-right"><?php echo $data['payment_reference']?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Payment Ref"),
	         'value'=>Yii::app()->functions->formatOrderNumber($data['order_id'])
	       );
	       ?>
	       <?php endif;?>

	       <?php if ( $data['payment_type']=="ccr" || $data['payment_type']=="ocr"):?>
	       <tr>
	         <td><?php echo Yii::t("default","Card #")?></td>
	         <td class="text-right"><?php echo $card=Yii::app()->functions->maskCardnumber($data['credit_card_number'])?></td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Card #"),
	         'value'=>$card
	       );
	       ?>
	       <?php endif;?>

	       <tr>
	         <td><?php echo Yii::t("default","Order Date")?></td>
	         <td class="text-right">
	         <?php
	         $trn_date=date('M d,Y G:i:s',strtotime($data['date_created']));
	         echo Yii::app()->functions->translateDate($trn_date);
	         ?>
	         </td>
	       </tr>
	       <?php
	       $print[]=array(
	         'label'=>Yii::t("default","Order Date"),
	         'value'=>$trn_date
	       );
	       ?>

	       <?php if ($data['trans_type']=="delivery"):?>

		       <?php if (isset($_SESSION['kr_delivery_options']['delivery_date'])):?>
		       <tr>
		         <td><?php echo Yii::t("default","Delivery Date")?></td>
		         <td class="text-right">
		         <?php
		         $deliver_date=prettyDate($_SESSION['kr_delivery_options']['delivery_date']);
		         echo Yii::app()->functions->translateDate($deliver_date);
		         ?>
		         </td>
		       </tr>
		       <?php
		       $print[]=array(
		         'label'=>Yii::t("default","Delivery Date"),
		         'value'=>$deliver_date
		       );
		       ?>
		       <?php endif;?>

		       <?php if (isset($_SESSION['kr_delivery_options']['delivery_time'])):?>
		       <?php if ( !empty($_SESSION['kr_delivery_options']['delivery_time'])):?>
		       <tr>
		         <td><?php echo Yii::t("default","Delivery Time")?></td>
		         <td class="text-right"><?php echo Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)?></td>
		       </tr>
		       <?php
		       $print[]=array(
		         'label'=>Yii::t("default","Delivery Time"),
		         'value'=>Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)
		       );
		       ?>
		       <?php endif;?>
		       <?php endif;?>

		       <?php if (isset($_SESSION['kr_delivery_options']['delivery_asap'])):?>
		       <?php if ( !empty($_SESSION['kr_delivery_options']['delivery_asap'])):?>
		       <tr>
		         <td><?php echo Yii::t("default","Deliver ASAP")?></td>
		         <td class="text-right">
		         <?php echo $delivery_asap=$_SESSION['kr_delivery_options']['delivery_asap']==1?t("Yes"):'';?>
		         </td>
		       </tr>
			   <?php
				$print[]=array(
				 'label'=>Yii::t("default","Deliver ASAP"),
				 'value'=>$delivery_asap
				);
				?>
		       <?php endif;?>
		       <?php endif;?>

		       <tr>
		         <td><?php echo Yii::t("default","Deliver to")?></td>
		         <td class="text-right">
		         <?php
		         if (!empty($data['client_full_address'])){
		         	echo $delivery_address=$data['client_full_address'];
		         } else echo $delivery_address=$data['full_address'];
		         ?>
		         </td>
		       </tr>
				<?php
				$print[]=array(
				  'label'=>Yii::t("default","Deliver to"),
				  'value'=>$delivery_address
				);
				?>

		       <!--<tr>
		         <td><?php echo Yii::t("default","Delivery Instruction")?></td>
		         <td class="text-right"><?php echo $data['delivery_instruction']?></td>
		       </tr>-->
		       <?php
				$print[]=array(
				  'label'=>Yii::t("default","Delivery Instruction"),
				  'value'=>$data['delivery_instruction']
				);
				?>

		      <!-- <tr>
		         <td><?php echo Yii::t("default","Location Name")?></td>
		         <td class="text-right">
		         <?php
		         if (!empty($data['location_name1'])){
		         	$data['location_name']=$data['location_name1'];
		         }
		         echo $data['location_name'];
		         ?>
		         </td>
		       </tr>-->
		       <?php
				//$print[]=array(
				  //'label'=>Yii::t("default","Location Name"),
				 // 'value'=>$data['location_name']
				//);
				?>

		      
		       <?php
				$print[]=array(
				  'label'=>Yii::t("default","Contact Number"),
				  'value'=>$data['contact_phone']
				);
				?>

				<?php if ($data['order_change']>=0.1):?>
		       <tr>
		         <td><?php echo Yii::t("default","Change")?></td>
		         <td class="text-right">
		         <?php echo displayPrice( baseCurrency(), normalPrettyPrice($data['order_change']))?>
		         </td>
		       </tr>
		       <?php
				$print[]=array(
				  'label'=>Yii::t("default","Change"),
				  'value'=>normalPrettyPrice($data['order_change'])
				);
				?>
				<?php endif;?>


		   <?php else :?>

		      <?php
		      $label_date=t("Pickup Date");
		      $label_time=t("Pickup Time");
		      if ($transaction_type=="dinein"){
		      	  $label_date=t("Dine in Date");
		          $label_time=t("Dine in Time");
		      }
		      ?>

               <?php
				if (isset($data['contact_phone1'])){
					if (!empty($data['contact_phone1'])){
						$data['contact_phone']=$data['contact_phone1'];
					}
				}
			   ?>
		       <tr>
		         <td><?php echo Yii::t("default","Contact Number")?></td>
		         <td class="text-right"><?php echo $data['contact_phone']?></td>
		       </tr>
		       <?php
				$print[]=array(
				  'label'=>Yii::t("default","Contact Number"),
				  'value'=>$data['contact_phone']
				);
				?>

		      <?php if (isset($_SESSION['kr_delivery_options']['delivery_date'])):?>
		       <tr>
		         <td><?php echo $label_date?></td>
		         <td class="text-right">
		         <?php echo $_SESSION['kr_delivery_options']['delivery_date']?>
		         </td>
		       </tr>
		       <?php
				$print[]=array(
				  'label'=>$label_date,
				  'value'=>$_SESSION['kr_delivery_options']['delivery_date']
				);
				?>
		       <?php endif;?>

		       <?php if (isset($_SESSION['kr_delivery_options']['delivery_time'])):?>
		       <?php if ( !empty($_SESSION['kr_delivery_options']['delivery_time'])):?>
		       <tr>
		         <td><?php echo $label_time?></td>
		         <td class="text-right">
		         <?php echo Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)?>
		         </td>
		       </tr>
		       <?php
				$print[]=array(
				 'label'=>$label_time,
				 'value'=>Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)
				);
				?>
		       <?php endif;?>
		       <?php endif;?>

		       <?php if ($data['order_change']>=0.1):?>
		       <tr>
		         <td><?php echo Yii::t("default","Change")?></td>
		         <td class="text-right">
		         <?php echo displayPrice( baseCurrency(), normalPrettyPrice($data['order_change']))?>
		         </td>
		       </tr>
		        <?php
				$print[]=array(
				  'label'=>Yii::t("default","Change"),
				  'value'=>$data['order_change']
				);
				?>
				<?php endif;?>

			   <?php if ($transaction_type=="dinein"):?>
			    <tr>
		         <td><?php echo t("Number of guest")?></td>
		         <td class="text-right">
		         <?php echo $data['dinein_number_of_guest']?>
		         </td>
		       </tr>
		       <tr>
		         <td><?php echo t("Special instructions")?></td>
		         <td class="text-right">
		         <?php echo stripslashes($data['dinein_special_instruction'])?>
		         </td>
		       </tr>
		       <?php
				$print[]=array(
				  'label'=>t("Number of guest"),
				  'value'=>$data['dinein_number_of_guest']
				);
				$print[]=array(
				  'label'=>t("Special instructions"),
				  'value'=>$data['dinein_special_instruction']
				);
				?>
			 <tr>
			 <td class="<?php echo $tabs==2?"active":''?>">
        <a href="<?php $this->renderPartial('/front/address-book',array(
           'client_id'=>Yii::app()->functions->getClientId(),
           'data'=>Yii::app()->functions->getAddressBookByID( isset($_GET['id'])?$_GET['id']:'' ),
           'tabs'=>$tabs
         ));?>">Track Order</a></td>
       </tr>	 
			   <?php endif;?>

       
      
	       <?php endif;?>
		 

	       <tr>
			 <td colspan="2"></td>
		   </tr>
		  
	        
	        

	    </tbody>
	    
	   </table>
	
	    <div class="receipt-wrap order-list-wrap">
	    <?php echo $item_details=Yii::app()->functions->details['html'];?>
	    </div>

	   </div> <!--box-grey-->

   </div> <!--inner-->
 

   <div class="row">
       <script>
//function myFunction() {
    //location.replace("https://www.yummytakeaways.co.uk/profile")
//}
</script>
   <div class="col-sm-6 text-left">
       <a class="btn btn-default" href="https://www.yummytakeaways.co.uk/profile?#order-history">Track Order</a>
      </div> <!--col-->
      <div class="col-sm-6 text-right">
        <a href="javascript:;" class="print-receipt"><i class="ion-ios-printer-outline"></i></a>
      </div> <!--col-->
   </div> <!--row-->

   <?php else :?>
    <p class="text-warning"><?php echo t("Sorry but we cannot find what you are looking for.")?></p>
    <?php $order_ok=false;?>
   <?php endif;?>

   </div> <!--container-->
</div>  <!--section-receipt-->

<?php
$data_raw=Yii::app()->functions->details['raw'];
if ( $apply_tax==1 && $tax_set>0){
	$receipt=EmailTPL::salesReceiptTax($print,Yii::app()->functions->details['raw']);
} else $receipt=EmailTPL::salesReceipt($print,Yii::app()->functions->details['raw']);

$to=isset($data['email_address'])?$data['email_address']:'';

if (!isset($_SESSION['kr_receipt'])){
	$_SESSION['kr_receipt']='';
}

/*dump($receipt);
dump(Yii::app()->functions->additional_details);*/

if (!in_array($data['order_id'],(array)$_SESSION['kr_receipt'])){
	if ($order_ok==true){
		/*SEND EMAIL TO CUSTOMER*/
		FunctionsV3::notifyCustomer($data,Yii::app()->functions->additional_details,$receipt, $to);
		FunctionsV3::notifyMerchant($data,Yii::app()->functions->additional_details,$receipt);
		FunctionsV3::notifyAdmin($data,Yii::app()->functions->additional_details,$receipt);

	   FunctionsV3::fastRequest(FunctionsV3::getHostURL().Yii::app()->createUrl("cron/processemail"));
	   FunctionsV3::fastRequest(FunctionsV3::getHostURL().Yii::app()->createUrl("cron/processsms"));
	}
}

$_SESSION['kr_receipt']=array($data['order_id']);