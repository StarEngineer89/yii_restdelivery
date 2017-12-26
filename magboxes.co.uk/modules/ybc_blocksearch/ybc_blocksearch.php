<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class Ybc_blockSearch extends Module
{
    private $errorMessage;
    public $configs;
    public $baseAdminPath;
    private $categoryDropDown = '';
    private $depthLevel = false;
    private $excludedCats = array();
    private $categoryPrefix = '-';
	public function __construct()
	{
		$this->name = 'ybc_blocksearch';
		$this->tab = 'search_filter';
		$this->version = '1.0.1';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
        $this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Advanced search block');
		$this->description = $this->l('Quick search block with categories dropdown.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        //Config fields        
        $this->configs = array(
            'YBC_BLOCKSEARCH_SHOW_PRODUCT_IMAGE' => array(
                'label' => $this->l('Show product image in ajax search result'),
                'type' => 'switch',
                'default' => 1
            ),
            'YBC_BLOCKSEARCH_ENABLE_BY_CAT' => array(
                'label' => $this->l('Enable search by category'),
                'type' => 'switch',
                'default' => 1
            ),
            'YBC_BLOCKSEARCH_DEPTH_LEVEL' => array(
                'label' => $this->l('Category depth level'),
                'type' => 'text',
                'default' => '',
                'desc' => $this->l('Leave blank to show all levels')
            ),  
            'YBC_BLOCKSEARCH_EXCLUDED_CATS' => array(
                'label' => $this->l('Exclueded categories in dropdown'),
                'type' => 'text',
                'default' => '',
                'desc' => $this->l('Separated by comma, leave blank if you want to show all active categories in dropdown')
            ),  
            'YBC_BLOCKSEARCH_CAT_PREFIX' => array(
                'label' => $this->l('Category name prefix'),
                'type' => 'text',
                'default' => '-',                
            ),                       
        );
        
        $this->categoryPrefix = Configuration::get('YBC_BLOCKSEARCH_CAT_PREFIX');
        $this->depthLevel = (int)Configuration::get('YBC_BLOCKSEARCH_DEPTH_LEVEL');
        $cats = Configuration::get('YBC_BLOCKSEARCH_EXCLUDED_CATS');
        if($cats)
            $this->excludedCats = explode(',', $cats);        
	}
    
	public function install()
	{
		if (!parent::install() || !$this->_installDb() || !$this->registerHook('top') || !$this->registerHook('displayNav') || !$this->registerHook('header') || !$this->registerHook('displayMobileTopSiteMap'))
			return false;
		return true;
	} 
    public function _installDb()
    {
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
                    Configuration::updateValue($key, $values);
                }
                else
                    Configuration::updateValue($key, isset($config['default']) ? $config['default'] : '');
            }
        }        
        return true;
    }   
	public function uninstall()
	{
        return parent::uninstall() && $this->_uninstallDb();
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
        return true;
    }
	public function hookdisplayMobileTopSiteMap($params)
	{
		$this->smarty->assign(array('hook_mobile' => true, 'instantsearch' => false));
		$params['hook_mobile'] = true;
		return $this->hookdisplayNav($params);
	}

	public function hookHeader($params)
	{
		$this->context->controller->addCSS(($this->_path).'blocksearch.css', 'all');


		if (Configuration::get('PS_INSTANT_SEARCH'))
			$this->context->controller->addCSS(_THEME_CSS_DIR_.'product_list.css');

		if (Configuration::get('PS_SEARCH_AJAX') || Configuration::get('PS_INSTANT_SEARCH'))
		{
			Media::addJsDef(array('search_url' => $this->context->link->getPageLink('search', Tools::usingSecureMode())));
			$this->context->controller->addJS(($this->_path).'blocksearch.js');
            $this->context->controller->addJS(($this->_path).'autocomplete.js');
		}
	}

	public function hookLeftColumn($params)
	{
		return $this->hookRightColumn($params);
	}

	public function hookRightColumn($params)
	{
	    $treeHelper = new HelperTreeCategories('categories-blocksearch', null, null, (int)$this->context->language->id);
        $treeHelper->setRootCategory(2);
        $categoriesTree = $treeHelper->getData();
        $this->getCategoriesDropdown($categoriesTree);        
        $this->smarty->assign(array('searched_categories' => $this->categoryDropDown ? '<select class="searched_category" name="searched_category"><option value="0">'.$this->l('All categories').'</option>'.$this->categoryDropDown.'</select>' : false));     
		
		if (Tools::getValue('search_query') || !$this->isCached('blocksearch.tpl', $this->getCacheId()))
		{
			$this->calculHookCommon($params);
			$this->smarty->assign(array(
				'blocksearch_type' => 'block',
				'search_query' => (string)Tools::getValue('search_query')
				)
			);
		}
		Media::addJsDef(array('blocksearch_type' => 'block'));
		return $this->display(__FILE__, 'blocksearch.tpl', Tools::getValue('search_query') ? null : $this->getCacheId());
	}
    
    public function getCategoriesDropdown($categories, &$depth_level = -1)
    {        
        if(!(int)Configuration::get('YBC_BLOCKSEARCH_ENABLE_BY_CAT'))
        {            
            return false;
        }
              
        
        if($categories)
        {
            $depth_level++;
            foreach($categories as $category)
            {
                if(!in_array((int)$category['id_category'],$this->excludedCats) && (!$this->depthLevel || $this->depthLevel && (int)$depth_level <= $this->depthLevel))
                {
                    $levelSeparator = '';
                    if($depth_level >= 2)
                    {
                        for($i = 1; $i <= $depth_level-1; $i++)
                        {
                            $levelSeparator .= $this->categoryPrefix;
                        }
                    }
                    if($category['id_category'] == 4)
                    {
                        
                    }        
                    if($category['id_category'] > 2)
                        $this->categoryDropDown .= '<option '.((int)Tools::getValue('searched_category') == (int)$category['id_category'] ? ' selected="selected" ' : '').' class="search_depth_level_'.$depth_level.'" value="'.$category['id_category'].'">'.($levelSeparator ? $levelSeparator.' ' : '').$category['name'].'</option>';
                    if(isset($category['children']) && $category['children'])
                    {                        
                        $this->getCategoriesDropdown($category['children'], $depth_level);
                    }   
                }                                 
            } 
            $depth_level--;           
        }        
        return;
    }
    public function getCategoriesTree($id_root, $active = true, $id_lang = null)
    {
        $tree = array();
        if(is_null($id_lang))
            $id_lang = (int)$this->context->language->id;
        $sql = "SELECT c.id_category, cl.name
                FROM "._DB_PREFIX_."category c
                LEFT JOIN "._DB_PREFIX_."category_lang cl ON c.id_category = cl.id_category AND cl.id_lang = $id_lang
                WHERE c.id_category = $id_root ".($active ? " AND  c.active = 1" : "");
        if($category = Db::getInstance()->getRow($sql))
        {            
            $cat = array(
                            'id_category' => $id_root,
                            'name' => $category['name']
                        );            
            $children = $this->getChildrenCategories($id_root, $active, $id_lang);
            $temp = array();
            if($children)
            {
                foreach($children as $child)
                {
                    $arg = $this->getCategoriesTree($child['id_category'], $active, $id_lang);
                    if($arg && isset($arg[0]))
                        $temp[] = $arg[0];
                }                    
            }
            $cat['children'] = $temp;
            $tree[] = $cat;
        }
        return $tree;            
    }
    public function getChildrenCategories($id_root, $active = true, $id_lang = null)
    {
        if(is_null($id_lang))
            $id_lang = (int)$this->context->language->id;
        $sql = "SELECT c.id_category, cl.name
                FROM "._DB_PREFIX_."category c
                LEFT JOIN "._DB_PREFIX_."category_lang cl ON c.id_category = cl.id_category AND cl.id_lang = $id_lang
                WHERE c.id_parent = $id_root".($active ? " AND  c.active = 1" : "");
        return Db::getInstance()->executeS($sql);
    }
    

	public function hookDisplayTop($params)
	{
		
        $categoriesTree = $this->getCategoriesTree(2); 
        $this->getCategoriesDropdown($categoriesTree);                
        $this->smarty->assign(array('searched_categories' => $this->categoryDropDown ? '<select class="searched_category" name="searched_category"><option value="0">'.$this->l('All categories').'</option>'.$this->categoryDropDown.'</select><span class="select-arrow"></span>' : false));     
		$key = $this->getCacheId('blocksearch-top'.((!isset($params['hook_mobile']) || !$params['hook_mobile']) ? '' : '-hook_mobile'));
		if (Tools::getValue('search_query') || !$this->isCached('blocksearch-top.tpl', $key))
		{
			$this->calculHookCommon($params);
			$this->smarty->assign(array(
				'blocksearch_type' => 'top',
				'search_query' => (string)Tools::getValue('search_query')
				)
			);
		}
		Media::addJsDef(array('blocksearch_type' => 'top'));
		return $this->display(__FILE__, 'blocksearch-top.tpl', Tools::getValue('search_query') ? null : $key);
	}
	private function calculHookCommon($params)
	{
		$this->smarty->assign(array(
			'ENT_QUOTES' =>		ENT_QUOTES,
			'search_ssl' =>		Tools::usingSecureMode(),
			'ajaxsearch' =>		Configuration::get('PS_SEARCH_AJAX'),
			'instantsearch' =>	Configuration::get('PS_INSTANT_SEARCH'),
			'self' =>			dirname(__FILE__),
		));

		return true;
	}
    
    //Configuration form by YourBestCode
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
					'title' => $this->l('Blocksearch settings'),
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
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
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
            
            if(Tools::getValue('YBC_BLOCKSEARCH_DEPTH_LEVEL') != '' && (int)Tools::getValue('YBC_BLOCKSEARCH_DEPTH_LEVEL') < 1)
                $errors[] = $this->l('"Category depth level"  must be greater than 0');
            if(Tools::getValue('YBC_BLOCKSEARCH_EXCLUDED_CATS') && !preg_match('/^[0-9]+(,[0-9]+)*$/', Tools::getValue('YBC_BLOCKSEARCH_EXCLUDED_CATS')))
                $errors[] = $this->l('"Exclueded categories in dropdown" is invalid');
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
                            Configuration::updateValue($key,$valules);
                        }
                        else
                        {
                            if($config['type']=='switch')
                            {                           
                                Configuration::updateValue($key,(int)trim(Tools::getValue($key)) ? 1 : 0);
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
                                                Configuration::updateValue($key, $imageName);                                                                                               
                                            }
                                        }
                                    }
                                }
                                //End upload file
                            }
                            else
                                Configuration::updateValue($key,trim(Tools::getValue($key)));   
                        }                        
                    }
                }
            }
            if (count($errors))
            {
               $this->errorMessage = $this->displayError(implode('<br />', $errors));  
            }
            else
               Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);            
        }
     }}

