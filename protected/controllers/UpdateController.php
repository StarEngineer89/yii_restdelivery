<?php
/**
 * Update Controller
 *
 */
class UpdateController extends CController
{
	public function actionIndex()
	{
		$prefix=Yii::app()->db->tablePrefix;		
		$table_prefix=$prefix;
		
		$DbExt=new DbExt;
		
		echo "STARTING UPDATE(s)";
		echo "<br/>";		
		$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."languages (
  `lang_id` int(14) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(14) NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `source_text` text NOT NULL,
  `is_assign` int(1) NOT NULL DEFAULT '2',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";		
	    echo "Creating Table languages..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("languages") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table languages already exist.<br/>"; 
		  
				
		echo "<br/>";		
		$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."stripe_logs (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `json_result` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";		
	    echo "Creating Table stripe_logs..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("stripe_logs") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table stripe_logs already exist.<br/>"; 
		  				
	    echo "<br/>Updating Table admin_user.<br/>";	        
        $new_field=array(         
          'user_lang'=>"int(14) NOT NULL",
          'email_address'=>"varchar(255) NOT NULL",
          'lost_password_code'=>"varchar(255) NOT NULL"
        );	        
        $this->alterTable('admin_user',$new_field);
        echo "<br/>";
        
        
/*1.0.1*/        
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_broadcast (
  `broadcast_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `send_to` int(14) NOT NULL,
  `list_mobile_number` text CHARACTER SET utf8 NOT NULL,
  `sms_alert_message` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`broadcast_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1;
";		
	    echo "Creating Table sms_broadcast..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("sms_broadcast") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table sms_broadcast already exist.<br/>";         
		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_broadcast_details (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `broadcast_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact_phone` varchar(50) NOT NULL,
  `sms_message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_executed` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";		
	    echo "Creating Table sms_broadcast_details..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("sms_broadcast_details") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table sms_broadcast_details already exist.<br/>";         		
		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_package (
  `sms_package_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(14,4) NOT NULL,
  `promo_price` float(14,4) NOT NULL,
  `sms_limit` int(14) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`sms_package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";		
	    echo "Creating Table sms_package..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("sms_package") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table sms_package already exist.<br/>";         				
		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_package_trans (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `sms_package_id` int(14) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `package_price` float(14,4) NOT NULL,
  `sms_limit` int(14) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `payment_reference` varchar(255) NOT NULL,
  `payment_gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";		
	    echo "Creating Table sms_broadcast_details..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("sms_package_trans") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table sms_package_trans already exist.<br/>";         						
		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."payment_order (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(10) CHARACTER SET utf8 NOT NULL,
  `payment_reference` varchar(255) CHARACTER SET utf8 NOT NULL,
  `order_id` int(14) NOT NULL,
  `raw_response` text CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
";		
	    echo "Creating Table payment_order..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("payment_order") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table payment_order already exist.<br/>";         								
        
		
        echo "<br/>Updating Table merchant.<br/>";	        
        $new_field=array(         
          'user_lang'=>"int(14) NOT NULL",
          'membership_purchase_date'=>"datetime NOT NULL",
          'sort_featured'=>"int(14) NOT NULL",
          'is_commission'=>"int(1) NOT NULL DEFAULT '1'",
          'percent_commision'=>"float(14,5) NOT NULL",
        );	        
        $this->alterTable('merchant',$new_field);
        echo "<br/>";
        
        echo "<br/>Updating Table packages.<br/>";	        
        $new_field=array(         
          'sell_limit'=>"int(14) NOT NULL"     
        );	        
        $this->alterTable('packages',$new_field);
        echo "<br/>";
                
        /*END 1.0.1*/
        
        
$stmt="CREATE TABLE IF NOT EXISTS ".$prefix."voucher (
  `voucher_id` int(14) NOT NULL AUTO_INCREMENT,
  `voucher_name` varchar(255) NOT NULL,
  `merchant_id` int(14) NOT NULL,
  `number_of_voucher` int(14) NOT NULL,
  `amount` float NOT NULL,
  `voucher_type` varchar(100) NOT NULL DEFAULT 'fixed amount',
  `status` varchar(100) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";        
echo "Creating Table voucher..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("voucher") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table voucher already exist.<br/>";         								        
		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."voucher_list (
  `voucher_id` int(14) NOT NULL,
  `voucher_code` varchar(50) NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'unused',
  `client_id` int(14) NOT NULL,
  `date_used` varchar(50) NOT NULL,
  `order_id` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";        
echo "Creating Table voucher_list..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("voucher_list") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table voucher_list already exist.<br/>";         								        		
				
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."merchant_user (
  `merchant_user_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_access` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'active',
  `last_login` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`merchant_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";        
echo "Creating Table merchant_user..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("merchant_user") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table merchant_user already exist.<br/>";         								        				
        		
		
echo "<br/>Updating Table payment_order.<br/>";	        
        $new_field=array(         
          'payment_type'=>"varchar(10) CHARACTER SET utf8 NOT NULL"     
        );	        
        $this->alterTable('payment_order',$new_field);
        echo "<br/>";
        
echo "<br/>Updating Table client.<br/>";	        
        $new_field=array(         
          'status'=>"varchar(100) NOT NULL DEFAULT 'active'" ,
          "token"=>"varchar(255) NOT NULL",  
          "mobile_verification_code"=>"int(14) NOT NULL",  
          "mobile_verification_date"=>"datetime NOT NULL", 
          'custom_field1' => "varchar(255) NOT NULL",
          'custom_field2' => "varchar(255) NOT NULL",
          'avatar' => "varchar(255) NOT NULL",
          'email_verification_code' => "varchar(14) NOT NULL",
        );	        
        $this->alterTable('client',$new_field);
        echo "<br/>";        
        		
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."bookingtable (
  `booking_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `number_guest` int(14) NOT NULL,
  `date_booking` date NOT NULL,
  `booking_time` varchar(50) NOT NULL,
  `booking_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `booking_notes` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

echo "Creating Table bookingtable..<br/>";	
	    if ( !Yii::app()->functions->isTableExist("bookingtable") ){			
			if ($DbExt->qry($stmt)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table bookingtable already exist.<br/>";         								        				

       echo "<br/>Updating Booking table<br/>";	        
        $new_field=array(         
          'status'=>"varchar(255) NOT NULL DEFAULT 'pending'",
          'viewed'=>"int(1) NOT NULL DEFAULT '1'"
        );	        
        $this->alterTable('bookingtable',$new_field);
        echo "<br/>";    
        
        
$stmt="CREATE TABLE IF NOT EXISTS ".$prefix."bank_deposit (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `branch_code` varchar(100) NOT NULL,
  `date_of_deposit` date NOT NULL,
  `time_of_deposit` varchar(50) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `scanphoto` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `date_created` date NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
echo "Updating Table bank_deposit..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";
        

       echo "<br/>Updating Bank deposit table<br/>";	        
        $new_field=array(         
          'transaction_type'=>"varchar(255) NOT NULL DEFAULT 'merchant_signup'",
          "client_id"=>"int(14) NOT NULL",
          "order_id"=>"int(14) NOT NULL"
        );	        
        $this->alterTable('bank_deposit',$new_field);
        echo "<br/>";        
        
        echo "<br/>Updating custom_page table<br/>";	        
        $new_field=array(         
          'open_new_tab'=>"int(11) NOT NULL DEFAULT '1'",
          'is_custom_link'=>"int(2) NOT NULL DEFAULT '1'"
        );	        
        $this->alterTable('custom_page',$new_field);
        echo "<br/>";                
                        
        echo "<br/>Updating order table<br/>";	        
        $new_field=array(         
          'order_change'=>"float(14,4) NOT NULL",
          'payment_provider_name'=>"varchar(255) NOT NULL",
          'discounted_amount'=>"float(14,5) NOT NULL",
          'discount_percentage'=>"float(14,5) NOT NULL",
          'percent_commision'=>"float(14,4) NOT NULL",
          'total_commission'=>"float(14,4) NOT NULL",
          'commision_ontop'=>"int(2) NOT NULL DEFAULT '2'",
          'merchant_earnings'=>"float(14,4) NOT NULL",
          'packaging'=>"float(14,4) NOT NULL",
          'cart_tip_percentage'=>"float(14,4) NOT NULL",
          "cart_tip_value"=>"float(14,4) NOT NULL",
          "card_fee"=>"float(14,4) NOT NULL",
          'donot_apply_tax_delivery'=>"int(1) NOT NULL DEFAULT '1'",
          'order_locked'=>"int(1) NOT NULL DEFAULT '1'",
          'request_from'=>"varchar(10) NOT NULL DEFAULT 'web'",
          'mobile_cart_details'=>"text NOT NULL"
          'authKey'=>"varchar(50) NOT NULL DEFAULT 'yummy-10-10'",
        );	        
        $this->alterTable('order',$new_field);
        echo "<br/>";                 
        
$stmt="CREATE TABLE IF NOT EXISTS ".$prefix."payment_provider (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(255) NOT NULL,
  `payment_logo` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'publish',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
echo "Creating Table _payment_provider..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";      

$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."offers (
  `offers_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `offer_percentage` float(14,4) NOT NULL,
  `offer_price` float(14,4) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`offers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table _offers..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>"; 

$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."newsletter (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table _newsletter..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>"; 


        echo "<br/>Updating Table sms_broadcast_details.<br/>";	        
        $new_field=array(         
          'gateway'=>"varchar(255) NOT NULL DEFAULT 'twilio'"     
        );
        $this->alterTable('sms_broadcast_details',$new_field);
        echo "<br/>";
        
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."barclay_trans (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL DEFAULT 'signup',
  `date_created` date NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `param1` varchar(255) NOT NULL,
  `param2` text NOT NULL,
  `param3` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table barclay_trans..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";         

$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."ingredients (
  `ingredients_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `ingredients_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'published',
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`ingredients_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table ingredients..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";         

        $new_field=array(         
          'ingredients'=>"text NOT NULL",
          'spicydish'=>"int(2) NOT NULL DEFAULT '1'",
          "two_flavors"=>"int(2) NOT NULL",
          "two_flavors_position"=>"text NOT NULL",
          "require_addon"=>"text NOT NULL",
          'dish'=>"text NOT NULL",
          'item_name_trans'=>"text NOT NULL",
          'item_description_trans'=>"text NOT NULL",
          'non_taxable'=>"int(1) NOT NULL DEFAULT '1'",
          'not_available'=>"int(1) NOT NULL DEFAULT '1'",
          'gallery_photo'=>"text NOT NULL"
        );	                
        $this->alterTable('item',$new_field);
        echo "<br/>";        
        
        $new_field=array(         
          'ingredients'=>"text NOT NULL" ,
          'non_taxable'=>"int(1) NOT NULL DEFAULT '1'"
        );	        
        $this->alterTable('order_details',$new_field);
        echo "<br/>";        
        
        
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."withdrawal (
  `withdrawal_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `current_balance` float(14,4) NOT NULL,
  `balance` float(14,4) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `account` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) NOT NULL,
  `swift_code` varchar(100) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_branch` varchar(255) NOT NULL,
  `bank_country` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `viewed` int(2) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_to_process` date NOT NULL,
  `date_process` datetime NOT NULL,
  `api_raw_response` text NOT NULL,
  `withdrawal_token` text NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `bank_type` varchar(255) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`withdrawal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table withdrawal..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";              

      $new_field=array(         
          'bank_type'=>"varchar(255) NOT NULL DEFAULT 'default'"          
        );	        
        $this->alterTable('withdrawal',$new_field);
        echo "<br/>";        

        $new_field=array(         
          'contact_email'=>"varchar(255) NOT NULL",
          'session_token'=>"varchar(255) NOT NULL",
        );	        
        $this->alterTable('merchant_user',$new_field);
        echo "<br/>";        
                
        
        $new_field=array(         
          'abn'=>"varchar(255) NOT NULL",
          'session_token'=>"varchar(255) NOT NULL" ,
          'commision_type'=>"varchar(50) NOT NULL DEFAULT 'percentage'"     
        );	        
        $this->alterTable('merchant',$new_field);
        echo "<br/>";      
        
        
$stmt="
CREATE TABLE IF NOT EXISTS ".$prefix."fax_package (
`fax_package_id` int(14) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`description` text NOT NULL,
`price` float(14,4) NOT NULL,
`promo_price` float(14,4) NOT NULL,
`fax_limit` int(14) NOT NULL,
`sequence` int(14) NOT NULL,
`status` varchar(100) NOT NULL,
`date_created` datetime NOT NULL,
`date_modified` datetime NOT NULL,
`ip_address` varchar(100) NOT NULL,
PRIMARY KEY (`fax_package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table fax_package..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";                      


$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."fax_package_trans (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `fax_package_id` int(14) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `package_price` float(14,4) NOT NULL,
  `fax_limit` int(14) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `payment_reference` varchar(255) NOT NULL,
  `payment_gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

echo "Creating Table fax_package_trans..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";                      

$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."fax_broadcast (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `faxno` varchar(50) NOT NULL,
  `recipname` varchar(32) NOT NULL,
  `faxurl` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `jobid` varchar(255) NOT NULL,
  `api_raw_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_process` datetime NOT NULL,
  `date_postback` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

echo "Creating Table fax_broadcast..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";

$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."shipping_rate (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `distance_from` int(14) NOT NULL,
  `distance_to` int(14) NOT NULL,
  `shipping_units` varchar(5) NOT NULL,
  `distance_price` float(14,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

echo "Creating Table shipping_rate..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";

       $new_field=array(         
          'spicydish'=>"int(2) NOT NULL DEFAULT '1'",
          'spicydish_notes'=>"text NOT NULL" ,
          'dish'=>"text NOT NULL",
          'category_name_trans'=>"text NOT NULL",
          'category_description_trans'=>"text NOT NULL",
        );	        
        $this->alterTable('category',$new_field);
        echo "<br/>";  
        
        $new_field=array(         
          'session_token'=>"varchar(255) NOT NULL",
          'last_login'=>"datetime NOT NULL",
          'user_access'=>"text NOT NULL"
        );	        
        $this->alterTable('admin_user',$new_field);
        echo "<br/>";  

        

/**ADD INDEX*/
$this->addIndex('option','merchant_id');
$this->addIndex('rating','merchant_id');
$this->addIndex('rating','client_id');
$this->addIndex('order','merchant_id');
$this->addIndex('order','client_id');


$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."order_delivery_address (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `contact_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table order_delivery_address..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";


        $new_field=array(         
          'fee'=>"float(14,4) NOT NULL"          
        );	 
        $this->alterTable('package_trans',$new_field);
        echo "<br/>";  
        
        $new_field=array(         
          'contact_phone'=>"varchar(100) NOT NULL" 
        );	 
        $this->alterTable('order_delivery_address',$new_field);
        echo "<br/>";  
        
        $new_field=array(         
          'status'=>"varchar(100) NOT NULL DEFAULT 'publish'",
          'subcategory_name_trans'=>"text NOT NULL",
          'subcategory_description_trans'=>"text NOT NULL",
        );	 
        $this->alterTable('subcategory',$new_field);
        echo "<br/>";       
        
        /**check if has a permission set for admin*/
        $stmt="SELECT * FROM
        {{admin_user}}
        WHERE
        user_access<>''      
        ";        
        if ( !$DbExt->rst($stmt)){
        	$user_all_access='["autologin","dashboard","merchant","sponsoredMerchantList","packages","Cuisine","dishes","OrderStatus","settings","commisionsettings","voucher","merchantcommission","withdrawal","incomingwithdrawal","withdrawalsettings","emailsettings","emailtpl","customPage","Ratings","ContactSettings","SocialSettings","ManageCurrency","ManageLanguage","Seo","analytics","customerlist","subscriberlist","reviews","bankdeposit","paymentgatewaysettings","paymentgateway","paypalSettings","stripeSettings","mercadopagoSettings","sisowsettings","payumonenysettings","obdsettings","payserasettings","payondelivery","barclay","epaybg","authorize","sms","smsSettings","smsPackage","smstransaction","smslogs","fax","faxtransaction","faxpackage","faxlogs","faxsettings","reports","rptMerchantReg","rptMerchantPayment","rptMerchanteSales","rptmerchantsalesummary","rptbookingsummary","userList"]
';
        	$stmt_update_admin="UPDATE {{admin_user}}
        	SET user_access='$user_all_access'
        	";        	
        	$DbExt->qry($stmt_update_admin);
        }
        
        
        $alter_table="
        ALTER TABLE {{currency}} CHANGE 
       `currency_symbol` `currency_symbol` VARCHAR( 100 ) 
        CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ";                                         
        dump($alter_table);
        $DbExt->qry($alter_table);
        
        
        
$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."dishes (
  `dish_id` int(14) NOT NULL AUTO_INCREMENT,
  `dish_name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`dish_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table dishes..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";

$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."voucher_new (
  `voucher_id` int(14) NOT NULL AUTO_INCREMENT,
  `voucher_owner` varchar(255) NOT NULL DEFAULT 'merchant',
  `merchant_id` int(14) NOT NULL,
  `joining_merchant` text NOT NULL,
  `voucher_name` varchar(255) NOT NULL,
  `voucher_type` varchar(255) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `expiration` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `used_once` int(1) NOT NULL DEFAULT '1',  
  PRIMARY KEY (`voucher_id`),
  KEY `voucher_name` (`voucher_name`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";
echo "Creating Table voucher_new..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";
        

$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."address_book (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `as_default` int(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table address_book..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";
        
       $new_field=array(         
          'size_name_trans'=>"text NOT NULL"          
        );	 
        $this->alterTable('size',$new_field);
        echo "<br/>";       
        
        $new_field=array(         
          'ingredients_name_trans'=>"text NOT NULL"          
        );	 
        $this->alterTable('ingredients',$new_field);
        echo "<br/>";     
        
        $new_field=array(         
          'sub_item_name_trans' =>"text NOT NULL",
          'item_description_trans'=>"text NOT NULL"          
        );	 
        $this->alterTable('subcategory_item',$new_field);
        echo "<br/>";     
        
        $new_field=array(         
          'cooking_name_trans'=>"text NOT NULL"          
        );	 
        $this->alterTable('cooking_ref',$new_field);
        echo "<br/>";     
        
        
        $stmt_alter="
        ALTER TABLE ".$table_prefix."languages CHANGE 
        `language_code` `language_code` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL 
        ";
        dump($stmt_alter);
        $DbExt->qry($stmt_alter);
        
        
        $new_field=array(         
          'used_once'=>"int(1) NOT NULL DEFAULT '1'"          
        );	 
        $this->alterTable('voucher_new',$new_field);
        echo "<br/>";     
        
        /** new fields for update version 2.4*/
        $new_field=array(         
          'order_id'=>"varchar(14) NOT NULL"          
        );	 
        $this->alterTable('review',$new_field);
        echo "<br/>";     
                
$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."order_history (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table order_history..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";

$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."order_sms (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(50) NOT NULL,
  `code` int(4) NOT NULL,
  `session` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session` (`session`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";
echo "Creating Table order_sms..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";

/*2.6*/
$stmt="
CREATE TABLE IF NOT EXISTS ".$table_prefix."zipcode (
  `zipcode_id` int(14) NOT NULL AUTO_INCREMENT,
  `zipcode` varchar(255) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `stree_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`zipcode_id`),
  KEY `country_code` (`country_code`),
  KEY `area` (`area`),
  KEY `stree_name` (`stree_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
echo "Creating Table zipcode..<br/>";	
$DbExt->qry($stmt);
echo "(Done)<br/>";
        

        /** new fields for update version 3.1*/
        $new_field=array(         
          'cuisine_name_trans'=>"text NOT NULL"          
        );	 
        $this->alterTable('cuisine',$new_field);
        echo "<br/>";     
                                
        /*special category*/
        $new_field=array(         
          'parent_cat_id'=>"int(14) NOT NULL"          
        );	 
        $this->alterTable('category',$new_field);
        echo "<br/>";     
                        
        echo "Updating table order_delivery_address<br/>";
		$new_field=array( 
		   'formatted_address'=>"text NOT NULL",
		   'google_lat'=>"varchar(50) NOT NULL",
		   'google_lng'=>"varchar(50) NOT NULL",
		);
		$this->alterTable('order_delivery_address',$new_field);			
		
		echo "Updating table bookingtable<br/>";
		$new_field=array( 
		   'client_id'=>"int(14) NOT NULL"		   
		);
		$this->alterTable('bookingtable',$new_field);
		
		echo "Updating table client<br/>";
		$new_field=array( 
		   'is_guest'=>"int(1) NOT NULL DEFAULT '2'"		   
		);
		$this->alterTable('client',$new_field);
				
		$stmt="
		CREATE TABLE IF NOT EXISTS ".$prefix."receive_post (
		  `id` int(14) NOT NULL AUTO_INCREMENT,
		  `payment_type` varchar(3) NOT NULL,
		  `receive_post` text NOT NULL,
		  `status` text NOT NULL,
		  `date_created` datetime NOT NULL,
		  `ip_address` varchar(50) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1" ;

		echo "Creating Table receive_post..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";		
		
		
		/*VERSION 4.0 UPDATES*/
		
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."email_logs (
		  `id` int(14) NOT NULL,
		  `email_address` varchar(255) NOT NULL DEFAULT '',
		  `sender` varchar(255) NOT NULL DEFAULT '',
		  `subject` varchar(255) NOT NULL DEFAULT '',
		  `content` text NOT NULL,
		  `status` varchar(200) NOT NULL DEFAULT 'pending',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT '',
		  `module_type` varchar(255) NOT NULL DEFAULT '',
		  `user_type` varchar(100) NOT NULL DEFAULT '',
		  `user_id` int(14) NOT NULL DEFAULT '0',
		  `merchant_id` int(14) NOT NULL DEFAULT '0',
		  `email_provider` varchar(100) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					
		ALTER TABLE ".$prefix."email_logs
		  ADD PRIMARY KEY (`id`),
		  ADD KEY `user_id` (`user_id`),
		  ADD KEY `user_type` (`user_type`),
		  ADD KEY `merchant_id` (`merchant_id`),
		  ADD KEY `module_type` (`module_type`),
		  ADD KEY `email_address` (`email_address`);
		  
		  
		ALTER TABLE ".$prefix."email_logs
		  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table email_logs..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		$new_field=array( 
		   'email_provider'=>"varchar(100) NOT NULL DEFAULT ''",	   		  
		);
		$this->alterTable('email_logs',$new_field);
		
	    $stmt="
		CREATE TABLE IF NOT EXISTS ".$prefix."minimum_table (
		  `id` int(14) NOT NULL,
		  `merchant_id` int(14) NOT NULL DEFAULT '0',
		  `distance_from` int(14) NOT NULL DEFAULT '0',
		  `distance_to` int(14) DEFAULT '0',
		  `shipping_units` varchar(5) NOT NULL DEFAULT '',
		  `min_order` float(14,4) NOT NULL DEFAULT '0.0000'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE ".$prefix."minimum_table
		ADD PRIMARY KEY (`id`),
		ADD KEY `merchant_id` (`merchant_id`);
		
		ALTER TABLE ".$prefix."minimum_table
        MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table minimum_table..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
				
		echo "Updating table _order<br/>";
		$new_field=array( 
		   'apply_food_tax'=>"int(1) NOT NULL DEFAULT '0'",	   
		   'order_id_token'=>"varchar(100) NOT NULL DEFAULT ''",
		   'admin_viewed'=>"int(1) NOT NULL DEFAULT '0'",
		   'merchantapp_viewed'=>"int(1) NOT NULL DEFAULT '0'",
		   'dinein_number_of_guest'=>"varchar(14) NOT NULL DEFAULT ''",
		   'dinein_special_instruction'=>"varchar(255) NOT NULL DEFAULT ''",
		   'critical'=>"int(1) NOT NULL DEFAULT '1'",
		   'commision_type'=>"varchar(50) NOT NULL DEFAULT 'percentage'"
		);
		$this->alterTable('order',$new_field);
				
		echo "Updating table _merchant<br/>";
		$new_field=array( 
		   'merchant_key'=>"varchar(255) NOT NULL DEFAULT ''", 
		   'latitude'=>"varchar(50) NOT NULL DEFAULT ''", 
		   'lontitude'=>"varchar(50) NOT NULL DEFAULT ''", 
		   'delivery_charges'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'minimum_order'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'delivery_minimum_order'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'delivery_maximum_order'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'pickup_minimum_order'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'pickup_maximum_order'=>"float(14,5) NOT NULL DEFAULT '0.00000'", 
		   'country_name'=>"varchar(255) NOT NULL DEFAULT ''", 
		   'country_id'=>"int(14) NOT NULL DEFAULT '0'", 
		   'state_id'=>"int(14) NOT NULL DEFAULT '0'", 
		   'city_id'=>"int(14) NOT NULL DEFAULT '0'", 
		   'area_id'=>"int(14) NOT NULL DEFAULT '0'", 
		   'logo'=>"varchar(255) NOT NULL DEFAULT ''", 
		   'merchant_type'=>"int(1) NOT NULL DEFAULT '1'", 
		   'invoice_terms'=>"int(14) NOT NULL DEFAULT '7'", 
		);
		$this->alterTable('merchant',$new_field);
				
		$stmt="
		CREATE TABLE IF NOT EXISTS ".$prefix."bookingtable_history (
		  `id` int(14) NOT NULL,
		  `booking_id` int(14) NOT NULL DEFAULT '0',
		  `status` varchar(255) NOT NULL DEFAULT '',
		  `remarks` varchar(255) NOT NULL DEFAULT '',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE ".$prefix."bookingtable_history
		  ADD PRIMARY KEY (`id`),
		  ADD KEY `booking_id` (`booking_id`),
		  ADD KEY `status` (`status`);
		
		  ALTER TABLE ".$prefix."bookingtable_history
		  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;		
		";
		
		echo "Creating Table bookingtable_history..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."location_area (
		  `area_id` int(14) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `city_id` int(14) NOT NULL DEFAULT '0',
		  `sequence` int(14) NOT NULL DEFAULT '0',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
						
		ALTER TABLE ".$prefix."location_area
		  ADD PRIMARY KEY (`area_id`),
		  ADD KEY `city_id` (`city_id`),
		  ADD KEY `sequence` (`sequence`),
		  ADD KEY `name` (`name`);
		  
		  
		ALTER TABLE ".$prefix."location_area
		  MODIFY `area_id` int(14) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table location_area..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		$stmt="				
		CREATE TABLE IF NOT EXISTS ".$prefix."location_cities (
		  `city_id` int(11) NOT NULL,
		  `name` varchar(30) NOT NULL,
		  `postal_code` varchar(255) NOT NULL DEFAULT '',
		  `state_id` int(11) NOT NULL,
		  `sequence` int(14) NOT NULL DEFAULT '0',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;		  
				
		ALTER TABLE ".$prefix."location_cities
		  ADD PRIMARY KEY (`city_id`),
		  ADD KEY `postal_code` (`postal_code`),
		  ADD KEY `state_id` (`state_id`),
		  ADD KEY `sequence` (`sequence`),
		  ADD KEY `name` (`name`);
		  
		  
		ALTER TABLE ".$prefix."location_cities
		  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table location_cities..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."location_countries (
		  `country_id` int(11) NOT NULL,
		  `shortcode` varchar(3) NOT NULL,
		  `country_name` varchar(150) NOT NULL,
		  `phonecode` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE ".$prefix."location_countries
		  ADD PRIMARY KEY (`country_id`),
		  ADD KEY `shortcode` (`shortcode`);
		  
		  ALTER TABLE ".$prefix."location_countries
		  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table location_countries..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		/*INSERT DATA FOR COUNTRY*/
		$DbExt->qry("TRUNCATE TABLE {{location_countries}}");
        $stmt_country=InstallHelper::CountryList();
        $stmt="
        INSERT INTO {{location_countries}} (`country_id`, `shortcode`, `country_name`, `phonecode`) 
        $stmt_country
        ";
        $DbExt->qry($stmt);
		
		$stmt="
		CREATE TABLE IF NOT EXISTS ".$prefix."location_states (
		  `state_id` int(11) NOT NULL,
		  `name` varchar(30) NOT NULL,
		  `country_id` int(11) NOT NULL DEFAULT '1',
		  `sequence` int(14) NOT NULL DEFAULT '0',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
		ALTER TABLE ".$prefix."location_states
		  ADD PRIMARY KEY (`state_id`),
		  ADD KEY `country_id` (`country_id`),
		  ADD KEY `sequence` (`sequence`),
		  ADD KEY `name` (`name`);
		
		  ALTER TABLE ".$prefix."location_states
		  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table location_states..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."location_rate (
		  `rate_id` int(14) NOT NULL,
		  `merchant_id` int(14) NOT NULL DEFAULT '0',
		  `country_id` int(14) NOT NULL DEFAULT '0',
		  `state_id` int(14) NOT NULL DEFAULT '0',
		  `city_id` int(14) DEFAULT '0',
		  `area_id` int(14) NOT NULL DEFAULT '0',
		  `fee` float(14,5) NOT NULL DEFAULT '0.00000',
		  `sequence` int(14) NOT NULL DEFAULT '0',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		
		ALTER TABLE ".$prefix."location_rate
		  ADD PRIMARY KEY (`rate_id`);
		  
		  ALTER TABLE ".$prefix."location_rate
		  MODIFY `rate_id` int(14) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table location_rate..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		echo "Updating table order_delivery_address<br/>";
		$new_field=array( 
		   'area_name'=>"varchar(255) NOT NULL DEFAULT ''",
		);
		$this->alterTable('order_delivery_address',$new_field);
				
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."invoice (
		  `invoice_number` int(14) NOT NULL,
		  `invoice_token` varchar(100) NOT NULL DEFAULT '',
		  `merchant_id` int(14) NOT NULL DEFAULT '0',
		  `merchant_name` varchar(255) NOT NULL DEFAULT '',
		  `merchant_contact_email` varchar(200) NOT NULL DEFAULT '',
		  `merchant_contact_phone` varchar(50) NOT NULL DEFAULT '',
		  `invoice_terms` int(14) NOT NULL DEFAULT '0',
		  `invoice_total` float(14,4) NOT NULL DEFAULT '0.0000',
		  `date_from` date NOT NULL DEFAULT '0000-00-00',
		  `date_to` date NOT NULL DEFAULT '0000-00-00',
		  `pdf_filename` varchar(255) NOT NULL DEFAULT '',
		  `status` varchar(255) NOT NULL DEFAULT 'pending',
		  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
		  `viewed` varchar(2) NOT NULL DEFAULT '2',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_process` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE ".$prefix."invoice
		  ADD PRIMARY KEY (`invoice_number`),
		  ADD KEY `invoice_token` (`invoice_token`),
		  ADD KEY `merchant_id` (`merchant_id`),
		  ADD KEY `status` (`status`),
		  ADD KEY `date_from` (`date_from`),
		  ADD KEY `date_to` (`date_to`),
		  ADD KEY `invoice_total` (`invoice_total`);
		
		  ALTER TABLE ".$prefix."invoice
		  MODIFY `invoice_number` int(14) NOT NULL AUTO_INCREMENT;
		";
		echo "Creating Table invoice..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		
		$stmt="		
		CREATE TABLE IF NOT EXISTS ".$prefix."invoice_history (
		  `id` int(14) NOT NULL,
		  `invoice_number` varchar(14) NOT NULL DEFAULT '',
		  `payment_status` varchar(100) NOT NULL DEFAULT '',
		  `remarks` varchar(255) NOT NULL DEFAULT '',
		  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `ip_address` varchar(50) NOT NULL DEFAULT ''
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		ALTER TABLE ".$prefix."invoice_history
		  ADD PRIMARY KEY (`id`),
		  ADD KEY `invoice_number` (`invoice_number`),
		  ADD KEY `payment_status` (`payment_status`);
	  
	  ALTER TABLE ".$prefix."invoice_history
	  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
		";
		
		echo "Creating Table invoice_history..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		
		/*ADD INDEX*/
		/*MERCHANT TABLE*/
		$this->addIndex("merchant","restaurant_slug");
		$this->addIndex("merchant","restaurant_name");
		$this->addIndex("merchant","post_code");
		$this->addIndex("merchant","service");
		$this->addIndex("merchant","username");
		$this->addIndex("merchant","password");
		$this->addIndex("merchant","status");
		$this->addIndex("merchant","package_id");
		$this->addIndex("merchant","payment_steps");
		$this->addIndex("merchant","is_featured");
		$this->addIndex("merchant","is_ready");
		$this->addIndex("merchant","is_sponsored");
		$this->addIndex("merchant","is_commission");
		$this->addIndex("merchant","percent_commision");
		$this->addIndex("merchant","session_token");
		$this->addIndex("merchant","commision_type");
		$this->addIndex("merchant","delivery_charges");
		$this->addIndex("merchant","merchant_id");		
		$this->addIndex("merchant","latitude");
		$this->addIndex("merchant","lontitude");
		$this->addIndex("merchant","merchant_type");
		$this->addIndex("merchant","invoice_terms");
		
		/*RATINGS TABLE*/
		$this->addIndex("rating","ratings");
		
		/*ORDER TABLE*/
		$this->addIndex("order","viewed");
		$this->addIndex("order","admin_viewed");
		$this->addIndex("order","merchantapp_viewed");
		$this->addIndex("order","order_id_token");
		$this->addIndex("order","total_commission");
		$this->addIndex("order","merchant_earnings");
		$this->addIndex("order","total_w_tax");
		$this->addIndex("order","taxable_total");
		$this->addIndex("order","sub_total");
		$this->addIndex("order","payment_type");
		$this->addIndex("order","trans_type");
	        $this->addIndex("order","authKey")	
		/*ORDER DETAILS TABLE*/
		$this->addIndex("order_details","order_id");
		$this->addIndex("order_details","client_id");
		$this->addIndex("order_details","item_id");
		
		/*address_book*/
		$this->addIndex("address_book","client_id");
		$this->addIndex("address_book","as_default");
		
		/*admin_user*/
		$this->addIndex("admin_user","admin_id");
		$this->addIndex("admin_user","username");
		$this->addIndex("admin_user","password");
		$this->addIndex("admin_user","lost_password_code");
		$this->addIndex("admin_user","session_token");
		
		/*bank_deposit*/
		$this->addIndex("bank_deposit","merchant_id");
		$this->addIndex("bank_deposit","status");
		$this->addIndex("bank_deposit","client_id");
		$this->addIndex("bank_deposit","order_id");
		
		/*barclay_trans*/
		$this->addIndex("barclay_trans","orderid");
		$this->addIndex("barclay_trans","token");
		$this->addIndex("barclay_trans","transaction_type");
		
		/*bookingtable*/
		$this->addIndex("bookingtable","merchant_id");
		$this->addIndex("bookingtable","status");
		$this->addIndex("bookingtable","viewed");
		$this->addIndex("bookingtable","client_id");
		$this->addIndex("bookingtable","date_booking");
		
		/*category*/
		$this->addIndex("category","merchant_id");
		$this->addIndex("category","category_name");
		$this->addIndex("category","status");
		$this->addIndex("category","sequence");
		$this->addIndex("category","parent_cat_id");
		
		/*client*/
		$this->addIndex("client","social_strategy");
		$this->addIndex("client","email_address");
		$this->addIndex("client","password");
		$this->addIndex("client","street");
		$this->addIndex("client","city");
		$this->addIndex("client","state");
		$this->addIndex("client","contact_phone");
		$this->addIndex("client","lost_password_token");
		$this->addIndex("client","status");
		$this->addIndex("client","token");
		$this->addIndex("client","mobile_verification_code");
		$this->addIndex("client","is_guest");
		$this->addIndex("client","email_verification_code");
		
		/*client_cc*/
		$this->addIndex("client_cc","client_id");
		
		/*cooking_ref*/
		$this->addIndex("cooking_ref","merchant_id");
		$this->addIndex("cooking_ref","cooking_name");
		$this->addIndex("cooking_ref","sequence");
		$this->addIndex("cooking_ref","status");
		
		/*cuisine*/
		$this->addIndex("cuisine","cuisine_name");
		$this->addIndex("cuisine","sequence");
		
		/*currency*/
		$this->addIndex("currency","currency_symbol");
		$this->addIndex("currency","currency_code");
		
		/*custom_page*/
		$this->addIndex("custom_page","slug_name");
		
		/*dishes*/
		$this->addIndex("dishes","dish_name");
		
		/*fax_broadcast*/
		$this->addIndex("fax_broadcast","merchant_id");		
		
		/*fax_package*/
		$this->addIndex("fax_package","title");
		$this->addIndex("fax_package","status");
		
		/*ingredients*/
		$this->addIndex("ingredients","merchant_id");
		$this->addIndex("ingredients","status");
		$this->addIndex("ingredients","ingredients_name");
		
		/*item*/
		$this->addIndex("item","merchant_id");
		$this->addIndex("item","item_name");
		$this->addIndex("item","status");
		$this->addIndex("item","is_featured");
		$this->addIndex("item","spicydish");
		$this->addIndex("item","two_flavors");
		/*$this->addIndex("item","points_earned");
		$this->addIndex("item","points_disabled");*/
		
		/*item*/
		$this->addIndex("merchant_cc","merchant_id");
		
		/*merchant_user*/
		$this->addIndex("merchant_user","merchant_id");
		$this->addIndex("merchant_user","username");
		$this->addIndex("merchant_user","password");
		$this->addIndex("merchant_user","status");
		$this->addIndex("merchant_user","session_token");
		/*$this->addIndex("merchant_user","mobile_session_token");
		$this->addIndex("merchant_user","lost_password_code");*/
		
		/*newsletter*/
		$this->addIndex("newsletter","email_address");
		
		/*offers*/
		$this->addIndex("offers","merchant_id");
		$this->addIndex("offers","status");
		
		/*offers*/
		$this->addIndex("option","option_name");
		
		/*order_delivery_address*/
		$this->addIndex("order_delivery_address","order_id");
		$this->addIndex("order_delivery_address","client_id");		
		$this->addIndex("order_delivery_address","google_lat");
		$this->addIndex("order_delivery_address","google_lng");
		
		/*order_history*/
		$this->addIndex("order_history","order_id");
		$this->addIndex("order_history","status");		
		/*$this->addIndex("order_history","task_id");
		$this->addIndex("order_history","driver_id");
		$this->addIndex("order_history","driver_location_lat");
		$this->addIndex("order_history","driver_location_lng");*/
		
		/*order_status*/
		$this->addIndex("order_status","merchant_id");
		
		/*packages*/
		$this->addIndex("packages","title");
		$this->addIndex("packages","status");
		
		/*package_trans*/
		$this->addIndex("package_trans","package_id");
		$this->addIndex("package_trans","merchant_id");
		$this->addIndex("package_trans","TRANSACTIONID");
		$this->addIndex("package_trans","status");
		
		/*payment_order*/
		$this->addIndex("payment_order","order_id");
		$this->addIndex("payment_order","payment_type");
		$this->addIndex("payment_order","payment_reference");
		
		/*payment_provider*/
		$this->addIndex("payment_provider","payment_name");
		$this->addIndex("payment_provider","status");
		
		/*paypal_checkout*/
		$this->addIndex("paypal_checkout","order_id");
		$this->addIndex("paypal_checkout","token");
		$this->addIndex("paypal_checkout","status");
		
		/*paypal_checkout*/
		$this->addIndex("paypal_checkout","order_id");
		$this->addIndex("paypal_checkout","token");
		$this->addIndex("paypal_checkout","status");
		
		/*review*/
		$this->addIndex("review","client_id");
		$this->addIndex("review","merchant_id");
		$this->addIndex("review","rating");
		$this->addIndex("review","status");
		
		/*size*/
		$this->addIndex("size","merchant_id");		
		$this->addIndex("size","size_name");		
		$this->addIndex("size","status");		
		
		/*shipping_rate*/
		$this->addIndex("shipping_rate","merchant_id");		
		
		/*sms_broadcast*/
		$this->addIndex("sms_broadcast","merchant_id");		
		$this->addIndex("sms_broadcast","send_to");		
		$this->addIndex("sms_broadcast","status");		
		
		/*sms_broadcast_details*/
		$this->addIndex("sms_broadcast_details","merchant_id");		
		$this->addIndex("sms_broadcast_details","broadcast_id");
		$this->addIndex("sms_broadcast_details","client_id");
		$this->addIndex("sms_broadcast_details","status");
		$this->addIndex("sms_broadcast_details","gateway");
		
		/*subcategory*/
		$this->addIndex("subcategory","merchant_id");		
		$this->addIndex("subcategory","subcategory_name");
		$this->addIndex("subcategory","status");
		
		/*subcategory_item*/
		$this->addIndex("subcategory_item","merchant_id");
		$this->addIndex("subcategory_item","sub_item_name");
		$this->addIndex("subcategory_item","status");
		
		/*voucher*/
		$this->addIndex("voucher","voucher_name");
		$this->addIndex("voucher","merchant_id");
		$this->addIndex("voucher","voucher_type");
		$this->addIndex("voucher","status");
		
		/*voucher_new*/
		$this->addIndex("voucher_new","voucher_owner");
		$this->addIndex("voucher_new","merchant_id");
		$this->addIndex("voucher_new","voucher_type");
		$this->addIndex("voucher_new","status");
		
		/*withdrawal*/
		$this->addIndex("withdrawal","merchant_id");
		$this->addIndex("withdrawal","payment_type");
		$this->addIndex("withdrawal","payment_method");
		$this->addIndex("withdrawal","status");
		$this->addIndex("withdrawal","viewed");

		/*UPDATE TEMPLATES*/
		$this->actionUpdateTemplate();
		
		/*VIEW TABLES*/		
		$stmt="
		create OR REPLACE VIEW ".$prefix."view_ratings as
		select 
		merchant_id,
		SUM(ratings)/COUNT(*) AS ratings
		from
		".$prefix."rating
		group by merchant_id
		";
		
		echo "Updating view Table view_ratings..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";
		
		
		$stmt="
		create OR REPLACE VIEW ".$prefix."view_merchant as
		select a.*,
		f.ratings
		
		from ".$prefix."merchant a
		
		left join ".$prefix."view_ratings f
		ON 
		a.merchant_id = f.merchant_id 		
		";
		echo "Updating view Table merchant..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";		
		
		
		$stmt="
		create OR REPLACE VIEW ".$table_prefix."view_order_details as
		
		select a.* ,
		b.merchant_id,
		b.status,
		b.date_created
		
		from ".$table_prefix."order_details a
		
		left join ".$table_prefix."order b
		on
		a.order_id = b.order_id
		";
		echo "Creating Table view_order_details..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";				
		
		
		$stmt="
		CREATE OR REPLACE VIEW ".$prefix."view_location_rate AS
		SELECT 
		a.rate_id,
		a.merchant_id,
		a.country_id,
		b.country_name,
		a.state_id,
		c.name as state_name,
		a.city_id,
		d.name as city_name,
		d.postal_code,
		a.area_id,
		e.name as area_name,
		a.fee,
		a.sequence,
		a.date_created,
		a.date_modified,
		a.ip_address
		
		FROM
		".$prefix."location_rate a
		
		left join ".$prefix."location_countries b
		on
		a.country_id=b.country_id	   
		
		left join ".$prefix."location_states c
		on
		a.state_id = c.state_id
		
		left join ".$prefix."location_cities d
		on
		a.city_id = d.city_id
		
		left join ".$prefix."location_area e
		on
		a.area_id = e.area_id
		";
				
		echo "Creating Table view_location_rate..<br/>";	
		$DbExt->qry($stmt);
		echo "(Done)<br/>";				
		        
		echo "<br/>";
		echo "FINISH UPDATE(s)";
	}	
	
	public function setIncrement($table='', $field_name='')
	{
		$DbExt=new DbExt;
		$prefix=Yii::app()->db->tablePrefix;		
		
		$table=$prefix.$table;
		$stmt="ALTER TABLE `$table` CHANGE `$field_name` `$field_name` INT(14) NOT NULL AUTO_INCREMENT;";
		dump($stmt);		
		echo "Altering table $table<br/>";
		$DbExt->qry($stmt);
	}
	
	public function addIndex($table='',$index_name='')
	{
		$DbExt=new DbExt;
		$prefix=Yii::app()->db->tablePrefix;		
		
		$table=$prefix.$table;
		
		$stmt="
		SHOW INDEX FROM $table
		";		
		$found=false;
		if ( $res=$DbExt->rst($stmt)){
			foreach ($res as $val) {				
				if ( $val['Key_name']==$index_name){
					$found=true;
					break;
				}
			}
		} 
		
		if ($found==false){
			echo "create index<br>";
			$stmt_index="ALTER TABLE $table ADD INDEX ( $index_name ) ";
			dump($stmt_index);
			$DbExt->qry($stmt_index);
			echo "Creating Index $index_name on $table <br/>";		
            echo "(Done)<br/>";		
		} //else echo 'index exist<br>';
	}
	
	public function alterTable($table='',$new_field='')
	{
		$DbExt=new DbExt;
		$prefix=Yii::app()->db->tablePrefix;		
		$existing_field='';
		if ( $res = Yii::app()->functions->checkTableStructure($table)){
			foreach ($res as $val) {								
				$existing_field[$val['Field']]=$val['Field'];
			}			
			foreach ($new_field as $key_new=>$val_new) {				
				if (!in_array($key_new,$existing_field)){
					echo "Creating field $key_new <br/>";
					$stmt_alter="ALTER TABLE ".$prefix."$table ADD $key_new ".$new_field[$key_new];
					dump($stmt_alter);
				    if ($DbExt->qry($stmt_alter)){
					   echo "(Done)<br/>";
				   } else echo "(Failed)<br/>";
				} else echo "Field $key_new already exist<br/>";
			}
		}
	}
	
	public function actionUpdateMerchant()
	{
		$DbExt=new DbExt;
		$stmt="
		SELECT merchant_id,restaurant_name FROM
		{{merchant}}
		ORDER BY merchant_id ASC
		";
		if ($res=$DbExt->rst($stmt)){
			foreach ($res as $val) {
				//dump($val);
				$merchant_id=$val['merchant_id'];	
				$lat=self::getOption($merchant_id,'merchant_latitude');
				$lng=self::getOption($merchant_id,'merchant_longtitude');				
				$params=array(
				  'latitude'=>$lat,
				  'lontitude'=>$lng,
				  'delivery_charges'=>self::getOption($merchant_id,'merchant_delivery_charges'),
				  'minimum_order'=>self::getOption($merchant_id,'merchant_minimum_order'),
				  'delivery_minimum_order'=>self::getOption($merchant_id,'merchant_minimum_order'),
				  'delivery_maximum_order'=>self::getOption($merchant_id,'merchant_maximum_order'),
				  'pickup_minimum_order'=>self::getOption($merchant_id,'merchant_minimum_order_pickup'),
				  'pickup_maximum_order'=>self::getOption($merchant_id,'merchant_maximum_order_pickup'),
				);			
				if(!is_numeric($params['delivery_charges'])){
					$params['delivery_charges']=0;
				}
				if(!is_numeric($params['minimum_order'])){
					$params['minimum_order']=0;
				}
				if(!is_numeric($params['delivery_minimum_order'])){
					$params['delivery_minimum_order']=0;
				}
				if(!is_numeric($params['delivery_maximum_order'])){
					$params['delivery_maximum_order']=0;
				}
				if(!is_numeric($params['pickup_minimum_order'])){
					$params['pickup_minimum_order']=0;
				}
				if(!is_numeric($params['pickup_maximum_order'])){
					$params['pickup_maximum_order']=0;
				}
				//dump($params);
				$DbExt->updateData("{{merchant}}",$params,'merchant_id',$merchant_id);
			}
		}
		echo "FINISH";
	}
	
	public static function getOption($customer_id='',$option_name='')
	{
		return Yii::app()->functions->getOption($option_name,$customer_id );
	}
	
	public function actionUpdateTemplate()
	{		
		$DbExt=new DbExt;
		$option=InstallHelper::optionDefaultValue();
		foreach ($option as $val) {			
			if (!InstallHelper::OptionNameExist($val['option_name'])){
				dump($val);
				$DbExt->insertData("{{option}}",$val);				
			} 
		}
		unset($DbExt);
	}
	
} /*END CLASS*/