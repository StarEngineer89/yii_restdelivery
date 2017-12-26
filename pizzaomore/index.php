<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"><!--<![endif]-->
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Pizza omore</title>

    <meta name="author" content="themesflat.com">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css" >

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">

    <!-- Responsive -->
    <link rel="stylesheet" type="text/css" href="stylesheets/responsive.css">

    <!-- Colors -->
    <link rel="stylesheet" type="text/css" href="stylesheets/colors/color1.css" id="colors">
	
	<!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="stylesheets/animate.css">

    <!-- Favicon and touch icons  -->
    <link href="icon/apple-touch-icon-48-precomposed.png" rel="apple-touch-icon-precomposed" sizes="48x48">
    <link href="icon/apple-touch-icon-32-precomposed.png" rel="apple-touch-icon-precomposed">
    <link href="icon/favicon.png" rel="shortcut icon">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type='text/javascript' src='loadImg.js'></script>


    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>                                 
<body class="header-sticky page-loading">   
    <div class="loading-overlay">
    </div>
    
    <!-- Boxed -->
    <div class="boxed">
        
        <!-- Header -->            
        <header class="header header-v3 clearfix" id="header"> 
            <div class="header-wrap clearfix">
                <div class="container">
                    <div class="row">
                        <div class="flat-wrapper">
                            <div class="flat-logo">
                                <div id="logo" class="logo">
                                    <a href="index.php">
 <?php
