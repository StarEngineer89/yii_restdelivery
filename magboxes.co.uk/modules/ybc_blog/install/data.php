<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
    $languages = Language::getLanguages(false);
    $tempDir = dirname(__FILE__).'/../images/temp/';
    $imgDir = dirname(__FILE__).'/../images/';
    //Install sample data
    //Category
    $category = new Ybc_blog_category_class();
    $category->id_category = 1;
    $category->enabled = 1;
    $category->url_alias = 'sample-category';
    $category->image = '';
    $category->sort_order = 1;
    $category->datetime_added = date('Y-m-d H:i:s');
    $category->datetime_modified = date('Y-m-d H:i:s');
    $category->added_by = (int)$this->context->employee->id;
    $category->modified_by = (int)$this->context->employee->id;
    foreach($languages as $language)
    {
        $category->title[$language['id_lang']] = $this->l('Sample category');
        $category->description[$language['id_lang']] = $this->l('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $category->meta_description[$language['id_lang']] = $this->l('Sample category meta description');
        $category->meta_keywords[$language['id_lang']] = $this->l('Yourbestcode.com, Prestaman.com');
    }
    $category->save();
    
    //Post
    for ($i = 1; $i <= 5; $i++){
        $post = new Ybc_blog_post_class();
        $post->id_post = $i;
        $post->enabled = $i;
        $post->url_alias = 'sample-post'.$i;
        $post->sort_order = $i;
        $post->datetime_added = date('Y-m-d H:i:s');
        $post->datetime_modified = date('Y-m-d H:i:s');
        $post->added_by = (int)$this->context->employee->id;
        $post->modified_by = (int)$this->context->employee->id;
        $post->click_number = 0;
        $post->likes = 0;
        $post->products = '';
        $post->thumb = 'post-thumb-sample.jpg';
        $post->image = 'post.jpg';
        $post->is_featured = 1;        
        foreach($languages as $language)
        {
            $post->title[$language['id_lang']] = $this->l('Sample title blog');
            $post->short_description[$language['id_lang']] = $this->l('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
            $post->description[$language['id_lang']] = $this->l('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
            $post->description[$language['id_lang']] .= '<br/>'.$this->l('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
            $post->description[$language['id_lang']] .= '<br/>'.$this->l('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
            $post->description[$language['id_lang']] .= '<br/>'.$this->l('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
            $post->description[$language['id_lang']] .= '<br/>'.$this->l('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
            $post->meta_description[$language['id_lang']] = $this->l('Sample post meta description');
            $post->meta_keywords[$language['id_lang']] = $this->l('Yourbestcode.com, Prestaman.com');
        }
        $post->save();
        if(file_exists($tempDir.'post.jpg'))
            @copy($tempDir.'post.jpg',$imgDir.'post/post.jpg');
        if(file_exists($tempDir.'post-thumb-sample.jpg'))
            @copy($tempDir.'post-thumb-sample.jpg',$imgDir.'post/thumb/post-thumb-sample.jpg');
        
        $req ="INSERT INTO "._DB_PREFIX_."ybc_blog_post_category(id_post, id_category)  VALUES(".$i.",1)";
        Db::getInstance()->execute($req);
        
        foreach($languages as $language)
        {
            $req ="INSERT INTO "._DB_PREFIX_."ybc_blog_tag(id_post, id_lang, tag, click_number)  VALUES(".$i.",".$language['id_lang'].",'".addslashes($this->l('Lorem'))."',0)";
            Db::getInstance()->execute($req);
            $req ="INSERT INTO "._DB_PREFIX_."ybc_blog_tag(id_post, id_lang, tag, click_number)  VALUES(".$i.",".$language['id_lang'].",'".addslashes($this->l('Consectetur'))."',0)";
            Db::getInstance()->execute($req);
        }    
    }
    
    $slide = new Ybc_blog_slide_class();
    $slide->id_slide = 1;
    $slide->enabled = 1;
    $slide->image = 'slide1.jpg';
    $slide->sort_order = 1;
    $slide->url = '';
    foreach($languages as $language)
    {
        $slide->caption[$language['id_lang']] = $this->l('<span>Lorem ipsum dolor sit amet consectetur adipiscing</span> Elit sed do eiusmod tempor incididunt ut labore et');        
    }    
    $slide->save();
    if(file_exists($tempDir.'slide1.jpg'))
        @copy($tempDir.'slide1.jpg',$imgDir.'slide/slide1.jpg');
        
    $slide = new Ybc_blog_slide_class();
    $slide->id_slide = 2;
    $slide->enabled = 1;
    $slide->image = 'slide2.jpg';
    $slide->sort_order = 1;
    $slide->url = '';
    foreach($languages as $language)
    {
        $slide->caption[$language['id_lang']] = $this->l('<span>Lorem ipsum dolor sit amet consectetur adipiscing</span> Elit sed do eiusmod tempor incididunt ut labore et');
    }    
    $slide->save();
    if(file_exists($tempDir.'slide2.jpg'))
        @copy($tempDir.'slide2.jpg',$imgDir.'slide/slide2.jpg');
        
    //Gallery
    $gallery = new Ybc_blog_gallery_class();
    $gallery->id_gallery = 1;
    $gallery->enabled = 1;
    $gallery->image = 'gallery.jpg';
    $gallery->sort_order = 1;
    $gallery->url = '';
    $gallery->is_featured = 1;
    foreach($languages as $language)
    {
        $gallery->title[$language['id_lang']] = $this->l('Sample gallery');  
        $gallery->description[$language['id_lang']] = $this->l('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et');              
    }    
    $gallery->save();
    if(file_exists($tempDir.'gallery.jpg'))
        @copy($tempDir.'gallery.jpg',$imgDir.'gallery/gallery.jpg');
    if(file_exists($tempDir.'gallery-thumb.jpg'))
        @copy($tempDir.'gallery-thumb.jpg',$imgDir.'gallery/thumb/gallery-thumb.jpg');