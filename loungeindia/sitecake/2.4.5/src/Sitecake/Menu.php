<?php

namespace Sitecake;

use Sitecake\Util\HtmlUtils;

class Menu
{
    const SC_MENU_BASE_CLASS = 'sc-nav';

    const DEFAULT_MENU_NAME = 'main';

    const ITEM_TYPE_DEFAULT = 'default';
    const ITEM_TYPE_PAGE = 'page';
    const ITEM_TYPE_CUSTOM = 'custom';

    /**
     * At the moment all menus are treated as main. When menu manager is implemented this will deffer from menu to menu
     * @var string
     */
    protected $name = self::DEFAULT_MENU_NAME;

    protected $items;

    private $node;

    public function __construct(\DOMElement $node)
    {
        $this->node = $node;

        $this->init();
    }

    protected function init()
    {
        $class = $this->node->getAttribute('class');

        if (preg_match('/(^|\s)(' . preg_quote(self::SC_MENU_BASE_CLASS) . '(\-([^\s]+))*)(\s|$)/', $class, $matches)) {
            if ($matches[2] != self::SC_MENU_BASE_CLASS && isset($matches[4])) {
                $this->name = $matches[4];
            }

            $this->findItems();
        }
    }

    protected function findItems()
    {
        $doc = new \DOMDocument();

        // Suppress HTML5 errors
        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding((string)$this, 'HTML-ENTITIES', 'UTF-8'));
        libxml_use_internal_errors(false);

        foreach ($doc->getElementsByTagName('a') as $no => $menuItem) {
            /** @var \DOMElement $menuItem */
            $data = [
                'type' => self::ITEM_TYPE_DEFAULT,
                'text' => $menuItem->textContent,
                'url' => $menuItem->getAttribute('href'),
                'title' => $menuItem->getAttribute('title') ?: $menuItem->textContent
            ];

            if ($target = $menuItem->getAttribute('target')) {
                $data['target'] = $target;
            }

            $this->items[] = $data;
        }
    }

    public function render($template, $isActive = null, $activeClass = '')
    {
        $this->node->nodeValue = '';
        $menuItems = '';

        foreach ($this->items as $no => $item) {
            if (isset($item['target']) && !empty($item['target'])) {
                $itemHTML = str_replace('${url}', $item['url'] . '" target="' . $item['target'], $template);
            } else {
                $itemHTML = str_replace('${url}', $item['url'], $template);
            }
            $itemHTML = str_replace('${title}', $item['text'], $itemHTML);
            $itemHTML = str_replace('${order}', $no, $itemHTML);
            $itemHTML = str_replace(
                '${titleText}',
                (isset($item['title']) ? $item['title'] : $item['text']),
                $itemHTML
            );

            if (strpos($itemHTML, '${active}') !== false) {
                if (is_callable($isActive) && $isActive($item['url'])) {
                    $itemHTML = str_replace('${active}', $activeClass, $itemHTML);
                } else {
                    $itemHTML = str_replace('${active}', '', $itemHTML);
                }
            }

            $menuItems .= $itemHTML;
            HtmlUtils::appendHTML($this->node, $itemHTML);
        }

        return $menuItems;//(string)$this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->node->ownerDocument->saveHTML($this->node));
    }

    public function name()
    {
        return $this->name;
    }

    public function items($items = null, $process = null)
    {
        if ($items === null) {
            return $this->items;
        }

        if (empty($process)) {
            return $this->items =  $items;
        } else {
            return $this->items = array_map($process, $items);
        }
    }
}
