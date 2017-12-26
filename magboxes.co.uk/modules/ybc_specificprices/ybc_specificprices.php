<?php
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_specificprices extends Module
{
    private $errorMessage;
    public $configs;
    public $baseAdminPath;
    private $_html;
    public $templates;
    public function __construct()
	{
		$this->name = 'ybc_specificprices';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);        
		$this->bootstrap = true;

		parent::__construct();
        $this->displayName = $this->l('Hot deals');
		$this->description = $this->l('Display specific discounted products on home page');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        if(isset($this->context->controller->controller_type) && $this->context->controller->controller_type =='admin')
            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        
        //Config fields        
        $this->configs = array(
            'YBC_SHOPMSG_TITLE' => array(
                'label' => $this->l('Title'),
                'type' => 'text',                
                'lang' => true,     
                'default' => $this->l('Hot deals'),
                'required' => true,                        
            ),
            'YBC_SHOPMSG_PRODUCT' => array(
                'label' => $this->l('Product IDs'),
                'name'=>'product_id',
                'type' => 'text',
                'default' => '1,2,3',
                'desc' => $this->l('Separated a comma. Eg: 1,3,4')                            
            )                                
        );        
    }
    /**
	 * @see Module::install()
	 */
    public function install()
	{
	    return parent::install()        
        && $this->registerHook('displayCustomDiscount')
        && $this->_installDb();        
    }
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
        return parent::uninstall() && $this->_uninstallDb();
    }    
    public function _installDb()
    {
        $languages = Language::getLanguages(false);
        if($this->configs)
        {
            foreach($this->configs as $key => $config)
            {
                if(isset($config['lang']) && $config['lang'])
                {
                    $values = array();
                    foreach($languages as $lang)
                    {
                        $values[$lang['id_lang']] = isset($config['default']) ? $config['default'] : '';
                    }
                    Configuration::updateValue($key, $values,true);
                }
                else
                    Configuration::updateValue($key, isset($config['default']) ? $config['default'] : '',true);
            }
        }        
        return true;
    }    
    private function _uninstallDb()
    {
        if($this->configs)
        {
            foreach($this->configs as $key => $config)
            {
                Configuration::deleteByName($key);
            }
        } 
        $dirs = array('config');
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
	   $this->_postConfig();       
       //Display errors if have
       if($this->errorMessage)
            $this->_html .= $this->errorMessage;       
       //Render views
       $this->renderConfig(); 
       return $this->_html;
    } 
    public function renderConfig()
    {
        $configs = $this->configs;
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Hot deals'),
					'icon' => 'icon-AdminAdmin'
				),
				'input' => array(),
                'submit' => array(
					'title' => $this->l('Save'),
				)
            ),
		);
        if($configs)
        {
            foreach($configs as $key => $config)
            {
                $confFields = array(
                    'name' => $key,
                    'type' => $config['type'],
                    'label' => $config['label'],
                    'desc' => isset($config['desc']) ? $config['desc'] : false,
                    'required' => isset($config['required']) && $config['required'] ? true : false,
                    'autoload_rte' => isset($config['autoload_rte']) && $config['autoload_rte'] ? true : false,
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
                    'suffix' => isset($config['suffix']) && $config['suffix'] ? $config['suffix']  : false,
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
						),
                    'lang' => isset($config['lang']) ? $config['lang'] : false
                );
                if(!$confFields['suffix'])
                    unset($confFields['suffix']);
                if($config['type'] == 'file')
                {
                    if($imageName = Configuration::get($key))
                    {
                        $confFields['display_img'] = $this->_path.'images/config/'.$imageName;
                        if(!isset($config['required']) || (isset($config['required']) && !$config['required']))
                            $confFields['img_del_link'] = $this->baseAdminPath.'&delimage=yes&image='.$key; 
                    }
                }
                $fields_form['form']['input'][] = $confFields;
                
                if($confFields['name']=='YBC_SHOPMSG_DATEFROM' || $confFields['name']=='YBC_SHOPMSG_DATETO')
                    $this->context->controller->addJqueryUI('ui.datepicker');
            }
        }        
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
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=config';
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $fields = array();        
        $languages = Language::getLanguages(false);
        $helper->override_folder = '/';
        if(Tools::isSubmit('saveConfig'))
        {            
            if($configs)
            {                
                foreach($configs as $key => $config)
                {
                    if(isset($config['lang']) && $config['lang'])
                        {                        
                            foreach($languages as $l)
                            {
                                $fields[$key][$l['id_lang']] = Tools::getValue($key.'_'.$l['id_lang'],isset($config['default']) ? $config['default'] : '');
                            }
                        }
                        else
                            $fields[$key] = Tools::getValue($key,isset($config['default']) ? $config['default'] : '');
                }
            }
        }
        else
        {
            if($configs)
            {
                    foreach($configs as $key => $config)
                    {
                        if(isset($config['lang']) && $config['lang'])
                        {                    
                            foreach($languages as $l)
                            {
                                $fields[$key][$l['id_lang']] = Configuration::get($key,$l['id_lang']);
                            }
                        }
                        else
                            $fields[$key] = Configuration::get($key);                   
                    }
            }
        }
        $helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $fields,
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,                     
        );
        
        $this->_html .= $helper->generateForm(array($fields_form));		
     }
     private function _postConfig()
     {
        $errors = array();
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $configs = $this->configs;
        
        //Delete image
        if(Tools::isSubmit('delimage'))
        {
            $image = Tools::getValue('image');
            if(isset($configs[$image]) && !isset($configs[$image]['required']) || (isset($configs[$image]['required']) && !$configs[$image]['required']))
            {
                $imageName = Configuration::get($image);
                $imagePath = dirname(__FILE__).'/images/config/'.$imageName;
                if($imageName && file_exists($imagePath))
                {
                    @unlink($imagePath);
                    Configuration::updateValue($image,'');
                }
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
            else
                $errors[] = $configs[$image]['label'].$this->l(' is required');
        }
        if(Tools::isSubmit('saveConfig'))
        {            
            if($configs)
            {
                foreach($configs as $key => $config)
                {
                    if(isset($config['lang']) && $config['lang'])
                    {
                        if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key.'_'.$id_lang_default) == ''))
                        {
                            $errors[] = $config['label'].' '.$this->l('is required');
                        }                        
                    }
                    else
                    {
                        if(isset($config['required']) && $config['required'] && isset($config['type']) && $config['type']=='file')
                        {
                            if(Configuration::get($key)=='' && !isset($_FILES[$key]['size']))
                                $errors[] = $config['label'].' '.$this->l('is required');
                            elseif(isset($_FILES[$key]['size']))
                            {
                                $fileSize = round((int)$_FILES[$key]['size'] / (1024 * 1024));
                    			if($fileSize > 100)
                                    $errors[] = $config['label'].$this->l(' can not be larger than 100Mb');
                            }   
                        }
                        else
                        {
                            if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key) == ''))
                            {
                                $errors[] = $config['label'].' '.$this->l('is required');
                            }
                            elseif(!Validate::isCleanHtml(trim(Tools::getValue($key))))
                            {
                                $errors[] = $config['label'].' '.$this->l('is invalid');
                            } 
                        }                          
                    }                    
                }
            }            
            
            //Custom validation
            if(($productIds = Tools::getValue('YBC_SHOPMSG_PRODUCT')) && !preg_match('/^[0-9]+(,[0-9]+)*$/', $productIds))
                $errors[] = $this->l('Product IDs is not in valid format');
            
            if(!$errors)
            {
                if($configs)
                {
                    foreach($configs as $key => $config)
                    {
                        if(isset($config['lang']) && $config['lang'])
                        {
                            $valules = array();
                            foreach($languages as $lang)
                            {
                                if($config['type']=='switch')                                                           
                                    $valules[$lang['id_lang']] = (int)trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? 1 : 0;                                
                                else
                                    $valules[$lang['id_lang']] = trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? trim(Tools::getValue($key.'_'.$lang['id_lang'])) : trim(Tools::getValue($key.'_'.$id_lang_default));
                            }
                            Configuration::updateValue($key,$valules,true);
                        }
                        else
                        {
                            if($config['type']=='switch')
                            {                           
                                Configuration::updateValue($key,(int)trim(Tools::getValue($key)) ? 1 : 0,true);
                            }
                            if($config['type']=='file')
                            {
                                //Upload file
                                if(isset($_FILES[$key]['tmp_name']) && isset($_FILES[$key]['name']) && $_FILES[$key]['name'])
                                {
                                    $salt = sha1(microtime());
                                    $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));
                                    $imageName = $salt.'.'.$type;
                                    $fileName = dirname(__FILE__).'/images/config/'.$imageName;                
                                    if(file_exists($fileName))
                                    {
                                        $errors[] = $config['label'].$this->l(' already exists. Try to rename the file then reupload');
                                    }
                                    else
                                    {
                                        
                            			$imagesize = @getimagesize($_FILES[$key]['tmp_name']);
                                        
                                        if (!$errors && isset($_FILES[$key]) &&				
                            				!empty($_FILES[$key]['tmp_name']) &&
                            				!empty($imagesize) &&
                            				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                            			)
                            			{
                            				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
                            				if ($error = ImageManager::validateUpload($_FILES[$key]))
                            					$errors[] = $error;
                            				elseif (!$temp_name || !move_uploaded_file($_FILES[$key]['tmp_name'], $temp_name))
                            					$errors[] = $this->l('Can not upload the file');
                            				elseif (!ImageManager::resize($temp_name, $fileName, null, null, $type))
                            					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                            				if (isset($temp_name))
                            					@unlink($temp_name);
                                            if(!$errors)
                                            {
                                                if(Configuration::get($key)!='')
                                                {
                                                    $oldImage = dirname(__FILE__).'/images/config/'.Configuration::get($key);
                                                    if(file_exists($oldImage))
                                                        @unlink($oldImage);
                                                }                                                
                                                Configuration::updateValue($key, $imageName,true);                                                                                               
                                            }
                                        }
                                    }
                                }
                                //End upload file
                            }
                            else
                                Configuration::updateValue($key,trim(Tools::getValue($key)),true);   
                        }                        
                    }
                }
            }
            Tools::clearSmartyCache('display_product.tpl'); 
            if (count($errors))
            {
               $this->errorMessage = $this->displayError(implode('<br />', $errors));  
            }
            else
               Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);            
        }
     }
    public function hookDisplayCustomDiscount()
    {
        global $link;        
        if(($products = explode(",",Configuration::get('YBC_SHOPMSG_PRODUCT'))) && (!$products || $products && !is_array($products)))
            return;
            
        $products_list = array();    
        foreach($products as $prod)
        {
            $p = new Product((int)$prod, true, $this->context->language->id);
            if($p->id)
                $products_list[] = $p;
        }
            
        $this->context->controller->addJS($this->_path.'js/jquery.countdown.min.js');
        $this->context->controller->addJS($this->_path.'js/specific_prices.js');
        
        $this->smarty->assign(array(
            'products_list'=>$products_list,
            'YBC_SHOPMSG_TITLE' => Configuration::get('YBC_SHOPMSG_TITLE',$this->context->language->id),     
        ));
        
        return $this->display(__FILE__, 'display_product.tpl');
    }
}