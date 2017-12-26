<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
include_once(_PS_MODULE_DIR_.'ybc_widget/classes/ybc_widget_widget_class.php');
if (!defined('_PS_VERSION_'))
	exit;
/**
 * Includes 
 */   
class Ybc_widget extends Module
{
    private $baseAdminPath;
    private $errorMessage = false;
    private $_html;    
    private $widgetFields = array(
        array(
            'name' => 'id_widget',
            'primary_key' => true
        ),
        array(
            'name' => 'title',
            'multi_lang' => true
        ),
        array(
            'name' => 'subtitle',
            'multi_lang' => true
        ),
        array(
            'name' => 'description',            
            'multi_lang' => true
        ),
        array(
            'name' => 'link'
        ), 
        array(
            'name' => 'icon'
        ),         
        array(
            'name' => 'image'
        ),
        array(
            'name' => 'hook'
        ),
        array(
            'name' => 'enabled',
            'default' => 1
        ),
        array(
            'name' => 'show_title',
            'default' => 1
        ),
        array(
            'name' => 'show_image',
            'default' => 1
        ),        
        array(
            'name' => 'show_description',
            'default' => 1
        ),
    );
    private $_hooks = array();
    public function __construct()
	{	   
		$this->name = 'ybc_widget';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('HTML widgets');
		$this->description = $this->l('Add custom HTML widgets to various postions on frontend');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        
        $this->_hooks = array(
            
            array(
                'hook' => 'displayTopColumn',
                'name' => $this->l('Hook Top Column')
            ),
            
            array(
                'hook' => 'displayHome',
                'name' => $this->l('Hook Home')
            ),
            array(
                'hook' => 'displayNav',
                'name' => $this->l('Hook Top Navigation')
            ),
            array(
                'hook' => 'displayTop',
                'name' => $this->l('Hook Top')
            ),
            array(
                'hook' => 'displayLeftColumn',
                'name' => $this->l('Hook Left Column')
            ),
            array(
                'hook' => 'displayRightColumn',
                'name' => $this->l('Hook Right Column')
            ),
            array(
                'hook' => 'displayFooter',
                'name' => $this->l('Hook Footer')
            ),
            array(
                'hook' => 'ybcCustom1',
                'name' => $this->l('Hook Custom 1')
            ),
            array(
                'hook' => 'ybcCustom2',
                'name' => $this->l('Hook Custom 2')
            ), 
            array(
                'hook' => 'ybcCustom3',
                'name' => $this->l('Hook Custom 3')
            ),
            array(
                'hook' => 'ybcCustom4',
                'name' => $this->l('Hook Custom 4')
            ),           
            array(
                'hook' => 'ybcCustom5',
                'name' => $this->l('Hook Custom 5')
            ),
            array(
                'hook' => 'ybcCustom6',
                'name' => $this->l('Hook Custom 6')
            ),
            
            
            
        );
        
        if(isset($this->context->controller->controller_type) && $this->context->controller->controller_type =='admin')
            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;        
     }
     /**
	 * @see Module::install()
	 */
    public function install()
	{
	    $res = parent::install();        
        foreach($this->_hooks as $hook)
        {
            $res &= $this->registerHook($hook['hook']);
        }      
        $res &= $this->registerHook('displayBackOfficeHeader') && $this->registerHook('displayHeader') && $this->_installDb();        
        return  $res;
    }
    public function _installDb()
    {
        $tbls = array(
            "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_widget_widget` (
              `id_widget` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `hook` varchar(200) DEFAULT NULL,
              `enabled` tinyint(1) NOT NULL DEFAULT '1',
              `show_title` tinyint(1) NOT NULL DEFAULT '1',
              `show_image` tinyint(1) NOT NULL DEFAULT '1',
              `show_description` tinyint(1) NOT NULL DEFAULT '1',
              `image` varchar(500) DEFAULT NULL,
              `icon` varchar(200) DEFAULT NULL,
              `link` varchar(500) DEFAULT NULL,
              `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
              PRIMARY KEY (`id_widget`)
            )",
            "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_widget_widget_lang` (
              `id_widget` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `title` varchar(5000) CHARACTER SET utf8 NOT NULL,
              `subtitle` varchar(5000) CHARACTER SET utf8,
              `description` text CHARACTER SET utf8
            )
            "
        );
        foreach($tbls as $tbl)
            Db::getInstance()->execute($tbl);
        
        //Install sample data
        $this->installSample();   
        return true;
    }
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
        return parent::uninstall() && $this->_uninstallDb();
    }
    private function _uninstallDb()
    { 
        $tbls = array('widget', 'widget_lang');
        foreach($tbls as $tbl)
        {
            Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'ybc_widget_'.$tbl.'`');
        }        
        $dirs = array('widget');
        foreach($dirs as $dir)
        {
            $files = glob(dirname(__FILE__).'/images/'.$dir.'/*'); 
            foreach($files as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }        
        return true;
    }
    public function getContent()
	{
	   if(Tools::isSubmit('reorder'))
       {
            $this->_updateOrders();
            die(Tools::jsonEncode(array('updated' => 'true')));
       }
	   $control = trim(Tools::getValue('control'));
       if(!$control)
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');
       if($control == 'main')
            $this->context->controller->addJqueryUI('ui.sortable');
       //Process widget
       $this->_html .= '<script type="text/javascript" src="'.$this->_path.'js/admin.js"></script>';       
       if($control=='widget')
       {
            $this->_postWidget();   
       }
       else
       {
            $this->_postMain();
       }
       //Display errors if have
       if($this->errorMessage)
            $this->_html .= $this->errorMessage;  
       if($control=='widget')
       {
            $this->renderWidgetForm();
       }
       else
       {
            $this->renderMainForm();
       }
       return $this->_html;
    }
    public function renderWidgetForm()
    {        
            $fields_form = array(
    			'form' => array(
    				'legend' => array(
    					'title' => (int)Tools::getValue('id_widget') ? $this->l('Edit widget') : $this->l('Add new widget'),
                        'icon' => 'icon-AdminAdmin'				
    				),
    				'input' => array(					
    					array(
    						'type' => 'text',
    						'label' => $this->l('Title'),
    						'name' => 'title',
    						'lang' => true,    
                            'required' => true                    
    					), 
                        array(
    						'type' => 'text',
    						'label' => $this->l('Sub Title'),
    						'name' => 'subtitle',
    						'lang' => true                  
    					), 
                        
                        array(
    						'type' => 'select',
    						'label' => $this->l('Hook'),
    						'name' => 'hook',    						    
                            'required' => true,
                            'options' => array(
                                 'query' => $this->_getHookOptions(),                             
                                 'id' => 'id_option',
                    			 'name' => 'name'  
                            )                    
    					),   
                        array(
    						'type' => 'textarea',
    						'label' => $this->l('Description'),
    						'name' => 'description',
    						'lang' => true,  
                            'autoload_rte' => true                      
    					),  
                        array(
    						'type' => 'text',
    						'label' => $this->l('Link'),
    						'name' => 'link',   
                            'desc' => $this->l('Eg: http://yourwebsite.com') 						              
    					),                    
                        array(
    						'type' => 'file',
    						'label' => $this->l('Image'),
    						'name' => 'image'					
    					),
                        array(
    						'type' => 'text',
    						'label' => $this->l('Awesome icon'),
    						'name' => 'icon',
                            'desc' => $this->l('Eg: fa-home, fa-phone')				
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
    		$helper->submit_action = 'saveWidget';
    		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
    		$helper->token = Tools::getAdminTokenLite('AdminModules');
    		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $fieldValues = $this->getFieldsValues($this->widgetFields,'id_widget','Ybc_widget_widget_class','saveWidget');
            
            $helper->tpl_vars = array(
    			'base_url' => $this->context->shop->getBaseURL(),
    			'language' => array(
    				'id_lang' => $language->id,
    				'iso_code' => $language->iso_code
    			),
                'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
    			'fields_value' => $fieldValues,
    			'languages' => $this->context->controller->getLanguages(),
    			'id_language' => $this->context->language->id,
    			'image_baseurl' => $this->_path.'images/',
                'link' => $this->context->link,
                'cancel_url' => $this->baseAdminPath.'&control=main',
                'add_url' => $this->baseAdminPath.'&control=widget'
    		);
            
            if(Tools::isSubmit('id_widget') && $this->itemExists('widget','id_widget',(int)Tools::getValue('id_widget')))
            {
                
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_widget');
                $widget = new Ybc_widget_widget_class((int)Tools::getValue('id_widget'));
                if($widget->image)
                {             
                    $helper->tpl_vars['display_img'] = $this->_path.'images/widget/'.$widget->image;
                    $helper->tpl_vars['img_del_link'] = $this->baseAdminPath.'&id_widget='.Tools::getValue('id_widget').'&delwidgetimage=true&control=widget';                
                }
            }
            
    		$helper->override_folder = '/';
    
    		$languages = Language::getLanguages(false);
            
            $this->_html .= $helper->generateForm(array($fields_form));	
    }    
    private function _getHookOptions()
    {
        $options = array();
        $options[] = array(
            'id_option' => '',
            'name' => $this->l('-- Choose a hook --')
        );
        foreach($this->_hooks as $hook)
        {
            $item = array(
                'id_option' => $hook['hook'],
                'name' => $hook['name']
            );
            $options[] = $item;
        }
        return $options;
    }
    private function _getHooks()
    {
        $hooks = array();
        foreach($this->_hooks as $hook)
        {
            $hooks[] = $hook['hook'];
        }
        return $hooks;
    }
    private function _postWidget()
    {
        $errors = array();
        $id_widget = (int)Tools::getValue('id_widget');
        if($id_widget && !$this->itemExists('widget','id_widget',$id_widget))
            Tools::redirectAdmin($this->baseAdminPath);
        /**
         * Change status 
         */
         if(Tools::isSubmit('change_enabled'))
         {
            $status = (int)Tools::getValue('change_enabled') ?  1 : 0;
            $id_widget = (int)Tools::getValue('id_widget');            
            if($id_widget)
            {
                $this->changeStatus('widget',$field,$id_widget,$status);
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');
            }
         }
        /**
         * Delete image 
         */         
         if($id_widget && $this->itemExists('widget','id_widget',$id_widget) && Tools::isSubmit('delwidgetimage'))
         {
            $widget = new Ybc_widget_widget_class($id_widget);
            if($widget->image)
            {
                $imgUrl = dirname(__FILE__).'/images/widget/'.$widget->image; 
                if(file_exists($imgUrl))
                {
                    @unlink($imgUrl);
                    $widget->image = '';
                    $widget->update();
                }
            }
            else
                $errors[] = $this->l('Image does not exist'); 
             
         }
        /**
         * Delete widget 
         */ 
         if(Tools::isSubmit('del'))
         {
            $id_widget = (int)Tools::getValue('id_widget');
            if(!$this->itemExists('widget','id_widget',$id_widget))
                $errors[] = $this->l('Widget does not exist');
            elseif($this->_deleteWidget($id_widget))
            {                
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');
            }                
            else
                $errors[] = $this->l('Could not delete the widget. Please try again');    
         }                  
        /**
         * Save widget 
         */
        if(Tools::isSubmit('saveWidget'))
        {            
            if($id_widget && $this->itemExists('widget','id_widget',$id_widget))
            {
                $widget = new Ybc_widget_widget_class($id_widget);
            }
            else
            {
                $widget = new Ybc_widget_widget_class();
                $widget->sort_order = 1;                                   
            }                
            $widget->enabled = trim(Tools::getValue('enabled',1)) ? 1 : 0;
            $widget->show_title = trim(Tools::getValue('show_title',1)) ? 1 : 0;
            $widget->show_image = trim(Tools::getValue('show_image',1)) ? 1 : 0;
            $widget->show_description = trim(Tools::getValue('show_description',1)) ? 1 : 0;
            $widget->icon = trim(Tools::getValue('icon'));
            $widget->link = trim(Tools::getValue('link'));
            $widget->hook = trim(Tools::getValue('hook'));
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
			{			
		        $widget->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) != '' ? trim(Tools::getValue('title_'.$language['id_lang'])) :  trim(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT')));
                if($widget->title[$language['id_lang']] && !Validate::isCleanHtml($widget->title[$language['id_lang']]))
                    $errors[] = $this->l('Title in '.$language['name'].' is not valid');
                    
                $widget->subtitle[$language['id_lang']] = trim(Tools::getValue('subtitle_'.$language['id_lang'])) != '' ? trim(Tools::getValue('subtitle_'.$language['id_lang'])) :  trim(Tools::getValue('subtitle_'.Configuration::get('PS_LANG_DEFAULT')));
                if($widget->subtitle[$language['id_lang']] && !Validate::isCleanHtml($widget->subtitle[$language['id_lang']]))
                    $errors[] = $this->l('Sub Title in '.$language['name'].' is not valid');
                    
                $widget->description[$language['id_lang']] = trim(Tools::getValue('description_'.$language['id_lang'])) != '' ? trim(Tools::getValue('description_'.$language['id_lang'])) :  trim(Tools::getValue('description_'.Configuration::get('PS_LANG_DEFAULT')));
                if($widget->description[$language['id_lang']] && !Validate::isCleanHtml($widget->description[$language['id_lang']], true))
                    $errors[] = $this->l('Description in '.$language['name'].' is not valid');
            }
            $hooks = $this->_getHooks();
            if($widget->hook == '')
                $errors[] = $this->l('Please choose a hook');            
            elseif(!in_array($widget->hook, $hooks))
                $errors[] = $this->l('Hook is not valid');
            if($widget->icon!='' && !preg_match('/^fa-(.)+$/', $widget->icon))
                $errors[] = $this->l('Awesome icon is not vaild');
            
            if($widget->link!='' && !preg_match('/^http(.)+$/', $widget->link) && $widget->link!='#')
                $errors[] = $this->l('Link is not vaild');
            
            if(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT'))=='')
                $errors[] = $this->l('Title is required');                    
            
            /**
             * Upload image 
             */  
            $oldImage = false;
            $newImage = false;     
            
            if(isset($_FILES['image']['tmp_name']) && isset($_FILES['image']['name']) && $_FILES['image']['name'])
            {
                if(file_exists(dirname(__FILE__).'/images/widget/'.$_FILES['image']['name']))
                {
                    $errors[] = $this->l('Image file name already exists. Try to rename the file name then reupload it');
                }
                else
                {
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
        					$errors[] = $this->l('Can not upload the file');
        				elseif(!ImageManager::resize($temp_name, dirname(__FILE__).'/images/widget/'.$_FILES['image']['name'], null, null, $type))
        					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
        				
                        if($widget->image)
                        {
                            $oldImage = dirname(__FILE__).'/images/widget/'.$widget->image;                            
                        }                                
                        $widget->image = $_FILES['image']['name'];
                        $newImage = dirname(__FILE__).'/images/widget/'.$widget->image;                        
                        if(isset($temp_name))
        					@unlink($temp_name);		
        			}
                }
            }			
            
            /**
             * Save 
             */    
             
            if(!$errors)
            {
                if (!Tools::getValue('id_widget'))
    			{
    				if (!$widget->add())
                    {
                        $errors[] = $this->displayError($this->l('The item could not be added.'));
                        if($newImage && file_exists($newImage))
                            @unlink($newImage);                                              
                    }                	                    
    			}				
    			elseif (!$widget->update())
                {
                    if($newImage && file_exists($newImage))
                        @unlink($newImage);                    
                    $errors[] = $this->displayError($this->l('The item could not be updated.'));
                }
                else
                {
                    if($oldImage && file_exists($oldImage))
                        @unlink($oldImage);                    
                }    					                
            }
         }
         if (count($errors))
         {
            if($newImage && file_exists($newImage))
                @unlink($newImage);            
            $this->errorMessage = $this->displayError(implode('<br />', $errors));  
         }
         elseif (Tools::isSubmit('saveWidget') && Tools::isSubmit('id_widget'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_widget='.Tools::getValue('id_widget').'&control=widget');
		 elseif (Tools::isSubmit('saveWidget'))
         {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_widget='.$this->getMaxId('widget','id_widget').'&control=widget');
         }
    }
    private function _postMain()
    {
        
    }
    public function renderMainForm()
    {    
        $this->_html .= '<script type="text/javascript">var ybc_widget_sort_url = \''.$this->baseAdminPath.'\'</script>';
        $this->_html .= '<div class="panel"><div class="panel-heading"><span class="widget_title"> <i class="icon-AdminAdmin"></i>'.$this->l('Widgets').'</span>
            <span class="add_new_widget"><a class="label-tooltip" data-toggle="tooltip" data-original-title="'.$this->l('Add new widget').'" href="'.$this->baseAdminPath.'&control=widget" title=""><i class="process-icon-new "></i></a></span>
        </div>';
        $this->_html .= '<div class="form-wrapper">';
        $i = 0;
        foreach($this->_hooks as $hook)
        {
            $i++;
            if($i==1)
                $this->_html .= '<div class="widget_row">'; 
            $this->_html .= '<div class="widget_hook" rel="'.$hook['hook'].'"><div class="widget_heading widget_'.Tools::strtolower($hook['hook']).'">'.$hook['name'].' <a title="'.$this->l('Add a widget to this hook').'" href="'.$this->baseAdminPath.'&control=widget&hook='.$hook['hook'].'"><i class="process-icon-new"></i></a></div>';                      
            $this->_html .= '<ul id="widget_sortable_'.$i.'" class="widget_sortable">';
            $widgets = $this->getWidgetsByHook($hook['hook']);
            if($widgets)
            {            
                foreach($widgets as $widget)
                {
                    $this->_html .= '<li class="widget_item" rel="'.$widget['id_widget'].'">
                                         <span class="widget_edit_link">
                                            <a href="'.$this->baseAdminPath.'&control=widget&id_widget='.$widget['id_widget'].'">'.$widget['title'].'</a>
                                         </span>
                                         <span class="widget_tool_buttons">
                                             <a onclick="return confirm(\''.$this->l('Do you want to delete this?').'\');" href="'.$this->baseAdminPath.'&control=widget&id_widget='.$widget['id_widget'].'&del=true" class="delete"><i class="icon-trash"></i></a>
                                             <a class="enable_disnable" href="'.$this->baseAdminPath.'&control=widget&id_widget='.$widget['id_widget'].'&change_enabled='.($widget['enabled'] ? '0' : '1').'"><i title="'.($widget['enabled'] ? $this->l('Disable this item') : $this->l('Enable this item')).'" class="'.($widget['enabled'] ? 'icon-check' : 'icon-remove').'"></i></a>
                                             
                                         </span>
                                    </li>';
                }
            }  
            $this->_html .= '</ul>';          
            $this->_html .= '</div>';            
            if($i == 3 || $i == 6 || $i == 9 || $i == 12 || $i == 13)
                $this->_html .= '<div class="ybc_clear"></div></div><div class="widget_row">';
            if($i == 18)
                $this->_html .= '<div class="ybc_clear"></div></div>';
        }
        $this->_html .= '</div></div>';
    }
    public function itemExists($tbl, $primaryKey, $id)
	{
		$req = 'SELECT `'.$primaryKey.'`
				FROM `'._DB_PREFIX_.'ybc_widget_'.$tbl.'` tbl
				WHERE tbl.`'.$primaryKey.'` = '.(int)$id;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);        
		return ($row);
	}
    public function getMaxId($tbl, $primaryKey)
    {
        $req = 'SELECT max(`'.$primaryKey.'`) as maxid
				FROM `'._DB_PREFIX_.'ybc_widget_'.$tbl.'` tbl';				
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
        return isset($row['maxid']) ? (int)$row['maxid'] : 0;
    }
    public function getFieldsValues($formFields, $primaryKey, $objClass, $saveBtnName)
	{
		$fields = array();
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
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
                $fieldName = $field['name'];
                $fields[$field['name']] = trim(Tools::getValue($field['name'], $obj->$fieldName));      
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
                        $fieldName = $field['name'];
                        $field_langs = $obj->$fieldName;                        
                        $fields[$field['name']][$lang['id_lang']] = $field_langs[$lang['id_lang']];
                    }                        
                }                
            }
		}
        $fields['control'] = trim(Tools::getValue('control')) ? trim(Tools::getValue('control')) : '';        
        
         return $fields;
	}
    public function getWidgetsByHook($hook, $enabled = false)
    {
        $where = '';
        if(class_exists('ybc_themeconfig') && isset($this->context->controller->controller_type) && $this->context->controller->controller_type=='front')
        {
            $tc = new Ybc_themeconfig();
            if($tc->devMode && ($ids = $tc->getLayoutConfiguredField('widgets')))
            {
                $where = " AND w.id_widget IN(".implode(',',$ids).") ";
            }
        }
        
        $sql = "SELECT w.*, wl.title, wl.subtitle, wl.description 
                FROM "._DB_PREFIX_."ybc_widget_widget w
                LEFT JOIN "._DB_PREFIX_."ybc_widget_widget_lang wl ON w.id_widget = wl.id_widget AND wl.id_lang = ".($this->context->language->id)."
                WHERE w.hook = '$hook' ".($enabled ? ' AND enabled=1 ' : '').$where."
                ORDER BY w.sort_order ASC, wl.title ASC
                ";         
        return Db::getInstance()->executeS($sql);
    }
    private function _updateOrders()
    {
        $hooks = $this->_getHooks();
        $orderData = Tools::getValue('widget');
        if($orderData && is_array($orderData))
        {
            foreach($orderData as $key => $widget)
            {
                $temp = explode(',', $widget);
                if(count($temp) == 2 && in_array($temp[1], $hooks))
                {
                    $sql = "UPDATE "._DB_PREFIX_."ybc_widget_widget 
                            SET sort_order = ".(int)$temp[0].", hook='".$temp[1]."'
                            WHERE id_widget = $key";
                    Db::getInstance()->execute($sql);
                }                
            }
        }
    }
    public function hookDisplayBackOfficeHeader()
    { 
        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/css/admin.css', 'all');        
    }
    public function hookDisplayHeader()
    { 
        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/css/widget.css', 'all');        
    }
    public function changeStatus($tbl, $field, $id , $status)
    {
        $req = "UPDATE "._DB_PREFIX_."ybc_widget_$tbl SET `enabled`=$status WHERE id_$tbl=$id";
        return Db::getInstance()->execute($req);
    }
    private function _deleteWidget($id_widget)
    {
        if($this->itemExists('widget','id_widget',$id_widget))
        {
            $widget = new Ybc_widget_widget_class($id_widget);
            if($widget->image && file_exists(dirname(__FILE__).'/images/widget/'.$widget->image))
            {
                @unlink(dirname(__FILE__).'/images/widget/'.$widget->image);
            }            
            return $widget->delete();
        }
        return false;        
    }
    public function hookDisplayNav()
    {
        $widgets = $this->getWidgetsByHook('displayNav', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-nav'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayTop()
    {
        $widgets = $this->getWidgetsByHook('displayTop', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-top'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayFooter()
    {
        $widgets = $this->getWidgetsByHook('displayFooter', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-footer'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayHome()
    {
        $widgets = $this->getWidgetsByHook('displayHome', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-home'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayLeftColumn()
    {
        $widgets = $this->getWidgetsByHook('displayLeftColumn', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-left-column'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayRightColumn()
    {
        $widgets = $this->getWidgetsByHook('displayRightColumn', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-right-column'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    
    public function hookDisplayRightColumnProduct()
    {
        $widgets = $this->getWidgetsByHook('displayRightColumnProduct', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-right-column-product'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayLeftColumnProduct()
    {
        $widgets = $this->getWidgetsByHook('displayLeftColumnProduct', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-left-column-product'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookDisplayTopColumn()
    {
        $widgets = $this->getWidgetsByHook('displayTopColumn', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'display-top-column'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcCustomHook()
    {
        $widgets = $this->getWidgetsByHook('ybcCustomHook', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-hook'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcPaymentLogo()
    {
        $widgets = $this->getWidgetsByHook('ybcPaymentLogo', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-ybcpaymentlogo-hook'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcFooterLinks()
    {
        $widgets = $this->getWidgetsByHook('ybcFooterLinks', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-footer-links'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcCustom1()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom1', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-1'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcCustom2()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom2', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-2'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    public function hookYbcCustom3()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom3', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-3'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    
    public function hookYbcCustom4()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom4', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-4'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    
    public function hookYbcCustom5()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom5', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-5'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    
    
    public function hookYbcCustom6()
    {
        $widgets = $this->getWidgetsByHook('ybcCustom6', true);
        $this->smarty->assign(
            array(
                'widgets' => $widgets,
                'widget_module_path' => $this->_path,
                'widget_hook' => 'ybc-custom-6'
            )
        );
        return $this->display(__FILE__, 'widgets.tpl');
    }
    private function installSample()
     {       
       $languages = Language::getLanguages(false);
       $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
       $sqlFile = dirname(__FILE__).'/data/sql/widget.sql';       
       if(file_exists($sqlFile) && ($sql = Tools::file_get_contents($sqlFile)))
       {
            $tbs =  array('ybc_widget_widget','ybc_widget_widget_lang');            
            foreach($tbs as $tbl)
            {
                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_.$tbl);               
            }            
            if(!$this->parseSql($sql))
            {
                $sqlLangFile = dirname(__FILE__).'/data/sql/widget_lang.sql';
                if(file_exists($sqlLangFile) && ($sql = Tools::file_get_contents($sqlLangFile)) && $languages)
                { 
                   
                    foreach($languages as $lang)
                    {
                        $subsql = str_replace('_ID_LANG_',$lang['id_lang'],$sql);                                
                        $this->parseSql($subsql);
                    }
                }
            }            
       }
       if($oldFiles = glob(dirname(__FILE__).'/images/widget/*'))
        {
            foreach($oldFiles as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }         
        $this->copyDir(dirname(__FILE__).'/data/img/',dirname(__FILE__).'/images/widget/');
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
    private function copyDir($src,$dst) { 
        if(file_exists($src) && file_exists($dst) && is_dir($src) && is_dir($dst))
        {
            $dir = opendir($src); 
            @mkdir($dst); 
            while(false !== ( $file = readdir($dir)) ) { 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    @copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
            closedir($dir); 
        }
        
    } 
}