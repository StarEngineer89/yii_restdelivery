<?php
if (!isset($_SESSION)) { session_start(); }

class AjaxmerchantController extends CController
{
	
	public $code=2;
	public $msg;
	public $details;
	public $data;
	static $db;
	
	public function __construct()
	{
		$this->data=$_POST;	
		if(isset($_GET['method'])){
			if($_GET['method']=="get"){
			   $this->data=$_GET;
			}
		}
		self::$db=new DbExt;
	}	
	
	public function beforeAction($action)
	{
		$action_name= $action->id ;
		if ( !Yii::app()->functions->isMerchantLogin()){
			 $this->msg=t("Error session has expired");
			 $this->jsonResponse();
			 Yii::app()->end();
		}
		return true;
	}
	
	public function init()
	{				 
		// set website timezone
		$website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone");		 
		if (!empty($website_timezone)){		 	
		 	Yii::app()->timeZone=$website_timezone;
		}		 				 
		FunctionsV3::handleLanguage();
		//echo Yii::app()->language;
	}
	
	private function jsonResponse()
	{
		$resp=array('code'=>$this->code,'msg'=>$this->msg,'details'=>$this->details);
		echo CJSON::encode($resp);
		Yii::app()->end();
	}
	
	public function actionIndex()
	{
		$this->code=1;
		$this->msg=t("Ajax is working");
		$this->jsonResponse();
	}
	
	public function actionaddNewRates()
	{
		$country_id=getOptionA('location_default_country');		
		$mtid = Yii::app()->functions->getMerchantID();
		if ( $res=FunctionsV3::getMerchantInfo($mtid)){
			if ($resp=FunctionsV3::getDefaultCountrySignup($res['country_code'])){
				$country_id=$resp;
			}
		}		
				
		if (!empty($country_id)){
			$citys=''; $areas='';
			if ($data=FunctionsV3::GetLocationRateByID( isset($this->data['rate_id'])?$this->data['rate_id']:'')){
				$citys=FunctionsV3::ListCityList($data['state_id']);
				$areas=FunctionsV3::AreaList($data['city_id']);
			}		
			$this->renderPartial('/merchant/add-new-rates',array(
			  'default_country_id'=>$country_id,
			  'states'=>FunctionsV3::ListLocationState($country_id),
			  'data'=>$data,
			  'citys'=>$citys,
			  'areas'=>$areas
			));
		}
	}
	
	public function actionLoadStateList()
	{				
		if($data=FunctionsV3::ListLocationState($this->data['country_id'])){
		   $html='';
		   foreach ($data as $key=>$val) {		   	  
		   	  $html.="<option value=\"".$key."\">".$val."</option>";
		   }		   
		   $this->code=1;
		   $this->msg="OK";
		   $this->details=$html;
		} else $this->msg= t("No results");
		$this->jsonResponse();
	}
	
	public function actionLoadCityList()
	{
		if ( $data=FunctionsV3::ListCityList($this->data['state_id'])){
		   $html='';
		   foreach ($data as $key=>$val) {		   	  
		   	  $html.="<option value=\"".$key."\">".$val."</option>";
		   }		   
		   $this->code=1;
		   $this->msg="OK";
		   $this->details=$html;
		} else $this->msg= t("No results");
		$this->jsonResponse();
	}
	
	public function actionLoadArea()
	{		
		if ( $data=FunctionsV3::AreaList($this->data['city_id'])){
			$html='';
		    foreach ($data as $key=>$val) {		   	  
		   	   $html.="<option value=\"".$key."\">".$val."</option>";
		    }		   
		    $this->code=1;
		    $this->msg="OK";
		    $this->details=$html;
		} else $this->msg= t("No results");
		$this->jsonResponse();
	}
	
