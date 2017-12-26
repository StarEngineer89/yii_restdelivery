<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'ybc_nivoslider/ybc_nivoslide.php');

class Ybc_nivoslider extends Module
{
	private $_html = '';
	private $default_width = '100%';
    private $default_height = '100%';
    private $default_frame_width = '100%';
    private $default_caption_speed = '300';
	private $default_speed = 500;
	private $default_pause = 10000;
	private $default_loop = 1;
    private $default_start_slide = 1;
    private $default_pause_on_hover = 1;
    private $default_show_control = 1;
    private $default_button_image = 0;
    private $default_show_prev_next = 1;
    
    //Caption options
    private $default_caption_width = '40%';
    private $default_caption_position = 'left';
    private $default_caption_animate = 'random';
    private $default_caption_left = '10%';
    private $default_caption_right = '10%';
    private $default_caption_top = '10%';
    private $default_slide_effect = 'random';
    private $default_caption_text_direction = 'left';
    
	public function __construct()
	{	   
		$this->name = 'ybc_nivoslider';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Nivo slider');
		$this->description = $this->l('Nivo slider with stunning CSS3 caption animation effects');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
		if (parent::install() &&
			$this->registerHook('displayHeader') &&
			$this->registerHook('displayTopColumn') &&
			$this->registerHook('actionShopDataDuplication')
		)
		{		

			/* Sets up Global configuration */
			$res = Configuration::updateValue('YBCNIVO_WIDTH', $this->default_width);
            $res &= Configuration::updateValue('YBCNIVO_HEIGHT', $this->default_height);
			$res &= Configuration::updateValue('YBCNIVO_SPEED', $this->default_speed);
			$res &= Configuration::updateValue('YBCNIVO_PAUSE', $this->default_pause);
			$res &= Configuration::updateValue('YBCNIVO_LOOP', $this->default_loop);
            $res &= Configuration::updateValue('YBCNIVO_START_SLIDE', $this->default_start_slide);            
            $res &= Configuration::updateValue('YBCNIVO_PAUSE_ON_HOVER', $this->default_pause_on_hover);
            $res &= Configuration::updateValue('YBCNIVO_SHOW_CONTROL', $this->default_show_control);
            $res &= Configuration::updateValue('YBCNIVO_BUTTON_IMAGE', $this->default_button_image);
            $res &= Configuration::updateValue('YBCNIVO_SHOW_PREV_NEXT', $this->default_show_prev_next);
            $res &= Configuration::updateValue('YBCNIVO_CAPTION_SPEED', $this->default_caption_speed);
            $res &= Configuration::updateValue('YBCNIVO_FRAME_WIDTH', $this->default_frame_width);

			/* Creates tables */
			$res &= $this->createTables();

			/* Adds samples */
			if ($res)
				$this->installSample();

			return (bool)$res;
		}

		return false;
	}	

	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();

