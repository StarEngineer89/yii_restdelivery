<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blogReportModuleFrontController extends ModuleFrontController
{
    public function init()
	{
	     $json = array();
	     $id_comment = (int)Tools::getValue('id_comment');
         $module = new Ybc_blog();
         if(!$module->itemExists('comment','id_comment',$id_comment))
         {
            $json['error'] = $this->module->l('This comment does not exist');
            die(Tools::jsonEncode($json));
         }
         if(!(int)Configuration::get('YBC_BLOG_ALLOW_REPORT'))
         {
            $json['error'] = $this->module->l('You are not allowed to report this comment');
            die(Tools::jsonEncode($json));
         }
         $context = Context::getContext();
         if(!$context->cookie->reported_comments)
            $reportedComments = array();
         else
            $reportedComments = @unserialize($context->cookie->reported_comments); 
         
         if(is_array($reportedComments) && !in_array($id_comment, $reportedComments))
         {
             $reportedComments[] = $id_comment;
             $context->cookie->reported_comments = @serialize($reportedComments);
             $context->cookie->write();	
             $customer = new Customer((int)$this->context->cookie->id_customer);             
             $comment = new Ybc_blog_comment_class($id_comment);
             $comment->reported = 0;
             $comment->update();             
             $json['success'] = $this->module->l('Successfully reported');
             $this->sendNotification(
                $comment->id_comment,
                $comment->subject,
                $comment->comment,
                $comment->rating.' '.($comment->rating != 1 ? $this->module->l('stars') : $this->module->l('star')),
                $module->getLink('blog', array('id_post' => $comment->id_post)),
                trim($customer->firstname.' '.$customer->lastname),
                $customer->email
             );
             die(Tools::jsonEncode($json));
         }
         $json['error'] = $this->module->l('This comment has been reported');
         die(Tools::jsonEncode($json));
	}
    public function sendNotification($id_comment, $subject, $comment, $rating, $postLink, $reporter, $remail)
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
                        'report_comment', Mail::l('A blog comment is reported', $this->context->language->id), 
                        array('{reporter}' => $reporter, '{email}' => $remail,'{rating}' => $rating, '{subject}' => $subject, '{comment}'=>$comment, '{post_link}' => $postLink,'{id_comment}' => $id_comment),  
                        trim($email), null, null, null, null, null, 
                        $mailDir, 
                        false, $this->context->shop->id
                    );   
                }                
            }
        }
    }
}