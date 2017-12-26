<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blog_comment_class extends ObjectModel
{
    public $id_comment;
    public $id_user;
    public $id_post;
    public $subject;
    public $comment;
    public $reply;
	public $approved;
	public $datetime_added;
	public $reported;
    public $rating;
    public $replied_by;
    public static $definition = array(
		'table' => 'ybc_blog_comment',
		'primary' => 'id_comment',
		'multilang' => false,
		'fields' => array(			
            'id_comment' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'replied_by' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'id_user' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'rating' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_post' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'approved' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'reported' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'subject' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 5000),
            'comment' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 99000),
            'reply' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 99000),
            'datetime_added' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),  
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