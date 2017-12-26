    <style type="text/css">
	input:-ms-input-placeholder {
	   color:#000;
	  
	 
	   text-align:center;
	}
	
	input::-webkit-input-placeholder {
	   color:#000;
	   
	 
	   text-align:center;
	}
	
	input:-moz-placeholder {
	   color:#000;
	   
	  
	   text-align:center;
	}
	
	/* firefox 19+ */
	input::-moz-placeholder {
	   color:#000;
	  
	  
	   text-align:center;
	}
    </style>
<div class="search-wraps single-search">

  <h1><?php echo t($home_search_text);?></h1>
  <p><?php echo t($home_search_subtext);?></p>
    
  <form method="GET" class="forms-search" id="forms-search" action="<?php echo Yii::app()->createUrl('store/searcharea')?>">
  <div class="search-input-wraps rounded30" style="border-radius:3px;margin-top:60px">
     <div class="row">
        <div class=" border col-sm-11 col-xs-12">
        <?php echo CHtml::textField('s',$kr_search_adrress,array(
         'placeholder'=>$placholder_search,
         'required'=>true
         
        ))?>        
        </div>        
        
        <div class=" relative border col-sm-1 col-xs-2 Btndsk">
          <button type="submit" class="btn btn-primary btn-block" style="background-color:#ED1E79;margin-top:-6px;min-width:85px;padding:10px;font-size:14px;margin-right:-12px;">Search</button>         
        </div>
     </div>
  
  </div> <!--search-input-wrap-->
  <div class="row col-sm-12" style="margin-left:30%;margin-right:30%">
      <div class="col col-sm-3"></div>
  <div class="col col-sm-3">
  <div class=" Btnsearchres">
         <button type="submit" align="center" class="btn btn-danger" style="padding:8px;background-color:#ED1E79;margin-top:2px;margin-bottom:;min-width:70px;font-size:12px;font-style:bold">
        <i class="fa fa-search  fa-lg"> Search</i></button>  </div>        
        <div class="col col-sm-3"></div>
        </div></div>
  
  </form>
  
</div> <!--search-wrapper-->