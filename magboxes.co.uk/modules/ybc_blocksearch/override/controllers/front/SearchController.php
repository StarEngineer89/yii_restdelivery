<?php

    /** 

     * By YourBestCode.Com    

     * For Prestashop 1.6.0.14

     */

    class SearchController extends SearchControllerCore{

        public function initContent()

    	{

    		$query = Tools::replaceAccentedChars(urldecode(Tools::getValue('q')));

    		$original_query = Tools::getValue('q');

    		if ($this->ajax_search)

    		{

    			$searchResults = Search::find((int)(Tools::getValue('id_lang')), $query, 1, 10, 'position', 'desc', true);

    			if (is_array($searchResults))

    				foreach ($searchResults as &$product)

                    {

                        $product['product_link'] = $this->context->link->getProductLink($product['id_product'], $product['prewrite'], $product['crewrite']);

                        //Add image

                        if((int)Configuration::get('YBC_BLOCKSEARCH_SHOW_PRODUCT_IMAGE'))

                        {

                            $productObj = new Product((int)$product['id_product'], true, (int)$this->context->cookie->id_lang, $this->context->shop->id);

                            $images = $productObj->getImages((int)$this->context->cookie->id_lang);

                            if(isset($images[0]))

                    		    $id_image = Configuration::get('PS_LEGACY_IMAGES') ? ($productObj->id.'-'.$images[0]['id_image']) : $images[0]['id_image'];

                    		else

                                $id_image = $this->context->language->iso_code.'-default';			

                            $product['img_url'] =  $this->context->link->getImageLink($productObj->link_rewrite, $id_image, ImageType::getFormatedName('cart'));  

                        }

                        else

                            $product['img_url'] = '';

                                          

                    }

                $this->ajaxDie(Tools::jsonEncode($searchResults));

    		}

    

    		//Only controller content initialization when the user use the normal search

    		parent::initContent();

    

    		if ($this->instant_search && !is_array($query))

    		{

    			$this->productSort();

    			$this->n = abs((int)(Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'))));

    			$this->p = abs((int)(Tools::getValue('p', 1)));

    			$search = Search::find($this->context->language->id, $query, 1, 10, 'position', 'desc');

    			Hook::exec('actionSearch', array('expr' => $query, 'total' => $search['total']));

    			$nbProducts = $search['total'];

    			$this->pagination($nbProducts);

    

    			$this->addColorsToProductList($search['result']);

    

    			$this->context->smarty->assign(array(

    				'products' => $search['result'], // DEPRECATED (since to 1.4), not use this: conflict with block_cart module

    				'search_products' => $search['result'],

    				'nbProducts' => $search['total'],

    				'search_query' => $original_query,

    				'instant_search' => $this->instant_search,

    				'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));

    		}

    		elseif (($query = Tools::getValue('search_query', Tools::getValue('ref'))) && !is_array($query))

    		{

    			$this->productSort();

    			$this->n = abs((int)(Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'))));

    			$this->p = abs((int)(Tools::getValue('p', 1)));

    			$original_query = $query;

    			$query = Tools::replaceAccentedChars(urldecode($query));

    			$search = Search::find($this->context->language->id, $query, $this->p, $this->n, $this->orderBy, $this->orderWay);

    			if (is_array($search['result']))

    				foreach ($search['result'] as &$product)

    					$product['link'] .= (strpos($product['link'], '?') === false ? '?' : '&').'search_query='.urlencode($query).'&results='.(int)$search['total'];

    

    			Hook::exec('actionSearch', array('expr' => $query, 'total' => $search['total']));

    			$nbProducts = $search['total'];

    			$this->pagination($nbProducts);

    

    			$this->addColorsToProductList($search['result']);

    

    			$this->context->smarty->assign(array(

    				'products' => $search['result'], // DEPRECATED (since to 1.4), not use this: conflict with block_cart module

    				'search_products' => $search['result'],

    				'nbProducts' => $search['total'],

    				'search_query' => $original_query,

    				'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));

    		}

    		elseif (($tag = urldecode(Tools::getValue('tag'))) && !is_array($tag))

    		{

    			$nbProducts = (int)(Search::searchTag($this->context->language->id, $tag, true));

    			$this->pagination($nbProducts);

    			$result = Search::searchTag($this->context->language->id, $tag, false, $this->p, $this->n, $this->orderBy, $this->orderWay);

    			Hook::exec('actionSearch', array('expr' => $tag, 'total' => count($result)));

    

    			$this->addColorsToProductList($result);

    

    			$this->context->smarty->assign(array(

    				'search_tag' => $tag,

    				'products' => $result, // DEPRECATED (since to 1.4), not use this: conflict with block_cart module

    				'search_products' => $result,

    				'nbProducts' => $nbProducts,

    				'homeSize' => Image::getSize(ImageType::getFormatedName('home'))));

    		}

    		else

    		{

    			$this->context->smarty->assign(array(

    				'products' => array(),

    				'search_products' => array(),

    				'pages_nb' => 1,

    				'nbProducts' => 0));

    		}

    		$this->context->smarty->assign(array('add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'), 'comparator_max_item' => Configuration::get('PS_COMPARATOR_MAX_ITEM')));

    

    		$this->setTemplate(_PS_THEME_DIR_.'search.tpl');

    	}

    }