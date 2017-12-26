<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<head>

<!-- IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>
    Yummy Takeaways  | Online Ordering & Takeaways
    
    <?php //echo CHtml::encode($this->pageTitle); ?>




</title>
    <style>
        html{
            position: relative;
        }
        .iframe-body{
            height: auto !important;
            padding-top:40px;
        }
        .footer_button_cart{
            display: none;
        }
        .iframe-body .order-progress-bar{margin-top: -40px;}
        @media only screen and (max-width: 750px){
            .order-progress-bar{
                background: #fff;
                border-bottom-color: #ccc;
            }
            .iframe-body #noty_topCenter_layout_container{
                position: fixed;
                top: auto;
            }
            .menu_section .footer_button_cart{
                display: block;
            }
            .has-footer_cart-button .section-footer{
                padding-bottom: 57px;
            }
            .has-footer_cart-button .delivery-option.inner{
                padding-bottom: 57px;
            }
            #tawkchat-container{
                bottom: 57px!important;
            }
        }
        @media only screen and (max-width: 1024px){
            .iframe-body{
                padding-top:65px;
            }
            .iframe-body .order-progress-bar{margin-top: -65px;}
        }
    </style>
<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico?ver=1.1" />
<?php
/*add the analytic codes */
Widgets::analyticsCode();
?>
    <script>
        var is_iframe = <?php echo (!isset($_GET['iframe'])?'false':'true')?>;
    </script>
</head>
<body<?php if(isset($_GET['iframe'])){echo ' class="iframe-body"';}?> ">