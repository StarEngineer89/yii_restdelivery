<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blog_category_class extends ObjectModel
{
    public $id_category;
    public $title;
    public $description;
    public $meta_description;
    public $meta_keywords;
	public $enabled;
	public $url_alias;
	public $image;
    public $sort_order;
    public $datetime_added;
    public $datetime_modified;
    public $added_by;
    public $modified_by;
    public static $definition = array(
		'table' => 'ybc_blog_category',
		'primary' => 'id_category',
		'multilang' => true,
		'fields' => array(
			'enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'sort_order' => array('type' => self::TYPE_INT),
            'added_by' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'modified_by' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'url_alias' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500, 'required' => false),
            'image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),            
            'datetime_added' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            'datetime_modified' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            // Lang fields
            'meta_description' => array('type' => self::TYPE_STRING, 'lang' => true,'validate' => 'isCleanHtml', 'size' => 700),
            'meta_keywords' => array('type' => self::TYPE_STRING, 'lang' => true,'validate' => 'isCleanHtml', 'size' => 700),            
			'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 700),			
            'description' =>	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 900000),
            
        )
	);
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
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