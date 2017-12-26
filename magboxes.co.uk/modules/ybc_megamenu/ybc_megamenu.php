<?php
/**
 * Copyright prestashopaddon.com
 * Email: contact@prestashopaddon.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
/**
 * Includes 
 */   

include_once(_PS_MODULE_DIR_.'ybc_megamenu/classes/ybc_megamenu_class.php');
include_once(_PS_MODULE_DIR_.'ybc_megamenu/classes/ybc_megamenu_column_class.php');
include_once(_PS_MODULE_DIR_.'ybc_megamenu/classes/ybc_megamenu_block_class.php');
include_once(_PS_MODULE_DIR_.'ybc_megamenu/classes/ybc_megamenu_cache_class.php');
class Ybc_megamenu extends Module
{
    private $_html;
    private $baseAdminPath;
    private $directionClass = 'ybc-dir-ltr';
    private $errorMessage = false;
    private $themeImport = true;
    private $menuFields = array(
        array(
            'name' => 'id_menu',
            'primary_key' => true
        ),
        array(
            'name' => 'menu_type'
        ),
        array(
            'name' => 'title',            
            'multi_lang' => true
        ),
        array(
            'name' => 'link'
        ), 
        array(
            'name' => 'id_cms'
        ), 
        array(
            'name' => 'id_manufacturer'
        ), 
        array(
            'name' => 'id_category'
        ), 
        array(
            'name' => 'column_type',
            'default' => 'FULL'            
        ), 
        array(
            'name' => 'color1',
            'default' => '#333333'            
        ),
        array(
            'name' => 'color2',
            'default' => '#777777'            
        ),
        array(
            'name' => 'color3',
            'default' => ''            
        ),
        array(
            'name' => 'color4',
            'default' => '#FF564B'            
        ),
        array(
            'name' => 'color5',
            'default' => '#DDDDDD'            
        ),
        array(
            'name' => 'color6',
            'default' => '#FFFFFF'            
        ), 
        array(
            'name' => 'wrapper_border',
            'default' => 1            
        ), 
        array(
            'name' => 'sub_type',
            'default' => 'title'           
        ), 
        array(
            'name' => 'color6',
            'default' => '#FFFFFF'            
        ), 
        array(
            'name' => 'image'            
        ),
        array(
            'name' => 'banner_position',
            'default' => 'bottom'            
        ),
        array(
            'name' => 'banner_link',         
        ),
        array(
            'name' => 'sub_menu_max_width',
            'default' => '100'            
        ),       
        array(
            'name' => 'custom_class'            
        ),
        array(
            'name' => 'enabled',
            'default' => 1
        ),
        array(
            'name' => 'icon'
        ),
        array(
            'name' => 'icon_image'
        ),
        array(
            'name' => 'show_icon',
            'default' => 1
        )
    );
    
    private $columnFields = array(
        array(
            'name' => 'id_column',
            'primary_key' => true
        ),
        array(
            'name' => 'title',            
            'multi_lang' => true
        ),
        array(
            'name' => 'column_link'            
        ),
        array(
            'name' => 'description',            
            'multi_lang' => true
        ),        
        array(
            'name' => 'custom_class'            
        ),
        array(
            'name' => 'column_size',
            'default' => '2_12'            
        ),        
        array(
            'name' => 'image'            
        ),
        array(
            'name' => 'enabled',
            'default' => 1
        ),
        array(
            'name' => 'id_menu',
            'default' => 0,
            'default_submit' => true
        ),
        array(
            'name' => 'show_title',
            'default' => 1
        ),
        array(
            'name' => 'show_description',
            'default' => 1
        ),
        array(
            'name' => 'show_image',
            'default' => 1
        )         
    );
    
    private $blockFields = array(
        array(
            'name' => 'id_block',
            'primary_key' => true
        ),
        array(
            'name' => 'title',            
            'multi_lang' => true
        ),
        array(
            'name' => 'description',            
            'multi_lang' => true
        ),        
        array(
            'name' => 'custom_class'            
        ),
        array(
            'name' => 'image'            
        ),
        array(
            'name' => 'block_link'            
        ),
        array(
            'name' => 'params'            
        ),
        array(
            'name' => 'enabled',
            'default' => 1
        ),
        array(
            'name' => 'id_column',
            'default' => 0,
            'default_submit' => true
        ),
        array(
            'name' => 'show_title',
            'default' => 1
        ),
        array(
            'name' => 'show_description',
            'default' => 1
        ),
        array(
            'name' => 'show_image',
            'default' => 1
        ),
        array(
            'name' => 'block_type',
            'default' => 'CATEGORY'
        ),
        array(
            'name' => 'html_block',            
            'multi_lang' => true
        ),          
    );
    
