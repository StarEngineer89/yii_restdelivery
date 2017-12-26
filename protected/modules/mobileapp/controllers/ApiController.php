<?php
class ApiController extends CController
{	
	public $data;
	public $code=2;
	public $msg='';
	public $details='';
	
	public function __construct()
	{
		$this->data=$_GET;
		
		$website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone");		 
	    if (!empty($website_timezone)){
	 	   Yii::app()->timeZone=$website_timezone;
	    }		 
	    
	    FunctionsV3::handleLanguage();
	    $lang=Yii::app()->language;		 
	    //dump($lang);
	}
	
	public function beforeAction($action)
	{				
		/*check if there is api has key*/		
		$action=Yii::app()->controller->action->id;				
		if(isset($this->data['api_key'])){
			if(!empty($this->data['api_key'])){			   
			   $continue=true;
			   if($action=="getLanguageSettings" || $action=="registerMobile"){
			   	  $continue=false;
			   }
			   if($continue){
			   	   $key=getOptionA('mobileapp_api_has_key');
				   if(trim($key)!=trim($this->data['api_key'])){
				   	 $this->msg=$this->t("api hash key is not valid");
			         $this->output();
			         Yii::app()->end();
				   }
			   }			
			}
		}		
		return true;
	}	
	
	public function actionIndex(){
		//throw new CHttpException(404,'The specified url cannot be found.');
	}		
	
	private function q($data='')
	{
		return Yii::app()->db->quoteValue($data);
	}
	
	private function t($message='')
	{
		//return Yii::t("default",$message);
		return Yii::t("mobile",$message);
	}
		
    private function output()
    {
	   $resp=array(
	     'code'=>$this->code,
	     'msg'=>$this->msg,
	     'details'=>$this->details,
	     'request'=>json_encode($this->data)		  
	   );		   
	   if (isset($this->data['debug'])){
	   	   dump($resp);
	   }
	   
	   if (!isset($_GET['callback'])){
  	   	   $_GET['callback']='';
	   }    
	   
	   if (isset($_GET['json']) && $_GET['json']==TRUE){
	   	   echo CJSON::encode($resp);
	   } else echo $_GET['callback'] . '('.CJSON::encode($resp).')';		    	   	   	  
	   Yii::app()->end();
    }	
	
	public function actionSearch()
	{		
		if (!isset($this->data['address'])){
			$this->msg=$this->t("Address is required");
			$this->output();
		}
		
		if (isset($_GET['debug'])){
			dump($this->data);
		}
		
		if ( !empty($this->data['address'])){
			 if ( $res_geo=Yii::app()->functions->geodecodeAddress($this->data['address'])){
			 	
			 	$home_search_unit_type=Yii::app()->functions->getOptionAdmin('home_search_unit_type');
			 	
			 	$home_search_radius=Yii::app()->functions->getOptionAdmin('home_search_radius');
			 	$home_search_radius=is_numeric($home_search_radius)?$home_search_radius:20;
			 	
			 	$lat=$res_geo['lat'];
				$long=$res_geo['long'];
				
				$distance_exp=3959;
				if ($home_search_unit_type=="km"){
					$distance_exp=6371;
				}		
				
				$DbExt=new DbExt; 
				$DbExt->qry("SET SQL_BIG_SELECTS=1");
				
				$lat=!empty($lat)?$lat:0;
				$long=!empty($long)?$long:0;				
			 	
				$total_records=0;
				$data='';
				
				$and="AND status='active' AND is_ready='2' ";
								
				$services_filter='';
				if (isset($this->data['services'])){
					/*$services=!empty($this->data['services'])?explode(",",$this->data['services']):false;					
					if ($services!=false){
						foreach ($services as $services_val) {
							
							if ($services_val==3 || $services_val==2){
								$services_filter.="'1',";
							}
						
							if(!empty($services_val)){
							   $services_filter.="'$services_val',";
							}
						}
						$services_filter=substr($services_filter,0,-1);
						if(!empty($services_filter)){
						   $and.=" AND service IN ($services_filter)";
						}
					}*/					
					switch ($this->data['services']) {
						case 1:
							$and.= "AND ( service='1' OR service ='2' OR service='3' OR service='4' OR service='5' OR service='6' )";
							break;			
						case 2:
							$and.= "AND ( service ='2')";
							break;
						case 3:
							$and.= "AND ( service ='3')";
							break;		
						case 4:
							//$and = "AND ( service='1' OR service ='2' OR service ='3' OR service ='4' )";
							break;			
						case 5:
							$and.= "AND ( service='1' OR service ='2' OR service ='4' OR service ='7' )";
							break;									
						case 6:
							$and.= "AND ( service='3' OR service ='4' OR service ='6' OR service ='7' )";
							break;										
						case 7:
							$and.= "AND ( service='7' )";
							break;											
						default:
							break;
					}		
				}
							
				/*dump($and);
				die();*/
				
				$filter_cuisine='';
				if (isset($this->data['cuisine_type'])){
					$cuisine_type=!empty($this->data['cuisine_type'])?explode(",",$this->data['cuisine_type']):false;
					if ($cuisine_type!=false){
						$x=1;
						foreach (array_filter($cuisine_type) as $cuisine_type_val) {							
							if ( $x==1){
							   $filter_cuisine.=" LIKE '%\"$cuisine_type_val\"%'";
						    } else $filter_cuisine.=" OR cuisine LIKE '%\"$cuisine_type_val\"%'";
							$x++;
					    }			
					    if (!empty($filter_cuisine)){
				           $and.=" AND (cuisine $filter_cuisine)";
				         }			
					}
				}
				
				
				/*filter by restaurant name*/
				if(!empty($this->data['restaurant_name'])){
					$and.=" AND restaurant_name LIKE '%".addslashes($this->data['restaurant_name'])."%'  ";
				}
			 	
			 	$stmt="
				SELECT SQL_CALC_FOUND_ROWS a.*, ( $distance_exp * acos( cos( radians($lat) ) * cos( radians( latitude ) ) 
				* cos( radians( lontitude ) - radians($long) ) 
				+ sin( radians($lat) ) * sin( radians( latitude ) ) ) ) 
				AS distance								
				
				FROM {{view_merchant}} a 
				HAVING distance < $home_search_radius			
				$and
			 	ORDER BY is_sponsored DESC, distance ASC
				LIMIT 0,100
				";
			 	if (isset($_GET['debug'])){
			 	   dump($stmt);	
			 	}
			 	if ( $res=$DbExt->rst($stmt)){		
			 		
			 		$stmtc="SELECT FOUND_ROWS() as total_records";
			 		if ($resp=$DbExt->rst($stmtc)){			 			
			 			$total_records=$resp[0]['total_records'];
			 		}			 		
			 			 		
			 		$this->code=1;
			 		$this->msg=$this->t("Successful");
			 		
			 		foreach ($res as $val) {		
			 			
			 			$mtid=$val['merchant_id'];
			 			
			 			$minimum_order=getOption($val['merchant_id'],'merchant_minimum_order');
			 			if(!empty($minimum_order)){
				 			$minimum_order=displayPrice(getCurrencyCode(),prettyFormat($minimum_order));		 			
			 			}
			 			
			 			$delivery_fee=getOption($val['merchant_id'],'merchant_delivery_charges');
			 			
			 			/*check if mechant is open*/
			 			$open=AddonMobileApp::isMerchantOpen($val['merchant_id'],false);
			 			
				        /*check if merchant is commission*/
				        $cod=AddonMobileApp::isCashAvailable($val['merchant_id']);				        
				        if(!empty($cod)){
				        	if($val['service']==3){
				        		$cod=AddonMobileApp::t("Cash on pickup available");
				        	}
				        }
				        			 		
				        $online_payment='';
				        
				        $tag='';
				        $tag_raw='';
				        if ($open==true){				        	
				        	if ( getOption( $val['merchant_id'] ,'merchant_close_store')=="yes"){
				        	    $tag=$this->t("close");
				        	    $tag_raw='close';		        		
				        	} else {
				        		$tag=$this->t("open");
				        	    $tag_raw='open';
				        	}			        
				        } else  {
				        	$tag=$this->t("close");
				        	$tag_raw='close';
				        	if (getOption( $val['merchant_id'] ,'merchant_preorder')==1){
				        		$tag=$this->t("pre-order");
				        		$tag_raw='pre-order';
				        	}
				        }			 		
				        
				        
				        // get distance			
				        $distance='';	 $distance_type=''; $delivery_distance='';
				        
				        $merchant_lat=!empty($val['latitude'])?$val['latitude']:0;
				        $merchant_lng=!empty($val['lontitude'])?$val['lontitude']:0;				        
				        $distance_type=FunctionsV3::getMerchantDistanceType($mtid);					        
				        $distance_type_raw= $distance_type=="M"?"mi":"km";
				        
				        FunctionsV3::$distance_type_result='';
				        $distance=FunctionsV3::getDistanceBetweenPlot(
					        $lat,
					        $long,
					        $merchant_lat,
					        $merchant_lng,
					        $distance_type
					    ); 
					    					    
					    $straight_line=getOptionA('google_distance_method');
					    if ( $straight_line=="straight_line"){
					    	if(is_numeric($distance)){
					    	   $distance=round($distance,PHP_ROUND_HALF_UP);
					    	}
					    }			 		
					    					    
					    $distance_raw=$distance;					    
					    					    
					    if(is_numeric($distance)){						    	
					    	$distance_type= $distance_type=="M"?t("miles"):t("kilometers");
					    	
					    	if(!empty(FunctionsV3::$distance_type_result)){
				             	$distance_type_raw=FunctionsV3::$distance_type_result;
				             	$distance_type=t(FunctionsV3::$distance_type_result);
				            }
				            
					    	$distance=AddonMobileApp::t("Distance").": ".$distance ." $distance_type";
					    
						    $delivery_distance=AddonMobileApp::t("Delivery Distance").": ".getOption($mtid,'merchant_delivery_miles');
						    $delivery_distance.=" ".$distance_type;
					    
					        $delivery_fee=FunctionsV3::getMerchantDeliveryFee(
	                          $mtid,
	                          $delivery_fee,
	                          $distance_raw,
	                          $distance_type_raw);		
					    }                               		                    
				      
				        if(is_numeric($delivery_fee)){
			 				$delivery_fee=displayPrice(getCurrencyCode(),prettyFormat($delivery_fee));
			 			}
				        
			 			$payment_available=AddonMobileApp::displayCashAvailable($mtid,$val['service']);
			 			
					    					    
			 			$data[]=array(
			 			  'merchant_id'=>$val['merchant_id'],
			 			  'restaurant_name'=>stripslashes($val['restaurant_name']),
			 			  'address'=>$val['street']." ".$val['city']." ".$val['state']." ".$val['post_code'],
			 			  'ratings'=>Yii::app()->functions->getRatings($val['merchant_id']),
			 			  'cuisine'=>AddonMobileApp::prettyCuisineList($val['cuisine']),
			 			  //'delivery_fee'=>!empty($delivery_fee)?$delivery_fee:'-',
			 			  'delivery_fee'=>!empty($delivery_fee)?$delivery_fee:AddonMobileApp::t("Free Delivery"), 
			 			  'minimum_order'=>$minimum_order,
			 			  'delivery_est'=>getOption($val['merchant_id'],'merchant_delivery_estimation'),
			 			  'is_open'=>$tag,
			 			  'tag_raw'=>$tag_raw,
			 			  'payment_options'=>array(
			 			    'cod'=>$cod,
			 			    'online'=>$online_payment
			 			  ),			 			 
			 			  'logo'=>AddonMobileApp::getMerchantLogo($val['merchant_id']),
			 			  'offers'=>AddonMobileApp::getMerchantOffers($val['merchant_id']),
			 			  'service'=>$val['service'],
			 			  'services'=>AddonMobileApp::displayServicesList($val['service']),
			 			  'distance'=>$distance,
			 			  'delivery_estimation'=>$this->t("Delivery Est").": ".getOption($mtid,'merchant_delivery_estimation'),
			 			  'delivery_distance'=>$delivery_distance,
			 			  'is_sponsored'=>$val['is_sponsored'],
			 			  'payment_available'=>$payment_available
			 			);
			 		}			 		
			 					 		
			 		$this->details=array(
			 		  'total'=>$total_records,
			 		  'data'=>$data
			 		);
			 		
			 	} else $this->msg=$this->t("No restaurant found");
			 } else $this->msg=$this->t("Error has occured failed geocoding address");
		} else $this->msg=$this->t("Address is required");
		$this->output();
	}
	
	public function actionMenuCategory()
	{	

		//clear cart	
		$DbExt=new DbExt;
		if(isset($this->data['device_id'])){
			$DbExt->qry("
			DELETE FROM {{mobile_cart}}
			WHERE
			device_id=".AddonMobileApp::q($this->data['device_id'])."
			");
		}
		
		$data='';	
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant id is missing");
			$this->output();
		}
		if ( $data = AddonMobileApp::merchantInformation($this->data['merchant_id'])){				
			
			$mtid=$this->data['merchant_id'];
			
 			if($data['menu_category']=Yii::app()->functions->getCategoryList2($this->data['merchant_id'])){
 			  $data['has_menu_category']=2;
 			} else $data['has_menu_category']=1;
 			 			
 			$trans=getOptionA('enabled_multiple_translation'); 			
 			if ( $trans==2 && isset($_GET['lang_id'])){
 				$new='';
	 			if (AddonMobileApp::isArray($data['menu_category'])){
	 				foreach ($data['menu_category'] as $val) {	 					
	 					$val['category_name']=stripslashes($val['category_name']);
	 					$val['category_name']=AddonMobileApp::translateItem('category',
	 					$val['category_name'],$val['cat_id']);
	 					$new[]=$val;
	 				}
	 				
	 				unset($data['menu_category']);
	 				$data['menu_category']=$new;
	 			}			 			
 			} else {
 				if (is_array($data) && count($data)>=1){
 					$new='';
 					foreach ($data['menu_category'] as $val) {	 					
	 					$val['category_name']=stripslashes($val['category_name']);	 					
	 					$new[]=$val;
	 				}	 				
	 				unset($data['menu_category']);
	 				$data['menu_category']=$new; 						
 				} 			
 			}					
 			
 			$data['restaurant_name']=stripslashes($data['restaurant_name']);
 			$data['address']=stripslashes($data['address']);
 			
 			
            $table_booking=2;
			if ( getOptionA('merchant_tbl_book_disabled')==2){
				$table_booking=1;
			} else {
				if ( getOption($this->data['merchant_id'],'merchant_table_booking')=="yes"){
					$table_booking=1;
				}			
				
				$merchant_master_table_boooking=getOption($this->data['merchant_id'],'merchant_master_table_boooking');
				if($merchant_master_table_boooking==1){
					$table_booking=1;
				}			
			}		
			$data['enabled_table_booking']=$table_booking;

			$data['coordinates']=array(
			   'latitude'=>getOption($mtid,'merchant_latitude'),
			   'longtitude'=>getOption($mtid,'merchant_longtitude'),
			);
			
 			$this->code=1;
			$this->msg=$this->t("Successful");			
			$this->details=$data;			
		} else $this->msg=$this->t("Restaurant not found");
				
		$this->output();
	}
	
	public function actionCuisineList()
	{		
		if ($resp=Yii::app()->functions->Cuisine(true)){
			$this->code=1;
			$this->msg=$this->t("Successful");
			$this->details=array(
			  'cuisine'=>$resp,
			  'services'=>Yii::app()->functions->Services()
			);
		} else $this->msg=$this->t("No cuisine found");
		$this->output();
	}
	
	public function actionGetItemByCategory()
	{				
		if (!isset($this->data['cat_id'])){
			$this->msg=$this->t("Category is is missing");
			$this->output();
		}
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}
		
		$disabled_ordering=getOption($this->data['merchant_id'],'merchant_disabled_ordering');		
		
