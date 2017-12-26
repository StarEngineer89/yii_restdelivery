<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blog_link_class extends LinkCore
{
    public function getLangLinkFriendly($id_lang = null, Context $context = null, $id_shop = null)
	{
		if (!$context)
			$context = Context::getContext();

		if ((!$this->allow && in_array($id_shop, array($context->shop->id,  null))) || !Language::isMultiLanguageActivated($id_shop) || !(int)Configuration::get('PS_REWRITING_SETTINGS', null, null, $id_shop))
			return '';

		if (!$id_lang)
			$id_lang = $context->language->id;

		return Language::getIsoById($id_lang).'/';
	}
	
	public function getBaseLinkFriendly($id_shop = null, $ssl = null)
	{
		static $force_ssl = null;
		
		if ($ssl === null)
		{
			if ($force_ssl === null)
				$force_ssl = (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
			$ssl = $force_ssl;
		}

		if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && $id_shop !== null)
			$shop = new Shop($id_shop);
		else
			$shop = Context::getContext()->shop;

		$base = (($ssl && $this->ssl_enable) ? 'https://'.$shop->domain_ssl : 'http://'.$shop->domain);

		return $base.$shop->getBaseURI();
	}
}