	public function actionSaveRate()
	{		
		$mtid = Yii::app()->functions->getMerchantID();
		if(!empty($mtid)){
			$params=array(
			  'merchant_id'=>$mtid,
			  'country_id'=>$this->data['rate_country_id'],
			  'state_id'=>$this->data['rate_state_id'],
			  'city_id'=>$this->data['rate_city_id'],
			  'area_id'=>$this->data['rate_area_id'],
			  'fee'=>$this->data['fee'],
			  'date_created'=>FunctionsV3::dateNow(),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			$DbExt=new DbExt;
			if ( isset($this->data['rate_id'])){
				if ( $DbExt->updateData("{{location_rate}}",$params,'rate_id',$this->data['rate_id'])){
					$this->code=1; $this->msg=t("Successful");
				} else $this->msg=t("ERROR: cannot update records.");
			} else {
				$stmt_check="
				SELECT * FROM
				{{location_rate}}
				WHERE
				merchant_id=".FunctionsV3::q($mtid)."
				AND
				country_id=".FunctionsV3::q($this->data['rate_country_id'])."
				AND
				state_id=".FunctionsV3::q($this->data['rate_state_id'])."
				AND
				city_id=".FunctionsV3::q($this->data['rate_city_id'])."
				AND
				area_id=".FunctionsV3::q($this->data['rate_area_id'])."
				";
				
				if (!$DbExt->rst($stmt_check)){
					if ( $DbExt->insertData("{{location_rate}}",$params)){
						$this->code=1; $this->msg=t("Successful");
					} else $this->msg=t("ERROR. cannot insert data.");
				} else $this->msg=t("The rate you about to save is already exist");
			}
		} else $this->msg=t("Session Expired");
		$this->jsonResponse();
	}
	
	public function actionLoadTableRates()
	{
		$mtid = Yii::app()->functions->getMerchantID();
		if(!empty($mtid)){
			if ( $res = FunctionsV3::GetLocationRateByMerchantWithName($mtid)){
				$html='';
				foreach ($res as $val) {
					$id=$val['rate_id'];
					$action='<div class="options">';					
					$action.="<a href=\"javascript:;\" data-id=\"$id\" class=\"location_edit\" >".t("Edit")."</a>";
					$action.="<a href=\"javascript:;\" data-id=\"$id\" class=\"location_delete\" >".t("Delete")."</a>";
					$action.="</div>";
					
					$rate_id=$val['rate_id'];
					
					$html.="<tr data-rateid=\"$rate_id\">";
					$html.="<td>".$val['country_name'].$action."</td>";
					$html.="<td>".$val['state_name']."</td>";
					$html.="<td>".$val['city_name']."</td>";
					$html.="<td>".$val['area_name']."</td>";
					$html.="<td>".$val['postal_code']."</td>";
					$html.="<td>".FunctionsV3::prettyPrice($val['fee'])."</td>";
					$html.="</tr>";
				}
				$this->code=1; $this->msg="OK";
				$this->details=$html;
			} else $this->msg=t("No results");
		} else $this->msg=t("Session Expired");
		$this->jsonResponse();
	}
	
	public function actionDeleteLocationRates()
	{	
		$DbExt=new DbExt;
		$stmt="DELETE FROM
		{{location_rate}}
		WHERE
		rate_id=".FunctionsV3::q($this->data['rate_id'])."
		";
		$DbExt->qry($stmt);
		$this->code=1; $this->msg=t("Successful");
		$this->jsonResponse();
	}
	
	public function actionSortTableRates()
	{
		if (isset($this->data['ids'])){
			$DbExt=new DbExt;
			$id=explode(",",$this->data['ids']);
			foreach ($id as $sequence=>$rate_id) {
				if(!empty($rate_id)){
				   $sequence=$sequence+1;				   
				   $DbExt->updateData("{{location_rate}}",array(
				     'sequence'=>$sequence,
				     'date_modified'=>FunctionsV3::dateNow(),
				     'ip_address'=>$_SERVER['REMOTE_ADDR']
				   ),'rate_id', $rate_id);
				}
				$this->msg="OK";
				$this->code=1;
			}
		} else $this->msg=t("Missing ID");
		$this->jsonResponse();
	}
	
} /*end class*/