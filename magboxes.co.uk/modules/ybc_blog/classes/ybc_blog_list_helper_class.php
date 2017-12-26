<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blog_list_helper_class extends Module
{
    public $actions = array();
    public $currentIndex = '';
    public $identifier = '';
    public $show_toolbar = true;
    public $title = '';
    public $fields_list = array();
    public function __construct()
    {
        if($this->fields_list)
        {
            foreach($this->fields_list as $id => &$field)
            {
                $field['active'] = Tools::getValue($field[$id]);
            }
        }
    }
    public function render()
    {
        if($this->fields_list)
        {
            $this->context->smarty->assign(
                array(                    
                    'actions' => $this->actions,
                    'currentIndex' => $this->currentIndex,
                    'identifier' => $this->identifier,
                    'show_toolbar' => $this->show_toolbar,
                    'title' => $this->title,
                    'fields_list' => $this->fields_list,
                )
            );
            return $this->display(__FILE__.'../', 'list_helper.tpl');
        }
        return;
    }
}