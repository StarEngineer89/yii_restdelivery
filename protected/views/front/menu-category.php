<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>
<?php if(is_array($menu) && count($menu)>=1):?>
<div class="category">
<?php foreach ($menu as $val):?>
 <a href="javascript:;" class="category-child relative goto-category" data-id="cat-<?php echo $val['category_id']?>" >
  <?php echo qTranslate($val['category_name'],'category_name',$val)?>
  <span>(<?php echo is_array($val['item'])?count($val['item']):'0';?>)</span>
  <i class="ion-ios-arrow-right"></i>
 </a>
<?php endforeach;?>
</div>
<?php endif;?>

<script>


// $(document).ready(function(){

// 	//fire once once document is ready
// 	responsiveDiv();
	
// 	//fire every time window is resized
// 	$(window).resize(function(){
// 		responsiveDiv();
// 	});

// });

/*-----THE RESPONSIVE DIV FUNCTION-----*/

// function responsiveDiv(){
	
// 	//if the window width is less than 1024px
// 	if($(window).width() < 1024){
	
// 		//fade out the div
// 		$(".items-row").hide();
	
// 	//else the window is wider than 1024px
// 	}else{
		
// 		//fade in the div
// 		$(".items-row").show();
		
// 	}
	
       
// }

   
</script>
