<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blogBlogModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		parent::init();
	}
	public function initContent()
	{
	    $module = new Ybc_blog();
		parent::initContent();
        $id_post = (int)Tools::getValue('id_post');
        $context = Context::getContext();
        if($id_post)
        {
            //Increase views            
            if(!$context->cookie->posts_viewed)
               $postsViewed = array();
            else
               $postsViewed = @unserialize($context->cookie->posts_viewed);             
            if(is_array($postsViewed) && !in_array($id_post, $postsViewed))
            {                
                if($module->itemExists('post','id_post',$id_post))
                {
                    $post = new Ybc_blog_post_class($id_post);
                    $post->click_number = (int)$post->click_number + 1;
                    if($post->update())
                    {
                        $postsViewed[] = $id_post;
                        $context->cookie->posts_viewed = @serialize($postsViewed);
                        $context->cookie->write();      
                    }                    
                }                
            }
            
            $errors = array();
            $justAdded = false;
            $success = false;
            if(Tools::isSubmit('bcsubmit') && (int)Configuration::get('YBC_BLOG_ALLOW_COMMENT'))
            {
                $comment = new Ybc_blog_comment_class();
                $comment->approved = (int)Configuration::get('YBC_BLOG_COMMENT_AUTO_APPROVED') ? 1 : 0;
                $comment->subject = trim(Tools::getValue('subject'));
                $comment->comment = trim(Tools::getValue('comment'));
                $comment->id_post = (int)Tools::getValue('id_post');
                $comment->datetime_added = date('Y-m-d H:i:s');
                $comment->id_user = (int)$this->context->cookie->id_customer;
                $comment->rating = (int)Tools::getValue('rating');
                $comment->reported = 1;
                if(Tools::strlen($comment->subject) < 10)
                    $errors[] = $this->module->l('Subject need to be at least 10 characters');
                if(Tools::strlen($comment->subject) >300)
                    $errors[] = $this->module->l('Subject can not be longer than 300 characters');  
                if(!Validate::isCleanHtml($comment->subject,false))
                    $errors[] = $this->module->l('Subject need to be clean HTML');
                if(Tools::strlen($comment->comment) < 20)
                    $errors[] = $this->module->l('Comment need to be at least 20 characters');
                if(!Validate::isCleanHtml($comment->comment,false))
                    $errors[] = $this->module->l('Comment need to be clean HTML');
                if(Tools::strlen($comment->comment) >2000)
                    $errors[] = $this->module->l('Subject can not be longer than 2000 characters');    
                if(!$comment->id_user)
                    $errors[] = $this->module->l('You need to log in before posting a comment');
                if((int)Configuration::get('YBC_BLOG_ALLOW_RATING'))
                {
                    if($comment->rating > 5 || $comment->rating < 1)
                        $errors[] = $this->module->l('Rating need to be from 1 to 5');
                }
                else
                    $comment->rating = 0;                
                if(!$module->itemExists('post','id_post',$comment->id_post))
                    $errors[] = $this->module->l('This post does not exist');
                if((int)Configuration::get('YBC_BLOG_USE_CAPCHA'))
                {                    
                    $savedCode = $context->cookie->security_capcha_code;
                    $capcha_code = trim(Tools::getValue('capcha_code'));                    
                    if($savedCode && Tools::strtolower($capcha_code)!=Tools::strtolower($savedCode))
                    {
                        $errors[] = $this->module->l('Security code is invalid');
                    }
                }
                if(!count($errors))
                {
                    $comment->add();
                    $customer = new Customer((int)$this->context->cookie->id_customer);
                    $this->sendCommentNotificationEmail(
                        trim($customer->firstname.' '.$customer->lastname),
                        $customer->email,
                        $comment->subject,
                        $comment->comment,
                        $comment->rating.' '.($comment->rating != 1 ? $this->module->l('stars') : $this->module->l('star')),
                        $module->getLink('blog', array('id_post' => $comment->id_post))
                    );
                    $justAdded = true;
                    $success = $this->module->l('Comment has been submitted ');
                    if($comment->approved)
                        $success .= $this->module->l('and approved');
                    else
                        $success .= $this->module->l('and waiting for approval');
                }       
            }
            $post = $this->getPost((int)Tools::getValue('id_post'));
            if($post)
            {
                $urlAlias = Tools::strtolower(trim(Tools::getValue('url_alias')));
                if($urlAlias && $urlAlias != Tools::strtolower(trim($post['url_alias'])))
                    Tools::redirect($module->getLink('blog',array('id_post' => $post['id_post'])));               
                
                //check if liked post
                if(!$context->cookie->liked_posts)
                    $likedPosts = array();
                else
                    $likedPosts = @unserialize($context->cookie->liked_posts);
                
                if(is_array($likedPosts) && in_array($id_post, $likedPosts))
                    $likedPost = true;
                else
                    $likedPost = false;
                $climit = (int)Configuration::get('YBC_BLOG_MAX_COMMENT') ? (int)Configuration::get('YBC_BLOG_MAX_COMMENT') : false;  
                $cstart = $climit ? 0 : false;
                $prettySkin = Configuration::get('YBC_BLOG_GALLERY_SKIN');
                $randomcode = time();
                
                
                $this->context->smarty->assign(
                    array(
                        'blog_post' => $post,
                        'allowComments' => (int)Configuration::get('YBC_BLOG_ALLOW_COMMENT') ? true : false,
                        'blogCommentAction' => $module->getLink('blog',array('id_post'=>(int)Tools::getValue('id_post'))),
                        'comment' => !$justAdded ? Tools::getValue('comment') : '',
                        'subject' => !$justAdded ?Tools::getValue('subject') : '',
                        'hasLoggedIn' => $this->context->customer->isLogged(true), 
                        'blog_errors' => $errors,
                        'comments' => $module->getCommentsWithFilter(' AND bc.approved = 1 AND bc.id_post='.(int)Tools::getValue('id_post'),' bc.id_comment desc, ',$cstart,$climit),
                        'reportedComments' => $context->cookie->reported_comments ? @unserialize($context->cookie->reported_comments) : false,
                        'blog_success' => $success,
                        'allow_report_comment' =>(int)Configuration::get('YBC_BLOG_ALLOW_REPORT') ? true : false,
                        'display_related_products' =>(int)Configuration::get('YBC_BLOG_SHOW_RELATED_PRODUCTS') ? true : false,
                        'allow_rating' => (int)Configuration::get('YBC_BLOG_ALLOW_RATING') ? true : false,
                        'default_rating' => (int)Tools::getValue('rating') > 0 && (int)Tools::getValue('rating') <=5 ? (int)Tools::getValue('rating')  :(int)Configuration::get('YBC_BLOG_DEFAULT_RATING'),
                        'everage_rating' => (int)$module->getEverageReviews($post['id_post']),
                        'total_review' =>(int)$module->countTotalReviewsWithRating($post['id_post']),
                        'use_capcha' => (int)Configuration::get('YBC_BLOG_USE_CAPCHA') ? true : false,
                        'capcha_image' => $module->getLink('capcha',array('randcode'=>$randomcode)),
                        'use_facebook_share' => (int)Configuration::get('YBC_BLOG_ENABLE_FACEBOOK_SHARE') ? true : false,
                        'use_google_share' => (int)Configuration::get('YBC_BLOG_ENABLE_GOOGLE_SHARE') ? true : false,
                        'use_twitter_share' => (int)Configuration::get('YBC_BLOG_ENABLE_TWITTER_SHARE') ? true : false,
                        'post_url' => $module->getLink('blog',array('id_post'=>(int)Tools::getValue('id_post'))),
                        'report_url' => $module->getLink('report'),
                        'likedPost' => $likedPost,                        
                        'allow_like' => (int)Configuration::get('YBC_BLOG_ALLOW_LIKE') ? true : false,
                        'show_date' => (int)Configuration::get('YBC_BLOG_SHOW_POST_DATE') ? true : false,
                        'show_tags' => (int)Configuration::get('YBC_BLOG_SHOW_POST_TAGS') ? true : false,
                        'show_categories' => (int)Configuration::get('YBC_BLOG_SHOW_POST_CATEGORIES') ? true : false,
                        'show_views' => (int)Configuration::get('YBC_BLOG_SHOW_POST_VIEWS') ? true : false,
                        'enable_slideshow' => (int)Configuration::get('YBC_BLOG_ENABLE_POST_SLIDESHOW') ? true : false,
                        'prettySkin' => in_array($prettySkin, array('dark_square','dark_rounded','default','facebook','light_rounded','light_square')) ? $prettySkin : 'dark_square', 
                        'prettyAutoPlay' => (int)Configuration::get('YBC_BLOG_GALLERY_AUTO_PLAY') ? 1 : 0,
                        'path' => $module->getBreadCrumb(),
                        'show_author' => (int)Configuration::get('YBC_BLOG_SHOW_POST_AUTHOR') ? 1 : 0,
                        'blog_random_code' => $randomcode,
                        'date_format' => trim((string)Configuration::get('YBC_BLOG_DATE_FORMAT')),
                        'blog_layout' => Tools::strtolower(Configuration::get('YBC_BLOG_LAYOUT')),   
                        'blog_skin' => Tools::strtolower(Configuration::get('YBC_BLOG_SKIN')), 
                        'blog_related_product_type' => Tools::strtolower(Configuration::get('YBC_RELATED_PRODUCTS_TYPE')),
                        'blog_related_posts_type' => Tools::strtolower(Configuration::get('YBC_RELATED_POSTS_TYPE')),
                    )
                );   
            }
            else
                $this->context->smarty->assign(
                    array(
                        'blog_post' => false
                ));
                     
            $this->setTemplate('single_post.tpl');             
        }
        else
        {
            $postData = $this->getPosts();
            $this->context->smarty->assign(
                array(
                    'blog_posts' => $postData['posts'],
                    'blog_paggination' => $postData['paggination'],
                    'blog_category' => $postData['category'],
                    'blog_latest' => $postData['latest'],
                    'blog_dir' => $postData['blogDir'],
                    'blog_tag' => $postData['tag'],
                    'blog_search' => $postData['search'],
                    'is_main_page' => !$postData['category'] && !$postData['tag'] && !$postData['search'] && !Tools::isSubmit('latest') && !Tools::isSubmit('id_author') ? true : false,
                    'allow_rating' => (int)Configuration::get('YBC_BLOG_ALLOW_RATING') ? true : false,
                    'show_featured_post' => (int)Configuration::get('YBC_BLOG_SHOW_FEATURED_BLOCK') ? true : false,
                    'allow_like' => (int)Configuration::get('YBC_BLOG_ALLOW_LIKE') ? true : false,
                    'show_date' => (int)Configuration::get('YBC_BLOG_SHOW_POST_DATE') ? true : false,
                    'show_views' => (int)Configuration::get('YBC_BLOG_SHOW_POST_VIEWS') ? true : false,
                    'path' => $module->getBreadCrumb(),
                    'date_format' => trim((string)Configuration::get('YBC_BLOG_DATE_FORMAT')),
                    'show_categories' => (int)Configuration::get('YBC_BLOG_SHOW_POST_CATEGORIES') ? true : false, 
                    'blog_layout' => Tools::strtolower(Configuration::get('YBC_BLOG_LAYOUT')),   
                    'blog_skin' => Tools::strtolower(Configuration::get('YBC_BLOG_SKIN')),
                    'author' => $postData['author'],                   
                )
            );
            $this->setTemplate('blog_list.tpl'); 
        }               
	}
    public function getPost($id_post)
    {
        $module = new Ybc_blog();
        $post = $module->getPostById($id_post);
        if($post)
        {
            $post['id_category'] = $module->getCategoriesStrByIdPost($post['id_post']);
            $post['tags'] = $module->getTagsByIdPost($post['id_post']);
            $post['related_posts'] = (int)Configuration::get('YBC_BLOG_DISPLAY_RELATED_POSTS') ? $module->getRelatedPosts($id_post, $post['tags'], $this->context->language->id) : false; 
            if($post['related_posts'])
            {
                foreach($post['related_posts'] as &$rpost)
                    if($rpost['image'])
                    {
                        $rpost['image'] = $module->blogDir.'images/post/'.$rpost['image'];
                        $rpost['thumb'] = $module->blogDir.'images/post/thumb/'.$rpost['thumb'];
                        $rpost['link'] =   $module->getLink('blog',array('id_post'=>$rpost['id_post']));
                        $rpost['categories'] = $module->getCategoriesByIdPost($rpost['id_post'],false,true); 
                    }                        
            }               
            if($post['image'])
                $post['image'] = $module->blogDir.'images/post/'.$post['image'];
            $post['link'] = $module->getLink('blog',array('id_post'=>$post['id_post']));
            $post['categories'] = $module->getCategoriesByIdPost($post['id_post'],false,true);  
            $post['products'] = $post['products'] ? $module->getRelatedProductByProductsStr($post['products']) : false;   
            $params['id_author'] = (int)$post['added_by'];
            $employee = $this->getAuthorById($params['id_author']);
            if($employee)
                $params['alias'] = str_replace(' ','-',trim(Tools::strtolower($employee['firstname'].' '.$employee['lastname']))); 
            $post['author_link'] = $module->getLink('blog', $params);
            return $post;
        }
        return false;
    }
    public function getPosts()
    {
        $context = Context::getContext();
        $params = array('page'=>"_page_");
        $module = new Ybc_blog();
        $filter = ' AND p.enabled = 1 ';
        $featurePage = false;
        $id_category = (int)trim(Tools::getValue('id_category'));
        if($id_category)
        {
            if($module->itemExists('category','id_category',$id_category))
            {
                $category = new Ybc_blog_category_class($id_category);
                $urlAlias = Tools::strtolower(trim(Tools::getValue('url_alias')));
                if($urlAlias && $urlAlias != Tools::strtolower(trim($category->url_alias)))
                    Tools::redirect($module->getLink('blog',array('id_category' => $id_category)));
            }
            $filter .= " AND p.id_post IN (SELECT id_post FROM "._DB_PREFIX_."ybc_blog_post_category WHERE id_category = ".(int)trim(Tools::getValue('id_category')).") ";
            $params['id_category'] = (int)trim(Tools::getValue('id_category'));
        }
        elseif(trim(Tools::getValue('latest')))
        {            
            $params['latest'] = 'true';
        }                  
        elseif(trim(Tools::getValue('tag'))!='')
        {            
            $tag = addslashes(urldecode(trim(Tools::getValue('tag'))));
            $md5tag = md5(urldecode(trim(Tools::strtolower(Tools::getValue('tag')))));            
            $filter .= " AND p.id_post IN (SELECT id_post FROM "._DB_PREFIX_."ybc_blog_tag WHERE tag = '$tag' AND id_lang = ".$this->context->language->id.")";            
            //Increase views          
            
            if(!$context->cookie->tags_viewed)
               $tagsViewed = array();
            else
               $tagsViewed = @unserialize($context->cookie->tags_viewed);
                     
            if(is_array($tagsViewed) && !in_array($md5tag, $tagsViewed))
            {   
                if($module->increasTagViews($tag))
                {
                    $tagsViewed[] = $md5tag;
                    $context->cookie->tags_viewed = @serialize($tagsViewed);
                    $context->cookie->write();    
                }                              
            }
            $params['tag'] = trim(Tools::getValue('tag'));
        }  
        elseif(trim(Tools::getValue('search'))!='')
        {
            $search = addslashes(trim(Tools::getValue('search')));
            $filter .= " AND p.id_post IN (SELECT id_post FROM "._DB_PREFIX_."ybc_blog_post_lang WHERE (title like '%$search%' OR description like '%$search%') AND id_lang = ".$this->context->language->id.")";
            $params['search'] = trim(Tools::getValue('search'));
        }
        elseif($id_employee = (int)Tools::getValue('id_author'))
        {
            $filter .= " AND p.added_by = ".$id_employee;
            $params['id_author'] = $id_employee;
            $employee = $this->getAuthorById($id_employee);
            if($employee)
                $params['alias'] = str_replace(' ','-',trim(Tools::strtolower($employee['firstname'].' '.$employee['lastname'])));
        }                
        else
        {
            $filter .= ' AND p.is_featured = 1';
            $featurePage = true;            
        }
            
        if(!trim(Tools::getValue('latest')))            
            $sort = 'p.sort_order ASC, p.id_post DESC, ';
        else
            $sort = 'p.id_post DESC, ';
        
        //Paggination
        $page = (int)Tools::getValue('page') && (int)Tools::getValue('page') > 0 ? (int)Tools::getValue('page') : 1;
        $totalRecords = (int)$module->countPostsWithFilter($filter);
        $paggination = new Ybc_blog_paggination_class();            
        $paggination->total = $totalRecords;
        
        $paggination->url = $module->getLink('blog', $params);
        $paggination->limit =  (int)Configuration::get('YBC_BLOG_ITEMS_PER_PAGE') > 0 ? (int)Configuration::get('YBC_BLOG_ITEMS_PER_PAGE') : 20;
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        if(!$featurePage)
            $posts = $module->getPostsWithFilter($filter, $sort, $start, $paggination->limit);
        else
            $posts = $module->getPostsWithFilter($filter, $sort, 0, false);
        
        if(!$context->cookie->liked_posts)
            $likedPosts = array();
        else
            $likedPosts = @unserialize($context->cookie->liked_posts);
        if($posts)
        {
            foreach($posts as &$post)
            {
                $post['id_category'] = $module->getCategoriesStrByIdPost($post['id_post']);
                $post['tags'] = $module->getTagsByIdPost($post['id_post']);
                if($post['thumb'])
                    $post['thumb'] = $module->blogDir.'images/post/thumb/'.$post['thumb'];
                if($post['image'])
                    $post['image'] = $module->blogDir.'images/post/'.$post['image'];
                $post['link'] = $module->getLink('blog',array('id_post'=>$post['id_post']));
                $post['categories'] = $module->getCategoriesByIdPost($post['id_post'],false,true);
                $post['everage_rating'] = $module->getEverageReviews($post['id_post']);
                $post['total_review'] = $module->countTotalReviewsWithRating($post['id_post']);
                if(is_array($likedPosts) && in_array($post['id_post'], $likedPosts))
                    $post['liked'] = true;
                else
                    $post['liked'] = false;
            }                
        }
       
        return array(
            'posts' => $posts , 
            'paggination' => $featurePage ? '' : $paggination->render(), 
            'category' => (int)Tools::getValue('id_category') ? $module->getCategoryById((int)Tools::getValue('id_category')) : false,
            'blogDir' => $module->blogDir,
            'tag' => trim(Tools::getValue('tag')) !='' ? urldecode(trim(Tools::getValue('tag'))) : false,
            'search' => trim(Tools::getValue('search'))!='' ? urldecode(trim(Tools::getValue('search'))) : false,
            'latest' => trim(Tools::getValue('latest'))=='true' ? true : false,
            'author' => isset($employee) && $employee ? trim(Tools::ucfirst($employee['firstname']).' '.Tools::ucfirst($employee['lastname'])) : false,
        );
    }
    public function sendCommentNotificationEmail($customer, $bemail, $subject, $comment, $rating, $postLink)
    {
        if(!(int)Configuration::get('YBC_BLOG_ENABLE_MAIL'))
            return false;
        $mailDir = dirname(__FILE__).'/../../mails/';
        $lang = new Language((int)$this->context->language->id);
        $mail_lang_id = (int)$this->context->language->id;
        if(!is_dir($mailDir.$lang->iso_code))
           $mail_lang_id = (int)Configuration::get('PS_LANG_DEFAULT'); 
        if(Configuration::get('YBC_BLOG_ALERT_EMAILS'))
            $emails = explode(',',Configuration::get('YBC_BLOG_ALERT_EMAILS'));
        else
            $emails = array();
        if($emails)
        {
            foreach($emails as $email)
            {    
                if(Validate::isEmail(trim($email)))
                {
                    Mail::Send(
                        $mail_lang_id, 
                        'new_comment', trim($subject) ? trim($subject) : 
                        Mail::l('New comment from customer [{customer}]', $this->context->language->id), 
                        array('{customer}' => $customer, '{email}' => $bemail,'{rating}' => $rating, '{subject}' => $subject, '{comment}'=>$comment, '{post_link}' => $postLink),  
                        trim($email), null, null, null, null, null, 
                        $mailDir, 
                        false, $this->context->shop->id
                    );   
                }                
            }
        }
    }
    private function getAuthorById($id_employee)
    {
        return Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'employee WHERE id_employee = '.$id_employee);
    }
}