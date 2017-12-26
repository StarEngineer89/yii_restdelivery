<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blogCapchaModuleFrontController extends ModuleFrontController
{
    public function init()
	{
		$this->create_image();
        die;
	}
    public function create_image()
    {         
        $md5_hash = md5(rand(0,999)); 
        $security_code = Tools::substr($md5_hash, 15, 5); 
        $context = Context::getContext();
        $context->cookie->security_capcha_code = $security_code;
        $context->cookie->write();
        $width = 100;  
        $height = 30;  
        $image = ImageCreate($width, $height);  
        $white = ImageColorAllocate($image, 255, 255, 255); 
        $black = ImageColorAllocate($image, 0, 0, 0); 
        $noise_color = imagecolorallocate($image, 100, 120, 180);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 20, 40, 100);
        ImageFill($image,0, 0, $background_color); 
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
        }
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
        }
        ImageString($image, 5, 30, 6, $security_code, $black); 
        header("Content-Type: image/jpeg"); 
        ImageJpeg($image); 
        ImageDestroy($image); 
        exit();
    }
}