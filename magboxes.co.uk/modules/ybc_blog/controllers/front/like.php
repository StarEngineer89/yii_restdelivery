<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blogLikeModuleFrontController extends ModuleFrontController
{
    public function init()
	{
	     $json = array();
	     $id_post = (int)Tools::getValue('id_post');
         $module = new Ybc_blog();
         if(!$module->itemExists('post','id_post',$id_post))
         {
            $json['error'] = $this->module->l('This post does not exist');
            die(Tools::jsonEncode($json));
         }
         if(!(int)Configuration::get('YBC_BLOG_ALLOW_LIKE'))
         {
            $json['error'] = $this->module->l('You are not allow to like the post');
            die(Tools::jsonEncode($json));
         }
         $context = Context::getContext();
         if(!$context->cookie->liked_posts)
            $likedPosts = array();
         else
            $likedPosts = @unserialize($context->cookie->liked_posts);  
         if(is_array($likedPosts) && !in_array($id_post,$likedPosts))
         {
             $likedPosts[] = $id_post;
             $post = new Ybc_blog_post_class($id_post);
             $post->likes = $post->likes+1;
             if($post->update())
             {
                $context->cookie->liked_posts = @serialize($likedPosts);
                 $context->cookie->write();
                 $json['likes'] = $post->likes;
                 $json['success'] = $this->module->l('Successfully liked the post');
                 die(Tools::jsonEncode($json));
             }             
         }
         $json['error'] = $this->module->l('You have liked this post');
         die(Tools::jsonEncode($json));
	}
}