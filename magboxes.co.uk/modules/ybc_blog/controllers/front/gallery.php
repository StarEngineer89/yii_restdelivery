<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blogGalleryModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		parent::init();
	}
	public function initContent()
	{
	    $module = new Ybc_blog();
		parent::initContent();
        $galleryData = $this->getGalleries();
        $prettySkin = Configuration::get('YBC_BLOG_GALLERY_SKIN');
        $this->context->smarty->assign(
            array(
                'blog_galleries' => $galleryData['galleries'],
                'blog_paggination' => $galleryData['paggination'],
                'prettySkin' => in_array($prettySkin, array('dark_square','dark_rounded','default','facebook','light_rounded','light_square')) ? $prettySkin : 'dark_square', 
                'prettyAutoPlay' => (int)Configuration::get('YBC_BLOG_GALLERY_AUTO_PLAY') ? 1 : 0,
                'path' => $module->getBreadCrumb(),
                'blog_layout' => Tools::strtolower(Configuration::get('YBC_BLOG_LAYOUT')),   
                'blog_skin' => Tools::strtolower(Configuration::get('YBC_BLOG_SKIN')), 
            )
        );
        $this->setTemplate('gallery.tpl');                
	}    
    public function getGalleries()
    {
        $filter = ' AND g.enabled = 1';            
        $sort = ' g.sort_order asc, g.id_gallery asc, ';
        $module = new Ybc_blog();
        //Paggination
        $page = (int)Tools::getValue('page') && (int)Tools::getValue('page') > 0 ? (int)Tools::getValue('page') : 1;
        $totalRecords = (int)$module->countGalleriesWithFilter($filter);
        $paggination = new Ybc_blog_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->url = $module->getLink('gallery', array('page'=>"_page_"));
        $paggination->limit =  (int)Configuration::get('YBC_BLOG_ITEMS_PER_PAGE') > 0 ? (int)Configuration::get('YBC_BLOG_ITEMS_PER_PAGE') : 20;
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $galleries = $module->getGalleriesWithFilter($filter, $sort, $start, $paggination->limit);
        if($galleries)
        {
            foreach($galleries as &$gallery)
            {
                if($gallery['image'])
                {
                    $gallery['thumb'] = file_exists(dirname(__FILE__).'/../../images/gallery/thumb/'.$gallery['image']) ? $module->blogDir.'images/gallery/thumb/'.$gallery['image'] : $module->blogDir.'images/gallery/'.$gallery['image'];
                    $gallery['image'] = $module->blogDir.'images/gallery/'.$gallery['image'];                    
                }                    
            }                
        }        
        return array(
            'galleries' => $galleries , 
            'paggination' => $paggination->render()
        );
    }
}