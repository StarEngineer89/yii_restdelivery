<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Theme: Your Best First
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
/**
 * Includes 
 */   

class Ybc_themeconfig extends Module
{
    private $baseAdminPath;
    private $errorMessage = false;
    public $skins;
    public $layouts;
    public $fontSizes;
    public $fonts;
    public $bgs;
    public $modules;
    public $configs;
    public $_html;
    public $tabs;
    public $modulePath;
    public $gfonts;
    public $devMode = false;
    public $colors = array();    
    public function __construct()
	{
		$this->name = 'ybc_themeconfig';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'ETS Software Solutions (ETS-Soft)';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();
        
		$this->displayName = $this->l('Theme options');
		$this->description = $this->l('Configure your theme');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        if($this->context->controller->controller_type =='admin')
            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
	   $this->modulePath = $this->_path;
       $this->gfonts = array(
            'https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,800,900',
            'https://fonts.googleapis.com/css?family=Arimo:400,300,500,600,700,200,800,900',
            'https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,800,900',           
       );
       $this->tabs = array(
            'ybc_tab_general' => $this->l('General'),
            'ybc_tab_font' => $this->l('Fonts'), 
            'ybc_tab_header' => $this->l('Header'), 
            'ybc_tab_home' => $this->l('Home page'), 
            'ybc_tab_footer' => $this->l('Footer'),
            'ybc_tab_product' => $this->l('Product details page'),
            'ybc_tab_product_listing' => $this->l('Product listing pages'),
            'ybc_tab_social' => $this->l('Socials'),
            'ybc_tab_contact' => $this->l('Contact'),  
            //'ybc_tab_instagram' => $this->l('Instagram'),  
            //'ybc_tab_parallax' => $this->l('Custom'),            
            'ybc_tab_import' => $this->l('Import sample data'),  
       );
       $this->colors = array(
            'color1' => '#ff6c8d',
            'color2' => '#ffffff',
            'color3' => '#11e5ef',
            'color4' => '#ffc33c',
            'color5' => '#00ccd6',
            'color6' => '#ff8f8f',
            'color7' => '#a72c00',
       );
       $this->configs = array(
            'BEGIN_FORM' => array(
                'html' => $this->renderTabs(),
            ),
            'YBC_TC_DISPLAY_SETTING' => array(
                'label' => $this->l('Display front setting panel'),
                'type' => 'switch',
                'default' => 1,   
                'group' => 'ybc_tab_general',        
            ), 
            'YBC_TC_CACHE_CSS' => array(
                'label' => $this->l('Cache dynamic CSS'),
                'type' => 'switch',
                'default' => 0,   
                'group' => 'ybc_tab_general',        
            ),             
            'YBC_TC_FLOAT_HEADER' => array(
                'label' => $this->l('Float header'),
                'type' => 'switch',
                'default' => 1,
                'body_class' => true, 
                'group' => 'ybc_tab_header',
                'client_config' => true,
            ),   
            'YBC_TC_FLOAT_CSS3' => array(
                'label' => $this->l('Enable floating CSS3 transition effect'),
                'type' => 'switch',
                'default' => 1,
                'body_class' => true, 
                'group' => 'ybc_tab_general',
                'client_config' => true,
            ),  
            'YBC_TC_LAYOUT' => array(
                'label' => $this->l('Layout'),
                'type' => 'select',                
                'group' => 'ybc_tab_general', 
                'client_config' => true,                    
				'options' => array(
        			 'query' => array( 
                            array(
                                'id_option' => 'LAYOUT5', 
                                'name' => $this->l('Home page 1'),
                                //
                                'slides' => array(11,16,17),
                                'widgets' => array(53,65,66,54,14,61,62,63,64,67),
                                //'blogs' => array(1,2,3,4),
                            ),
                            array(
                                'id_option' => 'LAYOUT2', 
                                'name' => $this->l('Home page 2'),
                                //
                                'slides' => array(18,19,20),
                                'widgets' => array(53,54,14,61,62,63,64,67),
                                //'blogs' => array(1,2,3,4),
                            ),
                            array(
                                'id_option' => 'LAYOUT3', 
                                'name' => $this->l('Home page 3'),
                                //
                                'slides' => array(21,22,23),
                                'widgets' => array(53,54,14,61,62,63,64,67),
                                //'blogs' => array(1,2,3,4),
                            ),
                             
                        ),                             
                     'id' => 'id_option',
        			 'name' => 'name'  
                ),    
                'default' => 'LAYOUT5',
                'body_class' => true,                 
            ),          
            'YBC_TC_SKIN' => array(
                'label' => $this->l('Theme color'),
                'type' => 'select',                
                'group' => 'ybc_tab_general',  
                'client_config' => true,                   
				'options' => array(
        			 'query' => array(
                            array(
                                'id_option' => 'GREEN_1', 
                                'name' => $this->l('Green 1'),
                                'main_color' => '#60bd00',
                                'colors' => array(
                                    'color1' => '#60bd00',
                                    'color2' => '#ffffff',
                                    'color3' => '#faaa47',
                                    'color4' => '#ff6c8d',    
                                    'color5' => '#5e5e5e', 
                                    'color6' => '#ff8f8f',
                                    'color7' => '#a72c00',                            
                                ),
                                'logo' => 'green.png',
                            ),
                            array(
                                'id_option' => 'GREEN_2', 
                                'name' => $this->l('Green 2'),
                                'main_color' => '#87af33',
                                'colors' => array(
                                    'color1' => '#87af33',
                                    'color2' => '#ffffff',
                                    'color3' => '#f46f3f',
                                    'color4' => '#6e9ecf',    
                                    'color5' => '#dd5f32', 
                                    'color6' => '#87af33',
                                    'color7' => '#87af33',                                
                                ),
                                'logo' => 'green2.png',
                            ),
                            array(
                                'id_option' => 'BLUE_1', 
                                'name' => $this->l('Blue 1'),
                                'main_color' => '#28abe3',
                                'colors' => array(
                                    'color1' => '#28abe3',
                                    'color2' => '#ffffff',
                                    'color3' => '#ffc63d',
                                    'color4' => '#ee3f22',  
                                    'color5' => '#f9b002', 
                                    'color6' => '#01aae8',
                                    'color7' => '#fa6900',                                  
                                ),
                                'logo' => 'blue.png',
                            ),
                            array(
                                'id_option' => 'BLUE_2', 
                                'name' => $this->l('Blue 2'),
                                'main_color' => '#6e9ecf',
                                'colors' => array(
                                    'color1' => '#6e9ecf',
                                    'color2' => '#ffffff',
                                    'color3' => '#ffd168',
                                    'color4' => '#ff6c8d',    
                                    'color5' => '#ffc33c', 
                                    'color6' => '#ff8f8f',
                                    'color7' => '#a72c00',                            
                                ),
                                'logo' => 'blue2.png',
                            ),                         
                            array(
                                'id_option' => 'BLUE_3', 
                                'name' => $this->l('Blue 3'),                 
                                'main_color' => '#73c5e1',
                                'colors' => array(
                                    'color1' => '#73c5e1',
                                    'color2' => '#ffffff',
                                    'color3' => '#ff8ca6',
                                    'color4' => '#ffd041',
                                    'color5' => '#ff6c8d', 
                                    'color6' => '#c79b50',
                                    'color7' => '#fa6900',                                  
                                ),
                                'logo' => 'blue3.png',
                            ), 
                            array(
                                'id_option' => 'CYAN', 
                                'name' => $this->l('CYAN'),
                                'main_color' => '#00ccd6',
                                'colors' => array(
                                    'color1' => '#00ccd6',
                                    'color2' => '#ffffff',
                                    'color3' => '#fecc5c',
                                    'color4' => '#ff4c65',    
                                    'color5' => '#ffc33c', 
                                    'color6' => '#ff8f8f',
                                    'color7' => '#a72c00',                            
                                ),
                                'logo' => 'cyan.png',
                            ),
                            array(
                                'id_option' => 'RED', 
                                'name' => $this->l('Red'),
                                'main_color' => '#ff3234',
                                'colors' => array(
                                    'color1' => '#ff3234',
                                    'color2' => '#ffffff',
                                    'color3' => '#32d7fe',
                                    'color4' => '#ffc33c',    
                                    'color5' => '#00c8f8', 
                                    'color6' => '#de5842',
                                    'color7' => '#fcd059',                                
                                ),
                                'logo' => 'red.png',
                            ),
                            
                            array(
                                'id_option' => 'CUSTOM', 
                                'name' => $this->l('Custom color (Your color)'),
                                'main_color' => Configuration::get('YBC_TC_COLOR_COLOR1'),
                                'logo' => 'custom.png',
                            ), 
                        ),                                                  
                     'id' => 'id_option',
        			 'name' => 'name'  
                ),    
                'default' => 'GREEN_1',
                'body_class' => true, 
            ),         
             
            'YBC_SHOPMSG_MESSAGE' => array(
                'label' => $this->l('Shop alert'),
                'type' => 'textarea',
                'default' => $this->l('Welcome to our online store!'),                
                'group' => 'ybc_tab_header',
                'lang' => true,
                'info' => Module::isInstalled('ybc_shopmsg') && Module::isEnabled('ybc_shopmsg') ? false : $this->l('You need to install and enable module "ybc_shopmsg" to use this feature'), 
            ),  
            'YBC_TC_ENABLE_BANNER' => array(                
                'label' => $this->l('Display long banners on home page'),
                'type' => 'switch',
                'group' => 'ybc_tab_home',  
                'default' => 0,  
            ),           
            'YBC_TC_COPYRIGHT_TEXT' => array(                
                'label' => $this->l('Copyright text'),				
                'lang' => true,
                'type' => 'textarea',
                'group' => 'ybc_tab_footer',                
                'default' => 'Copyright 2017 <a href="#">PRO Business Co., LTD</a>. All rights reserved.',
            ), 
            'YBC_TC_POWERED_TEXT' => array(                
                'label' => $this->l('Powered by'),				
                'lang' => true,
                'type' => 'textarea',
                'group' => 'ybc_tab_footer',                
                'default' =>'Website is proudly powered by <b>Probusiness</b> open source. All images used in the demo website are for preview purpose only  and not included in the download file',
            ),   
            'YBC_TC_PAYMENT_LOGO' => array(                
                'label' => $this->l('Payment logo'),
                'type' => 'file',
                'group' => 'ybc_tab_footer',
                'default' => 'payment.png'
            ),
            'YBC_TC_FONT1_NAME' => array(                
                'label' => $this->l('General font name'),
                'type' => 'text',
                'group' => 'ybc_tab_font',  
                'desc' => $this->l('Leave blank to use default font'),                   
            ),  
            'YBC_TC_FONT1_DATA' => array(                
                'label' => $this->l('General font data'),
                'type' => 'textarea',
                'group' => 'ybc_tab_font', 
                'separator' => true,   
                'data_type' => 'font',     
                'validate' => 'isString',                              
            ),              
            'YBC_TC_FONT2_NAME' => array(                
                'label' => $this->l('Heading font name'),
                'type' => 'text',
                'group' => 'ybc_tab_font',  
                'desc' => $this->l('Leave blank to use default font'),                         
            ),  
            'YBC_TC_FONT2_DATA' => array(                
                'label' => $this->l('Heading font data'),
                'type' => 'textarea',
                'group' => 'ybc_tab_font',   
                'separator' => true,   
                'data_type' => 'font',  
                'validate' => 'isString',               
            ),              
            'YBC_TC_FONT3_NAME' => array(                
                'label' => $this->l('Other font name'),
                'type' => 'text',
                'group' => 'ybc_tab_font', 
                'desc' => $this->l('Leave blank to use default font'),                               
            ),  
            'YBC_TC_FONT3_DATA' => array(                
                'label' => $this->l('Other font data'),
                'type' => 'textarea',
                'group' => 'ybc_tab_font',    
                'data_type' => 'font',  
                'validate' => 'isString',                 
            ),  
            'YBC_TC_PRODUCT_LAYOUT' => array(
                'label' => $this->l('Product layout'),
                'type' => 'select',                
                'group' => 'ybc_tab_product',                     
				'options' => array(
        			 'query' => array(                             
                            array(
                                'id_option' => 'layout1', 
                                'name' => $this->l('Layout 1')
                            ),
                            array(
                                'id_option' => 'layout2', 
                                'name' => $this->l('Layout 2')
                            ),   
                        ),                             
                     'id' => 'id_option',
        			 'name' => 'name'  
                ),    
                'default' => 'layout2',
                'body_class' => true, 
            ),      
            'PS_DISPLAY_JQZOOM' => array(                
                'label' => $this->l('Enable JqZoom'),
                'type' => 'switch',
                'group' => 'ybc_tab_product',    
                'default' => 0,            
            ),              
            'YBC_TC_USEFUL_LINK' => array(                
                'label' => $this->l('Enable useful buttons'),
                'type' => 'switch',
                'desc' => $this->l('Add to wishlist, Send to a friend, Print'),
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),  
            'YBC_TC_SOCIAL_SHARING' => array(                
                'label' => $this->l('Enable social sharing buttons'),
                'type' => 'switch',                
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),
            'YBC_TC_PRODUCT_REF' => array(                
                'label' => $this->l('Display product reference text'),
                'type' => 'switch',                
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),
            'YBC_TC_CONDITION' => array(                
                'label' => $this->l('Display product condition text'),
                'type' => 'switch',                
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),
            'YBC_TC_PRODUCT_QTY' => array(                
                'label' => $this->l('Display available product quantity'),
                'type' => 'switch',                
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),
            'YBC_TC_PRODUCT_REVIEW' => array(                
                'label' => $this->l('Display everage product review'),
                'type' => 'switch',                
                'group' => 'ybc_tab_product',    
                'default' => 1,            
            ),
            /*social*/
            'BLOCKSOCIAL_FACEBOOK' => array(                
                'label' => $this->l('Facebook URL'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your Facebook fan page.'),  
                'default' => '#',                       
            ),
            'BLOCKSOCIAL_TWITTER' => array(                
                'label' => $this->l('Twitter URL'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official Twitter account.'),
                'default' => '#',                       
            ),
            'BLOCKSOCIAL_RSS' => array(                
                'label' => $this->l('RSS URL'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('The RSS feed of your choice (your blog, your store, etc.).'),  
                'default' => '#',                   
            ),
            'BLOCKSOCIAL_YOUTUBE' => array(                
                'label' => $this->l('YouTube URL'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official YouTube account.'), 
                'default' => '#',                    
            ),
            'BLOCKSOCIAL_GOOGLE_PLUS' => array(                
                'label' => $this->l('Google+ URL:'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official Google+ page.'),   
                'default' => '#',                  
            ),
            'BLOCKSOCIAL_PINTEREST' => array(                
                'label' => $this->l('Pinterest URL:'),
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official Pinterest account.'),  
                'default' => '#',                       
            ),
            'BLOCKSOCIAL_VIMEO' => array(                
                'label' => $this->l('Vimeo URL:'),	
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official Vimeo account.'),	
                'default' => '#',   	                     
            ),
            'BLOCKSOCIAL_INSTAGRAM' => array(                
                'label' => $this->l('Instagram URL:'),	
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official Instagram account.'),	   
                'default' => '#',                       
            ),
            'BLOCKSOCIAL_LINKEDIN' => array(                
                'label' => $this->l('Lnkedin URL:'),	
                'type' => 'text',
                'group' => 'ybc_tab_social',  
                'desc' => $this->l('Your official linkedin account.'),	     
                'default' => '#',                     
            ),    
            'YBC_TC_CONTACT_FORM_LAYOUT' => array(
                'label' => $this->l('Contact form layout'),
                'type' => 'select',                
                'group' => 'ybc_tab_contact',                     
				'options' => array(
        			 'query' => array(                             
                            array(
                                'id_option' => 'layout1', 
                                'name' => $this->l('Layout 1')
                            ),
                            array(
                                'id_option' => 'layout2', 
                                'name' => $this->l('Layout 2')
                            ),
                            array(
                                'id_option' => 'layout3', 
                                'name' => $this->l('Layout 3')
                            ),   
                        ),                             
                     'id' => 'id_option',
        			 'name' => 'name'  
                ),    
                'default' => 'layout1',
                'body_class' => true, 
                'client_config' => true,
            ),
                  
            'BLOCKCONTACTINFOS_COMPANY' => array(                
                'label' => $this->l('Company name'),
                'type' => 'text',
                'group' => 'ybc_tab_contact', 
                'default' => 'Your company',                     
            ),
            'BLOCKCONTACTINFOS_ADDRESS' => array(                
                'label' => $this->l('Address'),
                'type' => 'textarea',
                'group' => 'ybc_tab_contact',  
                'default' => 'Puffin street 12345 Puffinville France',                       
            ),
            'BLOCKCONTACTINFOS_PHONE' => array(                
                'label' => $this->l('Phone number'),
                'type' => 'text',
                'group' => 'ybc_tab_contact',     
                'default' => '0123-456-789',                          
            ),
            'BLOCKCONTACTINFOS_PHONE_TOP' => array(                
                'label' => $this->l('Header Phone number'),
                'type' => 'text',
                'group' => 'ybc_tab_contact',     
                'default' => '0123-456-789',                          
            ),
            'BLOCKCONTACTINFOS_EMAIL' => array(                
                'label' => $this->l('Email'),
                'type' => 'text',
                'group' => 'ybc_tab_contact', 
                'default' => 'sales@yourcompany.com',                              
            ),
            'BLOCKCONTACTINFOS_SKYPE' => array(                
                'label' => $this->l('Skype'),				
                'lang' => true,
                'type' => 'textarea',
                'group' => 'ybc_tab_contact',                
                'default' => 'skypername',
            ),
            'YBC_TC_CONTACT_PAGE_TEXT' => array(                
                'label' => $this->l('Contact Info'),
                'type' => 'textarea',
                'group' => 'ybc_tab_contact', 
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',                              
            ),
            'YBC_TC_GOOGLE_MAP_EMBED_CODE' => array(                
                'label' => $this->l('Google map embed code'),
                'type' => 'textarea',
                'group' => 'ybc_tab_contact', 
                'default' => '',
                'validate' => 'isString',                             
            ),            
            /*'YBC_INSTAGRAM_UID' => array(                
                'label' => $this->l('User ID'),
                'type' => 'text',
                'group' => 'ybc_tab_instagram',
                'default' => '3535749842',
            ),
            'YBC_INSTAGRAM_ACCESS_TOKEN' => array(                
                'label' => $this->l('Access token'),
                'type' => 'text',
                'group' => 'ybc_tab_instagram', 
                'default' => '3535749842.dd82889.4d1a3eabbdcb46a08bead1de066197fd',                        
            ),
            'YBC_INSTAGRAM_IMG_NUMBER' => array(                
                'label' => $this->l('Number of displayed images'),
                'type' => 'text',
                'group' => 'ybc_tab_instagram',
                'default' => 12,
                'info' => Module::isInstalled('ybc_instagram') && Module::isEnabled('ybc_instagram') ? false : $this->l('*Note: You need to install and enable module "ybc_instagram" to use this feature'),                          
            ),
            'YBC_INSTAGRAM_CACHE' => array(
                'label' => $this->l('Cache Instagram request'),
                'type' => 'switch',                
                'default' => 1,     
                'group' => 'ybc_tab_instagram',       
            ),*/
            'YBC_TC_LISTING_REVIEW' => array(
                'label' => $this->l('Display product review'),
                'type' => 'switch',
                'default' => 1,   
                'group' => 'ybc_tab_product_listing',        
            ), 
            'YBC_TC_LISTING_IMAGE_BLOCK' => array(
                'label' => $this->l('Display category image block'),
                'type' => 'switch',
                'default' => 0,   
                'group' => 'ybc_tab_product_listing',        
            ),
            'YBC_TC_LISTING_SUBCAT' => array(
                'label' => $this->l('Display subcategories'),
                'type' => 'switch',
                'default' => 0,   
                'group' => 'ybc_tab_product_listing',        
            ),  
            'YBC_PI_TRANSITION_EFFECT' => array(
                'label' => $this->l('Product image rollover effect'),
                'type' => 'select',
                'default' => 'zoom',   
                'group' => 'ybc_tab_product_listing',
                'options' => array(
        			 'query' => array(                             
                            array(
                                'id_option' => 'zoom',
                                'name' => $this->l('Zoom')
                            ),
                            array(
                                'id_option' => 'fade',
                                'name' => $this->l('Fade')
                            ),
                            array(
                                'id_option' => 'vertical_scrolling_bottom_to_top',
                                'name' => $this->l('Vertical Scrolling  Bottom To Top')
                            ),
                            array(
                                'id_option' => 'vertical_scrolling_top_to_bottom',
                                'name' => $this->l('Vertical Scrolling Top To Bottom')
                            ),                    
                            array(
                                'id_option' => 'horizontal_scrolling_left_to_right',
                                'name' => $this->l('Horizontal Scrolling Left To Right')
                            ),
                            array(
                                'id_option' => 'horizontal_scrolling_right_to_left',
                                'name' => $this->l('Horizontal Scrolling Right To Left')
                            )   
                        ),                             
                     'id' => 'id_option',
        			 'name' => 'name',
                     'info' => Module::isInstalled('ybc_productimagehover') && Module::isEnabled('ybc_productimagehover') ? false : $this->l('*Note: You need to install and enable module "ybc_productimagehover" to use this feature'),
                ),          
            ), 
           
            'IMPORT_DATA' => array(
                'group' => 'ybc_tab_import',
                'label' => $this->l('Data to import'),
                'sections' => array(
                    array(
                        'id' => 'menu',
                        'name' => $this->l('Mega menu'),
                    ),
                    array(
                        'id' => 'slide',
                        'name' => $this->l('Slider'),
                    ),
                    array(
                        'id' => 'widget',
                        'name' => $this->l('Html blocks'),
                    ),                                      
                ),
                'info' => $this->l('Clear / disable cache after importing sample data. This feature will override your old data of the selected section(s) that you will import sample data'),
            ),
            /*end contact*/
            'END_FORM' => array(),           
        );         
        //Custom color
        if($this->colors)
        {
            $colorConfig = array();
            $ik = 0;
            foreach($this->colors as $key => $color)
            {
                $ik++;
                $colorConfig['YBC_TC_COLOR_'.Tools::strtoupper($key)] = array(
                    'label' => $this->l('Color ').$ik,
                    'type' => 'color',
                    'default' => $color,   
                    'group' => 'ybc_tab_general',  
                    'is_custom_color' => true,      
                );
            }
            $configs = $this->configs;
            unset($configs['END_FORM']);
            $configs = array_merge($configs,$colorConfig,array('END_FORM'=>array()));
            $this->configs = $configs;
        }        
        $this->bgs = array('default','bg1','bg2','bg3','bg4','bg5','bg6','bg7','bg8','bg9','bg10','bg11');
        $this->modules = array();
    }
    public function getGroupName($field)
    {
        foreach($this->configs as $key => $config)
        {
            if($field==$key && isset($config['group']))
                return $config['group'];
        }
        return 'ybc_tab_general';
    }
    /**
	 * @see Module::install()
	 */
	public function install()
	{
	    $this->_installDb();
        return parent::install() 
        && $this->registerHook('displayHeader')
        && $this->registerHook('displayFooter')
        && $this->registerHook('ybcCopyright')
        && $this->registerHook('ybcBlockSocial')
        && $this->registerHook('displayBackOfficeFooter')
        && $this->registerHook('displayYbcProductReview')
        && $this->registerHook('displayBackOfficeHeader')
        && $this->registerHook('ybcLayoutUpdate');
    }
    
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
	    $this->_uninstallDb();
        return parent::uninstall();
    }    
    private function _installDb()
    {      
        $languages = Language::getLanguages(false);
        $tab = new Tab();
        $tab->class_name = 'AdminYbcThemeConfig';
        $tab->module = 'ybc_themeconfig';
        $tab->id_parent = 0;            
        foreach($languages as $lang){
                $tab->name[$lang['id_lang']] = $this->l('Theme options');
        }
        $tab->save();        
        $this->resetDefault();        
    }
    public function resetDefault()
    {
        //Install configure
        $languages = Language::getLanguages(false);
        if($this->configs)
        {
            foreach($this->configs as $key => $config)
            {   
                if($key !='BEGIN_FORM' && $key !='END_FORM' && $key!='IMPORT_DATA')
                {
                    if(isset($config['type']) && $config['type']!='file')
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
                    elseif(isset($config['type']) && $config['type']=='file')
                    {
                        if(isset($config['default']) && $config['default'] && @file_exists(dirname(__FILE__).'/images/init/'.$config['default']))
                        {
                            @copy(dirname(__FILE__).'/images/init/'.$config['default'],dirname(__FILE__).'/images/config/'.$config['default']);
                            Configuration::updateValue($key, $config['default'],true);   
                        }
                        else
                            Configuration::updateValue($key, '',true);                          
                    }   
                }                
            }
        }
    }
    private function _uninstallDb()
    {        
        $tabs = array('AdminYbcThemeConfig','AdminYbcTC');
        if($tabs)
        foreach($tabs as $classname)
        {
            if($tabId = Tab::getIdFromClassName($classname))
            {
                $tab = new Tab($tabId);
                if($tab)
                    $tab->delete();
            }                
        }
        
        //Uninstall configure
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
            if(!file_exists(dirname(__FILE__).'/images/'.$dir.'/index.php'))
                @file_put_contents(dirname(__FILE__).'/images/'.$dir.'/index.php','index.php');
        }      
    }   
    public function renderConfig()
    {
        $configs = $this->configs;
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Theme options'),
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
                    'type' => isset($config['type']) ? $config['type'] : '',
                    'label' => isset($config['label']) ? $config['label'] : '',
                    'desc' => isset($config['desc']) ? $config['desc'] : false,
                    'required' => isset($config['required']) && $config['required'] ? true : false,
                    'autoload_rte' => isset($config['autoload_rte']) && $config['autoload_rte'] ? true : false,
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
                    'suffix' => isset($config['suffix']) && $config['suffix'] ? $config['suffix']  : false,
                    'html' => isset($config['html']) ? $config['html'] : '',
                    'group' => isset($config['group']) ? $config['group'] : '',
                    'info' => isset($config['info']) ? $config['info'] : '',
                    'separator' => isset($config['separator']) && $config['separator'],
                    'is_custom_color' => isset($config['is_custom_color']) && $config['is_custom_color'] ? true : false,
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
                    'lang' => isset($config['lang']) ? $config['lang'] : false,
                    'layouts' => isset($config['layouts']) && $config['layouts'] ? $config['layouts'] : false,
                    'sections' => isset($config['sections']) && $config['sections'] ? $config['sections'] : false,
                );
                if(!isset($config['suffix']))
                    unset($confFields['suffix']);
                if(isset($config['type']) && $config['type'] == 'file')
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
            'reset_url' => $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&tcreset=yes',
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $fields,
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'export_link' => $this->baseAdminPath.'&exportNewsletter=yes',
            'module_path' => $this->_path, 
            'devMode' => $this->devMode,          
        );
        
        $this->_html .= $helper->generateForm(array($fields_form));		
     }
     public function renderTabs()
     {
        $html = '<ul class="ybc_tab">';
        foreach($this->tabs as $tab => $label)
        {
            $html .= '<li id="'.$tab.'" data-tab="'.$tab.'">'.$label.'</li>';
        }
        $html .= '</ul>';
        return $html;
     }
     private function exportTable($tbls,$savePath,$layout,$mod = false)
     {
        if(!is_array($tbls))
            $tbls = array($tbls);
        $sql = "";
        $images = array(
            'ybc_mm_menu' => array(
                'src' => dirname(__FILE__).'/../ybc_megamenu/images/menu/',
                'des' => dirname(__FILE__).'/data/'.$layout.'/img/menu/menu/',
                'mod' => dirname(__FILE__).'/../ybc_megamenu/data/img/menu/'
            ),
            'ybc_mm_column' => array(
                'src' => dirname(__FILE__).'/../ybc_megamenu/images/column/',
                'des' => dirname(__FILE__).'/data/'.$layout.'/img/menu/column/',
                'mod' => dirname(__FILE__).'/../ybc_megamenu/data/img/column/'
            ),
            'ybc_mm_block' => array(
                'src' => dirname(__FILE__).'/../ybc_megamenu/images/block/',
                'des' => dirname(__FILE__).'/data/'.$layout.'/img/menu/block/',
                'mod' => dirname(__FILE__).'/../ybc_megamenu/data/img/block/'
            ),
            'ybcnivoslider_slides_lang' => array(
                'src' => dirname(__FILE__).'/../ybc_nivoslider/images/',
                'des' => dirname(__FILE__).'/data/'.$layout.'/img/slide/',
                'mod' => dirname(__FILE__).'/../ybc_nivoslider/data/img/'
            ),
            'ybc_widget_widget' => array(
                'src' => dirname(__FILE__).'/../ybc_widget/images/widget/',
                'des' => dirname(__FILE__).'/data/'.$layout.'/img/widget/',
                'mod' => dirname(__FILE__).'/../ybc_widget/data/img/'
            ),
        );
        
        
       
        if($tbls)
        {
            foreach($tbls as $tbl)
            {
                $tblName = $tbl['name'];
                $key = isset($tbl['key']) ? $tbl['key'] : false;
                $ids = isset($tbl['ids']) ? $tbl['ids'] : array();
                $langField = isset($tbl['langField']) ? $tbl['langField'] : false;
                $rows = Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_.$tblName." WHERE 1 ".($key && $ids ? " AND $key IN(".implode(',',$ids).")" : "").($langField ? " AND `$langField`=".(int)Configuration::get('PS_LANG_DEFAULT') : ""));               
                if(!file_exists($images[$tblName]['des']))
                    @mkdir($images[$tblName]['des'],0777, true);
                if(isset($images[$tblName]['des']) && !$mod)
                {
                    if($files = glob($images[$tblName]['des'].'*'))
                    {                    
                        foreach($files as $file){ 
                          if(is_file($file))
                            @unlink($file);
                        }
                    }   
                }
                if($rows)
                    foreach($rows as $row)
                    {
                        if($row)
                        {
                            $sql .= "INSERT INTO `_DB_PREFIX_".$tblName."` VALUES(";
                            foreach($row as $key => $val)
                            {
                                $sql .= "'".($langField && $langField==$key ? '_ID_LANG_' : addslashes($val))."',";
                                if(!$mod)
                                {                                    
                                    if($key=='image' && $val && isset($images[$tblName]) && file_exists($images[$tblName]['src'].$val))
                                    {   
                                        
                                        if(file_exists($images[$tblName]['des'].$val))
                                            @unlink($images[$tblName]['des'].$val);
                                        $this->greyOutImage($images[$tblName]['src'].$val,$images[$tblName]['des']); 
                                    }
                                }
                                else
                                {
                                    if($key=='image' && $val && isset($images[$tblName]) && file_exists($images[$tblName]['src'].$val) && isset($images[$tblName]['mod']))
                                    {                                    
                                        if(file_exists($images[$tblName]['mod'].$val))
                                            @unlink($images[$tblName]['mod'].$val);
                                        $this->greyOutImage($images[$tblName]['src'].$val,$images[$tblName]['mod']);
                                    }
                                }
                            }    
                            $sql = trim($sql,',').");\n";
                        }
                    }
                $sql .= "\n\n";
            }
            
        }        
        if($sql)
            @file_put_contents($savePath,$sql);
        elseif(file_exists($savePath))
            @unlink($savePath);
     }
     private function _postConfig()
     {
        $errors = array();
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $configs = $this->configs;
        //Reset configs
        if(Tools::isSubmit('tcreset'))
        {
            $this->resetDefault();
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
        }     
        if(Tools::isSubmit('export_data'))
        {
            $dataDir = dirname(__FILE__).'/data/';
            $defaultConfig = $this->_getThemeConfig();
            $defaultLayout = Tools::strtolower($defaultConfig['YBC_TC_LAYOUT']);
            if($layouts = $configs['YBC_TC_LAYOUT']['options']['query'])
            {
                foreach($layouts as $layout)
                {
                    $layoutName = Tools::strtolower($layout['id_option']);
                    
                    if(!file_exists($dataDir.$layoutName))
                        @mkdir($dataDir.$layoutName);
                    if(!file_exists($dataDir.$layoutName.'/sql'))
                        @mkdir($dataDir.$layoutName.'/sql');
                    //Menu
                    $tbls = array(
                        array(
                            'name' => 'ybc_mm_menu',                            
                            'key' => 'id_menu',
                            'ids' => isset($layout['menus']) ? $layout['menus'] : false,
                        ),
                        array(
                            'name' => 'ybc_mm_block',
                            'key' => 'id_block',
                            'ids' => isset($layout['blocks']) ? $layout['blocks'] : false,
                        ),
                        array(
                            'name' => 'ybc_mm_column',
                            'key' => 'id_column',
                            'ids' => isset($layout['columns']) ? $layout['columns'] : false,
                        )
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/menu.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_megamenu/data/sql/menu.sql',$layoutName,true);
                    }
                    $tbls = array(
                        array(
                            'name' => 'ybc_mm_menu_lang',
                            'langField' => 'id_lang',
                            'key' => 'id_menu',
                            'ids' => isset($layout['menus']) ? $layout['menus'] : false,
                        ),
                        array(
                            'name' => 'ybc_mm_block_lang',
                            'langField' => 'id_lang',
                            'key' => 'id_block',
                            'ids' => isset($layout['blocks']) ? $layout['blocks'] : false,
                        ),
                        array(
                            'name' => 'ybc_mm_column_lang',
                            'langField' => 'id_lang',
                            'key' => 'id_column',
                            'ids' => isset($layout['columns']) ? $layout['columns'] : false,
                        )
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/menu_lang.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_megamenu/data/sql/menu_lang.sql',$layoutName,true);
                    }
                    
                    $tbls = array(
                        array(
                            'name' => 'ybcnivoslider',                            
                            'key' => 'id_homeslider_slides',
                            'ids' => isset($layout['slides']) ? $layout['slides'] : false,
                        ),
                        array(
                            'name' => 'ybcnivoslider_slides',                            
                            'key' => 'id_homeslider_slides',
                            'ids' => isset($layout['slides']) ? $layout['slides'] : false,
                        ),                        
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/slide.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_nivoslider/data/sql/slide.sql',$layoutName,true);
                    }
                    $tbls = array(
                        array(
                            'name' => 'ybcnivoslider_slides_lang',                            
                            'key' => 'id_homeslider_slides',
                            'langField' => 'id_lang',
                            'ids' => isset($layout['slides']) ? $layout['slides'] : false,
                        ),                   
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/slide_lang.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_nivoslider/data/sql/slide_lang.sql',$layoutName,true);
                    }
                    
                    $tbls = array(
                        array(
                            'name' => 'ybc_widget_widget',                            
                            'key' => 'id_widget',
                            'ids' => isset($layout['widgets']) ? $layout['widgets'] : false,
                        ),                   
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/widget.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_widget/data/sql/widget.sql',$layoutName,true);
                    }                    
                    $tbls = array(
                        array(
                            'name' => 'ybc_widget_widget_lang',                            
                            'key' => 'id_widget',
                            'langField' => 'id_lang',
                            'ids' => isset($layout['widgets']) ? $layout['widgets'] : false,
                        ),                   
                    );
                    $this->exportTable($tbls,$dataDir.$layoutName.'/sql/widget_lang.sql',$layoutName);
                    if($defaultLayout==$layoutName)
                    {
                        $this->exportTable($tbls,dirname(__FILE__).'/../ybc_widget/data/sql/widget_lang.sql',$layoutName,true);
                    }
                }
            }
            die(Tools::jsonEncode(array('success' => $this->l('Sample data exported'))));
        }   
        if(Tools::isSubmit('import_data'))
        {
            $layoutParam = array(                
                'menu' => array(
                    'tbl' => array('ybc_mm_menu','ybc_mm_menu_lang','ybc_mm_column','ybc_mm_column_lang','ybc_mm_block','ybc_mm_block_lang'),//Table to delete data
                    'imgDir' => dirname(__FILE__).'/../ybc_megamenu/images/', //Image directory to copy images to
                ),
                'slide' => array(
                    'tbl' => array('ybcnivoslider','ybcnivoslider_slides','ybcnivoslider_slides_lang'),//Table to delete data
                    'imgDir' => dirname(__FILE__).'/../ybc_nivoslider/images/', //Image directory to copy images to
                ),
                'widget' => array(
                    'tbl' => array('ybc_widget_widget','ybc_widget_widget_lang'),//Table to delete data
                    'imgDir' => dirname(__FILE__).'/../ybc_widget/images/widget/', //Image directory to copy images to
                ),                
            );
            $layout = Tools::strtolower(Configuration::get('YBC_TC_LAYOUT'));
            $sections = Tools::getValue('IMPORT_DATA');            
            $json = array();
            $errors = array();
            if($this->devMode)
                $errors[] = $this->l('You can not import sample data because "devMode" is enabled');
            if(!$errors)
            {
                if(!$layout)
                    $errors[] = $this->l('Website layout has not been set');
                if(!$sections)
                    $errors[] = $this->l('Choose at least 1 section to import sample data');   
            }
            
            if(!$errors)
            {
                foreach($sections as $section)
                {
                    $section = Tools::strtolower($section);
                    $sqlFile = dirname(__FILE__).'/data/'.$layout.'/sql/'.$section.'.sql';
                    if(file_exists($sqlFile) && ($sql = Tools::file_get_contents($sqlFile)))
                    {
                        if(isset($layoutParam[$section]['tbl']))
                        {
                            foreach($layoutParam[$section]['tbl'] as $tbl)
                            {
                                Db::getInstance()->execute("DELETE FROM "._DB_PREFIX_.$tbl);
                            }
                        }
                        $errors = array_merge($errors,$this->parseSql($sql));  
                        $sqlLangFile = dirname(__FILE__).'/data/'.$layout.'/sql/'.$section.'_lang.sql';
                        if(file_exists($sqlLangFile) && ($sql = Tools::file_get_contents($sqlLangFile)) && $languages)
                        { 
                           
                            foreach($languages as $lang)
                            {
                                $subsql = str_replace('_ID_LANG_',$lang['id_lang'],$sql);                                
                                $errors = array_merge($errors,$this->parseSql($subsql));   
                            }
                        }
                        //Copy images
                        if(isset($layoutParam[$section]['imgDir']) && $layoutParam[$section]['imgDir'])
                        {
                            if(is_dir($layoutParam[$section]['imgDir']) && is_writeable($layoutParam[$section]['imgDir'])) 
                            {
                                if($section!='menu')
                                    if($oldFiles = glob($layoutParam[$section]['imgDir'].'*'))
                                    {
                                        foreach($oldFiles as $file){ 
                                          if(is_file($file))
                                            @unlink($file); 
                                        }
                                        if(!file_exists($layoutParam[$section]['imgDir'].'index.php'))
                                            @file_put_contents($layoutParam[$section]['imgDir'].'index.php','');
                                    }  
                                else
                                {                                    
                                    if($oldFiles = glob($layoutParam[$section]['imgDir'].'menu/*'))
                                    {
                                        foreach($oldFiles as $file){ 
                                          if(is_file($file))
                                            @unlink($file); 
                                        }
                                        if(!file_exists($layoutParam[$section]['imgDir'].'menu/index.php'))
                                            @file_put_contents($layoutParam[$section]['imgDir'].'menu/index.php','');
                                    } 
                                    if($oldFiles = glob($layoutParam[$section]['imgDir'].'column/*'))
                                    {
                                        foreach($oldFiles as $file){ 
                                          if(is_file($file))
                                            @unlink($file); 
                                        }
                                        if(!file_exists($layoutParam[$section]['imgDir'].'column/index.php'))
                                            @file_put_contents($layoutParam[$section]['imgDir'].'column/index.php','');
                                    }  
                                    if($oldFiles = glob($layoutParam[$section]['imgDir'].'block/*'))
                                    {
                                        foreach($oldFiles as $file){ 
                                          if(is_file($file))
                                            @unlink($file); 
                                        }
                                        if(!file_exists($layoutParam[$section]['imgDir'].'block/index.php'))
                                            @file_put_contents($layoutParam[$section]['imgDir'].'block/index.php','');
                                    }   
                                }  
                                                          
                                if(file_exists(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/') && is_readable(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/'))                                   
                                
                                {
                                    if($section != 'menu')
                                        $this->copyDir(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/',$layoutParam[$section]['imgDir']);
                                    else
                                    {                                       
                                        $this->copyDir(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/menu/',$layoutParam[$section]['imgDir'].'menu/');
                                        $this->copyDir(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/column/',$layoutParam[$section]['imgDir'].'column/');
                                        $this->copyDir(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/block/',$layoutParam[$section]['imgDir'].'block/');
                                         
                                    }
                                }
                                elseif(file_exists(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/') && !is_readable(dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/'))
                                    $errors[] = '['.dirname(__FILE__).'/data/'.$layout.'/img/'.$section.'/'.'] '.$this->l('Directory is not writeable. Try to set its CMOD to 755');   
                            }
                            elseif(file_exists($layoutParam[$section]['imgDir']) && is_writeable($layoutParam[$section]['imgDir']))
                                  $errors[] = '['.$layoutParam[$section]['imgDir'].'] '.$this->l('Directory is not writeable. Try to set its CMOD to 755');                           
                        }
                                         
                    }
                    elseif(file_exists($sqlFile) && !is_writable($sqlFile))
                        $errors[] = '['.$sqlFile.'] '.$this->l('SQL file does not exist or file access denied (try to set the file CMOD to 755)');
                }
            }
            if($errors)
                $json['error'] = implode('<br/>',$errors);
            else
                $json['success'] = $this->l('Sample data imported');
            die(Tools::jsonEncode($json));
        }
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
                }
                Configuration::updateValue($image,'');
                $tab = $this->getGroupName($image);
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&submited_tab='.$tab);
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
                    if($key !='BEGIN_FORM' && $key !='END_FORM' && $key!='IMPORT_DATA')
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
                                elseif(!Validate::isCleanHtml(trim(Tools::getValue($key))) && !isset($config['validate']))
                                {
                                    $errors[] = $config['label'].' '.$this->l('is invalid');
                                } 
                            }                          
                        }
                    }                                        
                }
            }            
            
            //Custom validation
            if((int)Tools::getValue('YBC_TC_CACHE_CSS') && (int)Tools::getValue('YBC_TC_DISPLAY_SETTING'))
            {
                $errors[] = $this->l('"Cache dynamic" CSS can only be enabled if "Display front setting panel" is set to "No"');
            }
            if(!$errors)
            {
                if($configs)
                {
                    foreach($configs as $key => $config)
                    {
                        if($key !='BEGIN_FORM' && $key !='END_FORM' && $key!= 'IMPORT_DATA')
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
            }
            if(!$errors && !$this->devMode && !(int)Configuration::get('YBC_TC_DISPLAY_SETTING'))
            {
                $cacheTime = (int)Configuration::get('YBC_TC_CSS_CACHE_TIME');
                if(file_exists(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css'))
                    @unlink(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css');                      
            }
            if(!Tools::isSubmit('ajax'))
            {
                if (count($errors))
                {
                   $this->errorMessage = $this->displayError(implode('<br />', $errors));  
                }
                else
                   Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&submited_tab='.(Tools::getValue('submited_tab') ? Tools::getValue('submited_tab') : ''));
            }
            else
            {
                $json = array();
                $json['error'] = $errors ? $this->displayError(implode('<br />', $errors)) : false;
                $json['errorAlert'] = $this->l('Can not update theme configuration. Please check the errors report above');
                if(!$errors)
                    $json['success'] = $this->l('Successfully updated');
                die(Tools::jsonEncode($json));
            }            
        }
    }
    function copyDir($src,$dst) { 
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
    public function greyOutImage($src,$descDir)
    {
        if(!file_exists($src) || !is_dir($descDir))
            return;
        $name = basename($src);
        $extension = pathinfo($src, PATHINFO_EXTENSION);
        if(file_exists($descDir.$name))
            @unlink($descDir.$name);
        if($extension == 'png' || $extension=='jpg')
        {
            $img = ($extension=='jpg' ? imagecreatefromjpeg($src) : imagecreatefrompng($src)); 
            $grey = imagecolorallocate($img, 200, 200, 200);
            $width = imagesx($img);
            $height = imagesy($img);
            imagefilledrectangle($img, 0, 0, $width, $height, $grey);
            
            //Add sizing text
            $font = dirname(__FILE__).'/fonts/Montserrat-Bold.ttf';
            $font_size = 30;
            $angle = 45;
            $text = $width.' X '.$height;
            $text_box = imagettfbbox($font_size,$angle,$font,$text);
            $text_width = $text_box[2]-$text_box[0];
            $text_height = $text_box[7]-$text_box[1];
            $grey = imagecolorallocate($img, 160, 160, 160);
            // Calculate coordinates of the text
            $x = ($width/2) - ($text_width/2)-30;
            $y = ($height/2) - ($text_height/2);
            
            // Add some shadow to the text
            imagettftext($img, $font_size, 0, $x, $y, $grey, $font, $text);            
            
            if($extension=='jpg')
                imagejpeg($img, $descDir.$name);
            else
                imagepng($img, $descDir.$name);
        }
        else
            @copy($src,$descDir.$name);
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
    public function validateOption($arg, $valule)
    {       
        if($arg && is_array($arg))
        {
            foreach($arg as $item)
            {
                if($item['id_option']==$valule)
                    return true;
            }
        }
        return false;
    }
    public function getContent()
    {
	   $this->_postConfig(); 
       $this->_html .= '<div class="ybc-udpate-message">';      
       //Display errors if have
       if($this->errorMessage)
            $this->_html .= $this->errorMessage;  
       $this->_html .= '</div>';     
       //Render views
       $this->renderConfig();
       return $this->_html.'<script type="text/javascript" src="'.$this->_path.'js/themeconfig-admin.js"></script>'; 
    }   
    private function _getThemeConfig()
    {
        $fields = array();
        foreach($this->configs as $key => $config)
        {
            if(isset($config['lang']) && $config['lang'])
                $fields[$key] = Configuration::get($key,$this->context->language->id);
            else
                $fields[$key] = Configuration::get($key);
        }   
          
        return $fields;
    }
    public function getClientConfig()
    {
        $configs = array();        
        if(!$this->context->cookie->themeconfig)
        {            
            foreach($this->configs as $key => $config)
            {
                if(isset($config['client_config']) && $config['client_config'])
                {
                    $setConfig = Configuration::get($key);
                    $configs[$key] = $setConfig != '' ? $setConfig : (isset($config['default']) ? $config['default'] : '');
                }
            }
            $this->context->cookie->themeconfig = @serialize($configs);
            $this->context->cookie->write();
        }
        else
            $configs = @unserialize($this->context->cookie->themeconfig);
        return $configs;
    }
    public function getThemeConfigDemo()
    {      
        $configs = $this->_getThemeConfig();        
        if(Configuration::get('YBC_TC_DISPLAY_SETTING'))
        {
            $clientConfigs = $this->getClientConfig();
            if(!$this->devMode && isset($clientConfigs['YBC_TC_LAYOUT']))
                unset($clientConfigs['YBC_TC_LAYOUT']);
            $configs  = array_merge($configs,$clientConfigs);
        }        
        return $configs;
    }
    public function getLayoutConfiguredField($type='slides')
    {
        $currentConfig = $this->getThemeConfigDemo();
        $configs = $this->configs;
        if(isset($configs['YBC_TC_LAYOUT']['options']['query']) && isset($currentConfig['YBC_TC_LAYOUT']))
        {
            foreach($configs['YBC_TC_LAYOUT']['options']['query'] as $layout)
            {
                if($layout['id_option'] == $currentConfig['YBC_TC_LAYOUT'] && isset($layout[$type]))
                    return $layout[$type];
            }
        }
        return false;
    }
    public function getSkinConfiguredField($type='logo')
    {
        $currentConfig = $this->getThemeConfigDemo();
        $configs = $this->configs;
        
        if(isset($configs['YBC_TC_SKIN']['options']['query']) && isset($currentConfig['YBC_TC_SKIN']))
        {
            foreach($configs['YBC_TC_SKIN']['options']['query'] as $skin)
            {
                if($skin['id_option'] == $currentConfig['YBC_TC_SKIN'] && isset($skin[$type]))
                {
                    if($type == 'logo' && file_exists(dirname(__FILE__).'/images/logo/'.Tools::strtolower($currentConfig['YBC_TC_LAYOUT']).'/'.$skin[$type]))
                    {
                        return Tools::strtolower($currentConfig['YBC_TC_LAYOUT']).'/'.$skin[$type];
                    }
                    return $skin[$type];
                }                    
            }
        }
        return false;
    }
    public function updateThemeConfigDemo($key, $val)
    {        
        $config = false;
        if(!$this->context->cookie->themeconfig)
        {
            $this->context->cookie->themeconfig = @serialize($this->getClientConfig());            
        }
        if($this->context->cookie->themeconfig)
        {
            $config = @unserialize($this->context->cookie->themeconfig);
        }
        if($config && is_array($config))
        {
            $config[$key] = $val;
            $this->context->cookie->themeconfig = @serialize($config); 
            $this->context->cookie->write();
        }
        return;        
    }
    public function getThemeConfig($key)
    {
        if($this->context->cookie->themeconfig)
        {
            $config = @unserialize($this->context->cookie->themeconfig);
        }
        if($config && is_array($config) && isset($config[$key]))
        {
            return $config[$key];
        }
        return false;       
    }
    public function resetConfigDemo()
    {
        $this->context->cookie->themeconfig = false;
        $this->context->cookie->ybc_shopmsg_closed = 0;
        $this->context->cookie->ybcnewsletter = 0;
        $this->context->cookie->write();
    }
    /**
     * Hooks 
     */
    public function hookDisplayHeader()
    {   
        if((int)Configuration::get('YBC_TC_PARALLAX_NEWSLETTER_ON_OFF'))
            $this->context->controller->addJS($this->_path.'js/skrollr.min.js');
        if((int)Configuration::get('YBC_TC_FLOAT_CSS3'))
            $this->context->controller->addJS($this->_path.'js/wow.min.js');
        
        $this->context->controller->addJS($this->_path.'js/owl.carousel.js');
        $this->context->controller->addJS($this->_path.'js/ybctab.js');      
        $this->context->controller->addJS($this->_path.'js/ybc_themeconfig_frontend.js');      
        $this->context->controller->addCSS($this->_path.'css/font-awesome.css', 'all');
        $this->context->controller->addCSS($this->_path.'css/owl/owl.carousel.css', 'all');
        $this->context->controller->addCSS($this->_path.'css/owl/owl.theme.css', 'all');
        $this->context->controller->addCSS($this->_path.'css/elegant-font.css', 'all');
        $this->context->controller->addCSS($this->_path.'css/owl/owl.transitions.css', 'all');
        
        
        if($this->gfonts)
        {
            foreach($this->gfonts as $font)
            {
                $this->context->controller->addCSS($font);
            }
        }
        if(Configuration::get('YBC_TC_DISPLAY_SETTING') && Tools::isSubmit('tc_init'))
        {
            //Auto update skin / layout
            $this->context->cookie->themeconfig = false;
            $this->context->cookie->ybc_shopmsg_closed = 0;
            $this->context->cookie->ybcnewsletter = 0;
            $this->context->cookie->write();
            $configs = $this->configs;
            if(Tools::getValue('YBC_TC_SKIN') && $this->validateOption($configs['YBC_TC_SKIN']['options']['query'], Tools::getValue('YBC_TC_SKIN')))
                $this->updateThemeConfigDemo('YBC_TC_SKIN',Tools::getValue('YBC_TC_SKIN'));
            if($this->devMode)
            {                                
                if(Tools::getValue('YBC_TC_LAYOUT') && $this->validateOption($configs['YBC_TC_LAYOUT']['options']['query'], Tools::getValue('YBC_TC_LAYOUT')))
                    $this->updateThemeConfigDemo('YBC_TC_LAYOUT',Tools::getValue('YBC_TC_LAYOUT')); 
            }  
                      
            if(Tools::isSubmit('YBC_TC_FLOAT_HEADER'))
                $this->updateThemeConfigDemo('YBC_TC_FLOAT_HEADER',(int)Tools::getValue('YBC_TC_FLOAT_HEADER') ? 1 : 0);
            
            if(Tools::isSubmit('YBC_TC_SIMPLE_FOOTER'))
                $this->updateThemeConfigDemo('YBC_TC_SIMPLE_FOOTER',(int)Tools::getValue('YBC_TC_SIMPLE_FOOTER') ? 1 : 0);
            Tools::redirect($this->context->link->getPageLink('index',true));
        }
        if(Configuration::get('YBC_TC_DISPLAY_SETTING') && Tools::isSubmit('YBC_TC_CONTACT_FORM_LAYOUT') && in_array(Tools::getValue('YBC_TC_CONTACT_FORM_LAYOUT'),array('layout1','layout2','layout3')))
        {            
            $this->updateThemeConfigDemo('YBC_TC_CONTACT_FORM_LAYOUT',Tools::getValue('YBC_TC_CONTACT_FORM_LAYOUT'));
        }
        $this->context->controller->addCSS($this->_path.'css/themeconfig.css', 'all');
        $this->context->smarty->assign(
            array(
                'YBC_TC_CLASSES'=>$this->getBodyClasses(), 
                'layouts' => $this->getLayout(),
                'YBC_TC_MOBLE_ENABLED' => Configuration::get('YBC_TC_MOBLE_ENABLED') ? true : false,
                'tc_config' => Configuration::get('YBC_TC_DISPLAY_SETTING') ? $this->getThemeConfigDemo() : $this->_getThemeConfig(),
                'tc_module_path' => $this->_path,
                'tc_dev_mode' => $this->devMode,
                'tc_layout_products' => $this->getLayoutConfiguredField('products'),
                'tc_product' => Tools::isSubmit('id_product') && Tools::getValue('controller')=='product' ? $this->context->controller->getProduct() : false,
                'tc_display_settings' => count(Language::getLanguages()) > 1 || count(Currency::getCurrencies()) > 1,
            )
        );        
        if($this->devMode && (int)Configuration::get('YBC_TC_DISPLAY_SETTING') && ($logo = $this->getSkinConfiguredField('logo')))
        {
            $this->context->smarty->assign(
                array(
                    'logo_url'=> $this->_path.'images/logo/'.$logo,                    
                )
            ); 
        } 
        
        foreach($this->configs as $field => $config)
            if(isset($config['data_type']) && $config['data_type']=='font' && ($fontData=Configuration::get($field)) && Validate::isUrl($fontData))
                $this->context->controller->addCSS($fontData,'all',null,false);
         //Attach dynamic CSS
        $cacheTime = (int)Configuration::get('YBC_TC_CSS_CACHE_TIME');
        $request = '';
        $css = '';
        if((int)Configuration::get('YBC_TC_CACHE_CSS') && !(int)Configuration::get('YBC_TC_DISPLAY_SETTING'))
        {
            $cssPath = '';
            if($cacheTime > time()-3600 && file_exists(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css'))
                $cssPath = $this->_path.'cache/dynamic_css_'.$cacheTime.'.css';
            else
            {
                $css = $this->renderCss();
                if(file_exists(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css'))
                    @unlink(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css');
                $cacheTime = time();
                @file_put_contents(dirname(__FILE__).'/cache/dynamic_css_'.$cacheTime.'.css',$css);                
                Configuration::updateValue('YBC_TC_CSS_CACHE_TIME',$cacheTime);
                $cssPath = $this->_path.'cache/dynamic_css_'.$cacheTime.'.css';
            }
            $this->context->controller->addCSS($cssPath, 'all'); 
        }
        else
        {
            if($css = $this->renderCss())
                return '<style>'.$css.'</style>'; 
        }
    }
    public function cacheCss()
    {
        $cacheTime = (int)Configuration::get('YBC_TC_CSS_CACHE_TIME');
        $request = '';
        if((int)Configuration::get('YBC_TC_CACHE_CSS') && !(int)Configuration::get('YBC_TC_DISPLAY_SETTING'))
        {
            if($cacheTime > time()-3600 && file_exists(dirname(__FILE__).'/cache/'.$cacheTime.'.txt'))
                $request = Tools::file_get_contents(dirname(__FILE__).'/cache/'.$cacheTime.'.txt');
            else
            {
                $request = $this->getInstagramRequest();
                if(file_exists(dirname(__FILE__).'/cache/'.$cacheTime.'.txt'))
                    @unlink(dirname(__FILE__).'/cache/'.$cacheTime.'.txt');
                $cacheTime = time();
                @file_put_contents(dirname(__FILE__).'/cache/'.$cacheTime.'.txt',$request);
                Configuration::updateValue('YBC_INSTAGRAM_CACHE_TIME',$cacheTime);
            } 
        }
        else
            $request = $this->getInstagramRequest();
    }
    public function getLayout()
    {
        if(Configuration::get('YBC_TC_DISPLAY_SETTING'))      
            $fields = $this->getThemeConfigDemo();
        else
            $fields = $this->_getThemeConfig(); 
        $layouts = '';
        if($fields)
            foreach($fields as $field => $val)
            {
                if($field == 'YBC_TC_LAYOUT')
                    $layouts .= ($val ? Tools::strtolower($val) : 'default');
            } 
        return $layouts;               
    }    
    public function getBodyClasses()
    {
        if(Configuration::get('YBC_TC_DISPLAY_SETTING'))      
            $fields = $this->getThemeConfigDemo();
        else
            $fields = $this->_getThemeConfig();
        $configs = $this->configs; 
        $bodyClass = '';
        if($fields)
            foreach($fields as $field => $val)
            {
                if(isset($configs[$field]['body_class']) && $configs[$field]['body_class'])
                {
                    $bodyClass .= ' ybc-'.(Tools::strtolower(str_replace('YBC_TC_','',$field))).'-'.($val ? ($configs[$field]['type'] != 'switch' ? Tools::strtolower($val) : 'yes') : ($configs[$field]['type'] != 'switch' ? 'default' : 'no'));
                }                
            } 
        return $bodyClass;               
    }
    public function hookDisplayFooter()
    {
        $configs = $this->configs;  
        $tc_display_panel = (int)Configuration::get('YBC_TC_DISPLAY_SETTING') ? true : false;
        $skins = $configs['YBC_TC_SKIN']['options']['query'];
        if($tc_display_panel)
        {
            $this->smarty->assign(array(
                    'configs' => $this->getThemeConfigDemo(),                    
                    'skins' => $skins,
                    'layouts' => $configs['YBC_TC_LAYOUT']['options']['query'],
                )
            );
            
        }
        $this->smarty->assign(array(                    
                    'tc_display_panel' => $tc_display_panel,
                    'tc_comparison_link' => $this->context->link->getPageLink('products-comparison'),   
                    'moduleDirl' => $this->context->shop->getBaseURL().'modules/'.$this->name.'/',
                    'float_header' => isset($configs['YBC_TC_FLOAT_HEADER']),    
                    'YBC_TC_FLOAT_CSS3' => (int)Configuration::get('YBC_TC_FLOAT_CSS3'),
                    'ybcDev' => $this->devMode,                 
                )
        );
        return $this->display(__FILE__, 'panel.tpl'); 
    }
    public function getMenuScript()
    {        
        $modules = $this->modules;
        if($modules)
        {
            foreach($modules as &$module)
            {
                $module['link'] = $this->context->link->getAdminLink('AdminModules', true).'&configure='.$module['id'].'&module_name='.$module['id'];
                $module['installed'] = Module::isInstalled($module['id']) ? true : false;
            }
        }
        $this->smarty->assign(
            array(
                'modules' => $modules,
                'active_module' => Tools::getValue('configure'),
                'log_link' => $this->_path.'img/logo-16.png'
            )
        );
        return $this->display(__FILE__, 'modulelinks.tpl');
    }
    public function hookDisplayBackOfficeFooter()
    {
        return $this->getMenuScript();
    }
    public function hookYbcCopyright()
    {
        return '<div class="ybc-copyright">'.Configuration::get('YBC_TC_COPYRIGHT_TEXT', (int)$this->context->language->id).'</div>';
    }
    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/admin.css');
        
    }
    public function hookYbcBlockSocial()
    {
        if(Module::isInstalled('blocksocial') && Module::isEnabled('blocksocial'))
        {
            $this->smarty->assign(array(
				'facebook_url' => Configuration::get('BLOCKSOCIAL_FACEBOOK'),
				'twitter_url' => Configuration::get('BLOCKSOCIAL_TWITTER'),
				'rss_url' => Configuration::get('BLOCKSOCIAL_RSS'),
				'youtube_url' => Configuration::get('BLOCKSOCIAL_YOUTUBE'),
				'google_plus_url' => Configuration::get('BLOCKSOCIAL_GOOGLE_PLUS'),
				'pinterest_url' => Configuration::get('BLOCKSOCIAL_PINTEREST'),
				'vimeo_url' => Configuration::get('BLOCKSOCIAL_VIMEO'),
				'instagram_url' => Configuration::get('BLOCKSOCIAL_INSTAGRAM'),
                'linkedin_url' => Configuration::get('BLOCKSOCIAL_LINKEDIN'),
			));
            return $this->display(__FILE__, 'blocksocial.tpl');
        }
    }
    public function hookDisplayYbcProductReview($params)
    {        
        if(Module::isInstalled('productcomments') && Module::isEnabled('productcomments'))
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
        return;
    }
    public function renderCss()
    {
        $configs = $this->configs;        
        $css = '';        
        //Render custom font
        //Css
        if($font1 = Configuration::get('YBC_TC_FONT1_NAME'))
        {
            $css .= 'body{font-family: '.$font1.';}';
        }
        if($font2 = Configuration::get('YBC_TC_FONT2_NAME'))
        {
            $css .= 'h1,h2,h3,h4,h5,h6{font-family: '.$font2.';}';
        }
        if($font3 = Configuration::get('YBC_TC_FONT3_NAME'))
        {
            $css .= 'p{font-family: '.$font3.';}';
        }
        if($breadcrumb_bg = Configuration::get('YBC_TC_BREADCRUMB_BG'))
        {
            $css .= ".ybc_full_bg_breadcrum{background-image: url('".$this->_path."images/config/".$breadcrumb_bg."');}";
        }        
        if($newsletter_parallax_bg = Configuration::get('YBC_TC_PARALLAX_NEWSLETTER_BG'))
        {
            $css .= ".ybc-newsletter-home-parallax{background-image: url('".$this->_path."images/config/".$newsletter_parallax_bg."');}";
        }
        /*if ($newsletter2_parallax_bg = Configuration::get('YBC_TC_PARALLAX_NEWSLETTER2_BG'))
        {
            $css .= ".ybc-newsletter-home-bg{background-image: url('".$this->_path."images/config/".$newsletter2_parallax_bg."');}";
        }
        if ($newsletter3_parallax_bg = Configuration::get('YBC_TC_PARALLAX_NEWSLETTER3_BG'))
        {
            $css .= ".ybc-newsletter-home-3{background-image: url('".$this->_path."images/config/".$newsletter3_parallax_bg."');}";
        }*/
                  
        $cssTemplate = Tools::file_get_contents(dirname(__FILE__).'/css/dynamic_css_color.css');
        if($skins = $configs['YBC_TC_SKIN']['options']['query'])
        {            
            foreach($skins as $skin)
            {
                if(isset($skin['colors']) && $skin['colors'] && $skin['id_option']!='CUSTOM')
                {
                    if(Configuration::get('YBC_TC_DISPLAY_SETTING') || !Configuration::get('YBC_TC_DISPLAY_SETTING') && isset($skin['id_option']) && Tools::strtoupper($skin['id_option']) == Configuration::get('YBC_TC_SKIN'))
                    {
                        $finds = array();
                        $replacements = array();
                        $finds[] = '[body_class]';
                        $replacements[] = '.ybc-skin-'.Tools::strtolower($skin['id_option']);
                        $finds[] = '[main_color]'; 
                        $replacements[] = $skin['main_color'];
                                    
                        if(isset($skin['colors']) && $skin['colors'])
                        {
                            foreach($skin['colors'] as $color => $code)
                            {
                                $finds[] = '['.$color.']';
                                $replacements[] = $code;
                            } 
                        }                        
                        if($finds && $replacements)
                        {
                            $css .= str_replace($finds,$replacements,$cssTemplate)."\n";
                        }
                    }                    
                }
            }
        }
        if($this->colors && (Configuration::get('YBC_TC_DISPLAY_SETTING') || Configuration::get('YBC_TC_SKIN')=='CUSTOM'))
        {
            $finds = array();
            $replacements = array();
            $finds[] = '[body_class]';
            $replacements[] = '.ybc-skin-custom';
            foreach($this->colors as $color => $code)
            {
                $finds[] = '['.$color.']';
                $replacements[] = ($setColor = Configuration::get('YBC_TC_COLOR_'.Tools::strtoupper($color))) ? $setColor : $code;
            }
            $css .= str_replace($finds,$replacements,$cssTemplate)."\n";
        }
        return $css;       
    }
    public function hookYbcLayoutUpdate($params)
    {
        return;
        $configs = $this->configs;
        $layout = $params['layout'];        
        $currentLayout = Configuration::get('YBC_TC_LAYOUT');
        if(!$this->devMode)
            return;        
        if(isset($configs['YBC_TC_LAYOUT']['options']['query']) && $configs['YBC_TC_LAYOUT']['options']['query'])
        {            
            foreach($configs['YBC_TC_LAYOUT']['options']['query'] as $config)
            {                
                if(Tools::strtoupper($config['id_option']) == Tools::strtoupper($layout))
                {                    
                    if(isset($config['blogs']) && $config['blogs'])
                    {
                        Db::getInstance()->execute("UPDATE "._DB_PREFIX_."ybc_blog_post SET enabled=1");
                        //Db::getInstance()->execute("UPDATE "._DB_PREFIX_."ybc_blog_post SET enabled=1 WHERE id_post IN (".implode(',',$config['blogs']).")");                        
                    }                    
                    break;                    
                }
            } 
        }        
    }
}