		if ($res=Yii::app()->functions->getItemByCategory($this->data['cat_id'],false,$this->data['merchant_id'])){
						
			$item='';
			foreach ($res as $val) {		
				
				if ($val['single_item']==2){
					$food_details=Yii::app()->functions->getFoodItem($val['item_id']);				
					if(strlen($food_details['addon_item'])>=2){
						$val['single_item']=1;
					}			
				}
				
				$price='';	
				if (is_array($val['prices'])  && count($val['prices'])>=1){
					foreach ($val['prices'] as $val_price) {
						$val_price['price_pretty']=displayPrice(getCurrencyCode(),prettyFormat($val_price['price']));
												
						if(isset($_GET['lang_id'])){
						  if($_GET['lang_id']>0){
						  	 if (array_key_exists($_GET['lang_id'],(array)$val_price['size_trans'])){
						  	 	$val_price['size']=$val_price['size_trans'][$_GET['lang_id']];
						  	 }						  						  	 
						  }						
						}										
						
						if ($val['discount']>0){
						    $val_price['price_discount']=$val_price['price']-$val['discount'];
						    $val_price['price_discount_pretty']=
						    AddonMobileApp::prettyPrice($val_price['price']-$val['discount']);
						}					
						$price[]=$val_price;
					}
				}				
				
				/*dump($price);
				die();*/
							
				$trans=getOptionA('enabled_multiple_translation'); 
				if ( $trans==2 && isset($_GET['lang_id'])){
					$item[]=array(
					  'item_id'=>$val['item_id'],
					  
					  'item_name'=>AddonMobileApp::translateItem('item',$val['item_name'],
					  $val['item_id'],'item_name_trans'),
					  
					  'item_description'=>AddonMobileApp::translateItem('item',$val['item_description'],
					  $val['item_id'],'item_description_trans'),
					  
					  'discount'=>$val['discount'],
					  'photo'=>AddonMobileApp::getImage($val['photo']),
					  'spicydish'=>$val['spicydish'],
					  'dish'=>$val['dish'],
					  'single_item'=>$val['single_item'],
					  'single_details'=>$val['single_details'],
					  'not_available'=>$val['not_available'],
					  'prices'=>$price
					);
				} else {
					$item[]=array(
					  'item_id'=>$val['item_id'],
					  'item_name'=>$val['item_name'],
					  'item_description'=>$val['item_description'],
					  'discount'=>$val['discount'],
					  'photo'=>AddonMobileApp::getImage($val['photo']),
					  'spicydish'=>$val['spicydish'],
					  'dish'=>$val['dish'],
					  'single_item'=>$val['single_item'],
					  'single_details'=>$val['single_details'],
					  'not_available'=>$val['not_available'],
					  'prices'=>$price
					);
				}
			}
			/*dump($item);
			die();*/
									
			$this->code=1;
			$this->msg=$this->t("Successful");						
			$merchant_info= AddonMobileApp::merchantInformation($this->data['merchant_id']);
			$category_info=Yii::app()->functions->getCategory($this->data['cat_id']);			
			
			if (is_array($category_info) && count($category_info)>=1){
				$category_info['category_name']=stripslashes($category_info['category_name']);
			    $category_info['category_name']=AddonMobileApp::translateItem('category',
	 					$category_info['category_name'],$category_info['cat_id']);
			}
			
			$merchant_info['restaurant_name']=stripslashes($merchant_info['restaurant_name']);
			$merchant_info['address']=stripslashes($merchant_info['address']);
			
			
			/*get category list*/
			$new_category_list='';
			if($category_list=Yii::app()->functions->getCategoryList2($this->data['merchant_id'])){			   
 			   foreach ($category_list as $key_cat_id=>$category_val) {  			   	    
 			   	    $category_val['category_id']=$key_cat_id;
 			   	    $category_val['category_name']=stripslashes($category_val['category_name']);
 			  	    $category_val['category_name']=AddonMobileApp::translateItem('category',
	 			    $category_val['category_name'],$key_cat_id);
	 			    $category_val['merchant_id']=$this->data['merchant_id'];
	 			    
	 			    unset($category_val['category_description']);
	 			    unset($category_val['dish']);
	 			    unset($category_val['category_name_trans']);
	 			    unset($category_val['category_description_trans']);
	 			    unset($category_val['photo']);
	 			    
	 				$new_category_list[]=$category_val;
 			   }
 			} 
 			 			 			 			
 			$disabled_website_ordering=getOptionA('disabled_website_ordering'); 			
 			if ( $disabled_website_ordering=="yes"){
 				$disabled_ordering=$disabled_website_ordering;
 			}
 			
			$this->details=array(
			   'disabled_ordering'=>$disabled_ordering=="yes"?2:1,
			  'image_path'=>websiteUrl()."/upload",
			  'default_item_pic'=>'mobile-default-logo.png',
			  'mobile_menu'=>getOptionA('mobile_menu'),
			  'merchant_info'=>$merchant_info,
			  'category_info'=>$category_info,
			  'category_list'=>$new_category_list,
			  'item'=>$item
			);
		} else {
			$this->msg=AddonMobileApp::t("No food item found");
			$category_info=Yii::app()->functions->getCategory($this->data['cat_id']);
			$merchant_info= AddonMobileApp::merchantInformation($this->data['merchant_id']);
			$this->details=array(
			  'merchant_info'=>$merchant_info,
			  'category_info'=>$category_info,
			);
		}
		$this->output();
	}
	
	public function actionGetItemDetails()
	{		
		if (!isset($this->data['item_id'])){
			$this->msg=$this->t("Item id is missing");
			$this->output();
		}
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}
		if ( $res=Yii::app()->functions->getItemById($this->data['item_id'])){			
			$data=$res[0];			
			$data['photo']=AddonMobileApp::getImage($data['photo']);
			$data['has_gallery']=1;

			if (!empty($data['item_description'])){
			   //$data['item_description']=strip_tags($data['item_description']);		
			}
			
			$trans=getOptionA('enabled_multiple_translation'); 
			$lang_id=$_GET['lang_id'];
            if ( $trans==2 && isset($_GET['lang_id'])){                    
				if (AddonMobileApp::isArray($data['cooking_ref'])){					
					$new_cook='';
					foreach ($data['cooking_ref'] as $cok_id=>$cok_val) {						
						$new_cook[$cok_id]=AddonMobileApp::translateItem('cookingref',
						$cok_val,$cok_id,'cooking_name_trans');
					}
					unset($data['cooking_ref']);
					$data['cooking_ref']=$new_cook;
				}
				
				if (AddonMobileApp::isArray($data['ingredients'])){
					$new_ing='';
					foreach ($data['ingredients'] as $ing_id=>$ing_val) {
						$new_ing[$ing_id]=AddonMobileApp::translateItem('ingredients',
						$ing_val,$ing_id,'ingredients_name_trans');
					}
					unset($data['ingredients']);
					$data['ingredients']=$new_ing;
				}            
            }
			
            /*dump($data);
            die();*/
			
			//$trans=getOptionA('enabled_multiple_translation'); 
            if ( $trans==2 && isset($_GET['lang_id'])){			
            	if ( array_key_exists($_GET['lang_id'],(array)$data['item_name_trans'])){
            		if (!empty($data['item_name_trans'][$_GET['lang_id']])){
            			$data['item_name']=$data['item_name_trans'][$_GET['lang_id']];
            		}            	
            	}              	
            	if ( array_key_exists($_GET['lang_id'],(array)$data['item_description_trans'])){
            		if (!empty($data['item_description_trans'][$_GET['lang_id']])){
            			$data['item_description']=$data['item_description_trans'][$_GET['lang_id']];
            		}            	
            	}            
            }
			//die();
			
			if (is_array($data['prices']) && count($data['prices'])){
				$data['has_price']=2;		
				$price='';		
				foreach ($data['prices'] as $p) {	
					$discounted_price=$p['price'];
					if ($data['discount']>0){
						$discounted_price=$discounted_price-$data['discount'];
					}				
					
					//$trans=getOptionA('enabled_multiple_translation'); 
                    if ( $trans==2 && isset($_GET['lang_id'])){                    	
                    	$lang_id=$_GET['lang_id'];
                    	if (array_key_exists($lang_id,(array)$p['size_trans'])){
                    		if ( !empty($p['size_trans'][$lang_id]) ){
                    			$p['size']=$p['size_trans'][$lang_id];
                    		}                    	
                    	}                    
                    }					
					
					$price[]=array(
					  'price'=>$p['price'],
					  'pretty_price'=>displayPrice(getCurrencyCode(),prettyFormat($p['price'],$this->data['merchant_id'])),
					  'size'=>$p['size'],
					  'discounted_price'=>$discounted_price,
					  'discounted_price_pretty'=>AddonMobileApp::prettyPrice($discounted_price)
					);
				}
				$data['prices']=$price;
			} else $data['has_price']=1;
			
			
			if (is_array($data['addon_item']) && count($data['addon_item'])>=1){
				$addon_item='';					
				foreach ($data['addon_item'] as $val) {
					//unset($val['subcat_name_trans']);
					if ( $trans==2 && isset($_GET['lang_id'])){    						
						if (array_key_exists($lang_id,(array)$val['subcat_name_trans'])){
							if(!empty($val['subcat_name_trans'][$lang_id])){
								$val['subcat_name']=$val['subcat_name_trans'][$lang_id];
							}						
						}						
					}
					$sub_item='';
					if(is_array($val['sub_item']) && count($val['sub_item'])>=1){				       
					   foreach ($val['sub_item'] as $val2) {					   	
					   	   //unset($val2['sub_item_name_trans']);
					   	   //unset($val2['item_description_trans']);
					   	   $val2['pretty_price']=displayPrice(getCurrencyCode(),
					   	   prettyFormat($val2['price'],$this->data['merchant_id']));	
					   	   
					   	   /*check if price is numeric*/
					   	   if (!is_numeric($val2['price'])){
					   	   	   $val2['price']=0;
					   	   }
					   	   
					   	   if ( $trans==2 && isset($_GET['lang_id'])){  
					   	   	   if (array_key_exists($lang_id,(array)$val2['sub_item_name_trans'])){
					   	   	   	  if ( !empty($val2['sub_item_name_trans'][$lang_id]) ){
					   	   	   	  	 $val2['sub_item_name']=$val2['sub_item_name_trans'][$lang_id];
					   	   	   	  }					   	   	   
					   	   	   }					   	   
					   	   }
					   	   				   	   
					   	   $sub_item[]=$val2;
					   }					   
					}
					$val['sub_item']=$sub_item;
					$addon_item[]=$val;
				}			
				$data['addon_item']=$addon_item;
			}
			
			$gallery_list='';
			if (!empty($data['gallery_photo'])){
				$gallery_photo=json_decode($data['gallery_photo']);
				if(is_array($gallery_photo) && count($gallery_photo)>=1){
					foreach ($gallery_photo as $pic) {
						$gallery_list[]=AddonMobileApp::getImage($pic);
					}					
					$data['gallery_photo']=$gallery_list;
					$data['has_gallery']=2;
				}				
			}
			
			$data['currency_code']=Yii::app()->functions->adminCurrencyCode();
			$data['currency_symbol']=getCurrencyCode();
			//$data['category_info']=Yii::app()->functions->getCategory($this->data['cat_id']);
			
			$category_info=Yii::app()->functions->getCategory($this->data['cat_id']);			
			if (is_array($category_info) && count($category_info)>=1){
				$category_info['category_name']=stripslashes($category_info['category_name']);
                $category_info['category_name']=AddonMobileApp::translateItem('category',
                         $category_info['category_name'],$category_info['cat_id']);
            }
			$data['category_info']=$category_info;
						
			$this->code=1;
			$this->msg="OK";
			$this->details=$data;
		} else $this->msg=$this->t("Item not found");
		$this->output();
	}
	
	public function actionLoadCart()
	{				
		//dump($this->data);
		/*if (!isset($this->data['cart'])){
			$this->msg=$this->t("cart is missing");
			$this->output();
		}*/
		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}		
		if (!isset($this->data['search_address'])){
			$this->msg=$this->t("search address is is missing");
			$this->output();
		}
				
		if ($this->data['transaction_type']=="null" || empty($this->data['transaction_type'])){
			$this->data['transaction_type']="delivery";
		}
		
		if (!isset($this->data['delivery_date'])){
			$this->data['delivery_date']='';
		}	
		if ($this->data['delivery_date']=="null" || empty($this->data['delivery_date'])){
			$this->data['delivery_date']=date("Y-m-d");
		}
		
						
		$mtid=$this->data['merchant_id'];		
	    $merchant_info= AddonMobileApp::merchantInformation($mtid);							
	    
	    /*check services offers is pickup only*/
	    if (is_array($merchant_info) && count($merchant_info)>=1){
	    	if($merchant_info['service']==3){
	    		$this->data['transaction_type']="pickup";
	    	}
	    }
	    
		$cart_content='';
		$subtotal=0;
		$taxable_total=0;
		
		Yii::app()->functions->data="list";
		$subcat_list=Yii::app()->functions->getSubcategory2($mtid);		
		
		$item_total=0;
		
		/*pts*/
		$points=0;
		$has_pts=1;
		if (AddonMobileApp::hasModuleAddon('pointsprogram')){
			if (getOptionA('points_enabled')==1){
			   $has_pts=2;
			}
		}
		
		/*tips*/				
		$remove_tips=isset($this->data['remove_tips'])?$this->data['remove_tips']:'';		
		if (isset($this->data['tips_percentage'])){
			if($this->data['tips_percentage']<=0 && $remove_tips!=1){
				$tip_enabled=getOption($mtid,'merchant_enabled_tip');
				if($tip_enabled==2){
					$tip_default=getOption($mtid,'merchant_tip_default');
					if($tip_default>0){
						$this->data['tips_percentage']=$tip_default*100;
					}				
				}		
			}
		}	
		
		//dump($this->data);	
		/*update cart*/	
		if ( AddonMobileApp::saveCartToDb() ){
			if(isset($this->data['update_cart'])){
			   if(!empty($this->data['update_cart'])){
			   	  $db=new DbExt();
			   	  $db->updateData("{{mobile_cart}}",array(
			   	    'cart'=>$this->data['update_cart']
			   	  ),'device_id',$this->data['device_id']);
			   }		
			}	
		}
		
		
		/*get cart*/
		$cart='';
		
		if ( AddonMobileApp::saveCartToDb() ){					
			if($res_cart=AddonMobileApp::getCartByDeviceID($this->data['device_id'])){		   
			   $cart=!empty($res_cart['cart'])?json_decode($res_cart['cart'],true):false;		   
			}
		} else {
			if(isset($this->data['update_cart'])){
				$cart=json_decode($this->data['update_cart'],true);
			} else $cart=json_decode($this->data['cart'],true);			
		}	
	
		//if(!empty($this->data['cart'])){			
		if(!empty($cart)){
			//$cart=json_decode($this->data['cart'],true);
			
			if(isset($_GET['debug'])){
			   //dump($cart);			
			}
						
			if (is_array($cart) && count($cart)>=1){
			    foreach ($cart as $val) {
			    	
			    	//dump($val);
			    	
			    	/*loyalty points pts*/
			    	if($has_pts==2){
			    		$set_price=explode("|",$val['price']);
			    		if(is_array($set_price) && count($set_price)>=1){
			    			$set_price=$set_price[0];
			    		} else $set_price=0;
			    		
			    		$set_price=($val['qty']*$set_price);
			    		$points+=PointsProgram::getPointsByItem($val['item_id'],$set_price);
			    	}
			    	
			    	/*group sub item*/
			    	$new_sub='';
			    	if (AddonMobileApp::isArray($val['sub_item'])){
			    		foreach ($val['sub_item'] as $valsubs) {			    			
			    			$new_sub[$valsubs['subcat_id']][]=array( 
			    			  'value'=>$valsubs['value'],
			    			  'qty'=>$valsubs['qty']
			    			);
			    		}
			    		$val['sub_item']=$new_sub;
			    	}		
			    				    				    				   
			    	$item_price=0;
			    	$item_size='';
			    	$temp_price=explode("|",$val['price']);			    	
			    	if (AddonMobileApp::isArray($temp_price)){
			    		$item_price=isset($temp_price[0])?$temp_price[0]:'';
			    		$item_size=isset($temp_price[1])?$temp_price[1]:'';
			    	}			    
			    		    	
			    	$food=Yii::app()->functions->getFoodItem($val['item_id']);			    	
			    	
			    	/*check if item qty is less than 1*/
			    	if($val['qty']<1){
			    		$val['qty']=1;
			    	}			    
			    				    				    
			    	$discounted_price=0;
			    	if ($val['discount']>0){
			    		$discounted_price=$item_price-$val['discount'];
			    		$subtotal+=($val['qty']*$discounted_price);
			    	} else {
			    		$subtotal+=($val['qty']*$item_price);
			    	}			    
			    				  		
			    	if ( $food['non_taxable']==1){	    
			      	   $taxable_total=$subtotal;
			    	}
			    	
			    	$item_total+=$val['qty'];
			    				    	
			    	$sub_item='';
			    	if(is_array($val['sub_item']) && count($val['sub_item'])>=1){
			    		foreach ($val['sub_item'] as $sub_cat_id=> $valsub0) {			    			
			    			foreach ($valsub0 as $valsub) {				    				
			    				
				    			if(!empty($valsub['value'])){
				    				$sub=explode("|",$valsub['value']);
				    								    				
				    				$sub_item_id=$sub[0];
				    				
				    				if ( $valsub['qty']=="itemqty"){
				    				   $qty=$val['qty'];
				    				} else {
				    					$qty=$valsub['qty'];
				    					if ($qty<1){
				    						$qty=1;
				    						$valsub['qty']=1;
				    					}				    				
				    				}				    
				    								    				
				    				$subitem_total=($qty*$sub[1]);				    				
				    				
				    				/*check if food item is 2 flavor*/
				    				if($food['two_flavors']!=2){				    					
					    				$subtotal+=$subitem_total;
					    				if ( $food['non_taxable']==1){	
					    				   $taxable_total+=$subitem_total;
					    				}
				    				} else {				    					
				    					/*FIXED 2 FLAVOR NOT ADDING ADDON ITEM*/
				    					$found_2_flavor=false;
				    					$t_addon_item=!empty($food['addon_item'])?json_decode($food['addon_item'],true):false;
					    				$t_two_flavors_position=!empty($food['two_flavors_position'])?json_decode($food['two_flavors_position'],true):false;
					    				if(is_array($t_two_flavors_position) && count($t_two_flavors_position)>=1){
						    				foreach ($t_two_flavors_position as $t_two_key => $t_two_val) {
						    					if ($t_two_val[0]=="left" || $t_two_val[0]=="right"){
						    						//dump("found key $t_two_key");
						    						if (isset($t_addon_item[$t_two_key])){
						    							if (in_array($sub_item_id,(array)$t_addon_item[$t_two_key])){
						    								$found_2_flavor=true;
						    							}						    						
						    						}						    					
						    					}						    				
						    				}
					    				}						    				
					    				if($found_2_flavor==false){					    				   
					    				   $subtotal+=$subitem_total;
					    				   if ( $food['non_taxable']==1){	
					    				      $taxable_total+=$subitem_total;
					    				   }
					    				}
				    				}				  
				    				
				    								    				
				    				$category_name='';
				    				if(array_key_exists($sub_cat_id,(array)$subcat_list)){
				    					$category_name=$subcat_list[$sub_cat_id];
				    				}			    			
				    				
				    				$sub_item[$category_name][]=array(
				    				  'subcat_id'=>$sub_cat_id,
				    				  'category_name'=>AddonMobileApp::translateItem('subcategory',$category_name,
				    				  $sub_cat_id,'subcategory_name_trans')
				    				  ,
				    				  'sub_item_id'=>$sub[0],
				    				  'price'=>$sub[1],
				    				  'price_pretty'=>AddonMobileApp::prettyPrice($sub[1]),
				    				  'qty'=>$valsub['qty'],
				    				  'total'=>$subitem_total,
				    				  'total_pretty'=>AddonMobileApp::prettyPrice($subitem_total),
				    				  'sub_item_name'=>$sub[2]				    				  
				    				);
				    			}
			    			}
			    		}
			    	}
			    	
			    	//dump("subtotal=>".$subtotal);
			    	
			    	$cooking_ref='';
			    	if (AddonMobileApp::isArray($val['cooking_ref'])){
			    		foreach ($val['cooking_ref'] as $valcook) {
			    			$cooking_ref[]=$valcook['value'];
			    		}
			    	}
			    	
			    	$ingredients='';			    	
			    	if (AddonMobileApp::isArray($val['ingredients'])){
			    		foreach ($val['ingredients'] as $valing) {
			    			$ingredients[]=$valing['value'];
			    		}
			    	}
			    	
			    	$cooking_ref='';
			    	if(AddonMobileApp::isArray($val['cooking_ref'])){
			    		$cooking_ref=$val['cooking_ref'][0]['value'];
			    	}
			    	$ingredients='';
			    	if(AddonMobileApp::isArray($val['ingredients'])){
			    		foreach ($val['ingredients'] as $val_ing) {
			    			$ingredients[]=$val_ing['value'];
			    		}
			    	}			    
			    	
			    	$discount_amt=0;
			    	if (isset($val['discount'])){
			    		$discount_amt=$val['discount'];
			    	}
			    	
			    	$cart_content[]=array(			    	  
			    	  'item_id'=>$val['item_id'],			    	  
			    	  'item_name'=>stripslashes(AddonMobileApp::translateItem('item',$food['item_name'],$val['item_id'],'item_name_trans')),			    	  
			    	  'item_description'=>stripslashes(AddonMobileApp::translateItem('item',$food['item_description'],$val['item_id'],'item_description_trans')),			
			    	  
			    	  'qty'=>$val['qty'],
			    	  'price'=>$item_price,
			    	  'price_pretty'=>AddonMobileApp::prettyPrice($item_price),
			    	  'total'=>$val['qty']*($item_price-$discount_amt),
			    	  'total_pretty'=>AddonMobileApp::prettyPrice($val['qty']* ($item_price-$discount_amt) ),
			    	  'size'=>$item_size,			
			    	  'discount'=>isset($val['discount'])?$val['discount']:'',
			    	  'discounted_price'=>$discounted_price,
			    	  'discounted_price_pretty'=>AddonMobileApp::prettyPrice($discounted_price),
			    	  'cooking_ref'=>$cooking_ref,
			    	  'ingredients'=>$ingredients,
			    	  'order_notes'=>$val['order_notes'],
			    	  'sub_item'=>$sub_item
			    	);
			    	
			    } /*end foreach*/
			    
			    			    
			    $ok_distance=2;
			    $delivery_charges=0;
			    $distance='';
			    
			    $merchant_delivery_distance=getOption($mtid,'merchant_delivery_miles'); 
			    //dump("merchant_delivery_distance->$merchant_delivery_distance");
			    
			    if ( $this->data['transaction_type']=="delivery" && is_numeric($merchant_delivery_distance) ){		
			    		
			    	/*if($distance=AddonMobileApp::getDistance($mtid,$this->data['search_address'])){				    	  
			    	  $mt_delivery_miles=Yii::app()->functions->getOption("merchant_delivery_miles",$mtid); 	
			    	  if($mt_delivery_miles>0){
			    	  	 if ($distance['unit']!="ft"){		
				    	  	 if ($mt_delivery_miles<=$distance['distance']){
				    	  	 	$ok_distance=1;
				    	  	 }
			    	  	 }
			    	  }
			    	  			    		
					  if($res_delivery=AddonMobileApp::getDeliveryCharges($mtid,$distance['unit'],$distance['distance'])){
						 $delivery_charges=$res_delivery['delivery_fee'];										
					  }
			    	}*/

			    	if($distance_new=AddonMobileApp::getDistanceNew($merchant_info,$this->data['search_address'])){			    	   
			    	   if(isset($_GET['debug'])){
			    	   	  dump($distance_new);
			    	   }
			    	
			    	   $distance=array(
			    	     'unit'=>$distance_new['distance_type'],
			    	     'distance'=>$distance_new['distance'],
			    	   );
			    	   $delivery_charges=$distance_new['delivery_fee'];
			    	   
			    	   $merchant_delivery_distance=getOption($mtid,'merchant_delivery_miles'); 
			    	   if($distance_new['distance_type_raw']=="ft" || $distance_new['distance_type_raw']=="meter"){
			    	   	 // do nothing
			    	   } else {			    	   	 			    	   	
			    	   	  if(is_numeric($merchant_delivery_distance)){
				    	   	  if ($merchant_delivery_distance<$distance_new['distance']){
					    	  	  $ok_distance=1;
					    	  }
			    	   	  }
			    	   }
			    	} else $ok_distance=1;
			    	
			    }  else {
			    	
			    	if ( $this->data['transaction_type']=="delivery"){
				    	/*get the default delivery fee*/
				    	$merchant_delivery_charges=getOption($mtid,'merchant_delivery_charges');			    	
				    	if(is_numeric($merchant_delivery_charges)){
				    		$delivery_charges=unPrettyPrice($merchant_delivery_charges);
				    	}			    	
			    	}
			    }			   			    
			    /* end delivery condition*/
				
				$merchant_tax_percent=0;
				$merchant_tax=getOption($mtid,'merchant_tax');			
				
               /*get merchant offers*/
		    	$discount='';
		    	if ( $offer=Yii::app()->functions->getMerchantOffersActive($mtid)){			    		
		    		$merchant_spend_amount=$offer['offer_price'];
		        	$merchant_discount_amount=number_format($offer['offer_percentage'],0);			        	
		        	if ( $subtotal>=$merchant_spend_amount){
		        		$merchant_discount_amount1=$merchant_discount_amount/100;
		        		$discounted_amount=$subtotal*$merchant_discount_amount1;
		        		
		        		$subtotal-=$discounted_amount;
		        		if ( $food['non_taxable']==1){
		        		    $taxable_total-=$discounted_amount;
		        		}		        		
		        		$discount=array(
		        		  'amount'=>$discounted_amount,
		        		  'amount_pretty'=>AddonMobileApp::prettyPrice($discounted_amount),
		        		  'display'=>$this->t("Discount")." ".number_format($offer['offer_percentage'],0)."%"
		        		);
		        	}
		    	}
		    	
		    	/*check if has offer for free delivery*/
		    	$free_delivery_above_price=getOption($mtid,'free_delivery_above_price');
		        if(is_numeric($free_delivery_above_price)){
		        	if ($subtotal>=$free_delivery_above_price){
		        		$delivery_charges=0;
		        	}			        
		        }
		        
		        /*packaging*/		        		        
		        $merchant_packaging_charge=getOption($mtid,'merchant_packaging_charge');		        
		        if ($merchant_packaging_charge>0){
		        	if ( getOption($mtid,'merchant_packaging_increment')==2){		 		      		        		
		        		$merchant_packaging_charge=$merchant_packaging_charge*$item_total;
		        	}
		        } else $merchant_packaging_charge=0;
		        
		        /*REMOVE PACKAGING IF TRANSACTION IS DINEIN*/
		        if ($this->data['transaction_type']=="dinein"){
		        	$merchant_packaging_charge=0;
		        }
		        		        
		        /*apply tips*/
		        $tips_amount=0;
		        if ( isset($this->data['tips_percentage'])){
		        	if (is_numeric($this->data['tips_percentage'])){
		        	    $tips_amount=$subtotal*($this->data['tips_percentage']/100);		        	    
		        	}
		        }
			    
	           /*get the tax*/
		        $tax=0;
		        if ( $merchant_tax>0){
		        	$merchant_tax_charges=getOption($mtid,'merchant_tax_charges');
		        	if ( $merchant_tax_charges==2){
		        		$tax=($taxable_total+$merchant_packaging_charge)*($merchant_tax/100);
		        	} else $tax=($taxable_total+$delivery_charges+$merchant_packaging_charge)*($merchant_tax/100);
		        }			    
		        		        			    
				$cart_final_content=array(
				  'cart'=>$cart_content,
				  'sub_total'=>array(
				    'amount'=>$subtotal,
				    'amount_pretty'=>AddonMobileApp::prettyPrice($subtotal)
				  )			      
				);				
								
				if (AddonMobileApp::isArray($discount)){
					$cart_final_content['discount']=$discount;
				}

				if ($delivery_charges>0){
					$cart_final_content['delivery_charges']=array(
					  'amount'=>$delivery_charges,
					  'amount_pretty'=>AddonMobileApp::prettyPrice($delivery_charges)
					);
				}
				if ($merchant_packaging_charge>0){
					$cart_final_content['packaging']=array(
					  'amount'=>$merchant_packaging_charge,
					  'amount_pretty'=>AddonMobileApp::prettyPrice($merchant_packaging_charge)
					);					
				}
				if ($tax>0){
					$cart_final_content['tax']=array(
					  'amount'=>AddonMobileApp::prettyPrice($tax),
					  'tax_pretty'=>self::t("Tax")." ".$merchant_tax."%",
					  'tax'=>unPrettyPrice($merchant_tax)
					);					
				}
				
				if ($tips_amount>0){
				   $cart_final_content['tips']=array(
					  'tips'=>$tips_amount,
					  'tips_pretty'=>AddonMobileApp::prettyPrice($tips_amount),
					  'tips_percentage'=>$this->data['tips_percentage'],
					  'tips_percentage_pretty'=>AddonMobileApp::t("Tip")." (".$this->data['tips_percentage']."%)",
					);					
				}	
				
				$grand_total=$subtotal+$delivery_charges+$merchant_packaging_charge+$tax+$tips_amount;
				$cart_final_content['grand_total']=array(
				  'amount'=>$grand_total,
				  'amount_pretty'=>AddonMobileApp::prettyPrice($grand_total)
				);
				
				/*validation*/																
				$validation_msg='';
								
				if ( $this->data['transaction_type']=="delivery"){
					if ($ok_distance==1){
						$distanceOption=Yii::app()->functions->distanceOption();
						$validation_msg=AddonMobileApp::t("Sorry but this merchant delivers only with in ").
						getOption($mtid,'merchant_delivery_miles')." ".$distanceOption[getOption($mtid,'merchant_distance_type')];
					}
				}
				
				
				/*CHECK MINIUMUM ORDER*/
				switch ( $this->data['transaction_type']) {
					case "delivery":						
					    $minimum_order=getOption($mtid,'merchant_minimum_order');
				        $maximum_order=getOption($mtid,'merchant_maximum_order');
				        if(is_numeric($minimum_order)){					    	
					    	$temp_discounte_offer=0;
					    	if(isset($discounted_amount)){
					    	   if(is_numeric($discounted_amount)){
					    	      $temp_discounte_offer=$discounted_amount;
					    	   }				    	
					    	}
					    					    					  					    	
					    	if ( ($subtotal+$temp_discounte_offer)<$minimum_order){
					    		$validation_msg=$this->t("Sorry but Minimum order is")." ".AddonMobileApp::prettyPrice($minimum_order);
					    	}				    
					    }
					    if(is_numeric($maximum_order)){				
					    	if ($subtotal>$maximum_order){
					    		$validation_msg=$this->t("Maximum Order is")." ".AddonMobileApp::prettyPrice($maximum_order);
					    	}				    
					    }	
						break;
						
					case "pickup":	
						$minimum_order_pickup=getOption($mtid,'merchant_minimum_order_pickup');
					    $maximum_order_pickup=getOption($mtid,'merchant_maximum_order_pickup');
					    if(is_numeric($minimum_order_pickup)){				    	
					    	if ($subtotal<$minimum_order_pickup){
					    		$validation_msg=$this->t("sorry but the minimum pickup order is")." ".
					    		AddonMobileApp::prettyPrice($minimum_order_pickup);
					    	}				    
					    }
					    if(is_numeric($maximum_order_pickup)){				    	
					    	if ($subtotal>$maximum_order_pickup){
					    		$validation_msg=$this->t("sorry but the maximum pickup order is")." ".
					    		AddonMobileApp::prettyPrice($maximum_order_pickup);
					    	}				    
					    }
					    break;
					    
					case "dinein":   
						$minimum_order_dinein = getOption($mtid,'merchant_minimum_order_dinein');
						$maximum_order_dinein = getOption($mtid,'merchant_maximum_order_dinein');
						if(is_numeric($minimum_order_dinein)){				    	
					    	if ($subtotal<$minimum_order_dinein){
					    		$validation_msg=$this->t("sorry but the minimum dinein order is")." ".
					    		AddonMobileApp::prettyPrice($minimum_order_dinein);
					    	}				    
					    }
					    if(is_numeric($maximum_order_dinein)){				    	
					    	if ($subtotal>$maximum_order_dinein){
					    		$validation_msg=$this->t("sorry but the maximum dineine order is")." ".
					    		AddonMobileApp::prettyPrice($maximum_order_dinein);
					    	}				    
					    }
					    break;
				
					default:
						break;
				}

			
				$required_time=getOption( $mtid ,'merchant_required_delivery_time');
				$required_time=$required_time=="yes"?2:1;
				
				/*pts*/
				$points_label='';
				if ($has_pts==2){
				   $pts_label_earn=getOptionA('pts_label_earn');				   
				   //dump($pts_label_earn);
				   if(empty($pts_label_earn)){
				   	   //$pts_label_earn=$this->t("This order earned {points} points");
				   	   $pts_label_earn="This order earned {points} points";				   	   
				   } 				   
				   //$points_label=smarty('points',$points,$pts_label_earn);				   
				   $points_label=Yii::t("mobile",$pts_label_earn,array(
				     '{points}'=>$points
				   ));
				}
				
				$tip_default='';
				if (isset($this->data['tips_percentage'])){
					$tip_default=$this->data['tips_percentage'];
				} else {
					$tip_default=getOption($mtid,'merchant_tip_default');
					if ($tip_default>0){
						$tip_default=$tip_default*100;
					}							
				} 
				
			    $this->code=1;
			    $this->msg="OK";
			    $this->details=array(		
			      /*'is_merchant_open'=>$is_merchant_open,
			      'merchant_preorder'=>$merchant_preorder,*/
			      'validation_msg'=>$validation_msg,
			      'merchant_info'=>$merchant_info,
			      'transaction_type'=>$this->data['transaction_type'],
			      'delivery_date'=>$this->data['delivery_date'],
			      'delivery_time'=>isset($this->data['delivery_time'])?$this->data['delivery_time']:'',
			      'required_time'=>$required_time,
			      'currency_symbol'=>getCurrencyCode(),
			      'cart'=>$cart_final_content,	
			      'has_pts'=>$has_pts,	      
			      'points'=>$points,
			      'points_label'=>$points_label,
			      'enabled_tip'=>getOption($mtid,'merchant_enabled_tip'),
			      //'tip_default'=>getOption($mtid,'merchant_tip_default'),
			      'tip_default'=>$tip_default,
			    );			    			    
			    if (AddonMobileApp::isArray($distance)){
			    	$this->details['distance']=$distance;
			    }			    
			} else $this->msg=$this->t("cart is empty");
		} else $this->msg=$this->t("cart is empty");
		
		if($this->code==2){
			$this->details=array(
			  'cart_total'=>displayPrice(getCurrencyCode(),prettyFormat(0)),
			  'merchant_info'=>$merchant_info,			  
			);
		}		
		$this->output();
	}
	
	public function actionCheckOut()
	{
	
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}		
		if (!isset($this->data['search_address'])){
			$this->msg=$this->t("search address is is missing");
			$this->output();
		}		
		if (empty($this->data['transaction_type'])){
			$this->msg=$this->t("transaction type is missing");
			$this->output();
		}	
		if (empty($this->data['delivery_date'])){
			$this->msg=$this->data['transaction_type']." ".$this->t("type is missing");
			$this->output();
		}		
		if (!empty($this->data['delivery_time'])){
   	       $this->data['delivery_time']=date("G:i", strtotime($this->data['delivery_time']));	       	      
   	    }
   	    
	   /**check if customer chooose past time */
       if ( isset($this->data['delivery_time'])){
       	  if(!empty($this->data['delivery_time'])){
       	  	 $time_1=date('Y-m-d g:i:s a');
       	  	 $time_2=$this->data['delivery_date']." ".$this->data['delivery_time'];
       	  	 $time_2=date("Y-m-d g:i:s a",strtotime($time_2));	       	  	        	  	 
       	  	 $time_diff=Yii::app()->functions->dateDifference($time_2,$time_1);	       	  	 
       	  	 if (is_array($time_diff) && count($time_diff)>=1){
       	  	     if ( $time_diff['hours']>0){	       	  	     	
	       	  	     $this->msg=t("Sorry but you have selected time that already past");
	       	  	     $this->output(); 	  	     	
       	  	     }	       	  	
       	  	 }	       	  
       	  }	       
       }		    

       $mtid=$this->data['merchant_id']; 	 
       
       $time=isset($this->data['delivery_time'])?$this->data['delivery_time']:'';	       
       $full_booking_time=$this->data['delivery_date']." ".$time;
	   $full_booking_day=strtolower(date("D",strtotime($full_booking_time)));			
	   $booking_time=date('h:i A',strtotime($full_booking_time));			
	   if (empty($time)){
	   	  $booking_time='';
	   }	    
	   	   	   	   
	   if ( !Yii::app()->functions->isMerchantOpenTimes($mtid,$full_booking_day,$booking_time)){	
			$date_close=date("F,d l Y h:ia",strtotime($full_booking_time));
			$date_close=Yii::app()->functions->translateDate($date_close);
			$this->msg=t("Sorry but we are closed on")." ".$date_close;
			$this->msg.="\n\t\n";
			$this->msg.=t("Please check merchant opening hours");
		    $this->output();
		}					 
			   
	   /*check if customer already login*/
	   $address_book=''; $profile=''; $show_mobile_number=false;
	   $next_step='checkoutSignup';
	   //if (!empty($this->data['client_token'])){
	   if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {	   	  	   	  
	   	  $profile=array(
	   	    'contact_phone'=>isset($resp['contact_phone'])?$resp['contact_phone']:'',
	   	    'location_name'=>isset($resp['location_name'])?$resp['location_name']:'',
	   	  );
	   	  
	   	  if(empty($resp['contact_phone'])){   	  	 	 
   	  	 	 $show_mobile_number=true;
   	  	  }
   	  	  	   	  	   	  
	   	  /*if ( $this->data['transaction_type']=="pickup" ){
	   	  	 $next_step='payment_method';
	   	  	 if(empty($resp['contact_phone'])){
	   	  	 	$next_step='enter_contact_number';
	   	  	 	$show_mobile_number=true;
	   	  	 }
	   	  }*/	   	   	  
	   	  switch ($this->data['transaction_type']) {
	   	  	case "pickup":
	   	  	case "dinein":	
	   	  		$next_step='payment_method';
	   	  		break;
	   	  
	   	  	default:
	   	  		$next_step='shipping';
	   	  		break;
	   	  }
	   	  $address_book=AddonMobileApp::getDefaultAddressBook($resp['client_id']);	   	  
	   }		  
	   	   
	   $this->code=1;
	   $this->msg=array(
	     'address_book'=>$address_book,
	     'profile'=>$profile,
	     'transaction_type'=>$this->data['transaction_type'],
	     'show_mobile_number'=>$show_mobile_number
	   );
	   $this->details=$next_step;
	   $this->output();
	}
	
	public function actionSignup()
	{	
				
		$Validator=new Validator;
		$req=array(
		  'first_name'=>$this->t("first name is required"),
		  'last_name'=>$this->t("last name is required"),
		  'contact_phone'=>$this->t("contact phone is required"),
		  'email_address'=>$this->t("email address is required"),
		  'password'=>$this->t("password is required"),
		  'cpassword'=>$this->t("confirm password is required"),
		);
		
		if ($this->data['password']!=$this->data['cpassword']){
			$Validator->msg[]=$this->t("confirm password does not match");
		}	
		
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			
			/*check if email address is blocked*/
	    	if ( FunctionsK::emailBlockedCheck($this->data['email_address'])){
	    		$this->msg=$this->t("Sorry but your email address is blocked by website admin");
	    		$this->output();
	    	}	   
	    	if ( FunctionsK::mobileBlockedCheck($this->data['contact_phone'])){
	    		$this->msg=$this->t("Sorry but your mobile number is blocked by website admin");
	    		$this->output();
	    	}	    	
	    	/*check if mobile number already exist*/
	        $functionk=new FunctionsK();
	        if ( $functionk->CheckCustomerMobile($this->data['contact_phone'])){
	        	$this->msg=$this->t("Sorry but your mobile number is already exist in our records");
	        	$this->output();
	        }	  
	        if ( !$res=Yii::app()->functions->isClientExist($this->data['email_address']) ){
	        	
	        	$token=AddonMobileApp::generateUniqueToken(15,$this->data['email_address']);
	        	$params=array(
	    		  'first_name'=>$this->data['first_name'],
	    		  'last_name'=>$this->data['last_name'],
	    		  'email_address'=>$this->data['email_address'],
	    		  'password'=>md5($this->data['password']),
	    		  'date_created'=>AddonMobileApp::dateNow(),
	    		  'ip_address'=>$_SERVER['REMOTE_ADDR'],
	    		  'contact_phone'=>$this->data['contact_phone'],
	    		  'token'=>$token,
	    		  'social_strategy'=>"mobile"	    		  
	    		);	    	    	
	    		
	    		/*custom fields*/
	    		if(isset($this->data['custom_field1'])){
	    		  if(!empty($this->data['custom_field1'])){
	    		  	 $params['custom_field1']=$this->data['custom_field1'];
	    		  }	    		
	    		}	        
	    		if(isset($this->data['custom_field2'])){
	    		  if(!empty($this->data['custom_field2'])){
	    		  	 $params['custom_field2']=$this->data['custom_field2'];
	    		  }	    		
	    		}	        
	    		
	    		/*dump($params);
	    		die();*/

	    		$is_checkout=1;
	    		    		
	    		if(isset($this->data['transaction_type'])){
		    		if ($this->data['transaction_type']=="pickup"){
		    			$this->data['next_step']='payment_option';
		    		}		    		
	    		}
	    		
	    		/*check if the form is checkout*/
	    		if(isset($this->data['transaction_type'])){
		    	   if ($this->data['transaction_type']=="pickup"){
	    			   $is_checkout='payment_option';
	    		   }		    		
	    		   if ($this->data['transaction_type']=="dinein"){
	    			   $is_checkout='payment_option';
	    		   }		    		
	    		   if ($this->data['transaction_type']=="delivery"){
	    			   $is_checkout='shipping_address';
	    		   }		    		
	    		}
	    		
	    		/*check if verification is enabled mobile or web*/
	    		$website_enabled_mobile_verification=getOptionA('website_enabled_mobile_verification');
	    		$theme_enabled_email_verification=getOptionA('theme_enabled_email_verification');
	    		
	    		$has_verification=false;
	    		
	    		/*SMS VERIFICATION*/
	    		$verification_type='';
	    		if ($website_enabled_mobile_verification=="yes"){
	    			$verification_type='mobile_verification';
	    			$sms_code=Yii::app()->functions->generateRandomKey(5);
	    			$params['mobile_verification_code']=$sms_code;
	    			$params['status']='pending';
	    			//Yii::app()->functions->sendVerificationCode($this->data['contact_phone'],$sms_code);
	    			FunctionsV3::sendCustomerSMSVerification($this->data['contact_phone'],$sms_code);
	    			$has_verification=true;
	    		}	     
	    		
	    		/*EMAIL VERIFICATION*/
	    		if ($theme_enabled_email_verification==2){
	    			$verification_type='email_verification';
	    			$email_code=Yii::app()->functions->generateCode(10);
	    			$params['email_verification_code']=$email_code;
	    			$params['status']='pending';
	    			/*FunctionsV3::sendEmailVerificationCode($this->data['email_address'],
	    			$email_code,$this->data);*/	    			
	    			FunctionsV3::sendEmailVerificationCode($params['email_address'],$email_code,$params);
	    			$has_verification=true;
	    		}	     
	    		
	    		if(!empty($verification_type)){
	    			$this->data['next_step']=$verification_type;
	    		}
	    		
	    		/*dump($params);
	    		die();*/
	    		$DbExt=new DbExt; 
	    		if ( $DbExt->insertData("{{client}}",$params)){
	    			$client_id=Yii::app()->db->getLastInsertID();
	    			$this->msg=$this->t("Registration successful");
	    			$this->code=1;
	    			
	    			
	    			$avatar=AddonMobileApp::getAvatar( $client_id , array() );
	    			
	    			$this->details=array(
	    			   'token'=>$token,
	    			   'next_step'=>$this->data['next_step'],
	    			   'is_checkout'=>$is_checkout,
	    			   'client_id'=>$client_id,
	    			   'avatar'=>$avatar,
	    			   'client_name_cookie'=>$this->data['first_name']
	    			 ); 
	    			
	    			//FunctionsK::sendCustomerWelcomeEmail($this->data);
	    			//update device client id
		   	   	   if (isset($this->data['device_id'])){
		   	   	       AddonMobileApp::registeredDevice($client_id,$this->data['device_id'],$this->data['device_platform']);
		   	   	   }
		   	   	   
		   	   	   if($has_verification==FALSE){
		   	   	   	  /*SEND WELCOME EMAIL*/
		   	   	   	  FunctionsV3::sendCustomerWelcomeEmail($params);
		   	   	   }	    		
		   	   	   
		   	   	   /*loyalty points*/
		   	   	   if ( AddonMobileApp::hasModuleAddon("pointsprogram")){
		   	   	   	   PointsProgram::signupReward($client_id);
		   	   	   }
	    			
	    		} else $this->msg=$this->t("Something went wrong during processing your request. Please try again later.");
	        } else $this->msg=$this->t("Sorry but your email address already exist in our records.");	    				
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());		
		$this->output();
	}
	
	public function actionGetPaymentOptions()
	{		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}

		$mtid=$this->data['merchant_id'];
		
		/*ADD CHECKING DISTANCE OF NEW ADDRESS */
		//dump($this->data);
		if(!isset($this->data['transaction_type'])){
			$this->data['transaction_type']='';
		}
		
		$merchant_delivery_distance=getOption($mtid,'merchant_delivery_miles'); 		
		
		if ( $this->data['transaction_type']=="delivery" && is_numeric($merchant_delivery_distance) ){
			$client_address=$this->data['street']." ";
			$client_address.=$this->data['city']." ";
			$client_address.=$this->data['state']." ";
			$client_address.=$this->data['zipcode']." ";
			
			$merchant_info='';
			if (!$merchantinfo=AddonMobileApp::getMerchantInfo($mtid)){
				$this->msg=$this->t("Merchant Id is is missing");
				$this->output();
				Yii::app()->end();
			} else {
				$merchant_address=$merchantinfo['street']." ";
				$merchant_address.=$merchantinfo['city']." ";
				$merchant_address.=$merchantinfo['state']." ";
				$merchant_address.=$merchantinfo['post_code']." ";
				$merchant_info=array(
				  'merchant_id'=>$merchantinfo['merchant_id'],
				  'address'=>$merchant_address,
				  'delivery_fee_raw'=>getOption($mtid,'merchant_delivery_charges')
				);
			}
			
			
			if($distance_new=AddonMobileApp::getDistanceNew($merchant_info,$client_address)){
			   if(isset($_GET['debug'])){
			   	  dump("distance_new");
			      dump($distance_new);
			   }
			   $merchant_delivery_distance=getOption($mtid,'merchant_delivery_miles'); 
			   if($distance_new['distance_type_raw']=="ft" || $distance_new['distance_type_raw']=="meter"){
	    	   	 // do nothing
	    	   } else {		   	  
	    	   	  if(is_numeric($merchant_delivery_distance)){
		    	   	  if ($merchant_delivery_distance<=$distance_new['distance']){
			    	  	 $this->msg=$this->t("Sorry but this merchant delivers only with in ").
			    	  	 $merchant_delivery_distance . " ". $distance_new['distance_type'];
			    	  	 $this->details=3;
					     $this->output();
					     Yii::app()->end();
			    	  }
	    	   	  }
	    	   }
			} else {
				 $this->msg=$this->t("Failed calculating distance please try again");
	    	  	 $this->details=3;
			     $this->output();
			     Yii::app()->end();
			}
			
		} 
		/*ADD CHECKING DISTANCE OF NEW ADDRESS */
		
		/*GET CLIENT INFO*/
		$client=AddonMobileApp::getClientTokenInfo($this->data['client_token']);
		if(!$client){
			$this->msg=$this->t("Token not valid");
			$this->output();
			Yii::app()->end();
		}	
		
		/*SAVE TO ADDRESS*/
		if ( $this->data['transaction_type']=="delivery"){
		    if(!isset($this->data['save_address'])){
		    	$this->data['save_address']='';
		    }
		    if ($this->data['save_address']==2){
		    	//if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){
		    	if($client){
		    		$DbExt=new DbExt; 
		    		$DbExt->qry("UPDATE 
		    		    {{address_book}}
		    		    SET as_default='1'
		    		    WHERE
		    		    client_id=".AddonMobileApp::q($client['client_id'])."
		    		");
		    		$params_address=array(
		    		  'client_id'=>$client['client_id'],
		    		  'street'=>isset($this->data['street'])?$this->data['street']:'',
		    		  'city'=>isset($this->data['city'])?$this->data['city']:'',
		    		  'state'=>isset($this->data['state'])?$this->data['state']:'',
		    		  'zipcode'=>isset($this->data['zipcode'])?$this->data['zipcode']:'',
		    		  'location_name'=>isset($this->data['location_name'])?$this->data['location_name']:'',
		    		  'country_code'=>Yii::app()->functions->getOptionAdmin('admin_country_set'),
		    		  'date_created'=>AddonMobileApp::dateNow(),
		    		  'ip_address'=>$_SERVER['REMOTE_ADDR'],
		    		  'as_default'=>2
		    		);		    		
		    		$DbExt->insertData("{{address_book}}",$params_address);
		    	}
		    }
		}
		/*SAVE TO ADDRESS*/
		
		$merchant_payment_list='';
		
		/*LIST OF PAYMENT AVAILABLE FOR MOBILE*/
		$mobile_payment=array('cod','paypal','pyr','pyp','atz','stp','rzr','obd','ocr','ip8',
		'mri');
			
		$payment_list=getOptionA('paymentgateway');
		$payment_list=!empty($payment_list)?json_decode($payment_list,true):false;		
		
		$pay_on_delivery_flag=false;
		$paypal_flag=false;
		
		$paypal_credentials='';
		
		$stripe_publish_key='';
				
		/*check master switch for offline payment*/		
		if(is_array($payment_list) && count($payment_list)>=1){
		   $payment_list=array_flip($payment_list);
		   
		    $merchant_switch_master_cod=getOption($mtid,'merchant_switch_master_cod');
			if($merchant_switch_master_cod==2){
			   unset($payment_list['cod']);
			}
			$merchant_switch_master_pyr=getOption($mtid,'merchant_switch_master_pyr');
			if($merchant_switch_master_pyr==2){
			   unset($payment_list['pyr']);
			}
		}
		
		if(is_array($payment_list) && count($payment_list)>=1){
		   $payment_list=array_flip($payment_list);
		}		
		
		/*dump($mobile_payment);
		dump($payment_list);*/
		
		$is_merchant_commission=false;
		if (Yii::app()->functions->isMerchantCommission($mtid)){
			$is_merchant_commission=true;
		}	
		
		$ip8_credentials='';
				
		/*OVERWRITE PAYMENT LIST USING NEW FUNCTIONS*/
		$payment_list  = FunctionsV3::getMerchantPaymentListNew($mtid);				
		
		/*CHECK IF PAYPAL MOBILE IS ENABLED*/
		if (is_array($payment_list) && count($payment_list)>=1){
			if (!array_key_exists('pyp',(array)$payment_list)){				
				$payment_enabled=Yii::app()->functions->getMerchantListOfPaymentGateway();				
				if (in_array('pyp',(array)$payment_enabled)){					
					$master_key="merchant_switch_master_pyp";
		    		$master_key_val=getOption($mtid,$master_key);		    		
		    		if($master_key_val!=1){
		    			$payment_list['pyp']=t("Paypal");
		    		}
				}			
			} 		
		}
		
		//dump($payment_list);		
		//dump($mobile_payment);		
		//dump($this->data['transaction_type']);
		//dump($payment_list);
		
		$cod_change_required='';

		if (AddonMobileApp::isArray($payment_list)){			
			foreach ($mobile_payment as $val) {				
				//if(in_array($val,(array)$payment_list)){					
				if(array_key_exists($val,(array)$payment_list)){
					switch ($val) {						
						case "cod":			
						    $_label = $this->t("Cash On delivery");
						    if ($this->data['transaction_type']=="pickup"){
						    	$_label=$this->t("Cash On Pickup");
						    } elseif ($this->data['transaction_type']=="dinein"){
						    	$_label=$this->t("Pay in person");
						    }					
						    //if (Yii::app()->functions->isMerchantCommission($mtid)){
						    if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
						    							    	
						    	$cod_change_required=getOptionA('cod_change_required');
						    	
						    	$merchant_payment_list[]=array(
								  'icon'=>'fa-usd',
								  'value'=>$val,
								  'label'=>$_label,
								);
						    	continue;
						    }
							if ( getOption($mtid,'merchant_disabled_cod')!="yes"){
								
								$cod_change_required=getOption($mtid,'cod_change_required_merchant');
								
								$merchant_payment_list[]=array(
								  'icon'=>'fa-usd',
								  'value'=>$val,
								  'label'=>$_label
								);
							}
							break;
					
						case "paypal":	
						case "pyp":		
						   $paypal_fee=0;					   
						   if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
						   	   /*USER ADMIN PAYMENT */
						   	   $paypal_mobile_enabled=getOptionA('adm_paypal_mobile_enabled');
						   	   $paypal_fee=getOptionA("admin_paypal_fee");
						   	   $paypal_mobile_enabled=getOptionA('adm_paypal_mobile_enabled');
						   	   $paypal_mobile_mode=getOptionA('adm_paypal_mobile_mode');
						   	   $paypal_client_id=getOptionA('adm_paypal_mobile_clientid');				   	   
						   } else {
						   	   /*USER MERCHANT PAYMENT*/
						   	   $paypal_mobile_enabled=getOption($mtid,'mt_paypal_mobile_enabled');
						   	   $paypal_fee=getOption($mtid,'merchant_paypal_fee');
						   	   $paypal_mobile_enabled=getOption($mtid,'mt_paypal_mobile_enabled');
						   	   $paypal_mobile_mode=getOption($mtid,'mt_paypal_mobile_mode');
						   	   $paypal_client_id=getOption($mtid,'mt_paypal_mobile_clientid');						   	   
						   }											   
						   
						   if($paypal_mobile_enabled=="yes" && !empty($paypal_client_id)){						   	   
						   	   if($paypal_fee>0){
						   	   	  $paypal_lable= Yii::t("mobileapp","Paypal (card fee [card_fee])",array(
						   	   	    '[card_fee]'=>AddonMobileApp::prettyPrice($paypal_fee)
						   	   	  )) ;
						   	   } else $paypal_lable = $this->t("Papal");
						   	   $merchant_payment_list[]=array(
							      'icon'=>'fa-paypal',
							      'value'=>$val,
							      'label'=>$paypal_lable
							    );
							    
							    $paypal_flag=true;
							    
							    $paypal_credentials=array(
							       'mode'=>$paypal_mobile_mode,
							       'card_fee'=>$paypal_fee,
							       'client_id'=>$paypal_client_id
							    );							    
						   }
						   break;
						
						case "pyr":	
						   $pay_on_delivery_flag=true;
						   						   
						   $_label=$this->t("Pay On Delivery");
						   if ($this->data['transaction_type']=="pickup"){
						   	  $_label=$this->t("Pay On Pickup");
						   } elseif ( $this->data['transaction_type']=="dinein" ) {
						   	$_label=$this->t("Pay on dinein");
						   }

						    $merchant_payment_list[]=array(
						     'icon'=>'fa-cc-visa',
						     'value'=>$val,
						     'label'=>$_label
						   );						  						   
						   break;
						   
						case "atz":							
							$merchant_payment_list[]=array(
									   'icon'=>'ion-card',
									   'value'=>$val,
									   'label'=>$this->t("Authorize.net")
									);
							break;
							
					   case "stp":					   	
					   	    if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
					   	    	$mode=Yii::app()->functions->getOptionAdmin('admin_stripe_mode');  
			                    $mode=strtolower($mode);								
								if ( $mode=="sandbox"){
								   	$stripe_publish_key=getOptionA('admin_sandbox_stripe_pub_key');
								} else {
									$stripe_publish_key=getOptionA('admin_live_stripe_pub_key');
								}
					   	    } else {
					   	    	$mode=Yii::app()->functions->getOption('stripe_mode',$mtid);   
			                    $mode=strtolower($mode);
			                    if ( $mode=="sandbox"){
								   $stripe_publish_key=getOption($mtid,'sandbox_stripe_pub_key');
			                    } else {
			                       $stripe_publish_key=getOption($mtid,'live_stripe_pub_key'); 
			                    }
					   	    }							   	    
					   	    if(!empty($stripe_publish_key)){
						   	    $merchant_payment_list[]=array(
								   'icon'=>'ion-card',
								   'value'=>$val,
								   'label'=>$this->t("Stripe")
							    );			
					   	    }
							break;	
							   
					    case "rzr":		
					       $razor_key=''; $razor_secret='';			    						   
					   	  if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
					   	  	  $mode=getOptionA('admin_rzr_mode');
					   	  	  if($mode=="sandbox"){
				   	  	 		$razor_key=getOptionA('admin_razor_key_id_sanbox');
				   	  	 		$razor_secret=getOptionA('admin_razor_secret_key_sanbox');
				   	  	 	  } else {  
				   	  	 		$razor_key=getOptionA('admin_razor_key_id_live');
				   	  	 		$razor_secret=getOptionA('admin_razor_secret_key_live');
				   	  	 	  }	
					   	  } else {
					   	  	  $mode = getOption($mtid,'merchant_rzr_mode');
					   	  	  if($mode=="sandbox"){
					   	  	 	 $razor_key=getOption($mtid,'merchant_razor_key_id_sanbox');
					   	  	 	 $razor_secret=getOption($mtid,'merchant_razor_secret_key_sanbox');
					   	  	  } else {
				   	  	 		 $razor_key=getOption($mtid,'merchant_razor_key_id_live');
				   	  	 		 $razor_secret=getOption($mtid,'merchant_razor_secret_key_live');
					   	  	  }	
					   	  }		
					   	  
					   	  if(!empty($razor_key) && !empty($razor_secret)){
						   	  $merchant_payment_list[]=array(
							     'icon'=>'ion-card',
							     'value'=>$val,
							     'label'=>$this->t("Razorpay")
							  );
					   	  }
					   	 
					   	break;
					   	
					   	case "obd":					   							   		  
					   		$merchant_payment_list[]=array(
							   'icon'=>'ion-card',
							   'value'=>$val,
							   'label'=>$this->t("Offline Bank Deposit")
							);
					   		break;
					   		
					   	case "ocr":					   	  					   	    
					   	    $merchant_payment_list[]=array(
							   'icon'=>'ion-card',
							   'value'=>$val,
							   'label'=>$this->t("Offline Credit Card")
							);
					   	    break;
					   	
					   	case "ip8":
					   		if($is_merchant_commission){
					   			$enabled=getOptionA('admin_ip8_enabled');
					   			if($enabled==2){
					   			   $merchant_payment_list[]=array(
									   'icon'=>'ion-card',
									   'value'=>$val,
									   'label'=>$this->t("Ipay88")
								   );
								   $ip8_credentials=FunctionsV3::getIpay88Key(true);
					   			}					   		
					   		} else {
					   		   	$enabled=getOption($mtid,'merchant_ip8_mode');
					   		   	if($enabled==2){
					   		   	   $merchant_payment_list[]=array(
									   'icon'=>'ion-card',
									   'value'=>$val,
									   'label'=>$this->t("Ipay88")
								   );
								   $ip8_credentials=FunctionsV3::getIpay88Key(false,$mtid);
					   		   	}					   		
					   		}									   		
					   	    break;
					   	    
					   	case "mri":    
					   	   if ($credentials=Moneris::getCredentials('merchant',$mtid)){
					   	       $merchant_payment_list[]=array(
								   'icon'=>'ion-card',
								   'value'=>$val,
								   'label'=>$this->t("Moneris")
							   );
					   	   }
					   	   break;
					   	   
						default:
							break;
					}					
				}			
			}
			
			$pay_on_delivery_list='';
			if ($pay_on_delivery_flag){
				if ($list=Yii::app()->functions->getPaymentProviderListActive()){
										
					$merchant_provider_list='';
					//if (!Yii::app()->functions->isMerchantCommission($mtid)){
					if (!FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
					    if($list=Yii::app()->functions->getPaymentProviderMerchant($mtid)){
					    	foreach ($list as $val_payment) {
					    		$pay_on_delivery_list[]=array(
								  'payment_name'=>$val_payment['payment_name'],
								  'payment_logo'=>AddonMobileApp::getImage($val_payment['payment_logo']),
								);
					    	}
					    } 
					} else {
						foreach ($list as $val_payment) {																		
							$pay_on_delivery_list[]=array(
							  'payment_name'=>$val_payment['payment_name'],
							  'payment_logo'=>AddonMobileApp::getImage($val_payment['payment_logo']),
							);
						}
					}
				}				
			}
						
			if (AddonMobileApp::isArray($merchant_payment_list)){			
				
				/*pts*/
				$points_balance=0;
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){
						//if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){
						if($client){
							$client_id=$client['client_id'];
						} else $client_id=0;
						$points_balance=PointsProgram::getTotalEarnPoints($client_id);
					}
				}
				
				//dump($this->data); die();
				$show_mobile_number=false;
				if($client){					
					if(empty($client['contact_phone'])){
					  	$show_mobile_number=true;
					}
				}
				
				$this->code=1;
				$this->msg="OK";
				$this->details=array(
				  'transaction_type'=>$this->data['transaction_type'],
				  'show_mobile_number'=>$show_mobile_number,
				  'voucher_enabled'=>getOption($mtid,'merchant_enabled_voucher'),
				  'payment_list'=>$merchant_payment_list,
				  'pay_on_delivery_flag'=>$pay_on_delivery_flag,
				  'pay_on_delivery_list'=>$pay_on_delivery_list,
				  'paypal_flag'=>$paypal_flag==true?1:2,
				  'paypal_credentials'=>$paypal_credentials,
				  'stripe_publish_key'=>$stripe_publish_key,
				  'pts'=>array(
				    'balance'=>$points_balance,
				    'pts_label_input'=>AddonMobileApp::t(getOptionA('pts_label_input'))
				  ),
				  'razorpay'=>array(
				    'razor_key'=>isset($razor_key)?$razor_key:'',
				    'razor_secret'=>isset($razor_secret)?$razor_secret:''
				  ),
				  'ip8_credentials'=>$ip8_credentials,
				  'cod_change_required'=>$cod_change_required
				);
			} else $this->msg=$this->t("sorry but all payment options is not available");		
		} else $this->msg=$this->t("sorry but all payment options is not available");
				
		$this->output();	
	}
	
	public function actionPlaceOrder()
	{
		
		/*dump($this->data);
		die();*/
		
		$DbExt=new DbExt; 
		
		if (isset($this->data['next_step'])){
			unset($this->data['next_step']);
		}	
				
		$Validator=new Validator;
		$req=array(
		  'merchant_id'=>$this->t("Merchant Id is is missing"),
		  'cart'=>$this->t("cart is empty"),
		  'transaction_type'=>$this->t("transaction type is missing"),
		  'payment_list'=>$this->t("payment method is missing"),
		  'client_token'=>$this->t("client token is missing")		  
		);
							
		$mtid=$this->data['merchant_id'];
		
		$default_order_status=getOption($mtid,'default_order_status');
	/*	dump('=>'.$default_order_status);
		dump($this->data);*/
				
		if ( !$client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){
			$Validator->msg[]=$this->t("sorry but your session has expired please login again");
		} 
		$client_id=$client['client_id'];
		
		//dump($client);
						
		//dump($this->data);
		//die();
		
		/*$this->msg='Your order has been placed. Reference # 123';
		$this->code=1;
	    $this->details=array(
	       'next_step'=>'receipt',
	       'order_id'=>123,
	       'payment_type'=>$this->data['payment_list']
	    );
        $this->output();*/
		
		//dump($this->data);
		
		/*get cart*/			
		if ( AddonMobileApp::saveCartToDb()){
			if(isset($this->data['device_id'])){
				if($res_cart=AddonMobileApp::getCartByDeviceID($this->data['device_id'])){			   
				   $this->data['cart']=$res_cart['cart'];
				}
			}
		}
		
		/*dump($this->data);
		die();*/
											    	
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=AddonMobileApp::computeCart($this->data)){				
				/*dump($res);
				die();*/
								
				if (empty($res['validation_msg'])){
				   $json_data=AddonMobileApp::cartMobile2WebFormat($res,$this->data);
				   
				   if (AddonMobileApp::isArray($json_data)) {
					   $cart=$res['cart'];
					   //dump($cart);
					   
					   if ($this->data['payment_list']=="cod" || 
					      $this->data['payment_list']=="pyr"  || 
					      $this->data['payment_list']=="ccr"  || 
					      $this->data['payment_list']=="ocr"  || 
					      $this->data['payment_list']=="obd" ){				      	
					      	if (!empty($default_order_status)){
		    					$status=$default_order_status;
		    				} else $status="pending";
					   } else $status=initialStatus();
					   
					   
					   if(isset($this->data['delivery_asap'])){
						   if(!is_numeric($this->data['delivery_asap'])){
						   	  $this->data['delivery_asap']='';
						   }				   
					   }
					   					   					   					   
					   $params=array(
					    'merchant_id'=>$this->data['merchant_id'],
					    'client_id'=>$client_id,
					    'json_details'=>json_encode($json_data),
					    'trans_type'=>$this->data['transaction_type'],
					    //'payment_type'=>Yii::app()->functions->paymentCode($this->data['payment_list']),
					    'payment_type'=>$this->data['payment_list'],
					    'sub_total'=>isset($cart['sub_total'])?$cart['sub_total']['amount']:0,
					    'tax'=>isset($cart['tax'])?$cart['tax']['tax']:0,
					    'taxable_total'=>isset($cart['tax'])?$cart['tax']['amount_raw']:0,
					    'total_w_tax'=>isset($cart['grand_total'])?$cart['grand_total']['amount']:0,
					    'status'=>$status,
					    'delivery_charge'=>isset($cart['delivery_charges'])?$cart['delivery_charges']['amount']:0,
					    'delivery_date'=>isset($this->data['delivery_date'])?$this->data['delivery_date']:'',
					    'delivery_time'=>isset($this->data['delivery_time'])?$this->data['delivery_time']:'',
					    'delivery_asap'=>isset($this->data['delivery_asap'])?$this->data['delivery_asap']:'',
					    'delivery_instruction'=>isset($this->data['delivery_instruction'])?$this->data['delivery_instruction']:'',					    
					    'packaging'=>isset($cart['packaging'])?$cart['packaging']['amount']:0,
					    'date_created'=>AddonMobileApp::dateNow(),
					    'ip_address'=>$_SERVER['REMOTE_ADDR'],
					    'order_change'=>isset($this->data['order_change'])?$this->data['order_change']:'',
					    'mobile_cart_details'=>isset($this->data['cart'])?$this->data['cart']:'',
					    'delivery_asap'=>isset($this->data['delivery_asap'])?$this->data['delivery_asap']:''
					   );
					   
					   /*tips*/
					   if (isset($cart['tips'])){
					   	   $params['cart_tip_percentage']=$cart['tips']['tips_percentage'];
					   	   $params['cart_tip_value']=$cart['tips']['tips'];
					   }				   
					   
					   
					   /*offline cc payment*/
					   if ($this->data['payment_list']=="ocr"){
					   	   $params['cc_id']=isset($this->data['cc_id'])?$this->data['cc_id']:'';
					   }				   
					   
					  /* dump($params);
					   die();*/
					   
					   /*add voucher if has one*/
					   if (isset($this->data['voucher_code'])){
		        	       if (!empty($this->data['voucher_amount'])){
		        	       	   $params['voucher_code']=$this->data['voucher_code'];
		        	       	   $params['voucher_amount']=$this->data['voucher_amount'];
		        	       	   $params['voucher_type']=$this->data['voucher_type'];
		        	       }
					   }  
					   
					   /*dump($params);
					   die();*/
					   
					   if (isset($this->data['payment_provider_name'])){
					   	   $params['payment_provider_name']=$this->data['payment_provider_name'];
					   }
					   
					   if (getOption($mtid,'merchant_tax_charges')==2){
		    		       $params['donot_apply_tax_delivery']=2;
		    		   }	    	
		    		   
		    		   if(isset($cart['discount'])){
		    		   	  $params['discounted_amount']=$cart['discount']['amount'];
		    		   	  $params['discount_percentage']=$cart['discount']['discount'];
		    		   }				
		    		   
					   /*Commission*/
					   if ( Yii::app()->functions->isMerchantCommission($mtid)){
							$admin_commision_ontop=Yii::app()->functions->getOptionAdmin('admin_commision_ontop');
							if ( $com=Yii::app()->functions->getMerchantCommission($mtid)){
								$params['percent_commision']=$com;			            		
								$params['total_commission']=($com/100)*$params['total_w_tax'];
								$params['merchant_earnings']=$params['total_w_tax']-$params['total_commission'];
								if ( $admin_commision_ontop==1){
									$params['total_commission']=($com/100)*$params['sub_total'];
									$params['commision_ontop']=$admin_commision_ontop;			            		
									$params['merchant_earnings']=$params['sub_total']-$params['total_commission'];
								}
							}			
							
							/** check if merchant commission is fixed  */
							$merchant_com_details=Yii::app()->functions->getMerchantCommissionDetails($mtid);
							
							if ( $merchant_com_details['commision_type']=="fixed"){
								$params['percent_commision']=$merchant_com_details['percent_commision'];
								$params['total_commission']=$merchant_com_details['percent_commision'];
								$params['merchant_earnings']=$params['total_w_tax']-$merchant_com_details['percent_commision'];
								
								if ( $admin_commision_ontop==1){			            		
								    $params['merchant_earnings']=$params['sub_total']-$merchant_com_details['percent_commision'];
								}
							}            
					    }/** end commission condition*/
					    					    
					    /*insert the order details*/				
					    $params['request_from']='mobile_app';  // tag the order to mobile app
					    					    
					    /*add paypal card fee */
					    if ($this->data['payment_list']=="paypal" || $this->data['payment_list']=="pyp"){
					    	if(isset($this->data['paypal_card_fee'])){
						    	if($this->data['paypal_card_fee']>0){
						    	   $params['card_fee']=$this->data['paypal_card_fee'];
						    	   $params['total_w_tax']=$params['total_w_tax']+$this->data['paypal_card_fee'];
						    	}
					    	}
					    	$params['payment_type']="pyp";
					    }				   
					    
					    /*pts*/
					    $pts=1;
						if (AddonMobileApp::hasModuleAddon('pointsprogram')){
							if (getOptionA('points_enabled')==1){
							    $pts=2;
							}
						}
						
						if($pts==2){
						    if(isset($this->data['pts_redeem_amount'])){
						       if($this->data['pts_redeem_amount']>0.001){
						       	  $params['points_discount']=unPrettyPrice($this->data['pts_redeem_amount']);
						       }					    
						    }			
						}
						
						
						/*DINE TABLE NEW FIELDS*/
						if (isset($this->data['dinein_number_of_guest'])){
							$params['dinein_number_of_guest']=is_numeric($this->data['dinein_number_of_guest'])?$this->data['dinein_number_of_guest']:0;
						}
						if (isset($this->data['dinein_special_instruction'])){
							$params['dinein_special_instruction']=$this->data['dinein_special_instruction'];
						}
						
						/*UPDATE CONTACT NUMBER*/						
						if (isset($this->data['contact_phone'])){
							
							if ( FunctionsK::mobileBlockedCheck($this->data['contact_phone'])){
					    		$this->msg=$this->t("Sorry but your mobile number is blocked by website admin");
					    		$this->output();
					    	}
					    	
					    	$functionk=new FunctionsK();
					    	if ( $functionk->CheckCustomerMobile($this->data['contact_phone'],$client_id)){
					        	$this->msg=$this->t("Sorry but your mobile number is already exist in our records");
					        	$this->output();
					        }	  
	    	
							$DbExt->updateData("{{client}}",array(
							  'contact_phone'=>$this->data['contact_phone'],
							  'date_modified'=>AddonMobileApp::dateNow(),
							  'ip_address'=>$_SERVER['REMOTE_ADDR']
							),'client_id',$client_id);
						}				   
				   
						/*dump($this->data);
						dump($params);
						die();*/
						
						/*INSERT RECORDS IN ORDER TABLE*/
						
					    if (!$DbExt->insertData("{{order}}",$params)){
					    	$this->msg=AddonMobileApp::t("ERROR: Cannot insert records.");
					    	$this->output();
					    }					    
					    
					    $order_id=Yii::app()->db->getLastInsertID();	
					    
					    /*pts*/
					    if(isset($this->data['earned_points'])){
						    if($pts==2){
								if(is_numeric($this->data['earned_points'])){
									PointsProgram::saveEarnPoints(
									  $this->data['earned_points'],
									  $params['client_id'],
									  $this->data['merchant_id'],
									  $order_id,
									  $params['payment_type']
									);
								}
							}
					    }
					    
					    if(isset($this->data['pts_redeem_amount'])){
					    	if($this->data['pts_redeem_amount']>0.001){
					    	   if($pts==2){
					    	      PointsProgram::saveExpensesPoints(
					    	        isset($this->data['pts_redeem_points'])?$this->data['pts_redeem_points']:0,
					    	        isset($this->data['pts_redeem_amount'])?$this->data['pts_redeem_amount']:0,
					    	        $params['client_id'],
					    	        $this->data['merchant_id'],
					    	        $order_id,
					    	        $params['payment_type']
					    	      );	
					    	   }
					    	}
					    }
					    					    
					    /*saved food item details*/	
					    foreach ($cart['cart'] as $val_item) {
					    	//dump($val_item);		
					    	$item_details=Yii::app()->functions->getFoodItem($val_item['item_id']);
					    	$discounted_price=$val_item['price'];
					    	if($item_details['discount']>0){
					    		$discounted_price=$discounted_price-$item_details['discount'];
					    	}
					    	
					    	$sub_item='';
					    	if (AddonMobileApp::isArray($val_item['sub_item'])){
					    		foreach ($val_item['sub_item'] as $key_sub => $val_sub) {					    			
					    			foreach ($val_sub as $val_subs) {
						    			$sub_item[]=array(
						    			   'addon_name'=>$val_subs['sub_item_name'],
						    			   'addon_category'=>$key_sub,
						    			   'addon_qty'=>$val_subs['qty']=="itemqty"?$val_item['qty']:$val_subs['qty'],
						    			   'addon_price'=>$val_subs['price']
						    			);
					    			}
					    		}
					    	}
					    						    						    						    					
                            $params_details=array(
					    	  'order_id'=>$order_id,
					    	  'client_id'=>$client_id,
					    	  'item_id'=>$val_item['item_id'],
					    	  'item_name'=>$val_item['item_name'],					    	  
					    	  'order_notes'=>isset($val_item['order_notes'])?$val_item['order_notes']:'',
					    	  'normal_price'=>$val_item['price'],
					    	  'discounted_price'=>$discounted_price,
					    	  'size'=>isset($val_item['size'])?$val_item['size']:'',
					    	  'qty'=>isset($val_item['qty'])?$val_item['qty']:'',
					    	  'cooking_ref'=>isset($val_item['cooking_ref'])?$val_item['cooking_ref']:'',
					    	  'addon'=>json_encode($sub_item),
					    	  'ingredients'=>isset($val_item['ingredients'])?json_encode($val_item['ingredients']):'',
					    	  'non_taxable'=>isset($val_item['non_taxable'])?$val_item['non_taxable']:1
					    	);
					    	//dump($params_details);							    
					    	
					    	$DbExt->insertData("{{order_details}}",$params_details);			    	
					    }
					    //die();
					    					   					   
					    /*save the customer delivery address*/
					    if ( $this->data['transaction_type']=="delivery"){
						    $params_address=array(
						      'order_id'=>$order_id,
						      'client_id'=>$client_id,
						      'street'=>isset($this->data['street'])?$this->data['street']:'',
						      'city'=>isset($this->data['city'])?$this->data['city']:'',
						      'state'=>isset($this->data['state'])?$this->data['state']:'',
						      'zipcode'=>isset($this->data['zipcode'])?$this->data['zipcode']:'',
						      'location_name'=>isset($this->data['location_name'])?$this->data['location_name']:'',
						      'country'=>Yii::app()->functions->adminCountry(),
						      'date_created'=>AddonMobileApp::dateNow(),
						      'ip_address'=>$_SERVER['REMOTE_ADDR'],
						      'contact_phone'=>isset($this->data['contact_phone'])?$this->data['contact_phone']:''
						    );
						    //dump($params_address);
						    
						    if(isset($this->data['formatted_address'])){
					    	   $params_address['formatted_address']=$this->data['formatted_address'];
					    	}
					    	if(isset($this->data['google_lat'])){
					    	   $params_address['google_lat']=$this->data['google_lat'];
					    	}
					    	if(isset($this->data['google_lng'])){
					    	   $params_address['google_lng']=$this->data['google_lng'];
					    	}
					    								    						    	
						    $DbExt->insertData("{{order_delivery_address}}",$params_address);
					    }
					    
					    $merchant_info=AddonMobileApp::getMerchantInfo($this->data['merchant_id']);					    
					    $merchant_name='';
					    if (AddonMobileApp::isArray($merchant_info)){
					    	$merchant_name=$merchant_info['restaurant_name'];
					    }
					    
					    $total_w_tax_temp=number_format($params['total_w_tax'],2);
					    $total_w_tax_temp=Yii::app()->functions->unPrettyPrice($total_w_tax_temp);
					    
					    
					    $this->code=1;
					    $this->details=array(
					       'next_step'=>'receipt',
					       'order_id'=>$order_id,
					       'payment_type'=>$this->data['payment_list'],
					       'payment_details'=>array(
					         'total_w_tax'=>$total_w_tax_temp,
					         'currency_code'=>adminCurrencyCode(),
					         'paymet_desc'=>$this->t("Payment to merchant")." ".$merchant_name,
					         'total_w_tax_pretty'=>AddonMobileApp::prettyPrice($params['total_w_tax'])
					       )
					    );
					    
					    /*razorpay*/
					    if($this->data['payment_list']=="rzr"){					    	
					    	if($merchant_info=AddonMobileApp::getMerchantInfo($mtid=$this->data['merchant_id'])){
					    	   $this->details['payment_details']['merchant_name']=stripslashes($merchant_info['restaurant_name']);
					    	}					    
					    	$this->details['payment_details']['customer_name']=$client['first_name']." "
					    	.$client['last_name'];
					    	$this->details['payment_details']['customer_contact']=isset($client['contact_phone'])?$client['contact_phone']:'';
					    	$this->details['payment_details']['customer_email']=isset($client['email_address'])?$client['email_address']:'';
					    	$this->details['payment_details']['total_w_tax_times']=$total_w_tax_temp*100;
					    	$this->details['payment_details']['color']="#F37254";
					    }				   
					    				    
					    /*insert logs for food history*/
						$params_logs=array(
						  'order_id'=>$order_id,
						  'status'=> $status,
						  'date_created'=>AddonMobileApp::dateNow(),
						  'ip_address'=>$_SERVER['REMOTE_ADDR']
						);
						$DbExt->insertData("{{order_history}}",$params_logs);
						
					    					    
						$ok_send_notification=true;					   
					    switch ($this->data['payment_list'])
					    {					    	
					    	case "cod":
	    					case "ccr":	
	    					case "ocr":			    					
	    					case "pyr":
	    					    $this->msg=Yii::t("default","Your order has been placed.");
	    					    $this->msg.=" ".AddonMobileApp::t("Reference #")." $order_id";	    
	    					    
	    					    /*SEND EMAIL RECEIPT*/
						        AddonMobileApp::notifyCustomer($order_id);
						        
						        /*SEND FAX*/
                                Yii::app()->functions->sendFax($mtid,$order_id);
											    
	    						break;	    						
	    					case "obd":
	    					    /** Send email if payment type is Offline bank deposit*/		    					    
						    	AddonMobileApp::sendBankInstructionPurchase($mtid,$order_id,$params['total_w_tax'],$client_id);
						    	
	    					    $this->msg=Yii::t("default","Your order has been placed.");	    					    
	    					    $this->msg.=" ".AddonMobileApp::t("Reference # ".$order_id);
	    					    
	    					    /*SEND EMAIL RECEIPT*/
						        AddonMobileApp::notifyCustomer($order_id);
						        
						        /*SEND FAX*/
                                Yii::app()->functions->sendFax($mtid,$order_id);	
	    					    
	    						break;	    					
	    					case "paypal":
	    					case "pyp":
	    						$this->details['next_step']='paypal_init';	    						
	    						$ok_send_notification=false;
	    						break;	
	    						
	    					case "atz":
	    						$this->details['next_step']='atz_init';	    						
	    						$ok_send_notification=false;
	    						break;	
	    							
	    					case "stp":
	    						$this->details['next_step']='stp_init';	    						
	    						$ok_send_notification=false;
	    						break;		
	    						
	    					case "rzr":
	    						$this->details['next_step']='rzr_init';	    						
	    						$ok_send_notification=false;
	    						break;		
	    						
	    					case "mri":		
	    					    $this->details['next_step']='mri_init';	    						
	    						$ok_send_notification=false;
	    					    break;
	    						
	    					case "ip8":
	    						$this->details['next_step']='ip8_init';	    						
	    						$ok_send_notification=false;	    
	    						
	    						//$mtid
	    						$ip8_mode='';  $ip8_language='ISO-8859-1';
	    						if (Yii::app()->functions->isMerchantCommission($mtid)){
									$ip8_mode=getOptionA('admin_ip8_mode');
									$ip8_language=getOptionA('admin_ip8_language');
								} else {
									$ip8_mode=getOption($mtid,'merchant_ip8_mode');
									$ip8_language=getOption($mtid,'merchant_ip8_language');
								}
					    			    												
	    						if ($ip8_mode=="sandbox"){
	    							$total_w_tax_temp=unPrettyPrice(1)*100;
	    						} else {
	    							$total_w_tax_temp=unPrettyPrice($total_w_tax_temp)*100;	    							
	    						}					 
	    						
	    						if(empty($ip8_language)){
	    							$ip8_language='ISO-8859-1';
	    						}
					    					    						
	    						$this->details['ipay88_details']=array( 
	    						  'amount'=>number_format($total_w_tax_temp,2,'.',''),
	    						  'name'=>$client['first_name']." ".$client['last_name'],
	    						  'email'=>$client['email_address'],
	    						  'phone'=>$client['contact_phone'],
	    						  //'refNo'=>$order_id,
	    						  'refNo'=>Yii::app()->functions->generateRandomKey(9)."-".$order_id,
	    						  'currency'=>getOptionA('admin_currency_set'),
	    						  'lang'=>$ip8_language,
	    						  'country'=>getOptionA('admin_country_set'),
	    						  'description'=>$this->t("Payment to merchant")." ".$merchant_name,
	    						  'paymentId'=>"",
	    						  //'backendPostUrl'=>'http://www.orderjom.com/testcode/index.php',
	    						  'backendPostUrl'=>websiteUrl()."/store/Ipay88Receiver",
	    						  'remark'=>$this->t("Payment to merchant")." ".$merchant_name,
	    						  'merchant_id'=>$mtid,
	    						  'ip8_mode'=>$ip8_mode	    						  
	    						);
	    							    						
	    						break;				
	    						
	    					default:	
	    					    $this->msg=Yii::t("default","Please wait while we redirect...");
	    					    break;
					    }
					    				   					    					   
					    /*send email to client and merchant*/
					    //AddonMobileApp::sendOrderEmail($cart,$params,$order_id,$this->data,$ok_send_notification);
					      
					    /*send sms to merchant and client*/
					    //AddonMobileApp::sendOrderSMS($cart,$params,$order_id,$this->data,$ok_send_notification);			    					    
					    // driver app
					    if ( AddonMobileApp::hasModuleAddon("driver")){
					     	Yii::app()->setImport(array(			
							  'application.modules.driver.components.*',
							));							
							Driver::addToTask($order_id);
					     	//AddonMobileApp::addToTask($order_id);
					    }
					    
				   } else $this->msg=$this->t("something went wrong");
				} else $this->msg=$res['validation_msg'];
			} else $this->msg=$this->t("something went wrong");
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());	
		
		$this->output();
	}
	
	public function actionGetMerchantInfo()
	{		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant Id is is missing");
			$this->output();
		}	
		
		$mtid=$this->data['merchant_id'];
		
		if ( $data = AddonMobileApp::merchantInformation($this->data['merchant_id'])){							
			$opening_hours=AddonMobileApp::getOperationalHours($mtid);			
						
			$this->details=array(
			  'merchant_info'=>$data,
			  'opening_hours'=>$opening_hours
			);
			if ($payment_method=AddonMobileApp::getMerchantPaymentMethod($mtid)){
				$this->details['payment_method']=$payment_method;
			}				
			if ($review=AddonMobileApp::previewMerchantReview($mtid)){
				$review['date_created']=PrettyDateTime::parse(new DateTime($review['date_created']));
				$this->details['reviews']=Yii::app()->functions->translateDate($review);
			}
			
			$merchant_latitude=getOption($mtid,'merchant_latitude');
			$merchant_longtitude=getOption($mtid,'merchant_longtitude');
			if(!empty($merchant_latitude) && !empty($merchant_longtitude)){
				$this->details['maps']=array(
				  'merchant_latitude'=>$merchant_latitude,
				  'merchant_longtitude'=>$merchant_longtitude
				);
			}		
			
			$table_booking=2;
			if ( getOptionA('merchant_tbl_book_disabled')==2){
				$table_booking=1;
			} else {
				if ( getOption($mtid,'merchant_table_booking')=="yes"){
					$table_booking=1;
				}			
			}		
			$this->details['enabled_table_booking']=$table_booking;
			
			$this->code=1;
			$this->msg="OK";
		} else $this->msg=AddonMobileApp::t("sorry but merchant information is not available");
		
		$this->output();
	}
	
	public function actionBookTable()
	{
		$Validator=new Validator;
		
		$req=array(
		  'merchant_id'=>$this->t("merchant id is required"),
		  'number_guest'=>$this->t("number of guest is srequired"),
		  'date_booking'=>$this->t("date of booking is required"),
		  'booking_time'=>$this->t("time is required"),
		  'booking_name'=>$this->t("name is required"),		  
		);
		$Validator->required($req,$this->data);
		
		$time_1=date('Y-m-d g:i:s a');
   	  	$time_2=$this->data['date_booking']." ".$this->data['booking_time'];
   	  	$time_2=date("Y-m-d g:i:s a",strtotime($time_2));	       	  	        	  	 
   	  	$time_diff=Yii::app()->functions->dateDifference($time_2,$time_1);	       	  	    	  	
   	  	if (AddonMobileApp::isArray($time_diff)){
   	  		if ($time_diff['hours']>0){   	  			
   	  			$Validator->msg[]=AddonMobileApp::t("you have selected a date/time that already past");
   	  		}   	  	
   	  		if ($time_diff['days']>0){   	   	  			
   	  			$Validator->msg[]=AddonMobileApp::t("you have selected a date/time that already past");
   	  		}   	  	
   	  	}	   	  	
   	  	
		if ($Validator->validate()){
			
			$merchant_id=$this->data['merchant_id'];
			
			$full_booking_time=$this->data['date_booking']." ".$this->data['booking_time'];
			
			$full_booking_day=strtolower(date("D",strtotime($full_booking_time)));			
			$booking_time=date('h:i A',strtotime($full_booking_time));			
								
			
			if ( !Yii::app()->functions->isMerchantOpenTimes($merchant_id,$full_booking_day,$booking_time)){
				$this->msg=AddonMobileApp::t("Sorry but we are closed on"." ".date("F,d Y h:ia",strtotime($full_booking_time))).
				"\n".AddonMobileApp::t("Please check merchant opening hours");
			    $this->output();
			}					
					
			$now=isset($this->data['date_booking'])?$this->data['date_booking']:'';			
			$merchant_close_msg_holiday='';
		    $is_holiday=false;
		    if ( $m_holiday=Yii::app()->functions->getMerchantHoliday($merchant_id)){
	      	    if (in_array($now,(array)$m_holiday)){
	      	   	    $is_holiday=true;
	      	    }
		    }
		    if ( $is_holiday==true){
		    	$merchant_close_msg_holiday=!empty($merchant_close_msg_holiday)?$merchant_close_msg_holiday:AddonMobileApp::t("Sorry but we are on holiday on")." ".date("F d Y",strtotime($now));
		    	$this->msg=$merchant_close_msg_holiday;
		    	$this->output();
		    }		    
		    		    
		    $fully_booked_msg=Yii::app()->functions->getOption("fully_booked_msg",$merchant_id);
		    if (!Yii::app()->functions->bookedAvailable($merchant_id)){
		    	if (!empty($fully_booked_msg)){
		    		$this->msg=t($fully_booked_msg);
		    	} else $this->msg=AddonMobileApp::t("Sorry we are fully booked for that day");			 	
			 	$this->output();
			}
						
			$db_ext=new DbExt;					
			$params=array(
			  'merchant_id'=>isset($this->data['merchant_id'])?$this->data['merchant_id']:'',
			  'number_guest'=>isset($this->data['number_guest'])?$this->data['number_guest']:'',
			  'date_booking'=>isset($this->data['date_booking'])?$this->data['date_booking']:'',
			  'booking_time'=>isset($this->data['booking_time'])?$this->data['booking_time']:'',
			  'booking_name'=>isset($this->data['booking_name'])?$this->data['booking_name']:'',
			  'email'=>isset($this->data['email'])?$this->data['email']:'',
			  'mobile'=>isset($this->data['mobile'])?$this->data['mobile']:'',
			  'booking_notes'=>isset($this->data['booking_notes'])?$this->data['booking_notes']:'',
			  'date_created'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);				
						
			if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){							
				$params['client_id']=$client['client_id'];
		    } 
		    					
			if ( $db_ext->insertData('{{bookingtable}}',$params)){
				$this->details=Yii::app()->db->getLastInsertID();
			    $this->code=1;
			    $this->msg=Yii::t("mobile","we have receive your booking").".<br/>";
			    $this->msg.=$this->t("your booking reference number is")." #".$this->details;
			    
			    /*SEND EMAIL*/
			    $new_data=$params;
				if ( !$merchant_info=Yii::app()->functions->getMerchant($merchant_id)){			
					$merchant_info['restaurant_name']=AddonMobileApp::t("None");
				} else {
					$new_data['restaurant_name']=$merchant_info['restaurant_name'];
				}					
				$new_data['booking_id']=$this->details;
				FunctionsV3::notifyBooking($new_data);
			    			    			    
			} else $this->msg=Yii::t("mobile","Something went wrong during processing your request. Please try again later.");
			
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());		
		$this->output();
	}
	
	public function actionMerchantReviews()
	{
	
		if (isset($this->data['merchant_id'])){
			if ( $res=Yii::app()->functions->getReviewsList($this->data['merchant_id'])){
				$data='';
				foreach ($res as $val) {
					$prety_date=PrettyDateTime::parse(new DateTime($val['date_created']));
					$data[]=array(
					  'client_name'=>empty($val['client_name'])?$this->t("not available"):$val['client_name'],
					  'review'=>$val['review'],
					  'rating'=>$val['rating'],
					  'date_created'=>Yii::app()->functions->translateDate($prety_date)
					);
				}
				$this->code=1;$this->msg="OK";
				$this->details=$data;
			} else $this->msg=$this->t("no current reviews");
		} else $this->msg=$this->t("Merchant id is missing");
		$this->output();	
	}
	
	public function actionAddReview()
	{		
				
		$Validator=new Validator;
		$req=array(
		  'rating'=>$this->t("rating is required"),
		  'review'=>$this->t("review is required"),
		  'merchant_id'=>$this->t("Merchant id is missing")
		);
		$Validator->required($req,$this->data);

		if ( !$client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){
			$Validator->msg[]=$this->t("Sorry but you need to login to write a review.");
		} 
		$client_id=$client['client_id'];
		$mtid=$this->data['merchant_id'];
		
		if ( $Validator->validate()){
						
			$params=array(
	    	  'merchant_id'=>$mtid,
	    	  'client_id'=>$client_id,
	    	  'review'=>$this->data['review'],
	    	  'date_created'=>AddonMobileApp::dateNow(),
	    	  'rating'=>$this->data['rating']
	    	);		 
		    	
			/** check if user has bought from the merchant*/		    	
	    	if ( Yii::app()->functions->getOptionAdmin('website_reviews_actual_purchase')=="yes"){
	    		$functionk=new FunctionsK();
	    	    if (!$functionk->checkIfUserCanRateMerchant($client_id,$mtid)){
	    	    	$this->msg=$this->t("Reviews are only accepted from actual purchases!");
	    	    	$this->output();
	    	    }
	    	    		    	    	    	   
	    	    if (!$functionk->canReviewBasedOnOrder($client_id,$mtid)){
	    		   $this->msg=$this->t("Sorry but you can make one review per order");
	    	       $this->output();
	    	    }	  		   
	    	    
	    	    if ( $ref_orderid=$functionk->reviewByLastOrderRef($client_id,$this->data['merchant-id'])){
	    	    	$params['order_id']=$ref_orderid;
	    	    }
	    	}
	    	$DbExt=new DbExt;    	
	    	if ( $DbExt->insertData("{{review}}",$params)){
	    		$this->code=1;
	    		$this->msg=Yii::t("default","Your review has been published.");	    	
	    		
	    		
	    		/*loyalty points*/
	    		if ( AddonMobileApp::hasModuleAddon("pointsprogram")){
	    			PointsProgram::reviewsReward($client_id);
	    		}
	    			    	
	    	} else $this->msg=Yii::t("default","ERROR: cannot insert records.");		
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());	
		$this->output();	
	}
	
	public function actionBrowseRestaurant()
	{
		$DbExt=new DbExt;  
		$DbExt->qry("SET SQL_BIG_SELECTS=1");		
		
		$start=0;
		$limit=200;
		
		$and='';
		if (isset($this->data['restaurant_name'])){
			$and=" AND restaurant_name LIKE '%".$this->data['restaurant_name']."%'";
		}	
		
		$stmt="SELECT SQL_CALC_FOUND_ROWS a.*,
    	(
    	select option_value
    	from 
    	{{option}}
    	WHERE
    	merchant_id=a.merchant_id
    	and
    	option_name='merchant_photo'
    	) as merchant_logo
    	        
    	 FROM
    	{{view_merchant}} a    	
    	WHERE is_ready ='2'
    	AND status in ('active')
    	$and
    	ORDER BY membership_expired,is_featured DESC
    	LIMIT $start,$limit    	
    	";    			
		
		if (isset($_GET['debug'])){
			dump($stmt);
		}

		if ($res=$DbExt->rst($stmt)){
			$data='';
			
			$total_records=0;
			$stmtc="SELECT FOUND_ROWS() as total_records";
	 		if ($resp=$DbExt->rst($stmtc)){			 			
	 			$total_records=$resp[0]['total_records'];
	 		}			 		
			 		
			foreach ($res as $val) {
								
				$mtid=$val['merchant_id'];
				
				/*check if mechant is open*/
	 			$open=AddonMobileApp::isMerchantOpen($val['merchant_id'],false);
	 			
		        /*check if merchant is commission*/
		        $cod=AddonMobileApp::isCashAvailable($val['merchant_id']);
		        if(!empty($cod)){
		        	if($val['service']==3){
		        		$cod=AddonMobileApp::t("Cash on pickup available");
		        	}
		        }
		        $online_payment='';
		        
		        $tag='';
		        $tag_raw='';
		        if ($open==true){
		        	$tag=$this->t("open");
		        	$tag_raw='open';		        	
		        	if ( getOption( $val['merchant_id'] ,'merchant_close_store')=="yes"){
		        		$tag=$this->t("close");
		        		$tag_raw='close';				        		
		        	}  
		        } else  {
		        	$tag=$this->t("close");
		        	$tag_raw='close';
		        	if (getOption( $val['merchant_id'] ,'merchant_preorder')==1){
		        		$tag=$this->t("pre-order");
		        		$tag_raw='pre-order';
		        	}
		        }			 		
		        
		        $minimum_order=getOption($val['merchant_id'],'merchant_minimum_order');
	 			if(!empty($minimum_order)){
		 			$minimum_order=displayPrice(getCurrencyCode(),prettyFormat($minimum_order));		 			
	 			}
	 			
	 			$delivery_fee=getOption($val['merchant_id'],'merchant_delivery_charges');
	 			if (!empty($delivery_fee)){
	 				$delivery_fee=displayPrice(getCurrencyCode(),prettyFormat($delivery_fee));
	 			}
	 			
	 			$delivery_distance='';
	 			
	 			 $distance_type=FunctionsV3::getMerchantDistanceType($mtid);
	 			 if(!empty($distance_type)){
	 			    $distance_type= $distance_type=="M"?$this->t("miles"):$this->t("kilometers");
	 			    $merchant_delivery_miles=getOption($mtid,'merchant_delivery_miles');
	 			    if(!empty($merchant_delivery_miles)){
			           $delivery_distance=$this->t("Delivery Distance").": ".$merchant_delivery_miles;
			           $delivery_distance.=" ".$distance_type;
	 			    }
	 			 }
	 			
	 			$payment_available=AddonMobileApp::displayCashAvailable($mtid,$val['service']);
				        
				$data[]=array(
	 			  'merchant_id'=>$val['merchant_id'],
	 			  'restaurant_name'=>stripslashes($val['restaurant_name']),
	 			  'address'=>$val['street']." ".$val['city']." ".$val['state']." ".$val['post_code'],
	 			  'ratings'=>Yii::app()->functions->getRatings($val['merchant_id']),
	 			  'cuisine'=>AddonMobileApp::prettyCuisineList($val['cuisine']),	 			  
	 			  'delivery_fee'=>!empty($delivery_fee)?$delivery_fee:AddonMobileApp::t("Free Delivery"),
			 	  'minimum_order'=>$minimum_order,
	 			  'delivery_est'=>getOption($val['merchant_id'],'merchant_delivery_estimation'),
	 			  'is_open'=>$tag,
	 			  'tag_raw'=>$tag_raw,
	 			  'payment_options'=>array(
	 			    'cod'=>$cod,
	 			    'online'=>$online_payment
	 			  ),			 			 
	 			  'logo'=>AddonMobileApp::getMerchantLogo($val['merchant_id']),	 			  
	 			  'map_coordinates'=>array(
	 			    'latitude'=>!empty($val['latitude'])?$val['latitude']:'',
	 			    'lontitude'=>!empty($val['lontitude'])?$val['lontitude']:'',
	 			  ),
	 			  'offers'=>AddonMobileApp::getMerchantOffers($val['merchant_id']),
	 			  'service'=>$val['service'],
	 			  'services'=>AddonMobileApp::displayServicesList($val['service']),
	 			  'distance'=>'',
	 			  'delivery_estimation'=>AddonMobileApp::t("Delivery Est").": ".getOption($mtid,'merchant_delivery_estimation'),
	 			  'delivery_distance'=>$delivery_distance,
	 			  'payment_available'=>$payment_available
	 			);
			}
			$this->details=array(
	 		  'total'=>$total_records,
	 		  'data'=>$data
	 		);
	 		$this->code=1;$this->msg="Ok";
	 		$this->output();
		} else $this->msg=$this->t("No restaurant found");
		$this->output();
	}
	
	public function actiongetProfile()
	{	
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){			
			$this->code=1;
			$this->msg="OK";
			$avatar=AddonMobileApp::getAvatar( $res['client_id'] , $res );
			$res['avatar']=$avatar;
			$this->details=$res;
		} else $this->msg=$this->t("not login");
		$this->output();
	}
	
	public function actionsaveProfile()
	{		
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){
						
			/*check if mobile number is already exists*/
			if (isset($this->data['contact_phone'])){
			$functionsk=new FunctionsK();
				if ($functionsk->CheckCustomerMobile($this->data['contact_phone'],$res['client_id'])){
					$this->msg= $this->t("Sorry but your mobile number is already exist in our records");
					$this->output();
					Yii::app()->end();
				}		
			}			
			
			$params=array(
			  'first_name'=>$this->data['first_name'],
			  'last_name'=>$this->data['last_name'],
			  'contact_phone'=>isset($this->data['contact_phone'])?$this->data['contact_phone']:'',
			  'date_modified'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);
			if (!empty($this->data['password'])){
				$params['password']=md5($this->data['password']);
			}					
			$DbExt=new DbExt;  
			if($DbExt->updateData("{{client}}",$params,'client_id',$res['client_id'])){
				$this->code=1;
				$this->msg=$this->t("your profile has been successfully updated");				
			} else $this->msg=$this->t("something went wrong during processing your request");
		} else $this->msg=$this->t("it seems that your token has expired. please re login again");
		$this->output();
	}
	
	public function actionLogin()
	{
		
		/*check if email address is blocked by admin*/	    	
    	if ( FunctionsK::emailBlockedCheck($this->data['email_address'])){
    		$this->msg=t("Sorry but your email address is blocked by website admin");
    		$this->output();
    	}	    	
    	    
    	$Validator=new Validator;
		$req=array(
		  'email_address'=>$this->t("email address is required"),
		  'password'=>$this->t("password is required")		  
		);
		$Validator->required($req,$this->data);
    	
		if ( $Validator->validate()){
		   $stmt="SELECT * FROM
		   {{client}}
		    WHERE
	    	email_address=".Yii::app()->db->quoteValue($this->data['email_address'])."
	    	AND
	    	password=".Yii::app()->db->quoteValue(md5($this->data['password']))."
	    	AND
	    	status IN ('active')
	    	LIMIT 0,1
		   ";		   		   
		   $DbExt=new DbExt; 
		   if ($res=$DbExt->rst($stmt)){
		   	   $res=$res[0];
		   	   //dump($this->data);
		   	   //dump($res);
		   	   $client_id=$res['client_id'];
		   	   $token=AddonMobileApp::generateUniqueToken(15,$this->data['email_address']);
		   	   $params=array(
		   	     'token'=>$token,
		   	     'last_login'=>AddonMobileApp::dateNow(),
		   	     'ip_address'=>$_SERVER['REMOTE_ADDR']		   	     
		   	   );		
		   	      	   
		   	   if ($DbExt->updateData("{{client}}",$params,'client_id',$client_id)){
		   	   	   $this->code=1;
		   	   	   $this->msg=$this->t("Login Okay");
		   	   	   
		   	   	   $avatar=''; $client_name='';
		   	   	   $avatar=AddonMobileApp::getAvatar( $client_id , $res );		   	   	   
		   	   	   		
		   	   	   $default_address='';
		   	   	   if($default_address=AddonMobileApp::getDefaultAddressBook($client_id)){		   	   	   	 
		   	   	   }
		   	   		   	   	   
		   	   	   $show_mobile_number=false;
		   	   	   if (empty($res['contact_phone'])){
		   	   	   	  $show_mobile_number=true;
		   	   	   }
		   	   	   
		   	   	   $this->details=array(
		   	   	     'token'=>$token,
		   	   	     'next_steps'=>isset($this->data['next_steps'])?$this->data['next_steps']:'',
		   	   	     'has_addressbook'=>AddonMobileApp::hasAddressBook($client_id)?2:1,
		   	   	     'avatar'=>$avatar,
		   	   	     'client_name_cookie'=>$res['first_name'],
		   	   	     'contact_phone'=>isset($res['contact_phone'])?$res['contact_phone']:'',
	   	             'location_name'=>isset($res['location_name'])?$res['location_name']:'',
	   	             'default_address'=>$default_address,
	   	             'transaction_type'=>isset($this->data['next_steps'])?$this->data['next_steps']:'',
	   	             'show_mobile_number'=>$show_mobile_number
		   	   	   );
		   	   	   		   	   	   
		   	   	   //update device client id
		   	   	   if (isset($this->data['device_id'])){		   	   	       
		   	   	       AddonMobileApp::registeredDevice($client_id,$this->data['device_id'],$this->data['device_platform']);
		   	   	   }
		   	   	   
		   	   } else $this->msg=$this->t("something went wrong during processing your request");
		   } else $this->msg=$this->t("Login Failed. Either username or password is incorrect");
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());	    	
    	$this->output();
	}
	
	public function actionForgotPassword()
	{		
		$Validator=new Validator;
		$req=array(
		  'email_address'=>$this->t("email address is required")		  
		);
		$Validator->required($req,$this->data);
				
		if ( $Validator->validate()){
		   if ( $res=yii::app()->functions->isClientExist($this->data['email_address']) ){					
			$token=md5(date('c'));
			$params=array('lost_password_token'=>$token);					
			$DbExt=new DbExt;
			if ($DbExt->updateData("{{client}}",$params,'client_id',$res['client_id'])){
				$this->code=1;						
				$this->msg=AddonMobileApp::t("We sent your forgot password link, Please follow that link. Thank You.");
				
				//send email					
				/*$tpl=EmailTPL::forgotPass($res,$token);			    
			    $sender='';
                $to=$res['email_address'];		                
                if (!sendEmail($to,$sender,Yii::t("default","Forgot Password"),$tpl)){		    			                	
                	$this->details="failed";
                } else $this->details="mail ok";*/
				
				$to=$res['email_address'];
				$res['token']=$token;
				AddonMobileApp::SendForgotPassword($to,$res);
                				
			} else $this->msg=Yii::t("mobile","ERROR: Cannot update records");				
		} else $this->msg=Yii::t("mobile","Sorry but your Email address does not exist in our records.");
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());	
		$this->output();
	}
	
	public function actiongetOrderHistory()
	{		
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			if ( $order=Yii::app()->functions->clientHistyOrder($res['client_id'])){
				$this->code=1;
				$this->msg="Ok";
				$data='';
				foreach ($order as $val) {					
					$total_price=displayPrice(getCurrencyCode(),prettyFormat($val['total_w_tax']));
					$data[]=array(
					  'order_id'=>$val['order_id'],
					  'title'=>"#".$val['order_id']." ".stripslashes($val['merchant_name'])." ".Yii::app()->functions->translateDate(prettyDate($val['date_created']))." ($total_price)",
					  'status_raw'=>$val['status'],
					  'status'=>AddonMobileApp::t($val['status'])
					);
				}
				$this->details=$data;
			} else $this->msg =$this->t("you don't have any orders yet");
		} else {
			$this->msg=$this->t("sorry but your session has expired please login again");
			$this->code=3;
		}
		$this->output();
	}
	
	public function actionOrdersDetails()
	{		
		$trans=getOptionA('enabled_multiple_translation'); 		
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			 
			 if ( $res=AddonMobileApp::getOrderDetails($this->data['order_id'])){			 	  
			 	  
			 	  $data='';
			 	  foreach ($res as $val) {
			 	  	 
			 	  	 if ( $trans==2 && isset($_GET['lang_id'])){
			 	  	 	 $lang_id=$_GET['lang_id'];
			 	  	 	 $val['item_name']=AddonMobileApp::translateItem('item',$val['item_name'],
			 	  	 	 $val['item_id'],'item_name_trans');
			 	  	 }
			 	  	
			 	  	 $data[]=array(
			 	  	   'item_name'=>$val['qty']."x ".$val['item_name']			 	  	   
			 	  	 );
			 	  }			 	  
			 	  $history_data='';
			 	  if ($history=FunctionsK::orderHistory($this->data['order_id'])){
			 	  	 foreach ($history as $val) {
			 	  	 	$history_data[]=array(
			 	  	 	  'date_created'=>FormatDateTime($val['date_created'],true),
			 	  	 	  'status'=>AddonMobileApp::t($val['status']),
			 	  	 	  'remarks'=>!empty($val['remarks'])?$val['remarks']:''
			 	  	 	);
			 	  	 }
			 	  }			 
			 	  
			 	  $stmt="SELECT 
			 	  request_from,
			 	  payment_type,
			 	  trans_type
			 	   FROM
			 	  {{order}}
			 	  WHERE 
			 	  order_id=".AddonMobileApp::q($this->data['order_id'])."
			 	  LIMIT 0,1
			 	  ";
			 	  $DbExt=new DbExt;
			 	  $order_from='web';
			 	  if ($resp=$DbExt->rst($stmt)){
			 	  	 $order_from=$resp[0];
			 	  } else {
			 	  	 $order_from=array(
			 	  	   'request_from'=>'web'
			 	  	 );
			 	  }			 
			 	  
			 	  $this->details=array(
			 	    'order_id'=>$this->data['order_id'],
			 	    'order_from'=>$order_from,
			 	    'total'=>AddonMobileApp::prettyPrice($res[0]['total_w_tax']),
			 	    'item'=>$data,
			 	    'history_data'=>$history_data
			 	  );
			 	  $this->code=1; $this->msg="OK";
			 } else $this->msg=$this->t("no item found");		
		} else $this->msg=$this->t("sorry but your session has expired please login again");
		$this->output();
	}
	
	public function actiongetAddressBookDialog()
	{
		$this->actiongetAddressBook();
	}

	public function actiongetAddressBook()
	{
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			 
			if(isset($_GET['debug'])){
				dump($res['client_id']);
			}		
			if ( $resp= AddonMobileApp::getAddressBook($res['client_id'])){
				$this->code=1;
				$this->msg="OK";
				$this->details=$resp;
			} else $this->msg = $this->t("no results");
		} else {
			$this->msg=$this->t("sorry but your session has expired please login again");
			$this->code=3;
		}	
		$this->output();
	}
	
	public function actionGetAddressBookDetails()
	{		
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {	
			 if ( $resp= Yii::app()->functions->getAddressBookByID($this->data['id'])){			 	 
			 	 $this->code=1; $this->msg="OK";
			 	 $this->details=$resp;
			 } else $this->msg=$this->t("address book details not available");
		} else $this->msg=$this->t("sorry but your session has expired please login again");
		$this->output();
	}
	
	public function actionSaveAddressBook()
	{	
		$DbExt=new DbExt;
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {	
						
			if (isset($this->data['as_default'])){
			   if ($this->data['as_default']==2){
			   	   $stmt="UPDATE 
			   	   {{address_book}}
			   	   SET as_default ='1'
			   	   WHERE
			   	   client_id=".AddonMobileApp::q($res['client_id'])."
			   	   ";
			   	   //dump($stmt);
			   	   $DbExt->qry($stmt);
			   }			
			}					
			$params=array(
			  'client_id'=>$res['client_id'],
			  'street'=>isset($this->data['street'])?$this->data['street']:'',
			  'city'=>isset($this->data['city'])?$this->data['city']:'',
			  'state'=>isset($this->data['state'])?$this->data['state']:'',
			  'zipcode'=>isset($this->data['zipcode'])?$this->data['zipcode']:'',
			  'location_name'=>isset($this->data['location_name'])?$this->data['location_name']:'',
			  'as_default'=>isset($this->data['as_default'])?$this->data['as_default']:1,
			  'date_created'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR'],
			  'country_code'=>Yii::app()->functions->adminSetCounryCode()
			);							
			if ( $this->data['action']=="add"){
				if ( $DbExt->insertData("{{address_book}}",$params)){
					$this->code=1;
					$this->msg="address book added";
					$this->details=$this->data['action'];
				} else $this->msg=$this->t("something went wrong during processing your request");	
			} else {
				unset($params['client_id']);
				unset($params['date_created']);
				if ( $DbExt->updateData("{{address_book}}",$params,'id',$this->data['id'])){
					$this->code=1;				
					$this->msg="successfully updated";
					$this->details=$this->data['action'];
				} else $this->msg=$this->t("something went wrong during processing your request");		
			}
		} else $this->msg=$this->t("sorry but your session has expired please login again");
		$this->output();
	}
	
	public function actionDeleteAddressBook()
	{
		$DbExt=new DbExt;
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {				
			if ( $resp=Yii::app()->functions->getAddressBookByID($this->data['id'])){
				if ( $res['client_id']==$resp['client_id']){
					$stmt="
					DELETE FROM {{address_book}}
					WHERE
					id=".self::q($this->data['id'])."
					";
					if ( $DbExt->qry($stmt)){
						$this->code=1;
						$this->msg="OK";
					} else $this->msg=$this->t("something went wrong during processing your request");		
				} else $this->msg=$this->t("sorry but you cannot delete this records");
			} else $this->msg=$this->t("address book id not found");
		} else $this->msg=$this->t("sorry but your session has expired please login again");
		$this->output();	
	}
	
	public function actionreOrder()
	{	
		if ( $res=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {				
			 if ( $resp=Yii::app()->functions->getOrderInfo($this->data['order_id'])){			 	  
			 	
			 	  if ($resp['request_from']=="web"){
			 	  	 $this->msg=AddonMobileApp::t("Sorry but you cannot re-order this transaction the request was made in web");
			 	  	 $this->output();	
			 	  }			 
			 	
			 	  $merchant_info=Yii::app()->functions->getMerchant($resp['merchant_id']);
			 	  			 	  			 	  
			 	  if($merchant_info){
			 	  	 if ( $merchant_info['status']!='active'){
			 	  	   	 $this->msg=$this->t("this merchant is no longer available");
			 	  	     $this->output();			 	  	
			 	  	 }
			 	  	 if ( $merchant_info['is_ready']!=2){
			 	  	   	 $this->msg=$this->t("merchant is not published");
			 	  	     $this->output();			 	  	
			 	  	 }
			 	  } else {
			 	  	 $this->msg=$this->t("this merchant is no longer available");
			 	  	 $this->output();			 	  	
			 	  }			 
			 	
			 	  $disabled=getOption($resp['merchant_id'],'merchant_disabled_ordering');
			 	  if($disabled=="yes"){
			 	  	 $this->msg=$this->t("Ordering is disabled");
			 	  	 $this->output();			 	  	
			 	  }			 			 	  			 	  
			 	  $close_store=getOption($resp['merchant_id'],'merchant_close_store');
			 	  if($close_store=="yes"){
			 	  	 $this->msg=$this->t("Merchant is not accepting orders");
			 	  	 $this->output();			 	  	
			 	  }			 			 	  			 	 
			 	  $close_admin=getOptionA('disabled_website_ordering');
			 	  if($close_admin=="yes"){
			 	  	 $this->msg=$this->t("Merchant is not accepting orders");
			 	  	 $this->output();			 	  	
			 	  }			 
			 	  			 	  
			 	  $cart=!empty($resp['mobile_cart_details'])?json_decode($resp['mobile_cart_details'],true):false;
			 	  if ($cart==false){
			 	  	  $cart=!empty($resp['json_details'])?json_decode($resp['json_details'],true):false;
			 	  }			 
			 	  
			 	   $mobile_save_cart_db=getOptionA('mobile_save_cart_db');
			 	  //dump("=>".$mobile_save_cart_db);
			 	  if($mobile_save_cart_db==1){
				 	  $action=1;
	
				 	  $client_id=$res['client_id']; $device_id='';			 	  
				 	  $db=new DbExt();
				 	  
				 	  $stmt="SELECT * FROM
				 	  {{mobile_registered}}
				 	  WHERE
				 	  client_id=".AddonMobileApp::q($client_id)."
				 	  AND
				 	  status='active'	
				 	  LIMIT 0,1		 	  
				 	  ";
				 	  if ($res=$db->rst($stmt)){
				 	  	  $res=$res[0];			 	  	  
				 	  	  $device_id=$res['device_id'];
				 	  }						 	  
				 	  if($res=AddonMobileApp::getCartByDeviceID($device_id)){			   
				 	  	 $action=2;
				 	  } 
				 	  
				 	  if ( !empty($device_id)){
					 	  $params=array(
							 'device_id'=>$device_id,
							 'cart'=>json_encode($cart)
						  );	
						  /*dump($params);
						  dump($action);*/
						  if($action==1){
								$db->insertData("{{mobile_cart}}",$params);
						  } else {
								$db->updateData("{{mobile_cart}}",$params,'device_id',$this->data['device_id']);
						  }		
				 	  }
			 	  } 	  					 	  
			 	  
			 	  if ( $cart!=false){
			 	  	  $this->msg="OK";
			 	  	  $this->details=array(
			 	  	    'merchant_id'=>$resp['merchant_id'],
			 	  	    'cart'=>$cart,			 	  	    
			 	  	  );
			 	  	  $this->code=1;
			 	  } else $this->msg=$this->t("something went wrong during processing your request");			 
			 } else $this->msg=$this->t("sorry but we cannot find the order details");
		} else $this->msg=$this->t("sorry but your session has expired please login again");
		$this->output();	
	}
	
	public function actionregisterUsingFb()
	{
		$DbExt=new DbExt;
		
		if(!isset($this->data['email'])){
			$this->msg=$this->t("Email address is missing");
			$this->output();
		}	
				
		if (!empty($this->data['email']) && !empty($this->data['first_name'])){			
			if ( FunctionsK::emailBlockedCheck($this->data['email'])){
	    		$this->msg=$this->t("Sorry but your facebook account is blocked by website admin");
	    		$this->output();
	    	}	   
	    		   	    	 
	    	$token=AddonMobileApp::generateUniqueToken(15,$this->data['email']);
	    	
	    	//$name=explode(" ",$this->data['name']);	    	
	    	
	    	$params=array(
	    	  'social_strategy'=>'fb_mobile',
	    	  'email_address'=>$this->data['email'],
	    	  'first_name'=>isset($this->data['first_name'])?$this->data['first_name']:'' ,
	    	  'last_name'=>isset($this->data['last_name'])?$this->data['last_name']:'' ,
	    	  'token'=>$token,
	    	  'last_login'=>AddonMobileApp::dateNow()
	    	);
	    		    		    	
	    	if ( $res=AddonMobileApp::checkifEmailExists($this->data['email'])){
	    		// update
	    		unset($params['email_address']);
	    		$client_id=$res['client_id'];
	    		if (empty($res['password'])){
	    			$params['password']=md5($this->data['fbid']);
	    		}		    		
	    		if ($DbExt->updateData("{{client}}",$params,'client_id',$client_id)){
	    		   $this->code=1;
		   	   	    $this->msg=$this->t("Login Okay");
		   	   	    
		   	   	    $avatar=AddonMobileApp::getAvatar( $client_id , $res );
		   	   	    
		   	   	    $this->details=array(
		   	   	      'token'=>$token,
		   	   	      'next_steps'=>isset($this->data['next_steps'])?$this->data['next_steps']:'',
		   	   	      'has_addressbook'=>AddonMobileApp::hasAddressBook($client_id)?2:1,
		   	   	      'avatar'=>$avatar,
		   	   	      'client_name_cookie'=>$res['first_name'],
		   	   	      'contact_phone'=>isset($res['contact_phone'])?$res['contact_phone']:'',
	   	              'location_name'=>isset($res['location_name'])?$res['location_name']:'', 
		   	   	    );
		   	   	    
		   	   	    //update device client id
		   	   	   if (isset($this->data['device_id'])){		   	   	       
		   	   	       AddonMobileApp::registeredDevice($client_id,$this->data['device_id'],$this->data['device_platform']);
		   	   	   }
		   	   	    
	    		} else $this->msg=$this->t("something went wrong during processing your request");
	    	} else {
	    		// insert
	    		$params['date_created']=AddonMobileApp::dateNow();
	    		$params['password']=md5($this->data['fbid']);
	    		$params['ip_address']=$_SERVER['REMOTE_ADDR'];
	    		
	    		if ($DbExt->insertData("{{client}}",$params)){
	    			$client_id=Yii::app()->db->getLastInsertID();
	    			$this->code=1;
		   	   	    $this->msg=$this->t("Login Okay");
		   	   	    
		   	   	    $avatar=AddonMobileApp::getAvatar( $client_id , array() );
		   	   	    
		   	   	    $this->details=array(
		   	   	      'token'=>$token,
		   	   	      'next_steps'=>isset($this->data['next_steps'])?$this->data['next_steps']:'',
		   	   	      'has_addressbook'=>AddonMobileApp::hasAddressBook($client_id)?2:1,
		   	   	      'avatar'=>$avatar,
		   	   	      'client_name_cookie'=>$this->data['first_name'],
		   	   	      'contact_phone'=>'',
	   	              'location_name'=>'' 
		   	   	    );
		   	   	    
		   	   	   //update device client id
		   	   	   if (isset($this->data['device_id'])){		   	   	       
		   	   	       AddonMobileApp::registeredDevice($client_id,$this->data['device_id'],$this->data['device_platform']);
		   	   	   }
		   	   	    
	    		} else $this->msg=$this->t("something went wrong during processing your request");
	    	}		    	
		} else $this->msg=$this->t("failed. missing email and name");
		$this->output();	
	}
	
	public function actionregisterMobile()
	{		
		$DbExt=new DbExt;
		$params['device_id']=isset($this->data['registrationId'])?$this->data['registrationId']:'';
		$params['device_platform']=isset($this->data['device_platform'])?$this->data['device_platform']:'';
		
		if (isset($this->data['client_token'])){
			if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {					
				$params['client_id']=$client['client_id'];
			} else {
				/*$this->msg="Client id is missing";
				$this->output();*/
			}		
		}
					
		if (!empty($this->data['registrationId'])){
			$params['date_created']=AddonMobileApp::dateNow();
			$params['ip_address']=$_SERVER['REMOTE_ADDR'];
			if ( $res=AddonMobileApp::getDeviceID($this->data['registrationId'])){
				 $DbExt->updateData("{{mobile_registered}}",$params,'id',$res['id']);
				 
				 /*update all old device id of client to inactive*/
				 if(isset($params['client_id'])){
				   if(!empty($params['client_id'])){
				   	  $sql="UPDATE
	         			{{mobile_registered}}
	         			SET status='inactive'
	         			WHERE
	         			client_id=".self::q($params['client_id'])."
	         			AND
	         			device_id<>".self::q($params['device_id'])."
	         			";
	         		    $DbExt->qry($sql);
				   }
				 }
				 
			} else {
				$DbExt->insertData("{{mobile_registered}}",$params);			
			}		
			$this->code=1; $this->msg="OK";
		} else $this->msg="Empty registration id";
		$this->output();	
	}
	
	public function actionpaypalSuccessfullPayment()
	{		
		$DbExt=new DbExt;
				
		$resp=!empty($this->data['response'])?json_decode($this->data['response'],true):false;		
		if (AddonMobileApp::isArray($resp)){
			
			$order_id=isset($this->data['order_id'])?$this->data['order_id']:'';
			
			$params=array(
			  'payment_type'=>Yii::app()->functions->paymentCode("paypal"),
			  'payment_reference'=>$resp['response']['id'],
			  'order_id'=>$order_id,
			  'raw_response'=>$this->data['response'],
			  'date_created'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);						
										
			if ( $DbExt->insertData("{{payment_order}}",$params) ){
				$this->code=1;
				$this->msg= AddonMobileApp::t("Your order has been placed.");
	    	    $this->msg.=" ".AddonMobileApp::t("Reference # ".$order_id);
	    	    
	    	    $amount_to_pay=0;
	    	    $client_id='';
	    	    if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
	    	       $amount_to_pay=$order_info['total_w_tax'];
	    	       $client_id=$order_info['client_id'];
	    	    }
	    	    
				$this->details=array(
				  'next_step'=>"receipt",
				  'amount_to_pay'=>$amount_to_pay
				);
				
				$params1=array('status'=> AddonMobileApp::t('paid') );		       
				$DbExt->updateData("{{order}}",$params1,'order_id',$order_id);
								
				/*insert logs for food history*/
				$params_logs=array(
				  'order_id'=>$order_id,
				  'status'=> 'paid',
				  'date_created'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				$DbExt->insertData("{{order_history}}",$params_logs);
				
				// now we send the pending emails
				//AddonMobileApp::processPendingReceiptEmail($order_id);
								
				/*SEND EMAIL RECEIPT*/
				AddonMobileApp::notifyCustomer($order_id);		
				
				/*SEND FAX*/
                Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);		
				
				/*pts*/
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){
					    AddonMobileApp::updatePoints($order_id,$client_id);
					}
				}
				
				// driver app
			    if ( AddonMobileApp::hasModuleAddon("driver")){
			     	Yii::app()->setImport(array(			
					  'application.modules.driver.components.*',
					));							
					Driver::addToTask($order_id);
					//AddonMobileApp::addToTask($order_id);
			    }
				
			} else $this->msg=$this->t("something went wrong during processing your request");
		} else $this->msg=$this->t("something went wrong during processing your request");
				
		$this->output();	
	}
	
	public function actionReverseGeoCoding()
	{		
		if (isset($this->data['lat']) && !empty($this->data['lng'])){
			/*$latlng=$this->data['lat'].",".$this->data['lng'];
			$file="https://maps.googleapis.com/maps/api/geocode/json?latlng=$latlng&sensor=true";
			$key=Yii::app()->functions->getOptionAdmin('google_geo_api_key');		
			if(!empty($key)){
				$file.="&key=".urlencode($key);
			}
			if ($res=@file_get_contents($file)){
				$res=json_decode($res,true);
				if (AddonMobileApp::isArray($res)){
					$this->code=1; $this->msg="OK";
					$this->details=$res['results'][0]['formatted_address'];
				} else  $this->msg=$this->t("not available");
			} else $this->msg=$this->t("not available");*/
			
			if ( $res=AddonMobileApp::latToAdress($this->data['lat'],$this->data['lng']) ){
				$this->code=1; $this->msg="OK";		
				
				$this->details=$res['formatted_address'];		
								
				$app_current_location_results=getOptionA('app_current_location_results');				
				if(!empty($app_current_location_results)){
					switch ($app_current_location_results) {
						case "address":
							$this->details=$res['address'];
							break;
						
						case "city":
							$this->details=$res['city'];
							break;		
							
						case "state":
							$this->details=$res['state'];
							break;			
					
						default:
							$this->details=$res['formatted_address'];
							break;
					}
				}			
				
			} else $this->msg=$this->t("location not available");
			
		} else $this->msg=$this->t("missing coordinates");
		$this->output();
	}
	
	public function actionSaveSettings()
	{
		$DbExt=new DbExt;					
		if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			 $client_id=$client['client_id'];			 
			 $params=array(
			   'enabled_push'=>isset($this->data['enabled_push'])?1:'',
			   'country_code_set'=>isset($this->data['country_code_set'])?$this->data['country_code_set']:'',
			   'date_modified'=>AddonMobileApp::dateNow(),
			   'ip_address'=>$_SERVER['REMOTE_ADDR']
			 );			 
			 if ( $DbExt->updateData("{{mobile_registered}}",$params,'client_id',$client_id)){
			 	 $this->code=1;
			     $this->msg=AddonMobileApp::t("Setting saved");
			 } else $this->msg = AddonMobileApp::t("something went wrong during processing your request");
		} else $this->msg= AddonMobileApp::t("You need to login or registered to save settings");
		$this->output();
	}
	
	public function actionGetSettings()
	{				
		if (!empty($this->data['device_id']) || $this->data['device_id']!="null"){
			$device_id=$this->data['device_id'];			
			if ( $res=AddonMobileApp::getDeviceID($device_id)){				
				$this->code=1; $this->msg="OK";
				$this->details=$res;
			} else $this->msg=$this->t("settings not found");
		} else $this->msg=$this->t("missing device id");
		$this->output();
	}
	
	public function actionMobileCountryList()
	{
		$list=getOptionA('mobile_country_list');
		if (!empty($list)){
			$list=json_decode($list,true);			
		} else $list = array(
		  'US','PH','GB'
		);
		
		$country_code_set='';
		$device_id=isset($this->data['device_id'])?$this->data['device_id']:'';
		if ( $res=AddonMobileApp::getDeviceID($device_id)){				
			$country_code_set=$res['country_code_set'];
		}
		
		/*if (empty($country_code_set)){
			$country_code_set=getOptionA('merchant_default_country');
		}*/
		
		$new_list='';
		$c=require_once('CountryCode.php');
		if (AddonMobileApp::isArray($list)){
			foreach ($list as $val) {
				$new_list[$val]=$c[$val];
			}
		}	
				
		$this->code=1;
		$this->msg="OK";
		$this->details=array(
		  'selected'=>$country_code_set,
		  'list'=>$new_list
		);
		$this->output();
	}
	
	public function actionGetLanguageSettings()
	{		
		
		$lang=AddonMobileApp::getAppLanguage();	
		
		/*$mobile_dictionary=getOptionA('mobile_dictionary');
		$mobile_dictionary=!empty($mobile_dictionary)?json_decode($mobile_dictionary,true):false;
		if ( $mobile_dictionary!=false){
			$lang=$mobile_dictionary;
		} else $lang='';*/
				
		/*$mobile_default_lang='en';
		$default_language=getOptionA('default_language');
		if(!empty($default_language)){
			$mobile_default_lang=$default_language;
		}*/	
				
		$mobile_default_lang=Yii::app()->language;		
				
		if(empty($mobile_default_lang)){
			$mobile_default_lang="en";
		}		
		
		$admin_decimal_separator=getOptionA('admin_decimal_separator');
		$admin_decimal_place=getOptionA('admin_decimal_place');
		$admin_currency_position=getOptionA('admin_currency_position');
		$admin_thousand_separator=getOptionA('admin_thousand_separator');
		
		$single_add_item=2;
		if (getOptionA('website_disbaled_auto_cart')=="yes"){
			$single_add_item=1;
		}
		
		/*pts*/
		$pts=1;
		if (AddonMobileApp::hasModuleAddon('pointsprogram')){
			if (getOptionA('points_enabled')==1){
			    $pts=2;
			}
		}
		
		/*facebook flag*/
		$facebook_flag=2;
		if (getOptionA('fb_flag')==1){
			$facebook_flag=1;
		}
		
		/*get profile pic*/
		$avatar=''; $client_name='';
		if(isset($this->data['client_token'])){
		  if(!empty($this->data['client_token'])){
			  if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			  	 $client_name=$client['first_name'];
				 $avatar=AddonMobileApp::getAvatar( $client['client_id'] , $client );
			  }
		  }
		}
				
		
		$icons=array(
		  'from_icon'=>websiteUrl()."/protected/modules/mobileapp/assets/images/h-2.png",
		  'destination_icon'=>websiteUrl()."/protected/modules/mobileapp/assets/images/racing-flag.png",
		);	
						
		$force_app_default_lang=getOptionA('force_app_default_lang');		
		if($force_app_default_lang=="0"){
			$force_app_default_lang='';
		}
		
		if ( is_null($mobile_default_lang) || $mobile_default_lang=="null"){			
			$mobile_default_lang='en';
		} 
		
	    $this->details=array(
		    'settings'=>array(
		        'force_app_default_lang'=>$force_app_default_lang,
			    'default_lang'=>$mobile_default_lang,
			    'decimal_place'=> strlen($admin_decimal_place)>0?$admin_decimal_place:2,
			    'currency_position'=>!empty($admin_currency_position)?$admin_currency_position:'left',
			    'currency_set'=>getCurrencyCode(),
			    'thousand_separator'=>!empty($admin_thousand_separator)?$admin_thousand_separator:'',
			    'decimal_separator'=>!empty($admin_decimal_separator)?$admin_decimal_separator:'.',	  
			    'single_add_item'=>$single_add_item ,
			    'pts'=>$pts,
			    'facebook_flag'=>$facebook_flag,
			    'avatar'=>$avatar,
			    'client_name_cookie'=>$client_name,
			    'show_addon_description'=>getOptionA('show_addon_description'),
			    'mobile_country_code'=>Yii::app()->functions->getAdminCountrySet(true),
			    'map_icons'=>$icons,
			    'mobile_save_cart_db'=>getOptionA('mobile_save_cart_db'),
		    ),
		     'translation'=>$lang
		    );
	
		$this->code=1;
		$this->output();
	}
	
	public function actionGetLanguageSelection()
	{
		/*if ($res=Yii::app()->functions->getLanguageList()){
			$set_lang_id=Yii::app()->functions->getOptionAdmin('set_lang_id');				
				$eng[]=array(
				  'lang_id'=>"en",
				  'country_code'=>"US",
				  'language_code'=>"English"
				);
				$res=array_merge($eng,$res);
			//}						
			$this->code=1;
			$this->msg="OK";
			$this->details=$res;
		} else $this->msg=AddonMobileApp::t("no language available");*/
		
		if($list=FunctionsV3::getLanguageList(false)){		   
		   $this->code=1;
		   $this->msg="OK";
		   $this->details=$list;
		} else  $this->msg=AddonMobileApp::t("no language available");
		
		$this->output();
	}
	
	public function actionApplyVoucher()
	{		
		
		if(isset($this->data['pts_redeem_amount'])){
		   if($this->data['pts_redeem_amount']>0){
		   	  $this->msg=$this->t("Sorry but you cannot apply voucher when you have already redeem a points");
		   	  $this->output();
		   	  Yii::app()->end();
		   }		
		}
		
		if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			$client_id=$client['client_id'];
			//dump($client_id);
			if (isset($this->data['merchant_id'])){
				$mtid=$this->data['merchant_id'];
				//dump($mtid);
				if ( $res=AddonMobileApp::getVoucherCodeNew($client_id,$this->data['voucher_code'],$mtid) ){
					//dump($res);
					
					/*check if voucher code can be used only once*/
					if ( $res['used_once']==2){
						if ( $res['number_used']>0){
							$this->msg=AddonMobileApp::t("Sorry this voucher code has already been used");
							$this->output();
						}
					}
					
					if ( !empty($res['expiration'])){						
						$time_2=$res['expiration'];
       	  	            $time_2=date("Y-m-d",strtotime($time_2));	       	  	 
       	  	            $time_1=date('Y-m-d');	       	  	            
       	  	            $time_diff=Yii::app()->functions->dateDifference($time_2,$time_1);	       	  	            
       	  	            if (is_array($time_diff) && count($time_diff)>=1){
       	  	            	if($time_diff['days']>0){
       	  	            	  $this->msg=AddonMobileApp::t("Voucher code has expired");
       	  	            	  $this->output();
       	  	            	}
       	  	            }
					}
					
					if ( $res['found']>0){
						$this->msg=AddonMobileApp::t("Sorry but you have already use this voucher code");
						$this->output();
					}
					
					$less=''; $less_amount=0;
					if ($res['voucher_type']=="fixed amount"){
						$less=AddonMobileApp::prettyPrice($res['amount']);
						$less_amount=$res['amount'];
					} else {
						$less=standardPrettyFormat($res['amount'])."%";
						if($res['amount']>0.001){
						   $less_amount=($res['amount']/100);
						}
					}
					
					$total=0;
					$cart_sub_total=$this->data['cart_sub_total'];
					if($less_amount>0){
						if ($res['voucher_type']=="fixed amount"){		
							$cart_sub_total=$cart_sub_total-$less_amount;					
						} else {
							$less_amount=($cart_sub_total*$less_amount);
							$cart_sub_total=$cart_sub_total-$less_amount;
						}
					}
					
					/*apply tips*/
			        $tips_amount=0;
			        if ( isset($this->data['tips_percentage'])){
			        	if (is_numeric($this->data['tips_percentage'])){
			        	    $tips_amount=$cart_sub_total*($this->data['tips_percentage']/100);		        	    
			        	}
			        }
					
					if(isset($this->data['cart_delivery_charges'])){
					   $cart_sub_total+=unPrettyPrice($this->data['cart_delivery_charges']);
					}
					if(isset($this->data['cart_packaging'])){
					   $cart_sub_total+=unPrettyPrice($this->data['cart_packaging']);
					}
					
					if(isset($this->data['cart_tax'])){
					   if($this->data['cart_tax']>0){
					   	  $tax=$cart_sub_total*($this->data['cart_tax']/100);
					   	  $total=$cart_sub_total+$tax+$tips_amount;
					   } else $total=$cart_sub_total+$tips_amount;
					} else $total=$cart_sub_total+$tips_amount;
						
					$voucher_details=array(
					  'voucher_id'=>$res['voucher_id'],
					  'voucher_name'=>$res['voucher_name'],
					  'voucher_type'=>$res['voucher_type'],
					  'amount'=>$res['amount'],
					  'less'=>$this->t("Less")." ".$less,
					  'new_total'=>$total
					);
					
					$this->details=$voucher_details;
					$this->code=1;
					$this->msg="merchant voucher";
					
				} else {
					// get admin voucher
					//echo 'get admin voucher';
					if ( $res=AddonMobileApp::getVoucherCodeAdmin($client_id,$this->data['voucher_code'])){
									

						if ( !empty($res['expiration'])){						
							$time_2=$res['expiration'];
	       	  	            $time_2=date("Y-m-d",strtotime($time_2));	       	  	 
	       	  	            $time_1=date('Y-m-d');	       	
	       	  	            	       	  	            
	       	  	            $time_diff=Yii::app()->functions->dateDifference($time_2,$time_1);	 
	       	  	            
	       	  	            if (is_array($time_diff) && count($time_diff)>=1){
	       	  	            	if($time_diff['days']>0){
		       	  	            	$this->msg=AddonMobileApp::t("Voucher code has expired");
		       	  	            	$this->output();
	       	  	            	}
	       	  	            }						
						}
						
						/*check if voucher code can be used only once*/
						if ( $res['used_once']==2){
							if ( $res['number_used']>0){
								$this->msg=AddonMobileApp::t("Sorry this voucher code has already been used");
								$this->output();
							}
						}
												
						if (!empty($res['joining_merchant'])){							
							$joining_merchant=json_decode($res['joining_merchant']);							
							if (in_array($this->data['merchant_id'],(array)$joining_merchant)){								
							} else {
								$this->msg=AddonMobileApp::t("Sorry this voucher code cannot be used on this merchant");
								$this->output();
							}
						}
															
						if ( $res['found']>0){
							$this->msg=AddonMobileApp::t("Sorry but you have already use this voucher code");
							$this->output();
						}
						
						$less='';
						$less_amount=0;
						if ($res['voucher_type']=="fixed amount"){
							$less=AddonMobileApp::prettyPrice($res['amount']);
							$less_amount=$res['amount'];
						} else {
							$less=standardPrettyFormat($res['amount'])."%";
							if($res['amount']>0.001){
							   $less_amount=($res['amount']/100);
							}
						}
						
						$total=0;
						$cart_sub_total=isset($this->data['cart_sub_total'])?$this->data['cart_sub_total']:0;
						if($less_amount>0){
							if ($res['voucher_type']=="fixed amount"){		
								$cart_sub_total=$cart_sub_total-$less_amount;
							} else {
								$less_amount=($cart_sub_total*$less_amount);
								$cart_sub_total=$cart_sub_total-$less_amount;
							}
						}
						
						/*apply tips*/
				        $tips_amount=0;
				        if ( isset($this->data['tips_percentage'])){
				        	if (is_numeric($this->data['tips_percentage'])){
				        	    $tips_amount=$cart_sub_total*($this->data['tips_percentage']/100);		        	    
				        	}
				        }
				        				        
						if(isset($this->data['cart_delivery_charges'])){
						   $cart_sub_total+=unPrettyPrice($this->data['cart_delivery_charges']);
						}
						if(isset($this->data['cart_packaging'])){
						   $cart_sub_total+=unPrettyPrice($this->data['cart_packaging']);
						}
						
				        		
						if(isset($this->data['cart_tax'])){
						   if($this->data['cart_tax']>0){
						   	  $tax=$cart_sub_total*($this->data['cart_tax']/100);
						   	  $total=$cart_sub_total+$tax+$tips_amount;
						   } else $total=$cart_sub_total+$tips_amount;
						} else $total=$cart_sub_total+$tips_amount;
						
						$voucher_details=array(
						  'voucher_id'=>$res['voucher_id'],
						  'voucher_name'=>$res['voucher_name'],
						  'voucher_type'=>$res['voucher_type'],
						  'amount'=>$res['amount'],
						  'less'=>$this->t("Less")." ".$less,
						  'new_total'=>$total
						);
						
						$this->details=$voucher_details;
						$this->code=1;
						$this->msg="admin voucher";
						
					} else $this->msg=AddonMobileApp::t("Voucher code not found");
				}			
			} else $this->msg=$this->t("Merchant id is missing");		
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}
	
	public function actionPayAtz()
	{
		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant id is missing");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['expiration_month'])){
			$this->msg=$this->t("Expiration month is required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['expiration_yr'])){
			$this->msg=$this->t("Expiration year is required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['x_country'])){
			$this->msg=$this->t("Country is required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['order_id'])){
			$this->msg=$this->t("Order id is missing");
			$this->output();
			Yii::app()->end();
		}
		
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			$client_id=$resp['client_id'];
			$mtid=$this->data['merchant_id'];
			$order_id=$this->data['order_id'];
			
			$mode_autho=Yii::app()->functions->getOption('merchant_mode_autho',$mtid);
            $autho_api_id=Yii::app()->functions->getOption('merchant_autho_api_id',$mtid);
            $autho_key=Yii::app()->functions->getOption('merchant_autho_key',$mtid);
            
            //if ( Yii::app()->functions->isMerchantCommission($mtid)){			
            if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
				$mode_autho=Yii::app()->functions->getOptionAdmin('admin_mode_autho');
		        $autho_api_id=Yii::app()->functions->getOptionAdmin('admin_autho_api_id');
		        $autho_key=Yii::app()->functions->getOptionAdmin('admin_autho_key');        
			}
			
            if(empty($mode_autho) || empty($autho_api_id) || empty($autho_key)){
            	$this->msg=$this->t("Payment settings not properly configured");
			    $this->output();
		 	    Yii::app()->end();
            }
            
            define("AUTHORIZENET_API_LOGIN_ID",$autho_api_id); 
            define("AUTHORIZENET_TRANSACTION_KEY",$autho_key);
            define("AUTHORIZENET_SANDBOX",$mode_autho=="sandbox"?true:false);     
			
            $amount_to_pay=unPrettyPrice($this->data['total_w_tax']);
            
            require_once 'anet_php_sdk/AuthorizeNet.php';
            $transaction = new AuthorizeNetAIM;
            $transaction->setSandbox(AUTHORIZENET_SANDBOX);
            $params= array(		        
		        'description' => $this->data['paymet_desc'],
		        'amount'     => $amount_to_pay, 
		        'card_num'   => $this->data['cc_number'], 
		        'exp_date'   => $this->data['expiration_month']."/".$this->data['expiration_yr'],
		        'first_name' => $this->data['x_first_name'],
		        'last_name'  => $this->data['x_last_name'],
		        'address'    => $this->data['x_address'],
		        'city'       => $this->data['x_city'],
		        'state'      => $this->data['x_state'],
		        'country'    => $this->data['x_country'],
		        'zip'        => $this->data['x_zip'],
		        'card_code'  => $this->data['cvv'],
	        );
	        //dump($params);
	        //die();
	        $transaction->setFields($params);        
            $response = $transaction->authorizeAndCapture();
            if ($response->approved) {
            	$resp_transaction = $response->transaction_id;
            	//dump($resp_transaction);
            	
            	$db_ext=new DbExt;
            	
            	$params_update=array('status'=>'paid');	        
                $db_ext->updateData("{{order}}",$params_update,'order_id',$order_id);
                
            	$params_logs=array(
		          'order_id'=>$order_id,
		          'payment_type'=>Yii::app()->functions->paymentCode('authorize'),
		          'raw_response'=>json_encode($response),
		          'date_created'=>AddonMobileApp::dateNow(),
		          'ip_address'=>$_SERVER['REMOTE_ADDR'],
		          'payment_reference'=>$resp_transaction
		        );
		        $db_ext->insertData("{{payment_order}}",$params_logs);
		       
		        $this->code=1;
				$this->msg= AddonMobileApp::t("Your order has been placed.");
	    	    $this->msg.=" ".AddonMobileApp::t("Reference # ".$order_id);
				$this->details=array(
				  'next_step'=>"receipt",
				  'amount_to_pay'=>$amount_to_pay
				);
				
				/*insert logs for food history*/
				$params_logs=array(
				  'order_id'=>$order_id,
				  'status'=> 'paid',
				  'date_created'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				$db_ext->insertData("{{order_history}}",$params_logs);
								
			    // now we send the pending emails
				//AddonMobileApp::processPendingReceiptEmail($order_id);
				
				/*SEND EMAIL RECEIPT*/
                AddonMobileApp::notifyCustomer($order_id);		
                
                /*SEND FAX*/
                if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
                   Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);			
                }                
				
				/*pts*/
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){
					    AddonMobileApp::updatePoints($order_id,$client_id);
					}
				}
				
				// driver app
			    if ( AddonMobileApp::hasModuleAddon("driver")){
			     	Yii::app()->setImport(array(			
					  'application.modules.driver.components.*',
					));							
					Driver::addToTask($order_id);
					//AddonMobileApp::addToTask($order_id);
			    }
            	
             } else $this->msg=$response->response_reason_text;    	
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}
	
	public function actionPayStp()
	{
		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant id is missing");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['order_id'])){
			$this->msg=$this->t("Order id is missing");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['stripe_token'])){
			$this->msg=$this->t("Stripe token is missing");
			$this->output();
			Yii::app()->end();
		}
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			 
			$client_id=$resp['client_id'];
			$mtid=$this->data['merchant_id'];
			$order_id=$this->data['order_id'];
			
			//if ( Yii::app()->functions->isMerchantCommission($mtid)){
			if (FunctionsV3::isMerchantPaymentToUseAdmin($mtid)){
			    $mode=Yii::app()->functions->getOptionAdmin('admin_stripe_mode');  
			    $mode=strtolower($mode);
			    if ( $mode=="sandbox"){
					$secret_key=Yii::app()->functions->getOptionAdmin('admin_sanbox_stripe_secret_key');   
					$publishable_key=Yii::app()->functions->getOptionAdmin('admin_sandbox_stripe_pub_key');   
				} elseif ($mode=="live"){
					$secret_key=Yii::app()->functions->getOptionAdmin('admin_live_stripe_secret_key');   
					$publishable_key=Yii::app()->functions->getOptionAdmin('admin_live_stripe_pub_key');   
				}	
			} else {
				$mode=Yii::app()->functions->getOption('stripe_mode',$mtid);   
				$mode=strtolower($mode);
				
				if ( $mode=="sandbox"){
					$secret_key=Yii::app()->functions->getOption('sanbox_stripe_secret_key',$mtid);   
					$publishable_key=Yii::app()->functions->getOption('sandbox_stripe_pub_key',$mtid);   
				} elseif ($mode=="live"){
					$secret_key=Yii::app()->functions->getOption('live_stripe_secret_key',$mtid);   
					$publishable_key=Yii::app()->functions->getOption('live_stripe_pub_key',$mtid);   
				}
			}		
			
			try {
				
				require_once('stripe/lib/Stripe.php');
				
				Stripe::setApiKey($secret_key);
				
			    $customer = Stripe_Customer::create(array(			    
			      'card'  => $this->data['stripe_token']
			    ));
			    
			    $amount_to_pay=unPrettyPrice($this->data['total_w_tax']);
			    $amount_to_pay_orig=$amount_to_pay;
			    $amount_to_pay=is_numeric($amount_to_pay)?unPrettyPrice($amount_to_pay*100):0;
		        $amount_to_pay=Yii::app()->functions->normalPrettyPrice2($amount_to_pay);	
		       
			    $charge = Stripe_Charge::create(array(
		          'customer' => $customer->id,
		          'amount'   => $amount_to_pay,
		          'currency' => Yii::app()->functions->adminCurrencyCode()
		        ));	        
		        
		        $chargeArray = $charge->__toArray(true);
		        
		        $db_ext=new DbExt;
		        $params_logs=array(
		          'order_id'=>$order_id,
		          'payment_type'=>"stp",
		          'raw_response'=>json_encode($chargeArray),
		          'date_created'=>AddonMobileApp::dateNow(),
		          'ip_address'=>$_SERVER['REMOTE_ADDR']
		        );
		        $db_ext->insertData("{{payment_order}}",$params_logs);
		        
		        $params_update=array( 'status'=>'paid');	        
		        $db_ext->updateData("{{order}}",$params_update,'order_id',$order_id);
		        
		        $this->code=1;
				$this->msg=Yii::t("default","Your order has been placed.");
	    	    $this->msg.=" ".AddonMobileApp::t("Reference # ".$order_id);
				$this->details=array(
				  'next_step'=>"receipt",
				  'amount_to_pay'=>$amount_to_pay_orig
				);
				
				/*insert logs for history*/
				$params_logs=array(
				  'order_id'=>$order_id,
				  'status'=> 'paid',
				  'date_created'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				$db_ext->insertData("{{order_history}}",$params_logs);
				
				//AddonMobileApp::processPendingReceiptEmail($order_id);
				
				/*SEND EMAIL RECEIPT*/
                AddonMobileApp::notifyCustomer($order_id);
				
                /*SEND FAX*/
                if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
                   Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);			
                }
                                
				/*pts*/
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){
					    AddonMobileApp::updatePoints($order_id,$client_id);
					}
				}
				
				// driver app
			    if ( AddonMobileApp::hasModuleAddon("driver")){
			     	Yii::app()->setImport(array(			
					  'application.modules.driver.components.*',
					));							
					Driver::addToTask($order_id);
					//AddonMobileApp::addToTask($order_id);
			    }
				
			} catch (Exception $e)   {
	    	   $this->msg=$e->getMessage();
	    }    
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}

	
	public function actionValidateCLient()
	{
		$db_ext=new DbExt;  
		
		switch ($this->data['validation_type']) {
			case "mobile_verification":
				if ( $res=AddonMobileApp::verifyMobileCode($this->data['code'],$this->data['client_id'])){
				    
					$params=array( 
					  'status'=>"active",
					  'mobile_verification_date'=>AddonMobileApp::dateNow(),
					  'last_login'=>AddonMobileApp::dateNow()
					);
					$db_ext->updateData("{{client}}",$params,'client_id',$res['client_id']);
					$this->code=1;
					$this->msg=$this->t("Validation successful");
					$this->details=array(
					  'token'=>$res['token'],
					  'is_checkout'=>$this->data['is_checkout']
					);
					
					/*SEND WELCOME EMAIL*/
					FunctionsV3::sendCustomerWelcomeEmail($res);
					
				} else $this->msg=$this->t("verification code is invalid");
				break;
		
			case "email_verification":	
			    if( $res=Yii::app()->functions->getClientInfo( $this->data['client_id'] )){	
			    	if ($res['email_verification_code']==trim($this->data['code'])){
			    		
			    		$params=array( 
						  'status'=>"active",
						  'last_login'=>AddonMobileApp::dateNow()
						);
						$db_ext->updateData("{{client}}",$params,'client_id',$res['client_id']);
			    		
			    	 	$this->code=1;
					    $this->msg=$this->t("Validation successful");
					    $this->details=array(
						  'token'=>$res['token'],
						  'is_checkout'=>$this->data['is_checkout']
						);
						
						/*SEND WELCOME EMAIL*/
					    FunctionsV3::sendCustomerWelcomeEmail($res);
					    
			    	} else $this->msg=$this->t("verification code is invalid");
			    } else $this->msg=$this->t("verification code is invalid");
				break;
				
			default:
				$this->msg=$this->t("validation type unrecognize");
				break;
		}
		
		$this->output();
	}
	
	public function actiongetPTS()
	{
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			 $client_id=$resp['client_id'];
			 $points=PointsProgram::getTotalEarnPoints($client_id);
			 $points_expiring=PointsProgram::getExpiringPoints($client_id);
			
			 $total_expenses_points=AddonMobileApp::getExpensesPointsTotal($client_id);
			 
			 $this->code=1;
			 $this->msg="OK";
			 $this->details=array(
			    'available_points'=>!empty($points)?$points:0,
			    'points_expiring'=>!empty($points_expiring)?$points_expiring:0,
			    'total_expenses_points'=>!empty($total_expenses_points)?$total_expenses_points:0,
			 );
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}
	
	public function actiondetailsPTS()
	{
		$db_ext=new DbExt;  
		$feed_data=''; $title='';
		
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			$client_id=$resp['client_id'];			
			switch ($this->data['pts_type']) {
				case 1:
					$stmt="
					SELECT * FROM
					{{points_earn}}
					WHERE
					status='active'
					AND
					client_id=".Yii::app()->functions->q($client_id)."
					ORDER BY id DESC
					LIMIT 0,500
					";
					
					$title=$this->t("Income Points");
					break;
			
				case 2:	
				   $stmt="
					SELECT * FROM
					{{points_expenses}}
					WHERE
					status='active'
					AND
					client_id=".Yii::app()->functions->q($client_id)."
					ORDER BY id DESC
					LIMIT 0,500
					";
				   $title=$this->t("Expenses Points");
				   break;
				   
				case 3:
					$stmt="
					SELECT * FROM
					{{points_earn}}
					WHERE
					status='expired'
					AND
					client_id=".Yii::app()->functions->q($client_id)."
					ORDER BY id DESC
					LIMIT 0,500
					";
					$title=$this->t("Expired Points");
				   break;
			}			
			if ( $res=$db_ext->rst($stmt)){
				foreach ($res as $val) {
					//dump($val);
					$label=PointsProgram::PointsDefinition($val['points_type'],$val['trans_type'],
					$val['order_id'],$val['total_points_earn']);					
					
					$points=$val['total_points_earn'];
					$points_label="<span>+".$points."</span>";
					if($this->data['pts_type']==2){
						$points=$val['total_points'];
						$points_label="<span>-".$points."</span>";
					}					
					
					$feed_data[]=array(
					   'date_created'=>Yii::app()->functions->displayDate($val['date_created']),
					   "label"=>$label,
					   "points"=>$points_label
					);
				}
			} 
			
			$this->code=1;
			$this->msg="OK";
			$this->details=array(
			  'title'=>$title,
			  'data'=>$feed_data
			);
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}
	
	public function actionapplyRedeemPoints()
	{

	    $Validator=new Validator;
	    
	    $amt=0; $total=0;
	    
	    if(isset($this->data['subtotal_order'])){
	    	$this->data['subtotal_order']=trim($this->data['subtotal_order']);
	    }
	    
	    $req=array(
	      'redeem_points'=>AddonMobileApp::t("redeem points is required"),
	      'subtotal_order'=>$this->t("Subtotal is missing")
	    );
	    	    
	    if($this->data['voucher_amount']>0.0){
	        $Validator->msg[]=AddonMobileApp::t("Sorry but you cannot redeem points if you have already voucher applied on your cart");
	    }
	    if ( $this->data['redeem_points']<1){
	    	$Validator->msg[]=AddonMobileApp::t("Redeem points must be greater than zero");
	    }
	    if ( !$resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
	    	$this->msg[]=AddonMobileApp::t("invalid token");
	    } else {
	    	
	    	 $client_id=$resp['client_id'];
	    	 $balance_points=PointsProgram::getTotalEarnPoints($client_id);	
	    	 
	    	 if ( $balance_points<$this->data['redeem_points']){
	    		$Validator->msg[]=$this->t("Sorry but your points is not enough");
	    	 }
	    	 
	    	$points_apply_order_amt=PointsProgram::getOptionA('points_apply_order_amt');
			if ($points_apply_order_amt>0){
				if ( $points_apply_order_amt>$this->data['subtotal_order'] ){
					$Validator->msg[]=AddonMobileApp::t("Sorry but you can only redeem points on orders over")." ".
					Yii::app()->functions->normalPrettyPrice($points_apply_order_amt);
				}
			}
			
			$points_minimum=PointsProgram::getOptionA('points_minimum');		
			if ($points_minimum>0){
				if ( $points_minimum>$this->data['redeem_points']){
					$Validator->msg[]=PointsProgram::t("Sorry but Minimum redeem points can be used is")." ".$points_minimum;	    
				}
			}
			
			$points_max=PointsProgram::getOptionA('points_max');
			if ( $points_max>0){
				if ( $points_max<$this->data['redeem_points']){
					$Validator->msg[]=PointsProgram::t("Sorry but Maximum redeem points can be used is")." ".$points_max;
				}
			}
			
			/*convert the redeem points to amount value*/
			$pts_redeeming_point=PointsProgram::getOptionA('pts_redeeming_point');
			$pts_redeeming_point_value=PointsProgram::getOptionA('pts_redeeming_point_value');
			if ($pts_redeeming_point<0.01){							
				$Validator->msg[]=PointsProgram::t("Error Redeeming Point less than zero on the backend settings");
			} 
			
			if ($pts_redeeming_point_value<0.01){				
				$Validator->msg[]=PointsProgram::t("Error Redeeming Point value is less than zero on the backend settings");	
				$this->jsonResponse();
				Yii::app()->end();
			}
			
			//$amt=($this->data['redeem_points']/$pts_redeeming_point)*$pts_redeeming_point_value;
			$temp_redeem=intval($this->data['redeem_points']/$pts_redeeming_point);
			$amt=$temp_redeem*$pts_redeeming_point_value;
			$amt=Yii::app()->functions->normalPrettyPrice($amt);
			
	    } /*end if*/
	    
	    $Validator->required($req,$this->data);
		if ($Validator->validate()){
			$client_id=$resp['client_id'];	
			
			//dump($this->data);
			
			$cart_sub_total=$this->data['cart_sub_total']-$amt;
			
			/*apply tips*/
	        $tips_amount=0;
	        if ( isset($this->data['tips_percentage'])){
	        	if (is_numeric($this->data['tips_percentage'])){
	        	    $tips_amount=$cart_sub_total*($this->data['tips_percentage']/100);		        	    
	        	}
	        }
	        	       
			if(isset($this->data['cart_delivery_charges'])){
			   $cart_sub_total+=unPrettyPrice($this->data['cart_delivery_charges']);
			}
			if(isset($this->data['cart_packaging'])){
			   $cart_sub_total+=unPrettyPrice($this->data['cart_packaging']);
			}
						
			if(isset($this->data['cart_tax'])){
			   if($this->data['cart_tax']>0){
			   	  $tax=$cart_sub_total*($this->data['cart_tax']/100);
			   	  $total=$cart_sub_total+$tax;
			   	  $total+=$tips_amount;
			   } else $total=$cart_sub_total;
			} else $total=$cart_sub_total+$tips_amount;
			
			$this->code=1;
			$this->msg="OK";
			$this->details=array(			  
			  'pts_amount'=>AddonMobileApp::prettyPrice($amt),
			  'pts_amount_raw'=>$amt,
			  'pts_points'=>$this->data['redeem_points']." ".AddonMobileApp::t("Points"),
			  'pts_points_raw'=>$this->data['redeem_points'],
			  'new_total'=>$total
			);
			
			
		} else $this->msg=AddonMobileApp::parseValidatorError($Validator->getError());
		$this->output();
	}
	
	
	public function actionrazorPaymentSuccessfull()
	{
		
		$DbExt=new DbExt;
		if(isset($this->data['payment_id'])){
			
			$order_id=isset($this->data['order_id'])?$this->data['order_id']:'';
			
			$params=array(
			  'payment_type'=>'rzr',
			  'payment_reference'=>$this->data['payment_id'],
			  'order_id'=>$order_id,
			  'raw_response'=>$this->data['payment_id'],
			  'date_created'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
						
			if ( $DbExt->insertData("{{payment_order}}",$params) ){
				
				$this->code=1;
				$this->msg=Yii::t("default","Your order has been placed.");
	    	    $this->msg.=" ".AddonMobileApp::t("Reference # ").$order_id;
	    	    
	    	    $amount_to_pay=0;
	    	    $client_id='';
	    	    if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
	    	       $amount_to_pay=$order_info['total_w_tax'];
	    	       $client_id=$order_info['client_id'];
	    	    }
	    	    
				$this->details=array(
				  'next_step'=>"receipt",
				  'amount_to_pay'=>$amount_to_pay
				);
				
				$params1=array('status'=> "paid" );		       
				$DbExt->updateData("{{order}}",$params1,'order_id',$order_id);
								
				/*insert logs for food history*/
				$params_logs=array(
				  'order_id'=>$order_id,
				  'status'=> 'paid',
				  'date_created'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				$DbExt->insertData("{{order_history}}",$params_logs);
				
				// now we send the pending emails
				//AddonMobileApp::processPendingReceiptEmail($order_id);
				
				/*SEND EMAIL RECEIPT*/
                AddonMobileApp::notifyCustomer($order_id);		
                
                /*SEND FAX*/
                if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
                   Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);			
                } 
				
				/*pts*/
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){												
					    AddonMobileApp::updatePoints($order_id,$client_id);
					}
				}
				
				// driver app
			    if ( AddonMobileApp::hasModuleAddon("driver")){
			     	Yii::app()->setImport(array(			
					  'application.modules.driver.components.*',
					));							
					Driver::addToTask($order_id);
					//AddonMobileApp::addToTask($order_id);
			    }
				
			} else $this->msg=$this->t("something went wrong during processing your request");
			
		} else $this->msg=AddonMobileApp::t("missing parameters");
		$this->output();
	}
	
	public function actionaddToCart()
	{
		
		if(isset($this->data['cart'])){
			
			$DbExt=new DbExt;
			
			$cart[]=json_decode($this->data['cart'],true);
			$_cart=json_decode($this->data['cart'],true);			
			
			$action=1;
			if($res=AddonMobileApp::getCartByDeviceID($this->data['device_id'])){			   
			   $temp = !empty($res['cart'])?json_decode($res['cart'],true):false;			   
			   //$cart=array_merge($cart,$temp);
			   			   
			   $cart=array_merge( (array) $temp, (array) $cart);
			   $action=2;
			} 
									
			$params=array(
			  'device_id'=>$this->data['device_id'],
			  'cart'=>json_encode($cart)
			);
						
			if($action==1){
				$DbExt->insertData("{{mobile_cart}}",$params);
			} else {
				$DbExt->updateData("{{mobile_cart}}",$params,'device_id',$this->data['device_id']);
			}								
		}	
		$this->code=1;
		$this->msg="OK";
		$this->output();
	}
	
	public function actionClearCart()
	{
		$DbExt=new DbExt;
		if(isset($this->data['device_id'])){
			$DbExt->qry("
			DELETE FROM {{mobile_cart}}
			WHERE
			device_id=".AddonMobileApp::q($this->data['device_id'])."
			");
		}
		$this->code=1;
		$this->msg="OK";
		$this->output();
	}
	
	public function actiongetCustomFields()
	{
		$fields='';
		$field_1=getOptionA('client_custom_field_name1');
		$field_2=getOptionA('client_custom_field_name2');
		if(!empty($field_1)){
			$fields['custom_field1']=$field_1;
		}	
		if(!empty($field_2)){
			$fields['custom_field2']=$field_2;
		}	
		
		if(!empty($fields)){			
		    $this->code=1;
		    $this->msg=getOptionA('website_terms_customer');
		    $this->details=$fields;
		} else $this->msg=getOptionA('website_terms_customer');
		
		$this->output();
	}
	
	public function actionVerifyAccount()
	{
	    $verification_type='';	
		$mobile_verification=getOptionA('website_enabled_mobile_verification');
		$email_verification=getOptionA('theme_enabled_email_verification');
		
		if($mobile_verification=="yes"){
			$verification_type="mobile";
		} else {
			$verification_type="email";
		}
		
		if ( $res=Yii::app()->functions->isClientExist($this->data['email_address'])){
			
			if($res['status']=="active"){
			   $this->msg=AddonMobileApp::t("Your account is already active");
			   $this->output();
			   Yii::app()->end();
			}		
			
			$client_id=$res['client_id'];		
			
			if($verification_type=="mobile"){
			   $fields='mobile_verification_code';
			} else $fields='email_verification_code';
							
			if($res[$fields]==trim($this->data['code'])){
								
				$db=new DbExt();
				
				$params=array(
				  'status'=>"active",
				  'mobile_verification_date'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				  
				);				
				$db->updateData("{{client}}",$params,'client_id',$client_id);
				
				$this->code=1;
				$this->msg=AddonMobileApp::t("Validation successful");
				$this->details=array(
				  'token'=>$res['token']
				);
			} else $this->msg=AddonMobileApp::t("verification code is invalid");
		} else $this->msg=AddonMobileApp::t("Your email address does not exist");
		
		$this->output();
	}
	
	public function actioncoordinatesToAddress()
	{		
		if(isset($this->data['lat']) && isset($this->data['lng']) ){
			if ( $res=AddonMobileApp::latToAdress($this->data['lat'],$this->data['lng']) ){
				$this->code=1;
				$this->msg="Successful";
				$this->details=array(
				  'lat'=>$this->data['lat'],
				  'lng'=>$this->data['lng'],
				  'result'=>$res
				);
			} else $this->msg=AddonMobileApp::t("Goecoding failed");
		} else $this->msg=AddonMobileApp::t("Missing lat and long parameter");
		$this->output();
	}
	
	public function actiondragMarker()
	{
		$this->actioncoordinatesToAddress();
	}
	
	public function actionTrackOrderHistory()
	{		
		$coordinates=''; $driver_info='';
				
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			$client_id=$resp['client_id'];

			$time_left="00";
			$time_left_label=AddonMobileApp::t("minutes left");
			$assign_driver=2;
			
			if ( AddonMobileApp::hasModuleAddon("driver")){
				if($task=AddonMobileApp::getOrderTask($this->data['order_id'])){	
						
					//dump($task);			
					$continue=true;
					switch ($task['status']) {
				    	case "successful":
				    	case "failed":	
				    	case "cancelled":
				    		$continue=false;
				    		break;
				    
				    	default:
				    		break;
				    }	
					
					$delivery_address=$task['delivery_address'];
					
					if($task['driver_id']>0 && $continue==TRUE){
												
						if (!empty($task['location_lat']) && !empty($task['location_lng']) 
						    && !empty($task['task_lat']) && !empty($task['task_lng']) ){								
							
						    $coordinates=array(
						      'driver_lat'=>trim($task['location_lat']),
						      'driver_lng'=>trim($task['location_lng']),
						      'task_lat'=>trim($task['task_lat']),
						      'task_lng'=>trim($task['task_lng']),
						    );
						    
						    $assign_driver=1;		
						    						    						    
						    $driver_info=array(
						      'driver_name'=>ucwords($task['driver_name']),
						      'driver_email'=>$task['email'],
						      'driver_phone'=>$task['phone'],
						      'licence_plate'=>$task['licence_plate'],
						      'transport_description'=>$task['transport_description'],
						      'transport_type'=>$task['transport_type_id'],
						    );
						    
							$task_distance_resp = AddonMobileApp::getTaskDistance(
							  $task['location_lat'],
							  $task['location_lng'],
							  $task['task_lat'],
							  $task['task_lng'],
							  $task['transport_type_id']
							);
							if($task_distance_resp){
							   //dump($task_distance_resp);
							   $task_distance_resp_raw=explode(" ",$task_distance_resp);
							   //dump($task_distance_resp_raw);
							   if(is_array($task_distance_resp_raw) && count($task_distance_resp_raw)>=1){
								   switch ($task_distance_resp_raw[1]) {
								   	case "min":
								   	case "minute":
								   	case "minutes":
								   		$time_left=$task_distance_resp_raw[0];
								   		$time_left_label=AddonMobileApp::t("minutes left");
								   		break;
								   		
								    case "hours":
								    case "hour":
								   		$time_left=$task_distance_resp_raw[0];
								   		$time_left_label=$task_distance_resp_raw[1];
								   		if(isset($task_distance_resp_raw[2])){
								   			$time_left_label.=" ".$task_distance_resp_raw[2];
								   		}								   
								   		if(isset($task_distance_resp_raw[3])){
								   			$time_left_label.=" ".$task_distance_resp_raw[3];
								   		}								   
								   		break;
								   		   
								   	default:
								   		$time_left=$task_distance_resp_raw[0];
								   		$time_left_label=$task_distance_resp_raw[1];
								   		if(isset($task_distance_resp_raw[2])){
								   			$time_left_label.=" ".$task_distance_resp_raw[2];
								   		}								   
								   		if(isset($task_distance_resp_raw[3])){
								   			$time_left_label.=" ".$task_distance_resp_raw[3];
								   		}								   
								   		break;
								   }
							   }
							}
						}
					}				
				}			
			}
					
			if ( $res=AddonMobileApp::orderHistory($this->data['order_id']) ){
				 foreach ($res as $val) {				 					 					 	
				 	
				 	$status=t($val['status']);		
				 	if(isset($val['remarks2'])){
					 	if(!empty($val['remarks2'])){							
							$args=json_decode($val['remarks_args'],true);								
							if(is_array($args) && count($args)>=1){
								foreach ($args as $args_key=>$args_val) {
									$args[$args_key]=t($args_val);
								}
							}								
							$new_remarks=$val['remarks2'];								
							$new_remarks=Yii::t("default",$new_remarks,$args);								
							$status.="<p class=\"small-font-dim\">$new_remarks</p>";
						} else {
							if(!empty($val['remarks'])){
					 	   	  $status.="<p class=\"small-font-dim\">".$val['remarks']."</p>";
					 	    }				 	
						}				 	
				 	} else {
				 	   if(!empty($val['remarks'])){
				 	   	  $status.="<p class=\"small-font-dim\">".$val['remarks']."</p>";
				 	   }				 	
				 	}				
				
				 	$data[]=array(
				 	  'date_time'=>date("g:i a M jS Y",strtotime($val['date_created'])),
				 	  //'status_raw'=>$status,
				 	  'status_raw'=>$val['status'],
				 	  'status'=>$status
				 	);
				 }
				 $this->code=1;
				 $this->msg="OK";
				 $this->details=array(
				   'delivery_address'=>isset($delivery_address)?$delivery_address:'',
				   'assign_driver'=>$assign_driver,
				   'coordinates'=>$coordinates,
				   'driver_info'=>$driver_info,
				   'history'=>$data,				   
				   'time_left'=>$time_left,
				   'remaining'=>$time_left_label,
				   'driver_icon'=>websiteUrl()."/protected/modules/mobileapp/assets/images/car.png",
				   'address_icon'=>websiteUrl()."/protected/modules/mobileapp/assets/images/racing-flag.png",
				   'driver_avatar'=>websiteUrl()."/protected/modules/mobileapp/assets/images/user.png",
				 );
			} else $this->msg=AddonMobileApp::t("No history found");
		} else $this->msg=AddonMobileApp::t("it seems that your token has expired. please re login again");
		$this->output();
	}
	
	public function actionsaveContactNumber()
	{		
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			$client_id=$resp['client_id'];
			
            if ( FunctionsK::mobileBlockedCheck($this->data['contact_phone'])){
	    		$this->msg=$this->t("Sorry but your mobile number is blocked by website admin");
	    		$this->output();
	    	}	    	
	    	
	    	$functionk=new FunctionsK();
	    	if ( $functionk->CheckCustomerMobile($this->data['contact_phone'],$client_id)){
	        	$this->msg=$this->t("Sorry but your mobile number is already exist in our records");
	        	$this->output();
	        }	  
	        	    	
	    	$db_ext=new DbExt;  
	    	$db_ext->updateData("{{client}}",array(
	    	  'contact_phone'=>trim($this->data['contact_phone'])
	    	),'client_id',$client_id);
	    	
	    	$this->code=1;
	    	$this->msg="OK";
			
		} else $this->msg=AddonMobileApp::t("it seems that your token has expired. please re login again");
		$this->output();	
	}
	
	public function actionTrackOrderMap()
	{
	
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {			
			$client_id=$resp['client_id'];
			
			if($task=AddonMobileApp::getOrderTask($this->data['order_id'])){	
				$continue=true;
				switch ($task['status']) {
			    	case "successful":
			    	case "failed":	
			    	case "cancelled":
			    		$continue=false;
			    		break;
			    
			    	default:
			    		break;
			    }	
			    
			    $delivery_address=$task['delivery_address'];
			    
			    if($task['driver_id']>0 && $continue==TRUE){
			    	
			    	if (!empty($task['location_lat']) && !empty($task['location_lng']) 
						    && !empty($task['task_lat']) && !empty($task['task_lng']) ){	
						    	
						  $coordinates=array(
						      'driver_lat'=>trim($task['location_lat']),
						      'driver_lng'=>trim($task['location_lng']),
						      'task_lat'=>trim($task['task_lat']),
						      'task_lng'=>trim($task['task_lng']),
						    );
						    
						    $this->code=1;
						    $this->msg="OK";
						    $this->details=$coordinates;
						    
				    } else $this->msg=AddonMobileApp::t("Driver location not yet ready");
			    	
			    } else $this->msg=AddonMobileApp::t("Task is already completed or cancelled");
			    
			} else $this->msg=AddonMobileApp::t("Task not found");
			
		} else $this->msg=AddonMobileApp::t("it seems that your token has expired. please re login again");
		$this->output();
	}
	
	public function actiongetMerchantCClist()
	{		
		if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){			
			if ( $res=AddonMobileApp::getCustomerCCList( $client['client_id'] )){
				foreach ($res as $val) {
					$val['credit_card_number']=Yii::app()->functions->maskCardnumber($val['credit_card_number']);
					$data[]=$val;
				}
				$this->code=1;
				$this->msg="OK";
				$this->details=$data;
			} else $this->msg=AddonMobileApp::t("You don't have credit card yet");
		} else $this->msg=AddonMobileApp::t("it seems that your token has expired. please re login again");
		$this->output();
	}

	public function actionsaveCreditCard()
	{		
		if ( $client=AddonMobileApp::getClientTokenInfo($this->data['client_token'])){			
			
			if (empty($this->data['expiration_month']) || empty($this->data['expiration_yr'])){
				$this->msg=AddonMobileApp::t("Expiration is required");
				$this->output();
				Yii::app()->end();
			}		
			
			$params=array(
			  'client_id'=>$client['client_id'],
			  'card_name'=>$this->data['card_name'],
			  'credit_card_number'=>$this->data['cc_number'],
			  'expiration_month'=>$this->data['expiration_month'],
			  'expiration_yr'=>$this->data['expiration_yr'],
			  'cvv'=>$this->data['cvv'],
			  'billing_address'=>$this->data['billing_address'],
			  'date_created'=>date('Y-m-d G:i:s'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);
			
			if(!isset($this->data['cc_id'])){
				$this->data['cc_id']='';
			}
									
			$db=new DbExt;
			if (is_numeric($this->data['cc_id'])){
				unset($params['date_created']);
				$params['date_modified']=date('Y-m-d G:i:s');				
				if ( $db->updateData("{{client_cc}}",$params,'cc_id',$this->data['cc_id'])){
					$this->code=1;
					$this->msg=AddonMobileApp::t("Successful");
				} else $this->msg=AddonMobileApp::t("ERROR: Cannot update records");
			} else {		
				if ( $db->insertData("{{client_cc}}",$params)){
					$this->code=1;
					$this->msg="OK";
				} else $this->msg=AddonMobileApp::t("Failed cannot saved records");
			}
			
		} else $this->msg=AddonMobileApp::t("it seems that your token has expired. please re login again");
		$this->output();
	}
	
	public function actionloadCC()
	{		
		if ( $res = Yii::app()->functions->getCreditCardInfo( $this->data['cc_id'] )){
			$this->code=1;
		    $this->msg="OK";
		    $this->details=$res;
		} else $this->msg=AddonMobileApp::t("Credit card information not available");
		$this->output();
	}
	
	public function actiondeleteCreditCard($cc_id='')
	{		
		$db=new DbExt;
		$stmt="
		DELETE FROM
		{{client_cc}}
		WHERE
		cc_id=".AddonMobileApp::q($cc_id)."
		";		
		$db->qry($stmt);
		$this->code=1;
		$this->msg="OK";
		$this->output();
	}
	
	public function actioniPay88Successfull()
	{
		$DbExt=new DbExt;
		if(isset($this->data['payment_id'])){
									
			$raw_response=isset($this->data['order_id'])?$this->data['order_id']:'';
			$order_id=isset($this->data['order_id'])?$this->data['order_id']:'';
			$order_id=explode("-",$order_id);			
			$order_id=$order_id[1];
						
			$params=array(
			  'payment_type'=>'ip8',
			  'payment_reference'=>$this->data['payment_id'],
			  'order_id'=>$order_id,
			  'raw_response'=>$raw_response,
			  'date_created'=>AddonMobileApp::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);						
						
			if ( $DbExt->insertData("{{payment_order}}",$params) ){
				
				$this->code=1;
				$this->msg= AddonMobileApp::t("Your order has been placed.");
	    	    $this->msg.=" ".AddonMobileApp::t("Reference # ").$order_id;
	    	    
	    	    $amount_to_pay=0;
	    	    $client_id='';
	    	    if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
	    	       $amount_to_pay=$order_info['total_w_tax'];
	    	       $client_id=$order_info['client_id'];
	    	    }
	    	    
				$this->details=array(
				  'next_step'=>"receipt",
				  'amount_to_pay'=>$amount_to_pay
				);
				
				$params1=array('status'=> "paid" );		       
				$DbExt->updateData("{{order}}",$params1,'order_id',$order_id);
								
				/*insert logs for food history*/
				$params_logs=array(
				  'order_id'=>$order_id,
				  'status'=> 'paid',
				  'date_created'=>AddonMobileApp::dateNow(),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				$DbExt->insertData("{{order_history}}",$params_logs);
				
				// now we send the pending emails
				//AddonMobileApp::processPendingReceiptEmail($order_id);
								
				/*SEND EMAIL RECEIPT*/
				AddonMobileApp::notifyCustomer($order_id);
				
				/*SEND FAX*/
                if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
                   Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);			
                }
								
				/*pts*/
				if (AddonMobileApp::hasModuleAddon('pointsprogram')){
					if (getOptionA('points_enabled')==1){												
					    AddonMobileApp::updatePoints($order_id,$client_id);
					}
				}
				
				// driver app
			    if ( AddonMobileApp::hasModuleAddon("driver")){
			     	Yii::app()->setImport(array(			
					  'application.modules.driver.components.*',
					));							
					Driver::addToTask($order_id);
					//AddonMobileApp::addToTask($order_id);
			    }
				
			} else $this->msg=$this->t("something went wrong during processing your request");
			
		} else $this->msg=AddonMobileApp::t("missing parameters");
		$this->output();
	}
	
	public function actionMonerisPay()
	{		
		if (!isset($this->data['merchant_id'])){
			$this->msg=$this->t("Merchant id is missing");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['order_id'])){
			$this->msg=$this->t("Order id is missing");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['total_w_tax'])){
			$this->msg=$this->t("Total amount to pay is required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['cards'])){
			$this->msg=$this->t("Card number is required");
			$this->output();
			Yii::app()->end();
		}		
		if(empty($this->data['expiration_month'])){
			$this->msg=$this->t("Expiration month is required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['expiration_yr'])){
			$this->msg=$this->t("Expiration year required");
			$this->output();
			Yii::app()->end();
		}
		if(empty($this->data['cvv'])){
			$this->msg=$this->t("CVV is required");
			$this->output();
			Yii::app()->end();
		}
		if ( $resp=AddonMobileApp::getClientTokenInfo($this->data['client_token'])) {
			
			$client_id=$resp['client_id'];
			$mtid=$this->data['merchant_id'];
			$order_id=$this->data['order_id'];
			
			require_once 'mpgClasses.php';	   
	        $payment_ref="ODR-" . Moneris::generatePaymentRef(). "-"  .Moneris::lastID('payment_order');
	        
	        $payment_description = AddonMobileApp::t("Payment to merchant");
	        
	        $amount_to_pay_orig=$this->data['total_w_tax'];
	        
	        $txnArray=array(
		       'type'=>"purchase",
			   'order_id'=>$payment_ref,		   
		       'amount'=>normalPrettyPrice($this->data['total_w_tax']),
			   'pan'=>$this->data['cards'],
			   'expdate'=>substr($this->data['expiration_yr'],2,2).$this->data['expiration_month'],
			   'crypt_type'=>Moneris::cryptType(),
			   'dynamic_descriptor'=>$payment_description
		    );	        
		    
		    $cvdTemplate = array(
			    'cvd_indicator' => 1,
			    'cvd_value' => isset($this->data['cvv'])?$this->data['cvv']:''
			);
		       
		    if ( $credentials=Moneris::getCredentials('merchant',$mtid)){
		    	
		    	$mpgCvdInfo = new mpgCvdInfo ($cvdTemplate);
		    	
		    	$mpgTxn = new mpgTransaction($txnArray);
		    	$mpgTxn->setCvdInfo($mpgCvdInfo);
		    	
		    	$mpgRequest = new mpgRequest($mpgTxn);
		    	$mpgRequest->setProcCountryCode( $credentials['country_code'] );
		    	$mpgRequest->setTestMode( $credentials['mode'] );
		    		    	
		    	$mpgHttpPost  =new mpgHttpsPost(trim($credentials['store_id']), trim($credentials['token']) ,$mpgRequest);	    	
		    	$resp=$mpgHttpPost->getMpgResponse();
		    	
		    	$cvv_response = $resp->getCvdResultCode();
		    	if (!empty($cvv_response)){
		    		$cvv_response=str_replace("1","",$cvv_response);
		    	}
		    			    	
		    	if ( in_array($resp->getResponseCode(),Moneris::approvedResponsenCode() )){
		    		if ( $cvv_response=="M" || $cvv_response=="1M"){
			    		$DbExt=new DbExt;
			    		 
			    		$full_response=json_encode($resp->responseData);
			    		
			    		$params_logs=array(
				          'order_id'=>$order_id,
				          'payment_type'=>Moneris::getPaymentCode(),
				          'payment_reference'=>$resp->getReferenceNum(),
				          'raw_response'=>$full_response,
				          'date_created'=>FunctionsV3::dateNow(),
				          'ip_address'=>$_SERVER['REMOTE_ADDR']
				        );		        
				        $DbExt->insertData("{{payment_order}}",$params_logs);
				        $params_update=array( 'status'=>'paid');	        
			            $DbExt->updateData("{{order}}",$params_update,'order_id',$order_id);
			            
			            $this->code=1;
						$this->msg= AddonMobileApp::t("Your order has been placed.");
			    	    $this->msg.=" ".AddonMobileApp::t("Reference # ".$order_id);
						$this->details=array(
						  'next_step'=>"receipt",
						  'amount_to_pay'=>$amount_to_pay_orig
						);
						
						/*insert logs for history*/
						$params_logs=array(
						  'order_id'=>$order_id,
						  'status'=> 'paid',
						  'date_created'=>AddonMobileApp::dateNow(),
						  'ip_address'=>$_SERVER['REMOTE_ADDR']
						);
						$DbExt->insertData("{{order_history}}",$params_logs);
						
						//AddonMobileApp::processPendingReceiptEmail($order_id);
																		
						/*SEND EMAIL RECEIPT*/
						AddonMobileApp::notifyCustomer($order_id);
						
						/*SEND FAX*/
                        if($order_info=Yii::app()->functions->getOrderInfo($order_id)){
                           Yii::app()->functions->sendFax($order_info['merchant_id'],$order_id);			
                        }                
						
						/*pts*/
						if (AddonMobileApp::hasModuleAddon('pointsprogram')){
							if (getOptionA('points_enabled')==1){
							    AddonMobileApp::updatePoints($order_id,$client_id);
							}
						}
						
						// driver app
					    if ( AddonMobileApp::hasModuleAddon("driver")){
					     	Yii::app()->setImport(array(			
							  'application.modules.driver.components.*',
							));							
							Driver::addToTask($order_id);						
					    }				
			    		
				    } else $this->msg = Moneris::CvvResult( $cvv_response );
		    	} else $this->msg=$resp->getMessage();
		    	
		    } else $this->msg = AddonMobileApp::t("Credentials not yet set");
		    
		} else $this->msg=$this->t("invalid token");
		$this->output();
	}
	
} /*end class*/