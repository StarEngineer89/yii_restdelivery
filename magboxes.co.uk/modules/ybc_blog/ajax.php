<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/


include_once('../../config/config.inc.php');

$query = Tools::getValue('q', false);
if (!$query OR $query == '' OR Tools::strlen($query) < 1)
	die();

/*
 * In the SQL request the "q" param is used entirely to match result in database.
 * In this way if string:"(ref : #ref_pattern#)" is displayed on the return list, 
 * they are no return values just because string:"(ref : #ref_pattern#)" 
 * is not write in the name field of the product.
 * So the ref pattern will be cut for the search request.
 */
if($pos = strpos($query, ' (ref:'))
	$query = Tools::substr($query, 0, $pos);

$excludeIds = Tools::getValue('excludeIds', false);
if ($excludeIds && $excludeIds != 'NaN')
	$excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
else
	$excludeIds = '';

// Excluding downloadable products from packs because download from pack is not supported
$excludeVirtuals = (bool)Tools::getValue('excludeVirtuals', false);
$exclude_packs = (bool)Tools::getValue('exclude_packs', false);

$sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, MAX(image_shop.`id_image`) id_image, il.`legend`
		FROM `'._DB_PREFIX_.'product` p
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)Context::getContext()->language->id.Shop::addSqlRestrictionOnLang('pl').')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
		Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)Context::getContext()->language->id.')
		WHERE (pl.name LIKE \'%'.pSQL($query).'%\' OR p.reference LIKE \'%'.pSQL($query).'%\')'.
		(!empty($excludeIds) ? ' AND p.id_product NOT IN ('.$excludeIds.') ' : ' ').
		($excludeVirtuals ? 'AND p.id_product NOT IN (SELECT pd.id_product FROM `'._DB_PREFIX_.'product_download` pd WHERE (pd.id_product = p.id_product))' : '').
		($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '').
		' GROUP BY p.id_product';

$items = Db::getInstance()->executeS($sql);

$acc = (bool)Tools::isSubmit('excludeIds');

if ($items && $acc)
	foreach ($items AS $item)
		echo trim($item['name']).(!empty($item['reference']) ? ' (ref: '.$item['reference'].')' : '').'|'.(int)($item['id_product'])."\n";
elseif ($items)
{
	// packs
	$results = array();
	foreach ($items AS $item)
	{
		$product = array(
			'id' => (int)($item['id_product']),
			'name' => $item['name'],
			'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
			'image' => str_replace('http://', Tools::getShopProtocol(), Context::getContext()->link->getImageLink($item['link_rewrite'], $item['id_image'], ImageType::getFormatedName('home'))),
		);
		array_push($results, $product);
	}
	echo Tools::jsonEncode($results);
}
else
	Tools::jsonEncode(new stdClass);