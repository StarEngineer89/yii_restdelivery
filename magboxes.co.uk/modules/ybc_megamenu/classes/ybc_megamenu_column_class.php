<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
Class Ybc_megamenu_column_class extends ObjectModel
{
    public $id_column;
    public $title;
    public $description;
	public $enabled;
	public $show_image;
    public $show_title;
    public $show_description;
	public $custom_class;
	public $image;
    public $sort_order;
    public $column_size;
    public $id_menu;
    public $column_link;
    public static $definition = array(
		'table' => 'ybc_mm_column',
		'primary' => 'id_column',
		'multilang' => true,
		'fields' => array(
			'enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'id_menu' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'show_image' =>array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_title' =>array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_description' =>array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'custom_class' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50),
            'column_link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            'column_size' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 50),
            'image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            // Lang fields
			'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 500),			
            'description' =>	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 4000),
            
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