			/* Unsets configuration */
			$res &= Configuration::deleteByName('YBCNIVO_WIDTH');
            $res &= Configuration::deleteByName('YBCNIVO_HEIGHT');
			$res &= Configuration::deleteByName('YBCNIVO_SPEED');
			$res &= Configuration::deleteByName('YBCNIVO_PAUSE');
			$res &= Configuration::deleteByName('YBCNIVO_LOOP');            
            $res &= Configuration::deleteByName('YBCNIVO_START_SLIDE');
			$res &= Configuration::deleteByName('YBCNIVO_PAUSE_ON_HOVER');
			$res &= Configuration::deleteByName('YBCNIVO_SHOW_CONTROL');
            $res &= Configuration::deleteByName('YBCNIVO_BUTTON_IMAGE');
			$res &= Configuration::deleteByName('YBCNIVO_SHOW_PREV_NEXT');
            $res &= Configuration::deleteByName('YBCNIVO_CAPTION_SPEED');
			$res &= Configuration::deleteByName('YBCNIVO_FRAME_WIDTH');
			return (bool)$res;
		}

		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* Slides */
		$res = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider` (
				`id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_homeslider_slides`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider_slides` (
			  `id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `position` int(10) unsigned NOT NULL DEFAULT \'0\',
			  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              `slide_effect` VARCHAR(50) NULL DEFAULT NULL,
              `caption_top` VARCHAR(50) NULL DEFAULT NULL,              
              `caption_left` VARCHAR(50) NULL DEFAULT NULL,
              `caption_right` VARCHAR(50) NULL DEFAULT NULL,
              `caption_animate` VARCHAR(50) NULL DEFAULT NULL,
              `caption_position` VARCHAR(50) NULL DEFAULT NULL,
              `caption_text_direction` VARCHAR(50) NULL DEFAULT NULL,
              `caption_width` VARCHAR(50) NULL DEFAULT NULL,    
              `custom_class` VARCHAR(255) NULL DEFAULT NULL,   
              `button_link` VARCHAR(255) NULL DEFAULT NULL,      
			  PRIMARY KEY (`id_homeslider_slides`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides lang configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider_slides_lang` (
			  `id_homeslider_slides` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `legend` varchar(255) NOT NULL,
              `legend2` varchar(255) NOT NULL,                         
			  `url` varchar(255) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_homeslider_slides`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		/*$slides = $this->getSlides();
		foreach ($slides as $slide)
		{
			$to_del = new YBCNIVOSLIDE($slide['id_slide']);
			$to_del->delete();
		}*/

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'ybcnivoslider`, `'._DB_PREFIX_.'ybcnivoslider_slides`, `'._DB_PREFIX_.'ybcnivoslider_slides_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();

		/* Validate & process */
		if (Tools::isSubmit('submitSlide') || Tools::isSubmit('delete_id_slide') ||
			Tools::isSubmit('submitSlider') ||
			Tools::isSubmit('changeStatus')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
                if(Tools::isSubmit('show_setting'))
				    $this->_html .= $this->renderForm();
                else
				    $this->_html .= $this->renderList();
			}
			else
            {
                if(!Tools::isSubmit('submitSlider'))
                    $this->_html .= $this->renderAddForm();
                else
                {
                    $this->_html .= $this->renderForm();                   
                }                    
            }			

			$this->clearCache();
		}
		elseif (Tools::isSubmit('addSlide') || (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))))
		{
			if (Tools::isSubmit('addSlide'))
				$mode = 'add';
			else
				$mode = 'edit';

			if ($mode == 'add')
			{
				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
					$this->_html .= $this->renderAddForm();
				else
					$this->_html .= $this->getShopContextError(null, $mode);
			}
			else
			{
				$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
				$associated_shop_id = $slide->getAssociatedIdShop();
				$context_shop_id = (int)Shop::getContextShopID();

				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL && $associated_shop_id == $context_shop_id)
					$this->_html .= $this->renderAddForm();
				else
				{
					$associated_shop = new Shop($associated_shop_id);
					$this->_html .= $this->getShopContextError($associated_shop->name, $mode);
				}

			}
		}
		else // Default viewport
		{
			$this->_html .= $this->getWarningMultishopHtml().$this->getCurrentShopInfoMsg();
            if(Tools::isSubmit('show_setting'))
                $this->_html .= $this->renderForm();
            else
                $this->_html .= $this->renderList();
		}

		return $this->_html;
	}

	private function _postValidation()
	{
		$errors = array();

		/* Validation for Slider configuration */
		if (Tools::isSubmit('submitSlider'))
		{

			if ((int)Tools::getValue('YBCNIVO_START_SLIDE') <= 0 || (int)Tools::getValue('YBCNIVO_CAPTION_SPEED') <= 0 || !Validate::isInt(Tools::getValue('YBCNIVO_SPEED')) || !Validate::isInt(Tools::getValue('YBCNIVO_PAUSE'))				
			)
            {
                $errors[] = $this->l('Invalid values');
            }
            else
            {
                $width = ltrim(Tools::getValue('YBCNIVO_WIDTH'),'0');
                $frameWidth = ltrim(Tools::getValue('YBCNIVO_FRAME_WIDTH'),'0');
                $height = ltrim(Tools::getValue('YBCNIVO_HEIGHT'),'0');
                if(!preg_match('/^[0-9]+%$/', $width) && !preg_match('/^[0-9]+px$/', $width))
                    $errors[] = $this->l('Width is not in valid format');
                if(!preg_match('/^[0-9]+%$/', $height) && !preg_match('/^[0-9]+px$/', $height))
                    $errors[] = $this->l('Height is not in valid format');
                if(!preg_match('/^[0-9]+%$/', $frameWidth) && !preg_match('/^[0-9]+px$/', $frameWidth))
                    $errors[] = $this->l('Caption frame width is not in valid format');
            }
				
		} /* Validation for status */
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_slide')))
				$errors[] = $this->l('Invalid slide');
		}
		/* Validation for Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_slide')) || (Tools::getValue('active_slide') != 0 && Tools::getValue('active_slide') != 1))
				$errors[] = $this->l('Invalid slide state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid slide position.');
			/* If edit : checks id_slide */
			if (Tools::isSubmit('id_slide'))
			{

				//d(var_dump(Tools::getValue('id_slide')));
				if (!Validate::isInt(Tools::getValue('id_slide')) && !$this->slideExists(Tools::getValue('id_slide')))
					$errors[] = $this->l('Invalid slide ID');
			}
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('legend_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The caption 1 is too long.');
                if (Tools::strlen(Tools::getValue('legend2_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The caption 2 is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The URL is too long.');
				if (Tools::strlen(Tools::getValue('description_'.$language['id_lang'])) > 4000)
					$errors[] = $this->l('The description is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
				if (Tools::getValue('image_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
				if (Tools::getValue('image_old_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_old_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			
            $caption_width = ltrim(Tools::getValue('caption_width'),'0');
            if(Tools::getValue('caption_top') != '0')
                $caption_top = ltrim(Tools::getValue('caption_top'),'0');
            else
                $caption_top = '0';
            if(Tools::getValue('caption_left') != '0')
                $caption_left = ltrim(Tools::getValue('caption_left'),'0');
            else
                $caption_left = '0';
            if(Tools::getValue('caption_right') != '0')
                $caption_right = ltrim(Tools::getValue('caption_right'),'0');
            else
                $caption_right = '0';           
            
            $caption_position = trim(Tools::getValue('caption_position'));
            $caption_text_direction = trim(Tools::getValue('caption_text_direction'));
            $caption_animate = trim(Tools::getValue('caption_animate'));
            $slide_effect = trim(Tools::getValue('slide_effect'));
            
                        
            if(empty($caption_position) || empty($caption_animate) || empty($caption_text_direction) || empty($slide_effect))
            {
               $errors[] = $this->l('Slide effect, caption position, caption text direction and caption animate are required'); 
            }
            
            if(!preg_match('/^[0-9]+%$/', $caption_width) && !preg_match('/^[0-9]+px$/', $caption_width))
                $errors[] = $this->l('Caption width is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_top) && !preg_match('/^[0-9]+px$/', $caption_top) && $caption_top!='0')
                $errors[] = $this->l('Caption top is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_left) && !preg_match('/^[0-9]+px$/', $caption_left) && $caption_left!='0')
                $errors[] = $this->l('Caption left is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_right) && !preg_match('/^[0-9]+px$/', $caption_right) && $caption_right!='0')
                $errors[] = $this->l('Caption right is not in valid format');
            
            if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('The image is not set.');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('The image is not set.');
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_slide') && (!Validate::isInt(Tools::getValue('delete_id_slide')) || !$this->slideExists((int)Tools::getValue('delete_id_slide'))))
			$errors[] = $this->l('Invalid slide ID');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	private function _postProcess()
	{
		$errors = array();
		$shop_context = Shop::getContext();

		/* Processes Slider */
		if (Tools::isSubmit('submitSlider'))
		{
			$res = Configuration::updateValue('YBCNIVO_WIDTH', (string)Tools::getValue('YBCNIVO_WIDTH'));
            $res &= Configuration::updateValue('YBCNIVO_HEIGHT', (string)Tools::getValue('YBCNIVO_HEIGHT'));
			$res &= Configuration::updateValue('YBCNIVO_SPEED', (int)Tools::getValue('YBCNIVO_SPEED'));
			$res &= Configuration::updateValue('YBCNIVO_PAUSE', (int)Tools::getValue('YBCNIVO_PAUSE'));
			$res &= Configuration::updateValue('YBCNIVO_LOOP', (int)Tools::getValue('YBCNIVO_LOOP'));
            
            $res &= Configuration::updateValue('YBCNIVO_START_SLIDE', (int)Tools::getValue('YBCNIVO_START_SLIDE'));
			$res &= Configuration::updateValue('YBCNIVO_PAUSE_ON_HOVER', (int)Tools::getValue('YBCNIVO_PAUSE_ON_HOVER'));
			$res &= Configuration::updateValue('YBCNIVO_SHOW_CONTROL', (int)Tools::getValue('YBCNIVO_SHOW_CONTROL'));
            $res &= Configuration::updateValue('YBCNIVO_BUTTON_IMAGE', (int)Tools::getValue('YBCNIVO_BUTTON_IMAGE'));
            $res &= Configuration::updateValue('YBCNIVO_SHOW_PREV_NEXT', (int)Tools::getValue('YBCNIVO_SHOW_PREV_NEXT'));
			$res &= Configuration::updateValue('YBCNIVO_CAPTION_SPEED', (int)Tools::getValue('YBCNIVO_CAPTION_SPEED'));
            $res &= Configuration::updateValue('YBCNIVO_FRAME_WIDTH', ltrim(Tools::getValue('YBCNIVO_FRAME_WIDTH'),'0'));
			

			$this->clearCache();

			if (!$res)
				$errors[] = $this->displayError($this->l('The configuration could not be updated.'));
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&show_setting=true');
		} /* Process Slide status */
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_slide'))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			if ($slide->active == 0)
				$slide->active = 1;
			else
				$slide->active = 0;
			$res = $slide->update();
			$this->clearCache();
			$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('The configuration could not be updated.')));
		}
		/* Processes Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_slide'))
			{
				$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
				if (!Validate::isLoadedObject($slide))
				{
					$this->_html .= $this->displayError($this->l('Invalid slide ID'));

					return false;
				}
			}
			else
				$slide = new YBCNIVOSLIDE();
			/* Sets position */
			$slide->position = (int)Tools::getValue('position');
			/* Sets active */
			$slide->active = (int)Tools::getValue('active_slide');
            
            $slide->caption_top = ltrim(Tools::getValue('caption_top'),'0');
            $slide->caption_left = ltrim(Tools::getValue('caption_left'),'0');
            $slide->caption_right = ltrim(Tools::getValue('caption_right'),'0');
            $slide->caption_width = ltrim(Tools::getValue('caption_width'),'0');
            $slide->caption_position = trim(Tools::getValue('caption_position'));
            $slide->caption_animate = trim(Tools::getValue('caption_animate'));
            $slide->caption_text_direction = trim(Tools::getValue('caption_text_direction'));
            $slide->slide_effect = trim(Tools::getValue('slide_effect'));
            $slide->custom_class = trim(Tools::getValue('custom_class'));
            $slide->button_link = trim(Tools::getValue('button_link'));            
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);

			foreach ($languages as $language)
			{
				$slide->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang']));
				$slide->url[$language['id_lang']] = trim(Tools::getValue('url_'.$language['id_lang']));
				$slide->legend[$language['id_lang']] = trim(Tools::getValue('legend_'.$language['id_lang']));
                $slide->legend2[$language['id_lang']] = trim(Tools::getValue('legend2_'.$language['id_lang']));                
				$slide->description[$language['id_lang']] = trim(Tools::getValue('description_'.$language['id_lang']));
                
                /* Uploads image and sets slide */
				$type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
				$imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name']);
				if (isset($_FILES['image_'.$language['id_lang']]) &&
					isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($imagesize) &&
					in_array(
						Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
							'jpg',
							'gif',
							'jpeg',
							'png'
						)
					) &&
					in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
				)
				{
					$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
					$salt = sha1(microtime());
					if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']]))
						$errors[] = $error;
					elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name))
						return false;
					elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type))
						$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
					if (isset($temp_name))
						@unlink($temp_name);
					$slide->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$slide->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_slide'))
				{
					if (!$slide->add())
						$errors[] = $this->displayError($this->l('The slide could not be added.'));
				}
				/* Update */
				elseif (!$slide->update())
					$errors[] = $this->displayError($this->l('The slide could not be updated.'));
				$this->clearCache();
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_slide'))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('delete_id_slide'));
			$res = $slide->delete();
			$this->clearCache();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitSlide') && Tools::getValue('id_slide'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_slide='.Tools::getValue('id_slide'));
		elseif (Tools::isSubmit('submitSlide'))
        {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_slide='.Db::getInstance()->Insert_ID());
        }
			
	}

	private function _prepareHook()
	{
		if (!$this->isCached('ybc_nivoslider.tpl', $this->getCacheId()))
		{
		    $id_lang = $this->context->language->id;
			$slides = $this->getSlides(true, $id_lang);
            if(!$slides)
                $slides = $this->getSlides(true, (int)Configuration::get('PS_LANG_DEFAULT'));
			if (is_array($slides))
				foreach ($slides as &$slide)
				{
					$slide['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$slide['image']));
					if (isset($slide['sizes'][3]) && $slide['sizes'][3])
						$slide['size'] = $slide['sizes'][3];
				}

			if (!$slides)
				return false;
            $options = array(
                'max_width' => Configuration::get('YBCNIVO_WIDTH'),
                'max_height' => Configuration::get('YBCNIVO_HEIGHT')
            );
			$this->smarty->assign(array('homeslider_slides' => $slides,'options' => $options,'ybc_nivo_dir' => $this->_path));
		}

		return true;
	}

	public function hookdisplayHeader($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$this->context->controller->addCSS($this->_path.'css/nivo/themes/default/default.css');
        $this->context->controller->addCSS($this->_path.'css/nivo/nivo-slider.css');
        $this->context->controller->addCSS($this->_path.'css/animate.css');
		$this->context->controller->addJS($this->_path.'js/jquery.nivo.slider.js');
        $this->context->controller->addJS($this->_path.'js/ybcnivoslider.js');
        $this->smarty->assign('ybcnivo', $this->getConfigFieldsValues());
		return $this->display(__FILE__, 'header.tpl');
    }

	public function hookdisplayTop($params)
	{
		return $this->hookdisplayTopColumn($params);
	}

	public function hookdisplayTopColumn($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;

		if (!$this->_prepareHook())
			return false;

		return $this->display(__FILE__, 'ybc_nivoslider.tpl', $this->getCacheId());
	}

	public function hookDisplayHome()
	{
		if (!$this->_prepareHook())
			return false;

		return $this->display(__FILE__, 'ybc_nivoslider.tpl', $this->getCacheId());
	}

	public function clearCache()
	{
		$this->_clearCache('ybc_nivoslider.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
			INSERT IGNORE INTO '._DB_PREFIX_.'ybcnivoslider (id_homeslider_slides, id_shop)
			SELECT id_homeslider_slides, '.(int)$params['new_id_shop'].'
			FROM '._DB_PREFIX_.'ybcnivoslider
			WHERE id_shop = '.(int)$params['old_id_shop']
		);
		$this->clearCache();
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');
		/* Style & js for fieldset 'slides configuration' */
		$html = '<script type="text/javascript">
			$(function() {
				var $mySlides = $("#slides");
				$mySlides.sortable({
					opacity: 0.6,
					cursor: "move",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
						$.post("'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/ybc_nivoslider/ajax_ybc_nivoslider.php?secure_key='.$this->secure_key.'", order);
						}
					});
				$mySlides.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
				});
			});
		</script>';

		return $html;
	}

	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(hss.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'ybcnivoslider_slides` hss, `'._DB_PREFIX_.'ybcnivoslider` hs
			WHERE hss.`id_homeslider_slides` = hs.`id_homeslider_slides` AND hs.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	public function getSlides($active = null, $id_lang = 0)
	{
	    if(!$id_lang)
            $id_lang = (int)$this->context->language->id;
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
        $where = '';
        if(class_exists('ybc_themeconfig') && isset($this->context->controller->controller_type) && $this->context->controller->controller_type=='front')
        {
            $tc = new Ybc_themeconfig();
            if($tc->devMode && ($ids = $tc->getLayoutConfiguredField('slides')))
            {
                $where = ' AND hs.id_homeslider_slides IN('.implode(',',$ids).') ';
            }
        }
        $sql = '
			SELECT hs.`id_homeslider_slides` as id_slide, hssl.`image`, hss.`position`, hss.`active`, hssl.`title`,hss.`caption_top`,hss.`caption_left`,hss.`button_link`,hss.`custom_class`,hss.`caption_right`,hss.`caption_width`,hss.`caption_position`,hss.`caption_text_direction`,hss.`slide_effect`,hss.`caption_animate`,
			hssl.`url`, hssl.`legend`,hssl.`legend2`, hssl.`description`, hssl.`image`
			FROM '._DB_PREFIX_.'ybcnivoslider hs
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides hss ON (hs.id_homeslider_slides = hss.id_homeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides_lang hssl ON (hss.id_homeslider_slides = hssl.id_homeslider_slides)
			WHERE id_shop = '.(int)$id_shop.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hss.`active` = 1' : ' ').$where.'
			ORDER BY hss.position';
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	}

	public function getAllImagesBySlidesId($id_slides, $active = null, $id_shop = null)
	{
		$this->context = Context::getContext();
		$images = array();

		if (!isset($id_shop))
			$id_shop = $this->context->shop->id;

		$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hssl.`image`, hssl.`id_lang`
			FROM '._DB_PREFIX_.'ybcnivoslider hs
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides hss ON (hs.id_homeslider_slides = hss.id_homeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides_lang hssl ON (hss.id_homeslider_slides = hssl.id_homeslider_slides)
			WHERE hs.`id_homeslider_slides` = '.(int)$id_slides.' AND hs.`id_shop` = '.(int)$id_shop.
			($active ? ' AND hss.`active` = 1' : ' ')
		);

		foreach ($results as $result)
			$images[$result['id_lang']] = $result['image'];

		return $images;
	}

	public function displayStatus($id_slide, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_slide='.(int)$id_slide.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';

		return $html;
	}

	public function slideExists($id_slide)
	{
		$req = 'SELECT hs.`id_homeslider_slides` as id_slide
				FROM `'._DB_PREFIX_.'ybcnivoslider` hs
				WHERE hs.`id_homeslider_slides` = '.(int)$id_slide;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function renderList()
	{ 
		$slides = $this->getSlides();
		foreach ($slides as $key => $slide)
			$slides[$key]['status'] = $this->displayStatus($slide['id_slide'], $slide['active']);

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'slides' => $slides,
				'image_baseurl' => $this->_path.'images/'
			)
		);

		return $this->display(__FILE__, 'list.tpl');
	}

	public function renderAddForm()
	{
	   
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Slide information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'file_lang',
						'label' => $this->l('Select a file'),
						'name' => 'image',
						'lang' => true,
						'desc' => $this->l(sprintf('Maximum image size: %s.', ini_get('upload_max_filesize'))),
                        'required' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Slide title'),
						'name' => 'title',
						'lang' => true,                        
					),
					array(
						'type' => 'text',
						'label' => $this->l('Target URL'),
						'name' => 'url',
						'lang' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Caption'),
						'name' => 'legend',
						'lang' => true,
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Button label'),
						'name' => 'legend2',                        
						'lang' => true,
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Button link'),
						'name' => 'button_link',
                    ),                    
					array(
						'type' => 'textarea',
						'label' => $this->l('Description'),
						'name' => 'description',
						'autoload_rte' => true,
						'lang' => true,
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Custom class'),
						'name' => 'custom_class',
                    ),
					array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'active_slide',
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
						),
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Slide transition effect'),
						'name' => 'slide_effect',
                        'required' => true,
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'random',              
                                    'name' => $this->l('Random') 
                                ),
                                array(
                                    'id_option' => 'fade',              
                                    'name' => $this->l('Fade') 
                                ),
                                array(
                                    'id_option' => 'fold',              
                                    'name' => $this->l('Fold') 
                                ),
                                array(
                                    'id_option' => 'boxRandom',              
                                    'name' => $this->l('Box random') 
                                ),
                                array(
                                    'id_option' => 'boxRain',              
                                    'name' => $this->l('Box rain') 
                                ),
                                array(
                                    'id_option' => 'boxRainReverse',              
                                    'name' => $this->l('Box rain reverse') 
                                ),
                                array(
                                    'id_option' => 'boxRainGrow',              
                                    'name' => $this->l('Box rain grow') 
                                ),
                                array(
                                    'id_option' => 'boxRainGrowReverse',              
                                    'name' => $this->l('Box rain grow reverse') 
                                ),
                                array(
                                    'id_option' => 'slideInLeft',              
                                    'name' => $this->l('Slice in left') 
                                ),
                                array(
                                    'id_option' => 'slideInRight',              
                                    'name' => $this->l('Slice in right') 
                                ),
                                array(
                                    'id_option' => 'sliceDown',              
                                    'name' => $this->l('Slice down') 
                                ),
                                array(
                                    'id_option' => 'sliceDownLeft',              
                                    'name' => $this->l('Slice down left') 
                                ),
                                array(
                                    'id_option' => 'sliceUp',              
                                    'name' => $this->l('Slice up') 
                                ),
                                array(
                                    'id_option' => 'sliceUpLeft',              
                                    'name' => $this->l('Slice up left') 
                                ),
                                array(
                                    'id_option' => 'sliceUpDown',              
                                    'name' => $this->l('Slice up down') 
                                ),
                                array(
                                    'id_option' => 'sliceUpDownLeft',              
                                    'name' => $this->l('Slice up down left') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption top'),
						'name' => 'caption_top',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),
                        'required' => true,                       				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption left'),
						'name' => 'caption_left',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),  
                        'required' => true,                     				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption right'),
						'name' => 'caption_right',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),    
                        'required' => true,                   				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption width'),
						'name' => 'caption_width',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 300px, 40%'), 
                        'required' => true,                      				
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Caption position'),
						'name' => 'caption_position',
                        'required' => true,
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'left',              
                                    'name' => $this->l('Left') 
                                ),
                                array(
                                    'id_option' => 'center',              
                                    'name' => $this->l('Center') 
                                ),
                                array(
                                    'id_option' => 'right',              
                                    'name' => $this->l('Right') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    array(
						'type' => 'select',
						'label' => $this->l('Caption text direction'),
						'name' => 'caption_text_direction',
                        'required' => true,
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'left',              
                                    'name' => $this->l('Left') 
                                ),
                                array(
                                    'id_option' => 'center',              
                                    'name' => $this->l('Center') 
                                ),
                                array(
                                    'id_option' => 'right',              
                                    'name' => $this->l('Right') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    array(
						'type' => 'select',
						'label' => $this->l('Caption animation effect'),
						'name' => 'caption_animate',
                        'required' => true,
                		'options' => array(
                			'query' => array(                                
                                array(
                                    'id_option' => 'type1',              
                                    'name' => $this->l('Type 1') 
                                ),
                                array(
                                    'id_option' => 'type2',              
                                    'name' => $this->l('Type 2') 
                                ),
                                array(
                                    'id_option' => 'type3',              
                                    'name' => $this->l('Type 3') 
                                ),
                                array(
                                    'id_option' => 'type4',              
                                    'name' => $this->l('Type 4') 
                                ),
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    )
				),
                'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_slide');
			$fields_form['form']['images'] = $slide->image;

			$has_picture = true;

			foreach (Language::getLanguages(false) as $lang)
				if (!isset($slide->image[$lang['id_lang']]))
					$has_picture &= false;

			if ($has_picture)
				$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
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
		$helper->submit_action = 'submitSlide';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/',
            'link' => $this->context->link
		);

		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);

		if (count($languages) > 1)
			return $this->getMultiLanguageInfoMsg().$helper->generateForm(array($fields_form));
		else
			return $helper->generateForm(array($fields_form));
	}

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Maximum image width'),
						'name' => 'YBCNIVO_WIDTH',
						'suffix' => 'pixels  / percent',
                        'desc' => $this->l('Eg: 1000px, 100%')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Maximum image height'),
						'name' => 'YBCNIVO_HEIGHT',
						'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 300px, 40%')
					),
					array(
						'type' => 'text',
						'label' => $this->l('Speed'),
						'name' => 'YBCNIVO_SPEED',
						'suffix' => 'milliseconds',
						'desc' => $this->l('The duration of the transition between two slides.')
					),
					array(
						'type' => 'text',
						'label' => $this->l('Pause'),
						'name' => 'YBCNIVO_PAUSE',
						'suffix' => 'milliseconds',
						'desc' => $this->l('The delay between two slides.')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Starting slide'),
						'name' => 'YBCNIVO_START_SLIDE',						
						'desc' => $this->l('Lowest valule is 1, highest value is the number of slides')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption frame width'),
						'name' => 'YBCNIVO_FRAME_WIDTH',
                        'suffix' => 'pixels / percent',						
						'desc' => $this->l('Eg: 1000px, 100%')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption delay'),
						'name' => 'YBCNIVO_CAPTION_SPEED',
                        'suffix' => 'milliseconds',						
						'desc' => $this->l('Delay time between 2 captions')
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Auto play'),
						'name' => 'YBCNIVO_LOOP',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Pause on hover'),
						'name' => 'YBCNIVO_PAUSE_ON_HOVER',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show control buttons'),
						'name' => 'YBCNIVO_SHOW_CONTROL',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
                    array(
						'type' => 'switch',
						'label' => $this->l('Display button images'),
						'name' => 'YBCNIVO_BUTTON_IMAGE',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show next/prev buttons'),
						'name' => 'YBCNIVO_SHOW_PREV_NEXT',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
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
		$helper->submit_action = 'submitSlider';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'image_baseurl' => $this->_path.'images/',
            'link' => $this->context->link
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		return array(
			'YBCNIVO_WIDTH' => Tools::getValue('YBCNIVO_WIDTH', Configuration::get('YBCNIVO_WIDTH')),
            'YBCNIVO_HEIGHT' => Tools::getValue('YBCNIVO_HEIGHT', Configuration::get('YBCNIVO_HEIGHT')),
			'YBCNIVO_SPEED' => Tools::getValue('YBCNIVO_SPEED', Configuration::get('YBCNIVO_SPEED')),
			'YBCNIVO_PAUSE' => Tools::getValue('YBCNIVO_PAUSE', Configuration::get('YBCNIVO_PAUSE')),
			'YBCNIVO_LOOP' => Tools::getValue('YBCNIVO_LOOP', Configuration::get('YBCNIVO_LOOP')),
            'YBCNIVO_START_SLIDE' => Tools::getValue('YBCNIVO_START_SLIDE', Configuration::get('YBCNIVO_START_SLIDE')),
            'YBCNIVO_PAUSE_ON_HOVER' => Tools::getValue('YBCNIVO_PAUSE_ON_HOVER', Configuration::get('YBCNIVO_PAUSE_ON_HOVER')),
            'YBCNIVO_BUTTON_IMAGE' => Tools::getValue('YBCNIVO_BUTTON_IMAGE', Configuration::get('YBCNIVO_BUTTON_IMAGE')),
            'YBCNIVO_SHOW_CONTROL' => Tools::getValue('YBCNIVO_SHOW_CONTROL', Configuration::get('YBCNIVO_SHOW_CONTROL')),
            'YBCNIVO_SHOW_PREV_NEXT' => Tools::getValue('YBCNIVO_SHOW_PREV_NEXT', Configuration::get('YBCNIVO_SHOW_PREV_NEXT')),
            'YBCNIVO_CAPTION_SPEED' => Tools::getValue('YBCNIVO_CAPTION_SPEED', Configuration::get('YBCNIVO_CAPTION_SPEED')),
            'YBCNIVO_FRAME_WIDTH' => Tools::getValue('YBCNIVO_FRAME_WIDTH', Configuration::get('YBCNIVO_FRAME_WIDTH'))
		);
	}

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			$fields['id_slide'] = (int)Tools::getValue('id_slide', $slide->id);
		}
		else
        {
            $slide = new YBCNIVOSLIDE();
        }
		$fields['slide_effect'] = Tools::getValue('slide_effect', $slide->slide_effect);	
        $fields['caption_top'] = Tools::getValue('caption_top', $slide->caption_top ? $slide->caption_top : '0');
        $fields['caption_left'] = Tools::getValue('caption_left', $slide->caption_left ? $slide->caption_left : '0');
        $fields['caption_right'] = Tools::getValue('caption_right', $slide->caption_right ? $slide->caption_right : '0');
        $fields['caption_width'] = Tools::getValue('caption_width', $slide->caption_width);
        $fields['caption_position'] = Tools::getValue('caption_position', $slide->caption_position);
        $fields['caption_animate'] = Tools::getValue('caption_animate', $slide->caption_animate);
        $fields['caption_text_direction'] = Tools::getValue('caption_text_direction', $slide->caption_text_direction);
		$fields['active_slide'] = Tools::getValue('active_slide', $slide->active);
        $fields['button_link'] = Tools::getValue('button_link', $slide->button_link);
        $fields['custom_class'] = Tools::getValue('custom_class', $slide->custom_class);
        
		$fields['has_picture'] = true;

		$languages = Language::getLanguages(false);
        
        /**
         *  Default
         */
        
        if(!Tools::isSubmit('submitSlide') && !Tools::isSubmit('id_slide'))
        {
            $fields['slide_effect'] = $this->default_slide_effect;
            $fields['caption_top'] = $this->default_caption_top;
            $fields['active_slide'] = 1;
            $fields['caption_left'] = $this->default_caption_left;
            $fields['caption_right'] = $this->default_caption_right;
            $fields['caption_width'] = $this->default_caption_width;
            $fields['caption_position'] = $this->default_caption_position;
            $fields['caption_animate'] = $this->default_caption_animate;
            $fields['caption_text_direction'] = $this->default_caption_text_direction;
        }
        
		foreach ($languages as $lang)
		{
			$fields['image'][$lang['id_lang']] = Tools::getValue('image_'.(int)$lang['id_lang']);
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $slide->title[$lang['id_lang']]);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $slide->url[$lang['id_lang']]);
			$fields['legend'][$lang['id_lang']] = Tools::getValue('legend_'.(int)$lang['id_lang'], $slide->legend[$lang['id_lang']]);
            $fields['legend2'][$lang['id_lang']] = Tools::getValue('legend2_'.(int)$lang['id_lang'], $slide->legend2[$lang['id_lang']]);            
			$fields['description'][$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], $slide->description[$lang['id_lang']]);
		}

		return $fields;
	}

	private function getMultiLanguageInfoMsg()
	{
		return '<p class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'</p>';
	}

	private function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage slides items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}

	private function getShopContextError($shop_contextualized_name, $mode)
	{
		if ($mode == 'edit')
			return '<p class="alert alert-danger">'.
							$this->l(sprintf('You can only edit this slide from the shop context: %s', $shop_contextualized_name)).
					'</p>';
		else
			return '<p class="alert alert-danger">'.
							$this->l(sprintf('You cannot add slides from a "All Shops" or a "Group Shop" context')).
					'</p>';
	}


	private function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
				$shop_info = $this->l(sprintf('The modifications will be applied to shop: %s', $this->context->shop->name));
			else if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$shop_info = $this->l(sprintf('The modifications will be applied to this group: %s', Shop::getContextShopGroup()->name));
			else
				$shop_info = $this->l('The modifications will be applied to all shops and shop groups');

			return '<div class="alert alert-info">'.
						$shop_info.
					'</div>';
		}
		else
			return '';
	}
    private function installSample()
     {       
       $languages = Language::getLanguages(false);
       $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
       $sqlFile = dirname(__FILE__).'/data/sql/slide.sql';       
       if(file_exists($sqlFile) && ($sql = Tools::file_get_contents($sqlFile)))
       {
            $tbs =  array('ybcnivoslider','ybcnivoslider_slides','ybcnivoslider_slides_lang');            
            foreach($tbs as $tbl)
            {
                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_.$tbl);               
            }            
            if(!$this->parseSql($sql))
            {
                $sqlLangFile = dirname(__FILE__).'/data/sql/slide_lang.sql';
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
       if($oldFiles = glob(dirname(__FILE__).'/images/*'))
        {
            foreach($oldFiles as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }         
        $this->copyDir(dirname(__FILE__).'/data/img/',dirname(__FILE__).'/images/');
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