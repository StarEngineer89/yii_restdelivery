<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('ybc_themeconfig.php');
$newConfigVal = trim(Tools::getValue('newConfigVal'));
$configName = trim(Tools::getValue('configName'));
$tc = new Ybc_themeconfig();
$json = array();
/**
 * Reset 
 */
if(Tools::getValue('tcreset'))
{
    $tc->resetConfigDemo();
    $json['success'] = true;
    die(Tools::jsonEncode($json));
}

$config = $tc->getThemeConfigDemo();
$configName = Tools::strtoupper($configName);
if(is_array($config) && isset($config[$configName]))
    $oldConfigVal = $config[$configName];
else
    $oldConfigVal = '';
$configs = $tc->configs;
switch($configName)
{
    case 'YBC_TC_LAYOUT':
        if(!$tc->validateOption($configs['YBC_TC_LAYOUT']['options']['query'], $newConfigVal))
            $json['error'] = $tc->l('Layout is invalid');
        else
        {
            $json['oldClass'] = 'ybc-layout-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-layout-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
            $json['reload'] = true;
            $json['noReplace'] = true;
            Hook::exec('ybcLayoutUpdate',array('layout'=>$newConfigVal));
        }
        break;
    case 'YBC_TC_SKIN':
        if(!$tc->validateOption($configs['YBC_TC_SKIN']['options']['query'], $newConfigVal))
            $json['error'] = $tc->l('Skin is invalid');
        else
        {
            $json['oldClass'] = 'ybc-skin-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-skin-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;    
    case 'YBC_TC_FLOAT_HEADER':
        $json['oldClass'] = 'ybc-float_header-'.((int)$oldConfigVal ? 'yes' : 'no');
        $json['newClass'] = 'ybc-float_header-'.((int)$newConfigVal ? 'yes' : 'no');
        $json['success'] =  true;
        $json['reload'] = true;
        break;    
    case 'YBC_TC_BG_IMG':
        if(!in_array($newConfigVal,$tc->bgs))
            $json['error'] = $tc->l('Background is invalid');
        elseif(Tools::strtolower($tc->getThemeConfig('YBC_TC_LAYOUT')) != 'boxed')
            $json['error'] = $tc->l('Background image is only available for BOXED layout');
        else
        {
            $json['oldClass'] = 'ybc-bg-img-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-bg-img-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    default:
        $json['error'] = $tc->l('Configuration is invalid');
        break;
}
if(isset($json['success']) && $json['success'])
    $tc->updateThemeConfigDemo($configName, $newConfigVal);
//Change logo
if($configName == 'YBC_TC_SKIN' && ($logo = $tc->getSkinConfiguredField('logo')) && $tc->devMode)
{
    $json['logo'] = $tc->modulePath.'images/logo/'.$logo;
}
die(Tools::jsonEncode($json));