<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_blog_paggination_class {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	public $text_first = '<span>|&lt;</span>';
	public $text_last = '<span>&gt;|</span>';
	public $text_next = '<span>&gt;</span>';
	public $text_prev = '<span>&lt;</span>';
	public $style_links = 'links';
	public $style_results = 'results';
    public $alias;
    public $friendly;
    public function __construct()
    {
        $this->alias = Configuration::get('YBC_BLOG_ALIAS');
        $this->friendly = (int)Configuration::get('YBC_BLOG_FRIENDLY_URL') && (int)Configuration::get('PS_REWRITING_SETTINGS') ? true : false;        
    }
	public function render() {
		$total = $this->total;
		
		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		
		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}
		
		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		
		if ($page > 1) {
			$output .= ' <a class = "frist" href="' . $this->replacePage(1) . '">' . $this->text_first . '</a> <a class = "prev" href="' . $this->replacePage($page-1) . '">' . $this->text_prev . '</a> ';
    	}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 1) {
				$output .= ' .... ';
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= ' <b>' . $i . '</b> ';
				} else {
					$output .= ' <a href="' . $this->replacePage($i) . '">' . $i . '</a> ';
				}	
			}
							
			if ($end < $num_pages) {
				$output .= ' .... ';
			}
		}
		
   		if ($page < $num_pages) {
			$output .= ' <a class = "next" href="' . $this->replacePage($page+1) . '">' . $this->text_next . '</a> <a class = "last" href="' . $this->replacePage($num_pages) . '">' . $this->text_last . '</a> ';
		}
		
		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);
		
		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total, 
			$num_pages
		);
		
		return ($output ? '<div class="' . $this->style_links . '">' . $output . '</div>' : '') . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>';
	}
    public function replacePage($page)
    {
        if($page > 1)
            return str_replace('_page_', $page, $this->url);
        elseif($this->friendly && $this->alias && Tools::getValue('controller') != 'AdminModules')
            return str_replace('/_page_', '', $this->url);
        else
            return str_replace('_page_', $page, $this->url);            
    }
}
?>