    public function __construct()
	{
		$this->name = 'ybc_megamenu';
		$this->tab = 'front_office_features';
		$this->version = '1.0.2';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Mega Menu');
		$this->description = $this->l('Powerful and easy-use mega menu system');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        if(Configuration::get('YBC_MM_DIR')=='auto')
            $this->directionClass = $this->context->language->is_rtl ? 'ybc-dir-rtl' : 'ybc-dir-ltr';  
        else
            $this->directionClass = 'ybc-dir-'.(Configuration::get('YBC_MM_DIR') == 'rtl' ? 'rtl' : 'ltr');        
        if($this->context->controller->controller_type =='admin')
            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
	   
    }
    /**
	 * @see Module::install()
	 */
	public function install()
	{
	    Module::disableByName('blocktopmenu');
        return parent::install() 
        && $this->registerHook('displayBackOfficeHeader') 
        && $this->registerHook('displayTop') 
        && $this->registerHook('displayHeader')
        && $this->registerHook('custom')
        && $this->registerHook('displayYbcReviews')
        && $this->_installDb();
    }
    
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
        return parent::uninstall() && $this->_clearData() && $this->_uninstallDb();
    }
    
    /**
     * Module backend html 
     */
    public function getContent()
	{
	   $control = trim(Tools::getValue('control'));
       /**
        * Sort orders 
        */
       
       if($control == 'sortOrder')
       {            
            $menuOrders = Tools::getValue('menu');
            $columnOrders = Tools::getValue('colunn');
            $blockOrders = Tools::getValue('block');
            if($menuOrders && is_array($menuOrders))
            {
                foreach($menuOrders as $id_menu => $order)
                {
                    if($this->itemExists('menu','id_menu',(int)$id_menu))
                    {
                        $menu = new Ybc_megamenu_class((int)$id_menu);   
                        $menu->sort_order = abs((int)$order);
                        $menu->update();
                    }                    
                }
            }
            if($columnOrders && is_array($columnOrders))
            {                
                foreach($columnOrders as $id_column => $order)
                {
                    if($this->itemExists('column','id_column',(int)$id_column))
                    {
                        $column = new Ybc_megamenu_column_class((int)$id_column);   
                        $column->sort_order = abs((int)$order);
                        $column->update();                        
                    }                    
                }
            }
            if($blockOrders)
            {
                foreach($blockOrders as $id_block => $order)
                {
                    if($this->itemExists('block','id_block',(int)$id_block))
                    {
                        $block = new Ybc_megamenu_block_class((int)$id_block);   
                        $block->sort_order = abs((int)$order);
                        $block->update();
                    }                    
                }
            }
            $this->_refeshMenuCache();
            die(Tools::jsonEncode(array('saved'=>true)));
       }
       if(!$control)
       {
            $this->_postConfig();            
       } 
       if($control=='menu')
       {
            $this->_postMenu();   
       }
       elseif($control=='column')
       {
            $this->_postColumn(); 
       }      
       elseif($control=='block')
       {
            $this->_postBlock(); 
       }
       if($this->errorMessage)
            $this->_html .= $this->errorMessage;  
       $this->context->controller->addJqueryUI('ui.sortable');      
       //$this->_html .= '<script type="text/javascript" src="'.$this->_path.'js/jquery.sort.js"></script>';
       $this->_html .= '<script type="text/javascript"> var ybc_mm_menu_url = \''.$this->baseAdminPath.'&control=sortOrder\'; var ybc_mm_ajax_url = \''.$this->_path.'ajax.php\';</script>';
       $this->_html .= '<script type="text/javascript" src="'.$this->_path.'js/admin.js"></script>';
       
	   $this->_html .= '<div class="bootstrap">';	   
        
        $this->renderList();
        $this->_html .= '<div style="float: left;width: 70%;" class="ybc-right-panel">';
        if(!$control)
        {
            $this->renderConfigForm();   
        }
        if($control=='menu')
        {
            $this->renderMenuForm();   
        }
        elseif($control=='column')
        {
            $this->renderColumnForm();   
        } 
        elseif($control=='block')
        {
            $this->renderBlockForm();   
        }       
        
        $this->_html .= '</div>';
        $this->_html .= '<div class="clearfix"></div>';
        $this->_html .= '</div><div class="clearfix"></div>';    
        return $this->_html;
    }
    
    private function _deleteBlock($id_block)
    {        
        if($this->itemExists('block','id_block',$id_block))
        {
            $block = new Ybc_megamenu_block_class($id_block);       
            if($block->image && file_exists(dirname(__FILE__).'/images/block/'.$block->image))
            {
                @unlink(dirname(__FILE__).'/images/block/'.$block->image);
            }
            return $block->delete();
        }
        return false;        
    }
    private function _deleteColumn($id_column)
    {
        if($this->itemExists('column','id_column',$id_column))
        {
            $column = new Ybc_megamenu_column_class($id_column);
            if($column->image && file_exists(dirname(__FILE__).'/images/column/'.$column->image))
            {
                @unlink(dirname(__FILE__).'/images/column/'.$column->image);
            }
            $blocks = $this->getBlockByIdColumn($id_column);            
            if($blocks)
            {
                foreach($blocks as $block)
                {
                    $this->_deleteBlock((int)$block['id_block']);
                }
            }
            return $column->delete();
        }
        return false;        
    }
    private function _deleteMenu($id_menu)
    {
        if($this->itemExists('menu','id_menu',$id_menu))
        {
            $menu = new Ybc_megamenu_class($id_menu); 
            if($menu->image && file_exists(dirname(__FILE__).'/images/menu/'.$menu->image))
            {
                @unlink(dirname(__FILE__).'/images/menu/'.$menu->image);
            }
            if($menu->icon_image && file_exists(dirname(__FILE__).'/images/menu/'.$menu->icon_image))
            {
                @unlink(dirname(__FILE__).'/images/menu/'.$menu->icon_image);
            }           
            $columns = $this->getColumnByIdMenu($id_menu);
            if($columns)
            {
                foreach($columns as $column)
                {
                    $this->_deleteColumn((int)$column['id_column']);
                }
            }
            return $menu->delete();
        }
        return false;        
    }
    
    /**
     * Add new menu form 
     */
    private function _postMenu()
    {
        $errors = array();
        $id_menu = (int)Tools::getValue('id_menu');
        /**
         * Delete banner 
         * */
         if($id_menu && $this->itemExists('menu','id_menu',$id_menu) && Tools::isSubmit('delimage'))
         {
            $menu = new Ybc_megamenu_class($id_menu);
            $imageUrl = dirname(__FILE__).'/images/menu/'.$menu->image; 
            if(file_exists($imageUrl))
            {
                @unlink($imageUrl);
                $menu->image = '';
                $menu->update();
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_menu='.$id_menu.($id_menu ? '&id_menu='.$id_menu : '').'&control=menu');
            }
            else
                $errors[] = $this->l('Image does not exist');   
         }
         
        /**
         * Delete icon 
         */
         
         if($id_menu && $this->itemExists('menu','id_menu',$id_menu) && Tools::isSubmit('delico'))
         {
            $menu = new Ybc_megamenu_class($id_menu);
            $icoUrl = dirname(__FILE__).'/images/icon/'.$menu->icon; 
            if(file_exists($icoUrl))
            {
                @unlink($icoUrl);
                $menu->icon = '';
                $menu->update();
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_menu='.$id_menu);
            }
            else
                $errors[] = $this->l('Image does not exist');   
         }
        /**
         * Delete menu 
         */ 
         if(Tools::isSubmit('delmenu'))
         {
            $id_menu = (int)Tools::getValue('id_menu');
            if(!$this->itemExists('menu','id_menu',$id_menu))
                $errors[] = $this->l('Menu does not exist');
            elseif($this->_deleteMenu($id_menu))
            {
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }                
            else
                $errors[] = $this->l('Could not delete the menu. Please try again');    
         }
                  
        /**
         * Save menu 
         */
        if(Tools::isSubmit('saveMenu'))
        {            
            if($id_menu && $this->itemExists('menu','id_menu',$id_menu))
            {
                $menu = new Ybc_megamenu_class($id_menu);                
            }
            else
            {
                $menu = new Ybc_megamenu_class();
                $menu->sort_order = (int)$this->getMaxOrder('menu') + 1;
            }
            $menu->menu_type = trim(Tools::getValue('menu_type',''));   
            $menu->link = trim(Tools::getValue('link',''));            
            $menu->id_category = trim(Tools::getValue('id_parent',0));
            $menu->id_cms = trim(Tools::getValue('id_cms',0));
            $menu->id_manufacturer = trim(Tools::getValue('id_manufacturer',0));
            $menu->custom_class = trim(Tools::getValue('custom_class',''));
            $menu->icon = trim(Tools::getValue('icon',''));
            $menu->column_type = trim(Tools::getValue('column_type',''));   
            $menu->sub_menu_max_width = trim(Tools::getValue('sub_menu_max_width',''));                 
            $menu->enabled = trim(Tools::getValue('enabled',1));                       
            $menu->show_icon = trim(Tools::getValue('show_icon',1));   
            $menu->color1 = trim(Tools::getValue('color1','#333333'));
            $menu->color2 = trim(Tools::getValue('color2','#777777'));
            $menu->color3 = trim(Tools::getValue('color3',''));
            $menu->color4 = trim(Tools::getValue('color4','#FF564B'));
            $menu->color5 = trim(Tools::getValue('color5','#DDDDDD'));
            $menu->color6 = trim(Tools::getValue('color6','#FFFFFF'));
            for($ik = 1; $ik<=6; $ik++)
            {
                if(Tools::getValue('color'.$ik) && !Validate::isColor(Tools::getValue('color'.$ik)))
                {
                    $errors[] = $this->l('One of color code is not valid');
                    break;
                }
            }
            $menu->wrapper_border = (int)Tools::getValue('wrapper_border') ? 1 : 0;
            $menu->sub_type = in_array(trim(Tools::getValue('sub_type')), array('title','list','title_list','no_title_list')) ? trim(Tools::getValue('sub_type')) : 'title';
            $menu->banner_position = in_array(Tools::getValue('banner_position'), array('bottom','top')) ? Tools::getValue('banner_position') : 'bottom';
            $menu->banner_link = trim(Tools::getValue('banner_link'));
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
			{			
				$menu->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) != '' ? trim(Tools::getValue('title_'.$language['id_lang'])) :  trim(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT')));
			}            
            if(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT'))=='')
                $errors[] = $this->l('You need to set menu title');
            
            if(!in_array($menu->menu_type,array('CUSTOM','CMS','CONTACT','CATEGORY','MNFT','HOME')))
                $errors[] = $this->l('Menu type is not valid');
            if($menu->icon!='' && !preg_match('/^fa-(.)+$/', $menu->icon))
                $errors[] = $this->l('Awesome icon is not vaild');
            switch($menu->menu_type)
            {
                case 'CUSTOM':
                        break;
                case 'CMS':
                    if(!$menu->id_cms)
                        $errors[] = $this->l('You need to choose link');
                        break;
                case 'CATEGORY':
                    if(!$menu->id_category)
                        $errors[] = $this->l('You need to choose a category');
                    break;
                case 'MNFT':
                    if(!$menu->id_manufacturer)
                        $errors[] = $this->l('You need to choose a manufacturer');
                    break;
                default:
                    break;
            }
            if(!in_array($menu->column_type,array('LEFT','RIGHT','FULL')))
                $errors[] = $this->l('Columns type is not valid');            			
            //ets-sang
            //if(!$menu->sub_menu_max_width)
//                $errors[] = $this->l('You need to set submenu max-width');
//            elseif(!Validate::isInt($menu->sub_menu_max_width))
//                $errors[] = $this->l('Submenu max-width is not valid');
//            elseif((int)$menu->sub_menu_max_width < 25 || (int)$menu->sub_menu_max_width > 100)
//                $errors[] = $this->l('Submenu max-width need to be between 25 and 100');
            
            /**
             * Upload icon 
             */  
                
            if(isset($_FILES['image']['tmp_name']) && isset($_FILES['image']['name']) && $_FILES['image']['name'])
            {
                if(file_exists(dirname(__FILE__).'/images/menu/'.$_FILES['image']['name']))
                {
                    $_FILES['image']['name'] = sha1(microtime()).'-'.$_FILES['image']['name'];
                }
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
    			$imagesize = @getimagesize($_FILES['image']['tmp_name']);
    			if (isset($_FILES['image']) &&				
    				!empty($_FILES['image']['tmp_name']) &&
    				!empty($imagesize) &&
    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
    			)
    			{
    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
    				if ($error = ImageManager::validateUpload($_FILES['image']))
    					$errors[] = $error;
    				elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name))
    					$errors[] = $this->l('Can not upload the image');
    				elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/menu/'.$_FILES['image']['name'], null, null, $type))
    					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
    				if (isset($temp_name))
    					@unlink($temp_name);
                    $menu->image = $_FILES['image']['name'];			
    			}
            }
            
            
            
            
            if(isset($_FILES['icon_image']['tmp_name']) && isset($_FILES['icon_image']['name']) && $_FILES['icon_image']['name'])
            {
                if(file_exists(dirname(__FILE__).'/images/menu/'.$_FILES['icon_image']['name']))
                {
                    $_FILES['icon_image']['name'] = sha1(microtime()).'-'.$_FILES['icon_image']['name'];
                }
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['icon_image']['name'], '.'), 1));
    			$icon_imagesize = @getimagesize($_FILES['icon_image']['tmp_name']);
    			if (isset($_FILES['icon_image']) &&				
    				!empty($_FILES['icon_image']['tmp_name']) &&
    				!empty($icon_imagesize) &&
    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
    			)
    			{
    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
    				if ($error = ImageManager::validateUpload($_FILES['icon_image']))
    					$errors[] = $error;
    				elseif (!$temp_name || !move_uploaded_file($_FILES['icon_image']['tmp_name'], $temp_name))
    					$errors[] = $this->l('Can not upload the icon image');
    				elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/menu/'.$_FILES['icon_image']['name'], null, null, $type))
    					$errors[] = $this->displayError($this->l('An error occurred during the icon image upload process.'));
    				if (isset($temp_name))
    					@unlink($temp_name);
                    $menu->icon_image = $_FILES['icon_image']['name'];			
    			}
            }
            
            /**
             * Save 
             */    
             
            if(!$errors)
            {
                if (!Tools::getValue('id_menu'))
    			{
    				if (!$menu->add())
    					$errors[] = $this->displayError($this->l('The menu could not be added.'));                    
    			}				
    			elseif (!$menu->update())
    					$errors[] = $this->displayError($this->l('The menu could not be updated.'));
                $this->_refeshMenuCache();
            }
         }
         if (count($errors))
         {
            $this->errorMessage = $this->displayError(implode('<br />', $errors));  
         }
         elseif (Tools::isSubmit('saveMenu') && Tools::isSubmit('id_menu'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_menu='.Tools::getValue('id_menu').'&control=menu');
		 elseif (Tools::isSubmit('saveMenu'))
         {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_menu='.$this->getMaxId('menu','id_menu').'&control=menu');
         }
    }
    private function _postConfig()
    {
        $errors = array();
        if(Tools::isSubmit('saveConfig'))
        {
            $cssFile = dirname(__FILE__).'/css/front_custom.css';
            $cacheDir = dirname(__FILE__).'/cache';
            $YBC_MM_TRANSITION_EFFECT = trim(Tools::getValue('YBC_MM_TRANSITION_EFFECT','FADE'));
            $YBC_MM_FIXED = (int)trim(Tools::getValue('YBC_MM_FIXED',1)) ?  1 : 0;
            $YBC_MM_FIXED_FULL = (int)trim(Tools::getValue('YBC_MM_FIXED_FULL',1)) ?  1 : 0;
            $YBC_MM_DIR = trim(Tools::getValue('YBC_MM_DIR','auto'));
            $YBC_MM_ARROW = (int)Tools::getValue('YBC_MM_ARROW',1) ?  1 : 0;
            $YBC_MM_CUSTOM_CLASS = trim(Tools::getValue('YBC_MM_CUSTOM_CLASS',''));
            $YBC_MM_CUSTOM_COLOR = trim(Tools::getValue('YBC_MM_CUSTOM_COLOR',''));
            $YBC_MM_CUSTOM_COLOR_HOVER = trim(Tools::getValue('YBC_MM_CUSTOM_COLOR_HOVER',''));
            $YBC_MM_CUSTOM_TEXT_COLOR = trim(Tools::getValue('YBC_MM_CUSTOM_TEXT_COLOR',''));
            $YBC_MM_CUSTOM_BORDER_COLOR = trim(Tools::getValue('YBC_MM_CUSTOM_BORDER_COLOR',''));
            $YBC_MM_CUSTOM_CSS = trim(Tools::getValue('YBC_MM_CUSTOM_CSS','')); 
            $YBC_MM_SKIN = trim(Tools::getValue('YBC_MM_SKIN','default'));
            $YBC_MM_TYPE = trim(Tools::getValue('YBC_MM_TYPE','default'));
            $YBC_MOBILE_MM_TYPE = trim(Tools::getValue('YBC_MOBILE_MM_TYPE','default'));
            $YBC_MM_USE_CACHE = (int)Tools::getValue('YBC_MM_USE_CACHE') == 0 ? 0 : 1;
            $YBC_MM_SHOW_IMAGE_ON_MOBILE = (int)Tools::getValue('YBC_MM_SHOW_IMAGE_ON_MOBILE') == 0 ? 0 : 1;
            if(!in_array($YBC_MM_TRANSITION_EFFECT,array('FADE','ZOOM','SLIDE','DROP_DOWN')))
            {
                $errors[] = $this->l('Transition effect is not valid');
            }            
            if($YBC_MM_USE_CACHE && (!file_exists($cacheDir) || !is_readable($cacheDir) || !is_writeable($cacheDir)))
            {
                $errors[] = $cacheDir.' '.$this->l('is not readable/writable');
            }
            if(!file_exists($cssFile) || !is_writable($cssFile))
            {
                $errors[] = $cssFile . ' '.$this->l('is not writable');
            }
            if(!$errors)
            {
                Configuration::updateValue('YBC_MM_TRANSITION_EFFECT',$YBC_MM_TRANSITION_EFFECT);    
                Configuration::updateValue('YBC_MM_CUSTOM_CLASS',$YBC_MM_CUSTOM_CLASS);
                Configuration::updateValue('YBC_MM_FIXED',$YBC_MM_FIXED);
                Configuration::updateValue('YBC_MM_FIXED_FULL',$YBC_MM_FIXED_FULL);
                Configuration::updateValue('YBC_MM_DIR',$YBC_MM_DIR);
                Configuration::updateValue('YBC_MM_ARROW',$YBC_MM_ARROW);
                 Configuration::updateValue('YBC_MM_CUSTOM_COLOR',$YBC_MM_CUSTOM_COLOR);
                 Configuration::updateValue('YBC_MM_CUSTOM_COLOR_HOVER',$YBC_MM_CUSTOM_COLOR_HOVER);
                 Configuration::updateValue('YBC_MM_CUSTOM_TEXT_COLOR',$YBC_MM_CUSTOM_TEXT_COLOR);
                 Configuration::updateValue('YBC_MM_CUSTOM_BORDER_COLOR',$YBC_MM_CUSTOM_BORDER_COLOR);
                Configuration::updateValue('YBC_MM_SKIN',$YBC_MM_SKIN);      
                Configuration::updateValue('YBC_MM_TYPE',$YBC_MM_TYPE);  
                Configuration::updateValue('YBC_MOBILE_MM_TYPE',$YBC_MOBILE_MM_TYPE);       
                Configuration::updateValue('YBC_MM_USE_CACHE',$YBC_MM_USE_CACHE);
                Configuration::updateValue('YBC_MM_SHOW_IMAGE_ON_MOBILE',$YBC_MM_SHOW_IMAGE_ON_MOBILE);
                if($YBC_MM_USE_CACHE)
                    $this->_refeshMenuCache();                       
                if(file_exists($cssFile) && is_writable($cssFile))
                    file_put_contents($cssFile,$YBC_MM_CUSTOM_CSS);
            }
            if (count($errors))
            {
               $this->errorMessage = $this->displayError(implode('<br />', $errors));  
            }
            else
               Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);            
        }
    }
    private function _postBlock()
    {
        $errors = array();
        $id_block = (int)Tools::getValue('id_block');
        $id_menu = (int)Tools::getValue('id_menu');
        $id_block = (int)Tools::getValue('id_block');
        /**
         * Delete icon 
         */
         
         if($id_block && $this->itemExists('block','id_block',$id_block) && Tools::isSubmit('delimage'))
         {
            $block = new Ybc_megamenu_block_class($id_block);
            $imageUrl = dirname(__FILE__).'/images/block/'.$block->image; 
            if(file_exists($imageUrl))
            {
                @unlink($imageUrl);
                $block->image = '';
                $block->update();
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.($id_menu ? '&id_menu='.$id_menu : '').($id_column ? '&id_column='.$id_column : '').'&control=block&id_block='.$id_block);
            }
            else
                $errors[] = $this->l('Image does not exist');   
         }
         
        /**
         * Delete block 
         */ 
         if(Tools::isSubmit('delblock'))
         {
            $id_block = (int)Tools::getValue('id_block');
            if(!$this->itemExists('block','id_block',$id_block))
                $errors[] = $this->l('Block does not exist');
            elseif($this->_deleteBlock($id_block))
            {
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }                
            else
                $errors[] = $this->l('Could not delete the block. Please try again');    
         }
        
        /**
         * Save block 
         */
        if(Tools::isSubmit('saveBlock'))
        {            
            if($id_block && $this->itemExists('block','id_block',$id_block))
            {
                $block = new Ybc_megamenu_block_class($id_block);                
            }
            else
            {
                $block = new Ybc_megamenu_block_class();
                $block->sort_order = (int)$this->getMaxOrder('block') + 1;
            }
            
            $block->custom_class = trim(Tools::getValue('custom_class',''));            
            $block->enabled = trim(Tools::getValue('enabled',1));  
            $block->id_column = trim(Tools::getValue('id_column',0));  
            $block->params = trim(Tools::getValue('params','test param'));  
            $block->show_image = trim(Tools::getValue('show_image',1));
            $block->show_title = trim(Tools::getValue('show_title',1));                     
            $block->show_description = trim(Tools::getValue('show_description',1));   
            $block->block_type = trim(Tools::getValue('block_type','')); 
            $block->block_link = trim(Tools::getValue('block_link',''));   
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
			{			
				$block->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) != '' ? trim(Tools::getValue('title_'.$language['id_lang'])) :  trim(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT')));
                $block->description[$language['id_lang']] = trim(Tools::getValue('description_'.$language['id_lang'])) != '' ? trim(Tools::getValue('description_'.$language['id_lang'])) :  trim(Tools::getValue('description_'.Configuration::get('PS_LANG_DEFAULT')));
                $block->html_block[$language['id_lang']] = trim(Tools::getValue('html_block_'.$language['id_lang'])) != '' ? trim(Tools::getValue('html_block_'.$language['id_lang'])) :  trim(Tools::getValue('html_block_'.Configuration::get('PS_LANG_DEFAULT')));
			}
            
            /**
             * Get posted params 
             */
            $params = array();
            $params['CATEGORY'] = array('categories_list_include_sub'=>trim(Tools::getValue('categories_list_include_sub',1)),'categories' => is_array(Tools::getValue('categories_list')) ? Tools::getValue('categories_list') : array());            
            $product_str = trim(trim(Tools::getValue('inputAccessories')),'-');
            $products = explode('-',$product_str);
            if($products)
            {
                foreach($products as $product)
                {
                    $product = (int)$product;
                }
            }            
            $params['PRODUCT'] = is_array($products) ? $products : array();
            $params['CMS'] = is_array(Tools::getValue('cms_pages')) ? Tools::getValue('cms_pages') : array();
            $params['MNFT'] = is_array(Tools::getValue('mnfts')) ? Tools::getValue('mnfts') : array();
            $params['CUSTOM'] = array('label'=>trim(Tools::getValue('custom_link_label')) ? trim(Tools::getValue('custom_link_label')) : '', 'link'=> trim(Tools::getValue('custom_link')) ? trim(Tools::getValue('custom_link')) : '');
            //$params['HTML'] = trim(Tools::getValue('html_block')) ? trim(Tools::getValue('html_block')) : '';
            
            $block->params = @serialize($params);
            
            /**
             * Validate 
             */
            
            if(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT'))=='')
                $errors[] = $this->l('You need to set block title');
            if((int)Tools::getValue('id_column')<=0)
                $errors[] = $this->l('You need to choose a column');
            elseif(!$this->itemExists('column','id_column',(int)Tools::getValue('id_column')))
                $errors[] = $this->l('Column does not exist');
           
            if(!in_array($block->block_type,array(
                'CATEGORY','PRODUCT','CMS','CONTACT','MNFT','HOME','CUSTOM','HTML'
            )))
                $errors[] = $this->l('Block type is not valid');
            if($product_str && !preg_match('/^[0-9]+(-[0-9]+)*$/', $product_str))
                $errors[] = $this->l('Products field is not valid');
            if(!$block->params)
                $errors[] = $this->l('Can not serialize params');
            switch($block->block_type)
            {
                case 'CATEGORY': 
                    if(!$params['CATEGORY']['categories'])
                        $errors[] = $this->l('You need to choose at least 1 categorory');
                    break;
                case 'PRODUCT': 
                    if(!$product_str)
                        $errors[] = $this->l('You need to choose at least 1 product');
                    break;
                case 'CMS': 
                    if(!$params['CMS'])
                        $errors[] = $this->l('You need to choose at least 1 CMS page');
                    break;
                case 'MNFT': 
                    if(!$params['MNFT'])
                        $errors[] = $this->l('You need to choose at least 1 manufacturer');
                    break;
                case 'CUSTOM': 
                    if(!$params['CUSTOM']['label'] || !$params['CUSTOM']['link'])
                        $errors[] = $this->l('You need to set both link and label for the custom link');
                    break;
                case 'HTML': 
                    if(Tools::getValue('html_block_'.Configuration::get('PS_LANG_DEFAULT'))=='')
                        $errors[] = $this->l('You need to set HTML content');
                    break;
                default:
                    break;
            }
            
            
            /**
             * Upload icon 
             */  
                
            if(isset($_FILES['image']['tmp_name']) && isset($_FILES['image']['name']) && $_FILES['image']['name'])
            {
                if(file_exists(dirname(__FILE__).'/images/block/'.$_FILES['image']['name']))
                {
                    $_FILES['image']['name'] = sha1(microtime()).'-'.$_FILES['image']['name'];
                }
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
    			$imagesize = @getimagesize($_FILES['image']['tmp_name']);
    			if (isset($_FILES['image']) &&				
    				!empty($_FILES['image']['tmp_name']) &&
    				!empty($imagesize) &&
    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
    			)
    			{
    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
    				if ($error = ImageManager::validateUpload($_FILES['image']))
    					$errors[] = $error;
    				elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name))
    					$errors[] = $this->l('Can not upload the image');
    				elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/block/'.$_FILES['image']['name'], null, null, $type))
    					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
    				if (isset($temp_name))
    					@unlink($temp_name);
                    $block->image = $_FILES['image']['name'];			
    			}
            }			
            
            /**
             * Save 
             */    
             
            if(!$errors)
            {
                if (!Tools::getValue('id_block'))
    			{
    				if (!$block->add())
    					$errors[] = $this->displayError($this->l('The block could not be added.'));                    
    			}				
    			elseif (!$block->update())
    					$errors[] = $this->displayError($this->l('The block could not be updated.'));
                $this->_refeshMenuCache();
            }
         }
         if (count($errors))
         {
            $this->errorMessage = $this->displayError(implode('<br />', $errors));  
         }			     
         elseif (Tools::isSubmit('saveBlock') && Tools::isSubmit('id_block'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_block='.Tools::getValue('id_block').'&control=block');
		 elseif (Tools::isSubmit('saveBlock'))
         {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_block='.$this->getMaxId('block','id_block').'&control=block');
         }
    }
    private function _postColumn()
    {
        $errors = array();
        $id_column = (int)Tools::getValue('id_column');
        $id_menu = (int)Tools::getValue('id_menu');
        /**
         * Delete image 
         */
         
         if($id_column && $this->itemExists('column','id_column',$id_column) && Tools::isSubmit('delimage'))
         {
            $column = new Ybc_megamenu_column_class($id_column);
            $imageUrl = dirname(__FILE__).'/images/column/'.$column->image; 
            if(file_exists($imageUrl))
            {
                @unlink($imageUrl);
                $column->image = '';
                $column->update();
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_column='.$id_column.($id_menu ? '&id_menu='.$id_menu : '').'&control=column');
            }
            else
                $errors[] = $this->l('Image does not exist');   
         }
        
        /**
         * Delete column 
         */ 
         if(Tools::isSubmit('delcolumn'))
         {
            $id_column = (int)Tools::getValue('id_column');
            if(!$this->itemExists('column','id_column',$id_column))
                $errors[] = $this->l('Column does not exist');
            elseif($this->_deleteColumn($id_column))
            {
                $this->_refeshMenuCache();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);                
            }                
            else
                $errors[] = $this->l('Could not delete the column. Please try again');    
         }
         
        /**
         * Save column 
         */
        if(Tools::isSubmit('saveColumn'))
        {            
            if($id_column && $this->itemExists('column','id_column',$id_column))
            {
                $column = new Ybc_megamenu_column_class($id_column);                
            }
            else
            {
                $column = new Ybc_megamenu_column_class();
                $column->sort_order = (int)$this->getMaxOrder('column') + 1;
            }
            
            $column->custom_class = trim(Tools::getValue('custom_class','')); 
            $column->column_link = trim(Tools::getValue('column_link','')); 
            $column->column_size = trim(Tools::getValue('column_size',''));                       
            $column->enabled = trim(Tools::getValue('enabled',1));  
            $column->id_menu = trim(Tools::getValue('id_menu',0));  
            $column->show_image = trim(Tools::getValue('show_image',1));
            $column->show_title = trim(Tools::getValue('show_title',1));                     
            $column->show_description = trim(Tools::getValue('show_description',1));   
            
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
			{			
				$column->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) != '' ? trim(Tools::getValue('title_'.$language['id_lang'])) :  trim(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT')));
                $column->description[$language['id_lang']] = trim(Tools::getValue('description_'.$language['id_lang'])) != '' ? trim(Tools::getValue('description_'.$language['id_lang'])) :  trim(Tools::getValue('description_'.Configuration::get('PS_LANG_DEFAULT')));
			}
            
            /**
             * Validate 
             */
            if(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT'))=='')
                $errors[] = $this->l('You need to set column title');
            if(!(int)Tools::getValue('id_menu'))
                $errors[] = $this->l('You need to choose a menu');
            elseif(!$this->itemExists('menu','id_menu',(int)Tools::getValue('id_menu')))
                $errors[] = $this->l('Menu does not exist');
            if(!in_array($column->column_size,array('1_12','2_12','3_12','4_12','5_12','6_12','7_12','8_12','9_12','10_12','11_12','12_12')))
                $errors[] = $this->l('Column size is not valid');
            
            /**
             * Upload icon 
             */  
                
            if(isset($_FILES['image']['tmp_name']) && isset($_FILES['image']['name']) && $_FILES['image']['name'])
            {
                if(file_exists(dirname(__FILE__).'/images/column/'.$_FILES['image']['name']))
                {
                    $_FILES['image']['name'] = sha1(microtime()).'-'.$_FILES['image']['name'];
                }
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
    			$imagesize = @getimagesize($_FILES['image']['tmp_name']);
    			if (isset($_FILES['image']) &&				
    				!empty($_FILES['image']['tmp_name']) &&
    				!empty($imagesize) &&
    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
    			)
    			{
    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
    				if ($error = ImageManager::validateUpload($_FILES['image']))
    					$errors[] = $error;
    				elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name))
    					$errors[] = $this->l('Can not upload the image');
    				elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/column/'.$_FILES['image']['name'], null, null, $type))
    					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
    				if (isset($temp_name))
    					@unlink($temp_name);
                    $column->image = $_FILES['image']['name'];			
    			}
            }			
            
            /**
             * Save 
             */    
             
            if(!$errors)
            {
                if (!Tools::getValue('id_column'))
    			{
    				if (!$column->add())
    					$errors[] = $this->displayError($this->l('The column could not be added.'));                    
    			}				
    			elseif (!$column->update())
    					$errors[] = $this->displayError($this->l('The column could not be updated.'));
                $this->_refeshMenuCache();
            }
         }
         if (count($errors))
         {
            $this->errorMessage = $this->displayError(implode('<br />', $errors));  
         }			     
         elseif (Tools::isSubmit('saveColumn') && Tools::isSubmit('id_column'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_column='.Tools::getValue('id_column').'&control=column');
		 elseif (Tools::isSubmit('saveColumn'))
         {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_column='.$this->getMaxId('column','id_column').'&control=column');
         }
    }
    public function getMaxId($tbl, $primaryKey)
    {
        $req = 'SELECT max(`'.$primaryKey.'`) as maxid
				FROM `'._DB_PREFIX_.'ybc_mm_'.$tbl.'` tbl';				
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
        return isset($row['maxid']) ? (int)$row['maxid'] : 0;
    }
    public function getMaxOrder($tbl)
    {
        $req = 'SELECT max(`sort_order`) as maxorder
				FROM `'._DB_PREFIX_.'ybc_mm_'.$tbl.'` tbl';				
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
        return isset($row['maxorder']) ? (int)$row['maxorder'] : 0;
    }
    public function validatePercentPixel($param, $empty = true)
    {
        if(!preg_match('/^[0-9]+%$/', $param) && !preg_match('/^[0-9]+px$/', $param) && $param != '' || $param=='' && !$empty)
            return false;
        return true;        
    }
    public function itemExists($tbl, $primaryKey, $id)
	{
		$req = 'SELECT `'.$primaryKey.'`
				FROM `'._DB_PREFIX_.'ybc_mm_'.$tbl.'` tbl
				WHERE tbl.`'.$primaryKey.'` = '.(int)$id;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);        
		return ($row);
	}
    public function renderBlockForm()
    {
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Manage blocks'),
					'icon' => 'icon-calendar-empty'
				),
				'input' => array(					
					array(
						'type' => 'text',
						'label' => $this->l('Block title'),
						'name' => 'title',
						'lang' => true,    
                        'required' => true                    
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Block link'),
						'name' => 'block_link',						                 
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Block description'),
						'name' => 'description',
						'lang' => true,  
                        'autoload_rte' => true                      
					),	
                    array(
						'type' => 'select',
						'label' => $this->l('Block type'),
						'name' => 'block_type',                        
                        'class' => 'ybc_block_type',
						'options' => array(
                			 'query' => array(                                
                                    array(
                                        'id_option' => 'CATEGORY', 
                                        'name' => $this->l('Category')
                                    ),
                                    array(
                                        'id_option' => 'PRODUCT', 
                                        'name' => $this->l('Product')
                                    ),
                                    array(
                                        'id_option' => 'CMS', 
                                        'name' => $this->l('CMS page')
                                    ),
                                    array(
                                        'id_option' => 'CONTACT', 
                                        'name' => $this->l('Contact')
                                    ),
                                    array(
                                        'id_option' => 'MNFT', 
                                        'name' => $this->l('Manufacturer')
                                    ),
                                    array(
                                        'id_option' => 'HOME', 
                                        'name' => $this->l('Home')
                                    ),
                                    array(
                                        'id_option' => 'CUSTOM', 
                                        'name' => $this->l('Custom link')
                                    ),
                                    array(
                                        'id_option' => 'HTML', 
                                        'name' => $this->l('HTML block')
                                    )
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    
                    //Block types
                    array(
    					'type'  => 'categories',
    					'label' => $this->l('Choose a category'),
    					'name'  => 'categories_list',                        
    					'tree'  => array(
    						'id'      => 'categories-tree',
    						'selected_categories' => $this->getSelectedCategories(),
    						'disabled_categories' => null,
                            'use_checkbox' => true,
                            'use_search' => true,
                            'root_category' => 2
    					),
                        'required' => true 
    				),
                    array(
						'type' => 'switch',
						'label' => $this->l('Include subcategories'),
						'name' => 'categories_list_include_sub',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
    					'type' => 'manufacturers',
    					'label' => $this->l('Choose manufacturers:'),
    					'manufacturers' => Manufacturer::getManufacturers(),
    					'name' => 'manufacturers_list',
                        'required' => true,
                        'selected_mnfts' => $this->getSelectedManufactures()
                                           
    				),
                    array(
    					'type' => 'cms_pages',
    					'label' => $this->l('Choose pages:'),
    					'pages' => CMS::listCms(),
    					'name' => 'cms_pages_list',
                        'required' => true,
                        'selected_pages' => $this->getSelectedCmsPages()                        
    				),
                    array(
    					'type' => 'products_search',
    					'label' => $this->l('Type product names:'),    				
    					'name' => 'products_list',
                        'required' => true,
                        'selected_products' => $this->getSelectedProducts()                        
    				),
                    array(
    					'type' => 'textarea',
    					'label' => $this->l('Custom html block:'),    				
    					'name' => 'html_block',
                        'autoload_rte' => true,
                        'required' => true,
                        'lang' => true,                         
    				),
                    array(
    					'type' => 'text',
    					'label' => $this->l('Custom link label:'),    				
    					'name' => 'custom_link_label',
                        'required' => true                                                 
    				),
                    array(
    					'type' => 'text',
    					'label' => $this->l('Custom link:'),    				
    					'name' => 'custom_link',
                        'required' => true                                                 
    				),
                    //End block type
                                        			
					array(
						'type' => 'select',
						'label' => $this->l('Column'),
						'name' => 'id_column',
						'options' => array(
                			 'query' => $this->getColumnsDropdown(),
                             'id' => 'id_column',
                			 'name' => 'title'  
                        ),
                        'required' => true                 
					),
					array(
						'type' => 'file',
						'label' => $this->l('Image'),
						'name' => 'image'						
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Custom class'),
						'name' => 'custom_class'						
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show image'),
						'name' => 'show_image',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Show title'),
						'name' => 'show_title',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Show description'),
						'name' => 'show_description',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'enabled',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),
                    array(
                        'type' => 'hidden', 
                        'name' => 'control'
                    )
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				)
            ),
		);
        
        
        
        
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'saveBlock';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getMenuFieldsValues($this->blockFields,'id_block','Ybc_megamenu_block_class','saveBlock'),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/',
            'link' => $this->context->link,
            'cancel_url' => $this->baseAdminPath
		);
        
        if(Tools::isSubmit('id_block') && $this->itemExists('block','id_block',(int)Tools::getValue('id_block')))
        {    
            
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_block');
            $block = new Ybc_megamenu_block_class((int)Tools::getValue('id_block'));
            if($block->image)
            {             
                $helper->tpl_vars['display_img'] = $this->_path.'images/block/'.$block->image;
                $helper->tpl_vars['img_del_link'] = $this->baseAdminPath.'&id_block='.Tools::getValue('id_block').'&delimage=true&control=block';                
            }
        }
        
		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);
        
        $this->_html .= $helper->generateForm(array($fields_form));			
    } 
    public function getSelectedCategories()
    {
        if(Tools::isSubmit('categories_list') && is_array(Tools::getValue('categories_list')))
            return Tools::getValue('categories_list');
        $id_block = (int)Tools::getValue('id_block');
        if($id_block && $this->itemExists('block','id_block',$id_block))
        {            
            $block = new Ybc_megamenu_block_class($id_block);
            if($block->params)
            {
                $params = @unserialize($block->params);
                if($params && isset($params['CATEGORY']['categories']) && is_array($params['CATEGORY']['categories']))
                    return $params['CATEGORY']['categories'];
            }
        }
        return array();
    }
    public function getSelectedManufactures()
    {
        if(Tools::isSubmit('saveBlock') && is_array(Tools::getValue('mnfts')))
            return Tools::getValue('mnfts');
        elseif(Tools::isSubmit('saveBlock'))
            return array();
        $id_block = (int)Tools::getValue('id_block');
        if($this->itemExists('block','id_block',$id_block))
        {
            $block = new Ybc_megamenu_block_class($id_block);
            if($block->params)
            {
                $params = @unserialize($block->params);
                if($params && isset($params['MNFT']) && is_array($params['MNFT']))
                    return $params['MNFT'];
            }
        }
        return array();
    }
    public function getSelectedCmsPages()
    {        
        if(Tools::isSubmit('saveBlock') && is_array(Tools::getValue('cms_pages')))
            return Tools::getValue('cms_pages');
        elseif(Tools::isSubmit('saveBlock'))
            return array();
        $id_block = (int)Tools::getValue('id_block');
        if($this->itemExists('block','id_block',$id_block))
        {
            $block = new Ybc_megamenu_block_class($id_block);
            if($block->params)
            {
                $params = @unserialize($block->params);
                if($params && isset($params['CMS']) && is_array($params['CMS']))
                    return $params['CMS'];
            }
        }
        return array();
    }
    public function getSelectedProducts()
    {
        $products = array();
        if(Tools::isSubmit('inputAccessories') && trim(trim(Tools::getValue('inputAccessories')),','))
        {
            $products = explode('-', trim(trim(Tools::getValue('inputAccessories')),'-'));
        }
        else
        {
            $id_block = (int)Tools::getValue('id_block');
            if($this->itemExists('block','id_block',$id_block))
            {
                $block = new Ybc_megamenu_block_class($id_block);
                if($block->params)
                {
                    $params = @unserialize($block->params);
                    if($params && isset($params['PRODUCT']) && is_array($params['PRODUCT']))
                        $products = $params['PRODUCT'];
                }
            }            
        }
        
        if($products)
        {
            foreach($products as $key => &$product)
            {
                $product = (int)$product;
            }
            $sql = 'SELECT p.`id_product`, pl.`name`,p.`reference`
				FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
				WHERE pl.`id_lang` = '.(int)$this->context->language->id.' AND p.`id_product` IN ('.implode(',',$products).')';
            $product_list = Db::getInstance()->executeS($sql);
            return $product_list;          
        }        
        return false;
    }
    public function orderIdsByName($ids, $tbl, $orderOnLang = true , $orderField = 'name', $id_shop = false, $id_lang = false)
    {
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        if($ids && is_array($ids))
        {
            if($orderOnLang)
                $sql = "SELECT DISTINCT t.id_".$tbl." FROM "._DB_PREFIX_.$tbl." t
                LEFT JOIN "._DB_PREFIX_.$tbl."_lang tl ON t.id_".$tbl." = tl.id_".$tbl." AND tl.id_lang = $id_lang ".($id_shop ? " AND tl.id_shop = ".$this->context->shop->id : "")."
                WHERE t.id_".$tbl." IN (".implode(',', $ids).")
                ORDER BY tl.".$orderField." ASC";
            else
                $sql = "SELECT DISTINCT t.id_".$tbl." FROM "._DB_PREFIX_.$tbl." t                
                WHERE t.id_".$tbl." IN (".implode(',', $ids).")
                ORDER BY t.".$orderField." ASC";
            $idsArg = Db::getInstance()->executeS($sql);
            $tempIds = array();
     
            if($idsArg)
            {
                foreach($idsArg as $id)
                    $tempIds[] = $id['id_'.$tbl];
            }            
            return $tempIds;
        }
        return $ids;        
    }
    public function renderColumnForm()
    {
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Manage columns'),
					'icon' => 'icon-sitemap'
				),
				'input' => array(					
					array(
						'type' => 'text',
						'label' => $this->l('Column title'),
						'name' => 'title',
						'lang' => true,    
                        'required' => true                    
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Column link'),
						'name' => 'column_link',
						'desc' => $this->l('Leave blank if you do not want to have link')                  
					),
                    array(
						'type' => 'textarea',
						'label' => $this->l('Column description'),
						'name' => 'description',
						'lang' => true,  
                        'autoload_rte' => true                      
					),				
					array(
						'type' => 'select',
						'label' => $this->l('Menu'),
						'name' => 'id_menu',
						'options' => array(
                			 'query' => $this->getMenusDropdown(),
                             'id' => 'id_menu',
                			 'name' => 'title'  
                        ),
                        'required' => true                
					),
					array(
						'type' => 'file',
						'label' => $this->l('Image'),
						'name' => 'image'						
					),                    
                    array(
						'type' => 'select',
						'label' => $this->l('Column size'),
						'name' => 'column_size',                                              
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => '1_12', 
                                        'name' => $this->l('1/12')
                                    ), 
                                    array(
                                        'id_option' => '2_12', 
                                        'name' => $this->l('2/12')
                                    ), 
                                    array(
                                        'id_option' => '3_12', 
                                        'name' => $this->l('3/12')
                                    ), 
                                    array(
                                        'id_option' => '4_12', 
                                        'name' => $this->l('4/12')
                                    ), 
                                    array(
                                        'id_option' => '5_12', 
                                        'name' => $this->l('5/12')
                                    ), 
                                    array(
                                        'id_option' => '6_12', 
                                        'name' => $this->l('6/12')
                                    ), 
                                    array(
                                        'id_option' => '7_12', 
                                        'name' => $this->l('7/12')
                                    ), 
                                    array(
                                        'id_option' => '8_12', 
                                        'name' => $this->l('8/12')
                                    ), 
                                    array(
                                        'id_option' => '9_12', 
                                        'name' => $this->l('9/12')
                                    ), 
                                    array(
                                        'id_option' => '10_12', 
                                        'name' => $this->l('10/12')
                                    ), 
                                    array(
                                        'id_option' => '11_12', 
                                        'name' => $this->l('11/12')
                                    ), 
                                    array(
                                        'id_option' => '12_12', 
                                        'name' => $this->l('12/12 (Full)')
                                    ),                                                                      
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Custom class'),
						'name' => 'custom_class'						
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show image'),
						'name' => 'show_image',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Show title'),
						'name' => 'show_title',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Show description'),
						'name' => 'show_description',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'enabled',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),
                    array(
                        'type' => 'hidden', 
                        'name' => 'control'
                    )
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				)
            ),
		);
        
        
        
        
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'saveColumn';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getMenuFieldsValues($this->columnFields,'id_column','Ybc_megamenu_column_class','saveColumn'),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/',
            'link' => $this->context->link,
            'cancel_url' => $this->baseAdminPath
		);
        
        if(Tools::isSubmit('id_column') && $this->itemExists('column','id_column',(int)Tools::getValue('id_column')))
        {    
            
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_column');
            $column = new Ybc_megamenu_column_class((int)Tools::getValue('id_column'));
            if($column->image)
            {             
                $helper->tpl_vars['display_img'] = $this->_path.'images/column/'.$column->image;
                $helper->tpl_vars['img_del_link'] = $this->baseAdminPath.'&id_column='.Tools::getValue('id_column').'&delimage=true&control=column';                
            }
        }
        
		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);
        
        $this->_html .= $helper->generateForm(array($fields_form));			
    } 
    public function renderMenuForm()
    {
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Manage menus'),
					'icon' => 'icon-book'
				),
				'input' => array(					
					array(
						'type' => 'text',
						'label' => $this->l('Menu title'),
						'name' => 'title',
						'lang' => true,    
                        'required' => true,                    
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Menu link type'),
						'name' => 'menu_type',
                        'required' => true,
                        'class' => 'ybc_menu_type',
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'CUSTOM', 
                                        'name' => $this->l('Custom link')
                                    ),
                                    array(
                                        'id_option' => 'CMS', 
                                        'name' => $this->l('CMS page')
                                    ),
                                    array(
                                        'id_option' => 'CONTACT', 
                                        'name' => $this->l('Contact')
                                    ),                               
                                    array(
                                        'id_option' => 'CATEGORY', 
                                        'name' => $this->l('Category')
                                    ),
                                    array(
                                        'id_option' => 'MNFT', 
                                        'name' => $this->l('Manufacturer')
                                    ),
                                    array(
                                        'id_option' => 'HOME', 
                                        'name' => $this->l('Home')
                                    )                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
    					'type'  => 'categories',
    					'label' => $this->l('Choose a category'),
    					'name'  => 'id_parent',                        
    					'tree'  => array(
    						'id'      => 'categories-tree',
    						'selected_categories' => array($this->getMenuData('id_category')),
    						'disabled_categories' => null,                            
                            'use_search' => true,
                            'root_category' => 2
    					),
                        'required' => true 
    				),                    
                    array(
    					'type' => 'manufacturer_menu',
    					'label' => $this->l('Choose a manufacturer:'),
    					'manufacturers' => Manufacturer::getManufacturers(),
    					'name' => 'id_manufacturer',
                        'required' => true,
                        'selected_mnft' => $this->getMenuData('id_manufacturer')
                                           
    				),
                    array(
    					'type' => 'cms_page_menu',
    					'label' => $this->l('Choose a page:'),
    					'pages' => CMS::listCms(),
    					'name' => 'id_cms',
                        'required' => true,
                        'selected_page' => $this->getMenuData('id_cms')              
    				),
					array(
						'type' => 'text',
						'label' => $this->l('Link'),
						'name' => 'link',
                        'desc' => $this->l('Leave blank if you do not want to have a link'),						
					),			
					array(
						'type' => 'select',
						'label' => $this->l('Submenu type'),
						'name' => 'column_type',
                        'required' => true,
                        'class' => 'ybc_column_type',
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'FULL', 
                                        'name' => $this->l('Full width')
                                    ), 
                                    array(
                                        'id_option' => 'LEFT', 
                                        'name' => $this->l('Left')
                                    ),
                                    array(
                                        'id_option' => 'RIGHT', 
                                        'name' => $this->l('Right')
                                    ),                                                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Submenu width'),
						'name' => 'sub_menu_max_width',
                        
                        'suffix' => 'percent (%)',
                        'desc' => $this->l('From: 25 - 100'),						
					),
					array(
						'type' => 'text',
						'label' => $this->l('Custom class'),
						'name' => 'custom_class'						
					),
					array(
						'type' => 'text',
						'label' => $this->l('Awesome font icon'),
						'name' => 'icon',
                        'desc' => $this->l('Eg: fa-home, fa-phone')						
					),
                    array(
                        'type' => 'file',
						'label' => $this->l('image icon'),
						'name' => 'icon_image'					
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show icon'),
						'name' => 'show_icon',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu title text color'),
						'name' => 'color1'						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu block body text color'),
						'name' => 'color2'						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu link hover color'),
						'name' => 'color3'						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu price color'),
						'name' => 'color4'						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu border color'),
						'name' => 'color5'						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Sub-menu background class'),
						'name' => 'color6'						
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Sub-menu border type'),
						'name' => 'sub_type',                                           
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'title', 
                                        'name' => $this->l('Title border only')
                                    ), 
                                    array(
                                        'id_option' => 'list', 
                                        'name' => $this->l('List item border only')
                                    ),
                                    array(
                                        'id_option' => 'title_list', 
                                        'name' => $this->l('Title and list border')
                                    ),
                                    array(
                                        'id_option' => 'no_title_list', 
                                        'name' => $this->l('No border')
                                    ),                                                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Use sub-menu wrapper border'),
						'name' => 'wrapper_border',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),
                    array(
						'type' => 'file',
						'label' => $this->l('Sub-menu banner'),
						'name' => 'image'						
					),   
                    array(
						'type' => 'text',
						'label' => $this->l('Sub-menu banner link'),
						'name' => 'banner_link',
                        'desc' => $this->l('Leave blank if you do not want to have banner link')						
					),                 
                    array(
						'type' => 'select',
						'label' => $this->l('Sub-menu banner position'),
						'name' => 'banner_position',                                          
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'bottom', 
                                        'name' => $this->l('Bottom')
                                    ),
                                    array(
                                        'id_option' => 'top', 
                                        'name' => $this->l('Top')
                                    ),                                 
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'enabled',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),
                    array(
                        'type' => 'hidden', 
                        'name' => 'control'
                    )
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				)
            ),
		);
        
        
        
        
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'saveMenu';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getMenuFieldsValues($this->menuFields,'id_menu','Ybc_megamenu_class','saveMenu'),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/',
            'link' => $this->context->link,
            'cancel_url' => $this->baseAdminPath
		);
        
        if(Tools::isSubmit('id_menu') && $this->itemExists('menu','id_menu',(int)Tools::getValue('id_menu')))
        {    
            
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_menu');
            $menu = new Ybc_megamenu_class((int)Tools::getValue('id_menu'));      
            if($menu->image)
            {             
                $helper->tpl_vars['display_img'] = $this->_path.'images/menu/'.$menu->image;
                $helper->tpl_vars['img_del_link'] = $this->baseAdminPath.'&id_menu='.Tools::getValue('id_menu').'&delimage=true&control=menu';                
            }      
        }
        
		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);
        
        $this->_html .= $helper->generateForm(array($fields_form));			
    }
    public function renderConfigForm()
    {
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Mega menu global configuration'),
					'icon' => 'icon-AdminAdmin'
				),
				'input' => array(                    
                    array(
						'type' => 'select',
						'label' => $this->l('Menu layout'),
						'name' => 'YBC_MM_TYPE',
                        'required' => true,                        
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'default', 
                                        'name' => $this->l('Default')
                                    ),
                                    array(
                                        'id_option' => 'light', 
                                        'name' => $this->l('Light')
                                    ),
                                    array(
                                        'id_option' => 'classic', 
                                        'name' => $this->l('Classic')
                                    ),                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Skin'),
						'name' => 'YBC_MM_SKIN',
                        'required' => true,                        
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'default', 
                                        'name' => $this->l('Default (light grey)')
                                    ),
                                    array(
                                        'id_option' => 'black', 
                                        'name' => $this->l('Black')
                                    ),
                                    array(
                                        'id_option' => 'pink', 
                                        'name' => $this->l('Pink')
                                    ),  
                                    array(
                                        'id_option' => 'red', 
                                        'name' => $this->l('Red')
                                    ),
                                    array(
                                        'id_option' => 'green', 
                                        'name' => $this->l('Green')
                                    ), 
                                    array(
                                        'id_option' => 'orange', 
                                        'name' => $this->l('Orange')
                                    ),
                                    array(
                                        'id_option' => 'blue', 
                                        'name' => $this->l('Blue')
                                    ),         
                                    array(
                                        'id_option' => 'custom', 
                                        'name' => $this->l('Custom color')
                                    ),                               
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Main color'),
						'name' => 'YBC_MM_CUSTOM_COLOR'                        
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Hover color'),
						'name' => 'YBC_MM_CUSTOM_COLOR_HOVER'                        
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Text color'),
						'name' => 'YBC_MM_CUSTOM_TEXT_COLOR'                        
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Border color'),
						'name' => 'YBC_MM_CUSTOM_BORDER_COLOR'                        
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Transition effect'),
						'name' => 'YBC_MM_TRANSITION_EFFECT',
                        'required' => true,                        
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'SLIDE', 
                                        'name' => $this->l('Slide down')
                                    ),
                                    array(
                                        'id_option' => 'DROP_DOWN', 
                                        'name' => $this->l('Drop down')
                                    ),
                                    array(
                                        'id_option' => 'FADE', 
                                        'name' => $this->l('Fade')
                                    ),
                                    array(
                                        'id_option' => 'ZOOM', 
                                        'name' => $this->l('Zoom')
                                    )                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Direction mode'),
						'name' => 'YBC_MM_DIR',
                        'required' => true,                        
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'auto', 
                                        'name' => $this->l('Auto detect LTR OR RTL')
                                    ),
                                    array(
                                        'id_option' => 'ltr', 
                                        'name' => $this->l('LTR')
                                    ),
                                    array(
                                        'id_option' => 'rtl', 
                                        'name' => $this->l('RTL')
                                    ),                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Mobile menu type'),
						'name' => 'YBC_MOBILE_MM_TYPE',
                        'required' => true,                        
						'options' => array(
                			 'query' => array( 
                                    array(
                                        'id_option' => 'default', 
                                        'name' => $this->l('Default')
                                    ),
                                    array(
                                        'id_option' => 'floating', 
                                        'name' => $this->l('Floating')
                                    ),
                                    array(
                                        'id_option' => 'full', 
                                        'name' => $this->l('Full')
                                    ),                                    
                                ),                             
                             'id' => 'id_option',
                			 'name' => 'name'  
                        )                
					),
                    
                    array(
						'type' => 'textarea',
						'label' => $this->l('Custom CSS'),
						'name' => 'YBC_MM_CUSTOM_CSS'                        
					),  
                    array(
						'type' => 'text',
						'label' => $this->l('Custom class'),
						'name' => 'YBC_MM_CUSTOM_CLASS'                        
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Show images on mobile devices'),
						'name' => 'YBC_MM_SHOW_IMAGE_ON_MOBILE',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Menu fixed position'),
						'name' => 'YBC_MM_FIXED',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					), 
                    array(
						'type' => 'switch',
						'label' => $this->l('Make floating menu full width'),
						'name' => 'YBC_MM_FIXED_FULL',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),  
                    array(
						'type' => 'switch',
						'label' => $this->l('Enable sub-menu top arrow'),
						'name' => 'YBC_MM_ARROW',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					),        
                    array(
						'type' => 'switch',
						'label' => $this->l('Use cache'),
						'name' => 'YBC_MM_USE_CACHE',
                        'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						)					
					)                  
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				)
            ),
		);
        
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'saveConfig';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		
        /**
         * Get field values 
         */
        
        $fields = array();
        if(Tools::isSubmit('saveConfig'))
        {
            $fields['YBC_MM_TRANSITION_EFFECT'] = Tools::getValue('YBC_MM_TRANSITION_EFFECT','FADE');
            $fields['YBC_MM_CUSTOM_CSS'] = Tools::getValue('YBC_MM_CUSTOM_CSS','');
            $fields['YBC_MM_CUSTOM_CLASS'] = Tools::getValue('YBC_MM_CUSTOM_CLASS','');
            $fields['YBC_MM_DIR'] = Tools::getValue('YBC_MM_DIR','auto');
            $fields['YBC_MM_ARROW'] = Tools::getValue('YBC_MM_ARROW',1);
            $fields['YBC_MM_FIXED'] = Tools::getValue('YBC_MM_FIXED',1);
            $fields['YBC_MM_FIXED_FULL'] = Tools::getValue('YBC_MM_FIXED_FULL',1);
            $fields['YBC_MM_CUSTOM_COLOR'] = Tools::getValue('YBC_MM_CUSTOM_COLOR','');
            $fields['YBC_MM_CUSTOM_COLOR_HOVER'] = Tools::getValue('YBC_MM_CUSTOM_COLOR_HOVER','');
            $fields['YBC_MM_CUSTOM_TEXT_COLOR'] = Tools::getValue('YBC_MM_CUSTOM_TEXT_COLOR','');
            $fields['YBC_MM_CUSTOM_BORDER_COLOR'] = Tools::getValue('YBC_MM_CUSTOM_BORDER_COLOR','');
            $fields['YBC_MM_SKIN'] = Tools::getValue('YBC_MM_SKIN','');
            $fields['YBC_MM_TYPE'] = Tools::getValue('YBC_MM_TYPE','');
            $fields['YBC_MOBILE_MM_TYPE'] = Tools::getValue('YBC_MOBILE_MM_TYPE','');
            $fields['YBC_MM_USE_CACHE'] = Tools::getValue('YBC_MM_USE_CACHE',0);
            $fields['YBC_MM_SHOW_IMAGE_ON_MOBILE'] = Tools::getValue('YBC_MM_SHOW_IMAGE_ON_MOBILE',1);
        }
        else
        {
            $fields['YBC_MM_TRANSITION_EFFECT'] = Configuration::get('YBC_MM_TRANSITION_EFFECT') ? Configuration::get('YBC_MM_TRANSITION_EFFECT') : 'FADE';
            $fields['YBC_MM_CUSTOM_CLASS'] = Configuration::get('YBC_MM_CUSTOM_CLASS') ? Configuration::get('YBC_MM_CUSTOM_CLASS') : '';
            $fields['YBC_MM_FIXED'] = Configuration::get('YBC_MM_FIXED') ? 1 : 0;
            $fields['YBC_MM_FIXED_FULL'] = Configuration::get('YBC_MM_FIXED_FULL') ? 1 : 0;
            $fields['YBC_MM_DIR'] = Configuration::get('YBC_MM_DIR') ? Configuration::get('YBC_MM_DIR') : 'auto';
            $fields['YBC_MM_ARROW'] = Configuration::get('YBC_MM_ARROW') ? 1 : 0;
            $fields['YBC_MM_CUSTOM_COLOR'] = Configuration::get('YBC_MM_CUSTOM_COLOR') ? Configuration::get('YBC_MM_CUSTOM_COLOR') : '';
            $fields['YBC_MM_CUSTOM_COLOR_HOVER'] = Configuration::get('YBC_MM_CUSTOM_COLOR_HOVER') ? Configuration::get('YBC_MM_CUSTOM_COLOR_HOVER') : '';
            $fields['YBC_MM_CUSTOM_TEXT_COLOR'] = Configuration::get('YBC_MM_CUSTOM_TEXT_COLOR') ? Configuration::get('YBC_MM_CUSTOM_TEXT_COLOR') : '';
            $fields['YBC_MM_CUSTOM_BORDER_COLOR'] = Configuration::get('YBC_MM_CUSTOM_BORDER_COLOR') ? Configuration::get('YBC_MM_CUSTOM_BORDER_COLOR') : '';
            $cssFile = dirname(__FILE__).'/css/front_custom.css';
            if(file_exists($cssFile) && is_readable($cssFile))
                $fields['YBC_MM_CUSTOM_CSS'] = Tools::file_get_contents($cssFile);
            else
                $fields['YBC_MM_CUSTOM_CSS'] = '';
            
            $fields['YBC_MM_SKIN'] = Configuration::get('YBC_MM_SKIN') ? Configuration::get('YBC_MM_SKIN') : 'default';
            $fields['YBC_MM_TYPE'] = Configuration::get('YBC_MM_TYPE') ? Configuration::get('YBC_MM_TYPE') : 'default';
            $fields['YBC_MOBILE_MM_TYPE'] = Configuration::get('YBC_MOBILE_MM_TYPE') ? Configuration::get('YBC_MOBILE_MM_TYPE') : 'default';
            $fields['YBC_MM_USE_CACHE'] = (int)Configuration::get('YBC_MM_USE_CACHE') ? 1 : 0;
            $fields['YBC_MM_SHOW_IMAGE_ON_MOBILE'] = (int)Configuration::get('YBC_MM_SHOW_IMAGE_ON_MOBILE') ? 1 : 0;
            
        }        
        $helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $fields,
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
        );
        $helper->override_folder = '/';
        $languages = Language::getLanguages(false);
        $this->_html .= $helper->generateForm(array($fields_form));			
    }
    public function renderList()
    {
        $this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'menus' => $this->getMenuTree(),
                'admin_path' => $this->baseAdminPath,
                'active_id_menu' => (int)Tools::getValue('id_menu'),
                'active_id_column' => (int)Tools::getValue('id_column'),
                'active_id_block' => (int)Tools::getValue('id_block'), 				
			)
		);
        $this->_html .= '<div style="float: left;width: 28%; margin-right: 2%;" class="ybc-right-panel">'.$this->display(__FILE__, 'menu_list.tpl').'</div>';
    }
    public function getMenus($id_lang = false)
    {
        $context = Context::getContext();
        $where = '';
        
        if(class_exists('ybc_themeconfig') && isset($this->context->controller->controller_type) && ($this->context->controller->controller_type=='front' || $this->context->controller->controller_type=='modulefront'))
        {
            $tc = new Ybc_themeconfig();
            if($tc->devMode && ($ids = $tc->getLayoutConfiguredField('menus')))
            {
                $where = ' AND  m.id_menu IN('.implode(',',$ids).') ';
            }
        }
        if(!$id_lang)
            $id_lang = $context->language->id;        
        $sql = "
            SELECT * FROM "._DB_PREFIX_."ybc_mm_menu m
            LEFT JOIN "._DB_PREFIX_."ybc_mm_menu_lang ml on m.id_menu = ml.id_menu
            WHERE ml.id_lang = ".$id_lang.$where." 
            ORDER BY m.sort_order asc, m.id_menu asc
        ";
        return Db::getInstance()->executeS($sql);
    }
    private function getMenuTree()
    {
        $menus = $this->getMenus();
        if($menus)
        {
            foreach($menus as &$menu)
            {
                $menu['columns'] = $this->getColumnByIdMenu($menu['id_menu']);
                if($menu['columns'])
                {
                    foreach($menu['columns'] as &$column)
                    {
                        $column['blocks'] = $this->getBlockByIdColumn($column['id_column']);
                    }
                }
            }
        }
        return $menus;
    }
    private function getProductInfo($id_product, $id_lang = false)
    {
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        $product = new Product($id_product, true, $id_lang, $this->context->shop->id);
        $pinfo = array();   
        $pinfo['description'] = $product->description_short;  
        $price = $product->getPrice(false,null);
        $oldPrice = $product->getPriceWithoutReduct(false,false);
        $discount = $oldPrice - $price;
        $pinfo['price'] = Tools::displayPrice($price);       
        $pinfo['old_price'] = Tools::displayPrice($oldPrice); 
        $pinfo['discount_percent'] = round(($oldPrice - $price) / $oldPrice * 100);
        $pinfo['discount_amount'] = Tools::displayPrice($discount);
        $pinfo['product'] = array('id_product' => $id_product);
        $images = $product->getImages((int)$this->context->cookie->id_lang);
        $link = $this->context->link;
        if(isset($images[0]))
		    $id_image = Configuration::get('PS_LEGACY_IMAGES') ? ($product->id.'-'.$images[0]['id_image']) : $images[0]['id_image'];
		else
            $id_image = $this->context->language->iso_code.'-default';			
        $pinfo['img_url'] =  $link->getImageLink($product->link_rewrite, $id_image, ImageType::getFormatedName('home'));
        return $pinfo;
    }
    private function getMenuArg($id_lang = false)
    {
        $link = $this->context->link;
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        $menus = $this->getMenus($id_lang);
        if($menus)
        {
            foreach($menus as &$menu)
            {
                if($menu['menu_type'] == 'CMS')
                    $menu['url'] = $this->getMenuLink($menu['menu_type'],$menu['id_cms'], $id_lang);
                elseif($menu['menu_type'] == 'CATEGORY')
                    $menu['url'] = $this->getMenuLink($menu['menu_type'],$menu['id_category'], $id_lang);
                elseif($menu['menu_type'] == 'MNFT')
                    $menu['url'] = $this->getMenuLink($menu['menu_type'],$menu['id_manufacturer'], $id_lang);
                elseif($menu['menu_type'] == 'CUSTOM')
                    $menu['url'] = $this->getMenuLink($menu['menu_type'],$menu['link'], $id_lang);   
                else
                    $menu['url'] = $this->getMenuLink($menu['menu_type'], 0, $id_lang);  
                if($menu['image'])
                    $menu['image'] = $this->_path.'images/menu/'.$menu['image']; 
                if($menu['icon_image'])
                    $menu['icon_image'] = $this->_path.'images/menu/'.$menu['icon_image'];                 
                $menu['columns'] = $this->getColumnByIdMenu($menu['id_menu'], $id_lang);
                if($menu['columns'])
                {
                    foreach($menu['columns'] as &$column)
                    {
                        if($column['image'])
                            $column['image'] = $this->_path.'images/column/'.$column['image'];
                        $column['blocks'] = $this->getBlockByIdColumn($column['id_column'], $id_lang);
                        if($column['blocks'])
                        {
                            foreach($column['blocks'] as &$block)
                            {   
                                if($block['image'])
                                    $block['image'] = $this->_path.'images/block/'.$block['image'];
                                $urls = array();
                                $subCategories = array();
                                if($block['params'])
                                {
                                    $parms = @unserialize($block['params']);
                                    $block['params'] = $parms;   
                                                                     
                                    if($parms)
                                    {
                                        switch($block['block_type'])
                                        {
                                            case 'PRODUCT':
                                                if(isset($parms['PRODUCT']) && $parms['PRODUCT'] && is_array($parms['PRODUCT']))
                                                {
                                                    foreach($parms['PRODUCT'] as $id_product)
                                                    {
                                                        if((int)$id_product)
                                                        {
                                                            $urls[] = $this->getBlockLink($block['block_type'],(int)$id_product, $id_lang);
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'CMS':
                                                if(isset($parms['CMS']) && $parms['CMS'] && is_array($parms['CMS']))
                                                {
                                                    $parms['CMS'] = $this->orderIdsByName($parms['CMS'],'cms',true,'meta_title');
                                                    foreach($parms['CMS'] as $id_cms)
                                                    {
                                                        if((int)$id_cms)
                                                        {
                                                            $urls[] = $this->getBlockLink($block['block_type'],(int)$id_cms, $id_lang);
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'MNFT':
                                                if(isset($parms['MNFT']) && $parms['MNFT'] && is_array($parms['MNFT']))
                                                {
                                                    $parms['MNFT'] = $this->orderIdsByName($parms['MNFT'],'manufacturer',false,'name');
                                                    foreach($parms['MNFT'] as $id_manufacturer)
                                                    {
                                                        if((int)$id_manufacturer)
                                                        {
                                                            $urls[] = $this->getBlockLink($block['block_type'],(int)$id_manufacturer, $id_lang);
                                                        }
                                                    }
                                                }
                                                break;
                                            case 'CUSTOM':
                                                if(isset($parms['CUSTOM']) && $parms['CUSTOM'] && is_array($parms['CUSTOM']))
                                                {
                                                    $urls[] = array('title'=>$parms['CUSTOM']['label'],'url'=>$parms['CUSTOM']['link']);
                                                }
                                                break;
                                            case 'CATEGORY':
                                                if(isset($parms['CATEGORY']) && $parms['CATEGORY'] && is_array($parms['CATEGORY']))
                                                {
                                                    $categories = $parms['CATEGORY']['categories'];
                                                    $categories = $this->orderIdsByName($categories,'category',true,'name',true);                                                   
                                                    foreach($categories as $id_category)
                                                    {
                                                        $urls[] = $this->getBlockLink($block['block_type'],(int)$id_category, $id_lang);   
                                                        if(isset($parms['CATEGORY']['categories_list_include_sub']) && (int)$parms['CATEGORY']['categories_list_include_sub'] && !isset($subCategories[$id_category]))
                                                        {                                                            
                                                            $level = 0;
                                                            $subCategories[$id_category] = $this->getCategoriesTree($id_category, $level);
                                                        }                                                        
                                                    }                                                    
                                                }
                                                break;
                                            case 'HOME':
                                                $urls[] = $this->getBlockLink($block['block_type'], 0, $id_lang);
                                                break;
                                            case 'CONTACT':
                                                $urls[] = $this->getBlockLink($block['block_type'], 0, $id_lang);
                                                break;
                                            case 'HTML':
                                                $block['parms']['HTML'] = $block['html_block']; 
                                                break;
                                            default:
                                                break;
                                        }//End switch case
                                    }                                  
                                }
                                $block['urls'] = $urls;
                                $block['subCategories'] = $subCategories;
                            }
                        }
                    }
                }
            }
        }
        
        return $menus;
    }
    private function getMenuLink($type,$id = 0, $id_lang = false)
    {
        $link = $this->context->link;
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        switch($type)
        {
            case 'CMS':
                $cms = CMS::getLinks((int)$id_lang, array((int)$id));
                if($cms)
                    return $cms[0]['link']; 
                 break;               
            case 'CUSTOM':
                return $id;
            case 'CATEGORY':
                $cat = new Category($id);
                if($cat && !is_null($cat->id))
                    return $cat->getLink();
                break;            
            case 'MNFT':
                $manufacturer = new Manufacturer((int)$id, (int)$id_lang);
                if(!is_null($manufacturer->id))
                {
                    if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
						$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
					else
						$manufacturer->link_rewrite = 0;
                    return $link->getManufacturerLink((int)$id, $manufacturer->link_rewrite);
                }   
                break;             
            case 'HOME':
                return $link->getPageLink('index',true);
            case 'CONTACT':
                return $link->getPageLink('contact', true);                
            default:
                return '#';
        }
        return '#';
    }
    private function getBlockLink($type,$id = 0, $id_lang = false)
    {
        $link = $this->context->link;
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        switch($type)
        {
            case 'PRODUCT':
                $product = new Product((int)$id, true, (int)$id_lang);
                if($product && !is_null($product->id))
                {
                    return array('title'=>$product->name,'url'=>$product->getLink(), 'id'=>(int)$id,'type'=>$type, 'info' => $this->getProductInfo((int)$id), $id_lang);
                }
                break;
            case 'CMS':
                $cms = new CMS((int)$id, (int)$id_lang);                
                if($cms && $cms->id)
                    return array('title'=>$cms->meta_title,'url'=>$link->getCMSLink($cms), 'id'=>(int)$id,'type'=>$type);
                break;
            case 'CATEGORY':
                $cat = new Category((int)$id,(int)$id_lang);
                if($cat)
                    return array('title'=>$cat->name,'url'=>$cat->getLink(), 'id'=>(int)$id,'type'=>$type);
                break;
            case 'MNFT':
                $manufacturer = new Manufacturer((int)$id, (int)$id_lang);
                
                if(!is_null($manufacturer->id))
                {
                    if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
						$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
					else
						$manufacturer->link_rewrite = 0;
                    return array('title' => $manufacturer->name, 'url' => $link->getManufacturerLink((int)$id, $manufacturer->link_rewrite), 'id'=>(int)$id,'type'=>$type);
                }
                break;
                                
            case 'HOME':
                return array('title'=>$this->l('Home'),'url'=>$link->getPageLink('index',true),'type'=>$type);
            case 'CONTACT':
                return array('title'=>$this->l('Contact us'),'url'=>$link->getPageLink('contact',true),'type'=>$type);                               
            default:
                return array();
        }
        return array();
    }
    public function getColumnByIdMenu($id_menu, $id_lang = false)
    {
        $context = Context::getContext();
        if(!$id_lang)
            $id_lang = $context->language->id;
        $sql = "
            SELECT * FROM "._DB_PREFIX_."ybc_mm_column c
            LEFT JOIN "._DB_PREFIX_."ybc_mm_column_lang cl ON c.id_column = cl.id_column
            WHERE cl.id_lang = ".$id_lang." AND c.id_menu=$id_menu
            ORDER BY c.sort_order asc, c.id_column asc
        ";
        return Db::getInstance()->executeS($sql);
    }
    public function getBlockByIdColumn($id_column, $id_lang = false)
    {
        $context = Context::getContext();
        if(!$id_lang)
            $id_lang = $context->language->id;
        $sql = "
            SELECT * FROM "._DB_PREFIX_."ybc_mm_block b
            LEFT JOIN "._DB_PREFIX_."ybc_mm_block_lang bl ON b.id_block = bl.id_block
            WHERE bl.id_lang = ".$id_lang." AND b.id_column=$id_column
            ORDER BY b.sort_order asc, b.id_block asc
        ";
        return Db::getInstance()->executeS($sql);
    }
    public function getColumnsDropdown()
    {        
        $menus = $this->getMenus();
        $tree = array();
        if($menus)
        {
            foreach($menus as $menu)
            {
                $columns = $this->getColumnByIdMenu($menu['id_menu']);
                if($columns)
                {
                    $tree[] = array('id_column'=>-(int)$menu['id_menu'],'title'=> Tools::strtoupper($this->l('Menu: ').$menu['title']));
                    foreach($columns as $column)
                    {
                        $tree[] = array('id_column'=>$column['id_column'], 'title' => '-- '.Tools::ucfirst($column['title']));
                    }
                }
            }
        }
        $firstElement = array('id_column'=>0,'title'=>$this->l('Choose a column'));
        
        if($tree)
        {
            array_unshift($tree, $firstElement);
            return $tree;  
        }
        else
            return $firstElement;
    }
    public function getMenusDropdown()
    {
        $menus = $this->getMenus();
        $firstElement = array('id_menu'=>0,'title'=>$this->l('Choose a menu'));
        
        if($menus)
         {
            array_unshift($menus, $firstElement);
            return $menus;  
         }
        else
            return $firstElement;
    }

    public function getMenuFieldsValues($formFields, $primaryKey, $objClass, $saveBtnName)
	{
		$fields = array();

		if (Tools::isSubmit($primaryKey))
		{
			$obj = new $objClass((int)Tools::getValue($primaryKey));
			$fields[$primaryKey] = (int)Tools::getValue($primaryKey, $obj->$primaryKey);            
		}
		else
        {
            $obj = new $objClass();
        }
        
        foreach($formFields as $field)
        {
            if(!isset($field['primary_key']) && !isset($field['multi_lang']) && !isset($field['connection']))
            {
                $fieldName = (string)$field['name'];
                $fields[$field['name']] = trim(Tools::getValue($field['name'], (string)$obj->$fieldName)); 
            }
        }
        
        $languages = Language::getLanguages(false);
        
        /**
         *  Default
         */
        
        if(!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey))
        {
            foreach($formFields as $field)
            {
                if(isset($field['default']) && !isset($field['multi_lang']))
                {
                    if(isset($field['default_submit']))
                        $fields[$field['name']] = (int)Tools::getValue($field['name']) ? (int)Tools::getValue($field['name']) : $field['default'];
                    else
                        $fields[$field['name']] = $field['default'];
                }
            }
        }
        
        /**
         * Multiple language 
         */
		foreach ($languages as $lang)
		{
		    foreach($formFields as $field)
            {
                if(!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey))
                {
                    if(isset($field['multi_lang']))
                    {
                        if(isset($field['default']))
                            $fields[$field['name']][$lang['id_lang']] = $field['default'];
                        else
                            $fields[$field['name']][$lang['id_lang']] = '';
                    }
                }
                elseif(Tools::isSubmit($saveBtnName))
                {
                    if(isset($field['multi_lang']))
                        $fields[$field['name']][$lang['id_lang']] = Tools::getValue($field['name'].'_'.(int)$lang['id_lang']);   
                }
                else{                    
                    if(isset($field['multi_lang']))
                    {
                        $fieldName = (string)$field['name'];
                        $field_langs = $obj->$fieldName;                        
                        $fields[$field['name']][$lang['id_lang']] = $field_langs[$lang['id_lang']];
                    }                        
                }                
            }
		} 
        $fields['control'] = trim(Tools::getValue('control')) ? trim(Tools::getValue('control')) : '';
        
        //Get block valules
        if($primaryKey=='id_block')
        {
            if(!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey))
            {
                $fields['categories_list_include_sub'] = 1;
                //$fields['html_block'] = '';
                $fields['custom_link_label'] = '';
                $fields['custom_link'] = '';
            }
            if(Tools::isSubmit($saveBtnName) || Tools::isSubmit($primaryKey))
            {
                $fields['params'] = $this->getBlockFields((int)Tools::getValue('id_block'));
                
                $fields['categories_list_include_sub'] = (int)Tools::getValue('categories_list_include_sub',$fields['params']['CATEGORY']['categories_list_include_sub']);
                //$fields['html_block'] = trim(Tools::getValue('html_block',$fields['params']['HTML']));
                $fields['custom_link_label'] = trim(Tools::getValue('custom_link_label',$fields['params']['CUSTOM']['label']));
                $fields['custom_link'] = trim(Tools::getValue('custom_link',$fields['params']['CUSTOM']['link']));;
                
            }
        }
        
		return $fields;
	}
    function getMenuData($field)
    {        
        if(Tools::isSubmit('saveMenu'))
            return $field == 'id_category' ?  Tools::getValue('id_parent') : Tools::getValue($field);
        $id_menu = (int)Tools::getValue('id_menu');
        if($id_menu && $this->itemExists('menu','id_menu',$id_menu))
        {
            $menu = new Ybc_megamenu_class($id_menu);
            return $menu->$field;
        }
        return 0;
    }
    function getBlockFields($id_block = 0)
    {
        $params['CATEGORY'] = array('categories_list_include_sub'=>1,'categories' => array());
        $params['PRODUCT'] = array();
        $params['CMS'] = array();
        $params['MNFT'] = array();
        $params['CUSTOM'] = array('label'=>'', 'link'=>'');
        $params['HTML'] = '';
        if($this->itemExists('block','id_block',$id_block))
        {
            $block = new Ybc_megamenu_block_class($id_block);
            if(!empty($block->params))
            {                 
                $temp = @unserialize($block->params);                
                if($temp)
                    $params = $temp;
            }            
        }
        return $params;
    }
    /**
     * Cache methods 
     */
    private function _setMenuCache($data, $id_lang)
    {
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        $language = new Language($id_lang);
        $cache = new Ybc_megamenu_cache_class();
        $cache->set('menu_'.$language->iso_code,$data);
    }
    private function _getMenuCache($id_lang = false)
    {
        if(!$id_lang)
            $id_lang = $this->context->language->id;
        $language = new Language($id_lang);
        $cache = new Ybc_megamenu_cache_class();
        $data = $cache->get('menu_'.$language->iso_code);
        if(!$data)
        {
            $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $data = $cache->get('menu_'.$language->iso_code);
        }            
        return $data;
    }
    private function _useMenuCache()
    {
        return (int)Configuration::get('YBC_MM_USE_CACHE') ? true : false;    
    }
    private function _refeshMenuCache()
    {
        if($this->_useMenuCache())
        {
            $languages = Language::getLanguages(false);
            if($languages)
            {
                foreach($languages as $lang)
                {
                    $menuData = $this->getMenuArg($lang['id_lang']);
                    $this->_setMenuCache($menuData, (int)$lang['id_lang']);
                }                    
            }            
        }
    }
    /**
     * Install DB 
     */
     private function _installDb()
     {
        $sqlResult = Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_block` (
              `id_block` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `id_column` int(11) DEFAULT NULL,
              `block_type` varchar(50) DEFAULT NULL,              
              `params` text CHARACTER SET utf8,
              `show_title` tinyint(1) NOT NULL DEFAULT '0',
              `show_description` tinyint(1) NOT NULL DEFAULT '0',
              `show_image` tinyint(1) NOT NULL DEFAULT '1',
              `image` varchar(500) DEFAULT NULL,
              `enabled` tinyint(1) NOT NULL DEFAULT '1',
              `custom_class` varchar(50) NOT NULL,
              `block_link` varchar(500) NOT NULL,
              `sort_order` int(11) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id_block`)
            )");
        $sqlResult &= Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_block_lang` (
              `id_block` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `title` varchar(500) DEFAULT NULL,
              `description` text DEFAULT NULL,
              `html_block` text DEFAULT NULL,
              PRIMARY KEY (`id_block`,`id_lang`)
            ) ");
        $sqlResult &= Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_column` (
              `id_column` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `id_menu` int(11) DEFAULT NULL,
              `enabled` tinyint(1) NOT NULL,
              `column_link` varchar(500) DEFAULT NULL,
              `show_title` tinyint(1) NOT NULL DEFAULT '0',
              `show_description` tinyint(1) NOT NULL DEFAULT '0',
              `custom_class` varchar(100) DEFAULT NULL,
              `column_size` varchar(50) DEFAULT NULL,
              `image` varchar(500) DEFAULT NULL,
              `show_image` tinyint(1) NOT NULL DEFAULT '1',
              `sort_order` int(11) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id_column`)
            )
        ");
        $sqlResult &= Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_column_lang` (
              `id_column` int(11) NOT NULL DEFAULT '0',
              `id_lang` int(11) NOT NULL DEFAULT '0',
              `title` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
              `description` text CHARACTER SET utf8,
              PRIMARY KEY (`id_column`,`id_lang`)
            )
        ");
        $sqlResult &= Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_menu` (
              `id_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `menu_type` varchar(50) DEFAULT NULL,
              `link` varchar(500) DEFAULT NULL,
              `id_cms` int(11) DEFAULT NULL,
              `id_manufacturer` int(11) DEFAULT NULL,
              `id_category` int(11) DEFAULT NULL,
              `column_type` varchar(100) DEFAULT NULL,
              `sub_menu_max_width` varchar(50) DEFAULT NUll,
              `color1` varchar(50) DEFAULT NULL,
              `color2` varchar(50) DEFAULT NULL,
              `color3` varchar(50) DEFAULT NULL,
              `color4` varchar(50) DEFAULT NULL,
              `color5` varchar(50) DEFAULT NULL,
              `color6` varchar(50) DEFAULT NULL,
              `sub_type` varchar(50) DEFAULT NULL,
              `wrapper_border` tinyint(4) NOT NULL DEFAULT '1',
              `banner_position` varchar(50) DEFAULT NULL,
              `banner_link` varchar(500) DEFAULT NULL,
              `image` varchar(500) DEFAULT NULL,
              `custom_class` varchar(100) DEFAULT NULL,
              `enabled` tinyint(1) NOT NULL DEFAULT '1',
              `icon` varchar(1000) DEFAULT NULL,
              `icon_image` varchar(1000) DEFAULT NULL,
              `show_icon` tinyint(4) NOT NULL DEFAULT '1',
              `sort_order` int(11) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id_menu`)
            )
        ");
        $sqlResult &= Db::getInstance()->execute("
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_mm_menu_lang` (
              `id_menu` int(11) NOT NULL DEFAULT '0',
              `id_lang` int(11) NOT NULL DEFAULT '0',
              `title` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
              PRIMARY KEY (`id_menu`,`id_lang`)
            )
        ");
        $sqlResult &= Configuration::updateValue('YBC_MM_TRANSITION_EFFECT', 'SLIDE');
        $sqlResult &= Configuration::updateValue('YBC_MM_SKIN', 'custom');     
        $sqlResult &= Configuration::updateValue('YBC_MM_TYPE', 'light');    
        $sqlResult &= Configuration::updateValue('YBC_MM_ARROW', 0);    
        $sqlResult &= Configuration::updateValue('YBC_MOBILE_MM_TYPE', 'default');    
        $sqlResult &= Configuration::updateValue('YBC_MM_CUSTOM_CLASS', '');
        $sqlResult &= Configuration::updateValue('YBC_MM_FIXED', 0);
        $sqlResult &= Configuration::updateValue('YBC_MM_FIXED_FULL', 1);
        $sqlResult &= Configuration::updateValue('YBC_MM_DIR', 'auto');
        $sqlResult &= Configuration::updateValue('YBC_MM_CUSTOM_COLOR', '');
        $sqlResult &= Configuration::updateValue('YBC_MM_CUSTOM_COLOR_HOVER', '');
        $sqlResult &= Configuration::updateValue('YBC_MM_CUSTOM_TEXT_COLOR', '');
        $sqlResult &= Configuration::updateValue('YBC_MM_CUSTOM_BORDER_COLOR', '#ffffff');
        $sqlResult &= Configuration::updateValue('YBC_MM_USE_CACHE', 0);
        $sqlResult &= Configuration::updateValue('YBC_MM_SHOW_IMAGE_ON_MOBILE', 1);
        
       
        
        //Empty custom css file
        $cssFile = dirname(__FILE__).'/css/front_custom.css';
        if(file_exists($cssFile) && is_writable($cssFile))
        {
            file_put_contents($cssFile,'');
        }
        //Delete cache files
        $files = glob(dirname(__FILE__).'/cache/*'); // get all file names
        if($files)
        {
            foreach($files as $file){ // iterate files
              if(is_file($file))
                @unlink($file); // delete file
            }   
        }  
        
        //Install sample data
        if($sqlResult)
        {
           $this->installSample();              
        }
        return $sqlResult;
     }
     private function installSample()
     {       
       $languages = Language::getLanguages(false);
       $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
       $sqlFile = dirname(__FILE__).'/data/sql/menu.sql';       
       if(file_exists($sqlFile) && ($sql = @Tools::file_get_contents($sqlFile)))
       {
            $tbs = array('ybc_mm_menu','ybc_mm_menu_lang','ybc_mm_column','ybc_mm_column_lang','ybc_mm_block','ybc_mm_block_lang');
            foreach($tbs as $tbl)
            {
                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_.$tbl);
            }            
            if(!$this->parseSql($sql))
            {
                $sqlLangFile = dirname(__FILE__).'/data/sql/menu_lang.sql';
                if(file_exists($sqlLangFile) && ($sql = @Tools::file_get_contents($sqlLangFile)) && $languages)
                { 
                   
                    foreach($languages as $lang)
                    {
                        $subsql = str_replace('_ID_LANG_',$lang['id_lang'],$sql);                                
                        $this->parseSql($subsql);
                    }
                }
            }
            
       }
       if($oldFiles = glob(dirname(__FILE__).'/images/menu/*'))
        {
            foreach($oldFiles as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        } 
        if($oldFiles = glob(dirname(__FILE__).'/images/column/*'))
        {
            foreach($oldFiles as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }  
        if($oldFiles = glob(dirname(__FILE__).'/images/block/*'))
        {
            foreach($oldFiles as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }
        $this->copyDir(dirname(__FILE__).'/data/img/menu/',dirname(__FILE__).'/images/menu/');
        $this->copyDir(dirname(__FILE__).'/data/img/column/',dirname(__FILE__).'/images/column/');
        $this->copyDir(dirname(__FILE__).'/data/img/block/',dirname(__FILE__).'/images/block/'); 
     }
     private function copyDir($src,$dst) { 
        if(file_exists($src) && file_exists($dst) && is_dir($src) && is_dir($dst))
        {
            $dir = opendir($src); 
            @mkdir($dst); 
            while(false !== ( $file = readdir($dir)) ) { 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    if ( is_dir($src . '/' . $file) ) { 
                        recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                    } 
                    else { 
                        copy($src . '/' . $file,$dst . '/' . $file); 
                    } 
                } 
            } 
            closedir($dir); 
        }
        
    } 
     
     /**
      * Uninstall Db 
      */
      
     private function _uninstallDb()
     {
        $sqlResult = Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'ybc_mm_block`, `'._DB_PREFIX_.'ybc_mm_block_lang`, `'._DB_PREFIX_.'ybc_mm_column`, `'._DB_PREFIX_.'ybc_mm_column_lang`, `'._DB_PREFIX_.'ybc_mm_menu`, `'._DB_PREFIX_.'ybc_mm_menu_lang`;
		');        
        $sqlResult &= Configuration::deleteByName('YBC_MM_TRANSITION_EFFECT');
        $sqlResult &= Configuration::deleteByName('YBC_MM_SKIN');
        $sqlResult &= Configuration::deleteByName('YBC_MM_TYPE');
        $sqlResult &= Configuration::deleteByName('YBC_MOBILE_MM_TYPE');
        $sqlResult &= Configuration::deleteByName('YBC_MM_CUSTOM_CLASS');
        $sqlResult &= Configuration::deleteByName('YBC_MM_FIXED_FULL');
        $sqlResult &= Configuration::deleteByName('YBC_MM_FIXED');
        $sqlResult &= Configuration::deleteByName('YBC_MM_DIR');
        $sqlResult &= Configuration::deleteByName('YBC_MM_ARROW');
        $sqlResult &= Configuration::deleteByName('YBC_MM_CUSTOM_COLOR');
        $sqlResult &= Configuration::deleteByName('YBC_MM_CUSTOM_COLOR_HOVER');
        $sqlResult &= Configuration::deleteByName('YBC_MM_CUSTOM_TEXT_COLOR');
        $sqlResult &= Configuration::deleteByName('YBC_MM_CUSTOM_BORDER_COLOR');
        $sqlResult &= Configuration::deleteByName('YBC_MM_USE_CACHE');
        $sqlResult &= Configuration::deleteByName('YBC_MM_SHOW_IMAGE_ON_MOBILE');
        //Empty custom css file
        $cssFile = dirname(__FILE__).'/css/front_custom.css';
        if(file_exists($cssFile) && is_writable($cssFile))
        {
            file_put_contents($cssFile,'');
        }
        //Delete cache files
        $files = glob(dirname(__FILE__).'/cache/*'); // get all file names
        if($files)
        {
            foreach($files as $file){ // iterate files
              if(is_file($file))
                @unlink($file); // delete file
            }   
        }        
        return $sqlResult;
     }
     /**
      * Delete menu data 
      */
     function _clearData()
     {
        $menus = $this->getMenus();
        if($menus)
        {
            foreach($menus as $menus)
            {
                $this->_deleteMenu((int)$menus['id_menu']);
            }
        }
        return true;
     }
      
    /**
     * Hooks 
     */
    public function hookDisplayYbcReviews($params)
    {        
       /* if(Module::isInstalled('productcomments') && Module::isEnabled('productcomments'))
        {
            $id_product = (int)$params['product']['id_product'];
    		require_once(dirname(__FILE__).'/../productcomments/ProductComment.php');
    		$average = ProductComment::getAverageGrade($id_product);
    		$this->smarty->assign(array(
    			'averageTotal' => round($average['grade']),
    			'ratings' => ProductComment::getRatings($id_product),
    			'nbComments' => (int)ProductComment::getCommentNumber($id_product)
    		));
    		return $this->display(__FILE__, 'productcomments_reviews.tpl');
        }
        return;*/
    }
    public function hookDisplayBackOfficeHeader()
    {        
        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/css/admin.css', 'all');        
    }
    public function hookDisplayTop()
    {
        $languages = Language::getLanguages(false);
        if($this->_useMenuCache())
            $menus = $this->_getMenuCache($this->context->language->id);
        else
            $menus = $this->getMenuArg($this->context->language->id);
        
        if(!$menus && $this->_useMenuCache())
        {
            $menus = $this->getMenuArg($this->context->language->id);
            if($languages)
            {
                foreach($languages as $lang)
                {
                    $menuData = $this->getMenuArg($lang['id_lang']);
                    $this->_setMenuCache($menuData, (int)$lang['id_lang']);
                }                    
            }
            
        }
        if(!$menus)
        {
            if($this->_useMenuCache())
                $menus = $this->_getMenuCache((int)Configuration::get('PS_LANG_DEFAULT'));
            else
                $menus = $this->getMenuArg((int)Configuration::get('PS_LANG_DEFAULT'));
        }    
        
        
        $this->smarty->assign(
            array(
                'YBC_MM_TYPE' => Tools::strtolower(trim(Configuration::get('YBC_MM_TYPE'))),
                'YBC_MM_ARROW' => (int)Configuration::get('YBC_MM_ARROW') ? 1 : 0,
                'YBC_MOBILE_MM_TYPE' => Tools::strtolower(trim(Configuration::get('YBC_MOBILE_MM_TYPE'))),
                'YBC_MM_DIRECTION' => $this->directionClass,
                'menus' => $menus,
                'effect'=>Tools::strtolower(Configuration::get('YBC_MM_TRANSITION_EFFECT')),
                'customClass' => Configuration::get('YBC_MM_CUSTOM_CLASS'),
                'fixedPosition' => (int)Configuration::get('YBC_MM_FIXED') ? 1 : 0,
                'fixedPositionFull' => (int)Configuration::get('YBC_MM_FIXED_FULL') ? 1 : 0,
                'mobileImage' => Configuration::get('YBC_MM_SHOW_IMAGE_ON_MOBILE'),
                'YBC_MM_SKIN' => Tools::strtolower(trim(Configuration::get('YBC_MM_SKIN'))),                
            )
        );
        return $this->display(__FILE__, 'ybc_megamenu_top.tpl');
    }
    
    
    
    public function hookcustom()
    {
        $languages = Language::getLanguages(false);
        if($this->_useMenuCache())
            $menus = $this->_getMenuCache($this->context->language->id);
        else
            $menus = $this->getMenuArg($this->context->language->id);
        
        if(!$menus && $this->_useMenuCache())
        {
            $menus = $this->getMenuArg($this->context->language->id);
            if($languages)
            {
                foreach($languages as $lang)
                {
                    $menuData = $this->getMenuArg($lang['id_lang']);
                    $this->_setMenuCache($menuData, (int)$lang['id_lang']);
                }                    
            }
            
        }
        if(!$menus)
        {
            if($this->_useMenuCache())
                $menus = $this->_getMenuCache((int)Configuration::get('PS_LANG_DEFAULT'));
            else
                $menus = $this->getMenuArg((int)Configuration::get('PS_LANG_DEFAULT'));
        }    
        
        
        $this->smarty->assign(
            array(
                'YBC_MM_TYPE' => Tools::strtolower(trim(Configuration::get('YBC_MM_TYPE'))),
                'YBC_MM_ARROW' => (int)Configuration::get('YBC_MM_ARROW') ? 1 : 0,
                'YBC_MOBILE_MM_TYPE' => Tools::strtolower(trim(Configuration::get('YBC_MOBILE_MM_TYPE'))),
                'YBC_MM_DIRECTION' => $this->directionClass,
                'menus' => $menus,
                'effect'=>Tools::strtolower(Configuration::get('YBC_MM_TRANSITION_EFFECT')),
                'customClass' => Configuration::get('YBC_MM_CUSTOM_CLASS'),
                'fixedPosition' => (int)Configuration::get('YBC_MM_FIXED') ? 1 : 0,
                'fixedPositionFull' => (int)Configuration::get('YBC_MM_FIXED_FULL') ? 1 : 0,
                'mobileImage' => Configuration::get('YBC_MM_SHOW_IMAGE_ON_MOBILE'),
                'YBC_MM_SKIN' => Tools::strtolower(trim(Configuration::get('YBC_MM_SKIN'))),                
            )
        );
        return $this->display(__FILE__, 'ybc_megamenu.tpl');
    }
    
    
    
    
    
    
    
    public function hookdisplayHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'css/ybc_megamenu.css','all');
        $this->context->controller->addCSS($this->_path.'css/front_custom.css','all');
        if($this->directionClass=='ybc-dir-rtl')
            $this->context->controller->addCSS($this->_path.'css/ybc_megamenu_rtl.css','all');   
        $this->context->controller->addJS($this->_path.'js/ybc_megamenu.js'); 
        $css = $this->renderSubmenuCss();
        if(Tools::strtolower(trim(Configuration::get('YBC_MM_SKIN')))== 'custom')
            $css .= $this->renderCustomCss();       
        return $css;
    }
    
    private function renderCustomCss()
    {
        $color1 = Configuration::get('YBC_MM_CUSTOM_COLOR');
        $color2 = Configuration::get('YBC_MM_CUSTOM_COLOR_HOVER');      
        $color3 = Configuration::get('YBC_MM_CUSTOM_TEXT_COLOR');      
        $color4 = Configuration::get('YBC_MM_CUSTOM_BORDER_COLOR');   
        $color4 = Configuration::get('YBC_MM_CUSTOM_BORDER_COLOR');  
        $color_sub_hover = Configuration::get('color3');
        $css = '<style>';
        //Custom css here
        $css .= '
        
        @media (min-width:768px)
        {
            .ybc-menu-skin-custom #ybc-menu-main-content,
            .fixed-full.position-fixed-scroll.ybc-menu-skin-custom
            {
                background-color: '.$color1.';            
            }

            .ybc-menu-layout-classic.ybc-menu-skin-custom .ybc-menu > .ybc-menu-item:hover .ybc-menu-item-link,
            .ybc-menu-layout-classic.ybc-menu-skin-custom .ybc-menu > .ybc-menu-item.active .ybc-menu-item-link {
              color:'.$color2.';
            }
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > .ybc-menu-item:hover .ybc-menu-item-link,
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > .ybc-menu-item:hover .ybc-menu-item-link,
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > .ybc-menu-item:hover .ybc-menu-item-no-link,
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > .ybc-menu-item:hover .ybc-menu-item-no-link         
             {
              background-color: '.$color2.';
             }
             .ybc-menu-skin-custom  #ybc-menu-main-content .ybc-mm-control-content .ybc-menu-block-links  li a:hover
            {
                color:'.$color_sub_hover.';
            }
            
            .ybc-menu-layout-default.ybc-menu-skin-custom .ybc-menu:before,
            .ybc-menu-layout-default.fixed-full.position-fixed-scroll.ybc-menu-skin-custom:before{
                background-color: '.$color4.';
            }
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item .ybc-menu-item-link,
            .ybc-dir-rtl.ybc-menu-layout-default.fixed-full.position-fixed-scroll.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > li:first-child > .ybc-menu-item-link
            {
                border-right-color: '.$color4.';
            }    
            .ybc-dir-rtl.ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item .ybc-menu-item-link
            {
                border-left-color: '.$color4.';
                border-right: none;
            } 
            .ybc-menu-layout-default.fixed-full.position-fixed-scroll.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu > li:first-child > .ybc-menu-item-link
            {
                border-left-color: '.$color4.';
            } 
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link,
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link,
            .ybc-menu-layout-classic.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link,
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link i,
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link i,
            .ybc-menu-layout-classic.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-link i,
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link,
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link,
            .ybc-menu-layout-classic.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link,
            .ybc-menu-layout-default.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link i,
            .ybc-menu-layout-light.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link i,
            .ybc-menu-layout-classic.ybc-menu-skin-custom #ybc-menu-main-content .ybc-menu-item  .ybc-menu-item-no-link i
            {
                color:'.$color3.';
            }
            .ybc-menu-skin-custom .ybc-ul-category li:hover >.ybc-mm-control::before,
            .ybc-menu-skin-custom .ybc-sub-categories li:hover >.ybc-mm-control::before
            {
                color:'.$color1.';
            }
            .ybc-menu-layout-light.ybc-menu-skin-custom .ybc-menu .ybc-menu-item 
            {
               /* border-right: 1px solid '.$color2.';*/
                box-shadow: none;                
            }
                        
        }
         
        @media (max-width: 767px)
        {
            .ybc-menu-wrapper.ybc-menu-skin-custom .ybc-menu-main-content {
              background-color:'.$color1.';
            }
            .ybc-menu-layout-default.ybc-menu-skin-custom  .ybc-menu-main-content {              
              border-bottom:none;
            }            
            .ybc-menu-skin-custom .ybc-sub-menu-header span:first-child    
            {
                background-color:'.$color1.'; 
            }
            .ybc-menu-skin-custom  #ybc-menu-main-content            
            {
                border-color: '.$color1.';
            }
            
            
        }        
        ';
        
        $css .= '</style>';
        return $css;
    }
    public function getMenuListLevel1($active = true)
    {
        $sql = "SELECT * FROM "._DB_PREFIX_."ybc_mm_menu".($active ? " WHERE enabled = 1" : "");
        return Db::getInstance()->executeS($sql);
    }
    public function getCategoriesTree($id_parent, &$level)
    {   
        $html = '';               
        if($id_parent)
        {
            
            $sql = "SELECT c.id_category, cl.name
                    FROM "._DB_PREFIX_."category c 
                    LEFT JOIN "._DB_PREFIX_."category_lang cl ON c.id_category = cl.id_category AND cl.id_lang = ".$this->context->language->id." 
                    WHERE c.active = 1 AND c.id_parent = ".$id_parent.' GROUP BY c.id_category';
            if($categories = Db::getInstance()->executeS($sql))
            {
                $level++; 
                $html = '<ul class="ybc-ul-category ybc-mm-control-content ybc-sub-categories category-sub-level-'.$level.'">';
                foreach($categories as $category)
                {
                    $subcat = $this->getCategoriesTree($category['id_category'], $level);
                    $cat = new Category((int)$category['id_category'],(int)$this->context->language->id);
                    $html .= '<li><a href="'.$cat->getLink().'">'.$category['name'].'</a>'.($subcat ? '<span class="ybc-mm-control closed"></span>' : '').$subcat.'</li>';                    
                }
                $html .= '</ul>';
                $level--;
            }
        }
        return $html;
    }
    private function renderSubmenuCss()
    {
        $css = '<style> @media (min-width: 768px){';
        $menus = $this->getMenuListLevel1(true); 
        for($i = 1; $i<=12; $i++)
        {
            $css .= '.ybc-menu-column-size-'.$i.'_12{width: '.((string)(round($i/12*100,4))).'%;}';
        }       
        if($menus)
        {            
            foreach($menus as $menu)
            {
                $css .= $menu['color1'] ? '#ybc-menu-'.$menu['id_menu'].' h6, #ybc-menu-'.$menu['id_menu'].' .ybc-menu-columns-wrapper h6 a{color: '.$menu['color1'].';} ' : '';
                $css .= $menu['color2'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-menu-block-bottom, #ybc-menu-'.$menu['id_menu'].' .ybc-menu-block p, #ybc-menu-'.$menu['id_menu'].' .ybc_description_block p, #ybc-menu-'.$menu['id_menu'].' .ybc_description_block, #ybc-menu-'.$menu['id_menu'].' .ybc-menu-columns-wrapper a{color: '.$menu['color2'].';} ' : '';
                $css .= $menu['color3'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-menu-columns-wrapper a:hover, #ybc-menu-'.$menu['id_menu'].'.ybc-menu-sub-type-custom .ybc-menu-columns-wrapper .ybc-ul-category li:hover > span.ybc-mm-control:before, #ybc-menu-'.$menu['id_menu'].'.ybc-menu-sub-type-custom li.ybc-no-product-block:hover > a, #ybc-menu-'.$menu['id_menu'].'.ybc-menu-sub-type-custom li.ybc-no-product-block li:hover > a, #ybc-menu-'.$menu['id_menu'].'.ybc-menu-sub-type-custom .ybc-menu-block-custom-html li:hover > a {color: '.$menu['color3'].';} ' : '';
                $css .= $menu['color4'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-mm-price{color: '.$menu['color4'].';} ' : '';
                $css .= $menu['color4'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-mm-discount-percent{background: '.$menu['color4'].';} ' : '';
                $css .= $menu['color5'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-menu-block-bottom ul li, #ybc-menu-'.$menu['id_menu'].' h6, #ybc-menu-'.$menu['id_menu'].' .ybc-mm-product-img-link, #ybc-menu-'.$menu['id_menu'].' .ybc-menu-columns-wrapper{border-color: '.$menu['color5'].';} ' : '';
                $css .= $menu['color6'] ? '#ybc-menu-'.$menu['id_menu'].' .ybc-menu-columns-wrapper, #ybc-menu-'.$menu['id_menu'].' .ybc-menu-has-sub.ybc-menu-item:hover .ybc-menu-item-link:before, #ybc-menu-'.$menu['id_menu'].' .ybc-ul-category.ybc-mm-control-content.ybc-sub-categories{background: '.$menu['color6'].';} .ybc-menu-wrapper #ybc-menu-main-content #ybc-menu-'.$menu['id_menu'].' .ybc-menu-item-link:after, .ybc-menu-wrapper #ybc-menu-main-content #ybc-menu-'.$menu['id_menu'].' .ybc-menu-item-no-link:after{border-bottom-color: '.$menu['color6'].';} ' : '';
                
            }            
        }
        $css .= '}</style>';
        return $css;
    }
    public function parseSql($sql)
    {
        $errors = array();
        $sql = str_replace('_DB_PREFIX_',_DB_PREFIX_, $sql);
        $queries = preg_split('#;\s*[\r\n]+#', $sql);
        foreach ($queries as $query) {
            $query = trim($query);
            if (!$query) {
                continue;
            }                
            if (!Db::getInstance()->execute($query)) {
                $errors[] = Db::getInstance()->getMsgError();
            }
        }
        return $errors;
    }
}