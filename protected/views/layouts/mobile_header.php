<div id="mobile-header" class="container">
<div class="row">
 <div class="col-xs-1 center">
    <a class="back-mobile" href="<?php echo Yii::app()->createUrl('/menu-'.((!isset($_GET['iframe']))?$slug:$slug.'?iframe=true'))?>">
    <i class="ion-ios-arrow-back"></i>
    </a>
 </div>
 <div class="col-xs-10 ">
    <h1 class="center"><?php echo isset($title)?$title:''?></h1>
 </div>
</div> <!--row-->
</div> <!--container-->