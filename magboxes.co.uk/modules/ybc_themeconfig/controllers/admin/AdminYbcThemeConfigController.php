<?php
    /**
     * Copyright YourBestCode.com
     * Email: support@yourbestcode.com
     * First created: 21/12/2015
     * Last updated: NOT YET
    */
    
    if (!defined('_PS_VERSION_'))
    	exit;
    class AdminYbcThemeConfigController extends ModuleAdminController
    {
       public function __construct()
	   {
	       $context = Context::getContext();
	       $link = $context->link->getAdminLink('AdminModules').'&configure=ybc_themeconfig&module_name=ybc_themeconfig';
	       Tools::redirectAdmin($link);
           exit();
       }
    }
