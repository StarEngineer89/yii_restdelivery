<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
Class Ybc_megamenu_class extends ObjectModel
{
    public $id_menu;
    public $title;
	public $enabled;
	public $show_icon;
	public $link;
    public $width;
	public $custom_class;
	public $icon;
    public $icon_image;
    public $id_cms;
    public $id_category;
    public $id_manufacturer;
    public $menu_type;
    public $sort_order;
    public $column_type;
    public $sub_menu_max_width;
    public $color1;
    public $color2;
    public $color3;
    public $color4;
    public $color5;
    public $color6;
    public $sub_type;
    public $wrapper_border;
    public $banner_position;
    public $banner_link;
    public $image;
    public static $definition = array(
		'table' => 'ybc_mm_menu',
		'primary' => 'id_menu',
		'multilang' => true,
		'fields' => array(
			'enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_icon' =>array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500,'required' => false),
            'id_category' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'id_manufacturer' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'id_cms' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),            
            'menu_type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500, 'required' => true),            
            'sub_menu_max_width' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            'custom_class' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50),
            'column_type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50),
            'icon' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),            
			'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'color1' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'color2' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'color3' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'color4' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'color5' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'color6' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'sub_type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'wrapper_border' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500, 'required' => false),
            'icon_image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500, 'required' => false),
            'banner_position' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50,'required' => false),
            'banner_link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            // Lang fields
			'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 500)			
        )
	);
    
    public	function __construct($id_slide = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_slide, $id_lang, $id_shop);
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        foreach($languages as $lang)
        {
            foreach(self::$definition['fields'] as $field => $params)
            {   
                $temp = $this->$field; 
                if(isset($params['lang']) && $params['lang'] && !isset($temp[$lang['id_lang']]))
                {                      
                    $temp[$lang['id_lang']] = '';                        
                }
                $this->$field = $temp;
            }
        }
	}
}