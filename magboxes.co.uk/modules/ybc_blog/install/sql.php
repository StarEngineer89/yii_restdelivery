<?php
    /**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
    $sqls = array();
    $sqls[] = "
        CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_category` (
          `id_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `url_alias` varchar(700) NOT NULL,
          `image` varchar(500) NOT NULL,
          `added_by` int(11) DEFAULT NULL,
          `modified_by` int(11) DEFAULT NULL,
          `enabled` tinyint(1) NOT NULL DEFAULT '1',
          `datetime_added` datetime DEFAULT NULL,
          `datetime_modified` datetime DEFAULT NULL,
          `sort_order` int(11) NOT NULL DEFAULT '1',
          PRIMARY KEY (`id_category`)
        )
    ";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_category_lang` (
  `id_category` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `title` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `meta_keywords` varchar(5000) CHARACTER SET utf8 DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_comment` (
  `id_comment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `subject` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  `comment` text CHARACTER SET utf8,
  `reply` text,
  `replied_by` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `datetime_added` datetime DEFAULT NULL,
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comment`)
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_gallery` (
  `id_gallery` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(1000) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_gallery`)
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_gallery_lang` (
  `id_gallery` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `description` text
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_post` (
  `id_post` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `url_alias` varchar(700) NOT NULL,
  `products` varchar(1000) DEFAULT NULL,
  `thumb` varchar(1000) DEFAULT NULL,
  `image` varchar(500) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `datetime_added` datetime DEFAULT NULL,
  `datetime_modified` datetime DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '1',
  `click_number` int(11) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_post`)
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_post_category` (
  `id_post` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_post_lang` (
  `id_post` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `title` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `short_description` text CHARACTER SET utf8,
  `meta_keywords` varchar(5000) CHARACTER SET utf8 DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_slide` (
  `id_slide` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(1000) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_slide`)
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_slide_lang` (
  `id_slide` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `caption` varchar(5000) CHARACTER SET utf8 NOT NULL
)";
    $sqls[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_blog_tag` (
  `id_tag` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `tag` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `click_number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tag`)
)";

if($sqls)
{
    foreach($sqls as $sql)
    {
        Db::getInstance()->execute($sql);
    }
}