$DB_host = "localhost";
$DB_user = "yummytak_yumm001";
$DB_pass = "yummytak_yumm001";
$DB_name = "yummytak_yumm001";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}



 $query = "SELECT * FROM mt_merchant WHERE merchant_id= 2";
 $stmt = $DB_con->prepare( $query );
 $stmt->execute();
 $row=$stmt->fetch(PDO::FETCH_ASSOC);
 extract($row);

 ?>        
         <script>
    jQuery(document).ready(function(){
    if (jQuery(window).width() < 900) {
        jQuery("#mobile").show();
        jQuery("#desktop").hide();
    } 
    
    else
    {
    jQuery("#desktop").show();
     jQuery("#mobile").hide();
    
    }
     
});

            
        
        
</script>
                             <img src="../upload/<?php echo $row['logo'];?>" alt="images" style="width:100px; height:76px;margin-top:-35px;margin-bottom:-20px" id="desktop">
                            <img src="../upload/<?php echo $row['logo'];?>"  style="margin-left:100%;
        width:100px;height:76px;margin-top:-35px;margin-bottom:-20px" id="mobile">
                                    </a>
                                </div><!-- /.logo -->
                                <!--<div class="btn-menu">
                                    <span></span>
                                </div>--><!-- //mobile menu button -->
                            </div><!-- /.flat-logo -->
                            

                            <div class="flat-header-information">
                                <div class="header-information">
                                    <div class="informaiton-text">
                                        <div class="info-icon">
                                           <!-- <i class="fa fa-zip"></i>-->
                                            <?php //echo $row['post_code']; ?>
                                          <div class="content"><strong>  <a href="http://www.yummytakeaways.co.uk/menu-pizzaomore" class="btn btn-block btn-danger">Order Online</a></strong><br>
                                               <!-- <span>Free Call</span>-->
                                               </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="header-information">
                                    <div class="informaiton-text">
                                        <div class="info-icon">
                                            <i class="fa fa-map-marker"></i>
                                            <div class="content"><strong> <?php echo $row['street'].','.$row['city']; ?>  </strong><br>
                                               <span> <?php echo $row['post_code']; ?></span>
                                            </div>
                                        </div></div>
                                    </div>      
                                </div>
                            </div><!-- /.flat-header-infomation -->
                        </div><!-- /.flat-wrapper -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.header-wrap -->
        </header>
       
                                                               
                                                           

                                                        
                                           

        <!-- Slider -->
        <div class="tp-banner-container">
            <div class="tp-banner" >
                <ul>
                    <li data-transition="random-static" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                        <img src="images/slides/1.jpg" alt="slider-image" />
                        <div class="tp-caption sfl title-slide center" data-x="40" data-y="111" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">                            
                          15% Discount <br>on All Orders.
                        </div>  
                        <div class="tp-caption sfr desc-slide center" data-x="40" data-y="272" data-speed="1000" data-start="1500" data-easing="Power3.easeInOut">                       
                           
                        </div>    
                        <div class="tp-caption sfl flat-button-slider" data-x="40" data-y="323" data-speed="1000" data-start="2000" data-easing="Power3.easeInOut"><a href="http://www.yummytakeaways.co.uk/menu-pizzaomore" target="_blank">Order Online</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></div>                    
                    </li>

                    <li data-transition="random-static" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                        <img src="images/slides/2.jpg" alt="slider-image" />
                        <div class="tp-caption sfl title-slide center" data-x="40" data-y="111" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">                            
                            15% Discount <br>on All Orders.
                        </div>  
                        <div class="tp-caption sfr desc-slide center" data-x="40" data-y="272" data-speed="1000" data-start="1500" data-easing="Power3.easeInOut">                       
                           
                        </div>    
                       <!--<div class="tp-caption sfl flat-button-slider bg-button-slider-15416e" data-x="40" data-y="323" data-speed="1000" data-start="2000" data-easing="Power3.easeInOut"><a href="http://www.yummytakeaways.co.uk/menu-pizzaomore">Order Online</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></div>-->

                        <div class="tp-caption sfl flat-button-slider" data-x="40" data-y="323" data-speed="1000" data-start="2000" data-easing="Power3.easeInOut"><a href="http://www.yummytakeaways.co.uk/menu-pizzaomore" target="_blank">Order   Online</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></div> 

                    </li>

                    <li data-transition="slidedown" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                        <img src="images/slides/3.jpg" alt="slider-image" />
                        <div class="tp-caption sfl title-slide center" data-x="40" data-y="111" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">                            
                            15% Discount <br>on All Orders.
                        </div>  
                        <div class="tp-caption sfr desc-slide center" data-x="40" data-y="272" data-speed="1000" data-start="1500" data-easing="Power3.easeInOut">                       
                           
                        </div>    
                        <div class="tp-caption sfl flat-button-slider" data-x="40" data-y="323" data-speed="1000" data-start="2000" data-easing="Power3.easeInOut"><a href="http://www.yummytakeaways.co.uk/menu-pizzaomore" target="_blank">Order   Online</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></div> 
                    </li>
                </ul>
            </div>
        </div>

        <!--<div class="flat-row pad-top40px pad-bottom40px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="no-margin-top no-margin-bottom f-size16px">15% Discount on All Orders. <a class="link" href="http://www.yummytakeaways.co.uk/menu-pizzaomore" target="_blank">Order Online</a></h3>
                    </div>
                </div>
            </div>
        </div>-->

       

               

      
       
        <!-- Footer -->
        <footer class="footer">
            <div class="content-bottom-widgets" style="background-color: #F0F0F0;color:#000">        
                <div class="container">
                    <div class="row"> 
                        <div class="flat-wrapper">
                            <div class="ft-wrapper">
                                <div class="footer-70">
                                    <div class="widget widget_text">            
                                        <div class="textwidget">
                                            <div class="custom-info">
                                                <span>Have any questions?</span>
                                                <span><i class="fa fa-reply" style="color:#812212"></i>sales@yummytakeaways.co.uk</span> 
                                                <span><i class="fa fa-map-marker" style="color:#812212"></i><?php echo $row['street'].','.$row['city']; ?></span> 
                                                <!--<span><i class="fa fa-phone" style="color:#812212"></i><?php //echo $row['restaurant_phone'];?></span>-->                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.col-md-10 -->

                                <div class="footer-30">
                                    <div class="widget widget_text">            
                                        <div class="textwidget">
                                           <a href="http://www.yummytakeaways.co.uk"> <div class="logo-ft"> <img src="images/1497632763-logo.png" alt="images"></div></a>
                                        </div>
                                    </div>
                                </div><!-- /.col-md-2 -->
                            </div><!-- /.ft-wrapper -->
                        </div><!-- /.flat-wrapper -->
                    </div><!-- /.row -->    
                </div><!-- /.container -->
            </div><!-- /.footer-widgets -->

            <div class="footer-widgets">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="widget widget_text">            
                                <div class="textwidget" style="color:#fff;">
                                    <p>If you suffer from a food allergy or intolerance, please let your server know upon placing your order</p>
                                                                    </div>
                            </div>
                        </div><!-- /.col-md-4 -->

                        <div class="col-md-4">
                           <div class="col-md-12">
                          
                            <div class="social-links" style="margin-left:20px;padding-bottom:5px">
                                <a href="#" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#" target="_blank">
                                    <i class="fa fa-facebook-official"></i>
                                </a>
                                <a href="#" target="_blank">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div><!-- /.col-md-12 -->
                         </div><!-- /.col-md-4 -->

                        <div class="col-md-4">
                            <div class="widget widget_mc4wp_form_widget">
                               <img src="images/s.jpg" class="image-responsive">
                            </div>
                        </div><!-- /.col-md-4 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.footer-content -->

            <div class="footer-content" style="margin-top:-50px">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="copyright">
                                <div class="copyright-content">
                                    Copyright © 2017 Pizza-Omore. Powered by <a href="http://www.yummytakeaways.co.uk">Yummy Takeaways</a>
                                </div>
                            </div>
                        </div><!-- /.col-md-12 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.footer-content -->
        </footer>

        <!-- Go Top -->
        <a class="go-top">
            <i class="fa fa-chevron-up"></i>
        </a>   

    </div>
    
    <!-- Javascript -->
    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.easing.js"></script> 
    <script type="text/javascript" src="javascript/owl.carousel.js"></script> 
    <script type="text/javascript" src="javascript/jquery-waypoints.js"></script>
    <script type="text/javascript" src="javascript/jquery.fancybox.js"></script>
    <script type="text/javascript" src="javascript/jquery.cookie.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="javascript/gmap3.min.js"></script>
    <script type="text/javascript" src="javascript/parallax.js"></script>
    <!--<script type="text/javascript" src="javascript/switcher.js"></script>-->
    <script type="text/javascript" src="javascript/smoothscroll.js"></script>
    <script type="text/javascript" src="javascript/main.js"></script>

    <!-- Revolution Slider -->
    <script type="text/javascript" src="javascript/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="javascript/slider.js"></script>
	
	<script>
$(function(){
        $('img').imgPreload()
    })
</script>
</body>
</html>