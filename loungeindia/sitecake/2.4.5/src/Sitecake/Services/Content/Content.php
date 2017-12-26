<?php
namespace Sitecake\Services\Content;

use Sitecake\Site;

class Content
{
    /**
     * Storage manager
     *
     * @var Site
     */
    protected $site;

    /**
     * Array containing all pages with path
     *
     * @var \ArrayObject<string, \ArrayObject<string, string|Sitecake\Page>>
     */
    protected $pages;

    /**
     * Indexed array where indexes are container names and
     * values are arrays of Page objects that contain that specific container
     *
     * @var \ArrayObject<string, \ArrayObject<string, \ArrayObject<string, string|Sitecake\Page>>>
     */
    protected $containers;

    /**
     * Content constructor.
     *
     * @param Site $site
     */
    public function __construct($site)
    {
        $this->site = $site;
    }

    public function save($data)
    {
        foreach ($data as $container => $content) {
            // remove slashes
            if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
                $content = stripcslashes($content);
            }
            $content = base64_decode($content);
            $this->setContainerContent($container, $content);
        }
        $this->savePages();

        return 0;
    }

    protected function setContainerContent($container, $content)
    {
        $containers = $this->containers();
        if (isset($containers[$container])) {
            foreach ($containers[$container] as $page) {
                $this->setPageDirty($page);
                $page['page']->setContainerContent($container, $content);
            }
        }
    }

    protected function containers()
    {
        if (!$this->containers) {
            $this->initContainers();
        }

        return $this->containers;
    }

    protected function initContainers()
    {
        $this->containers = [];
        $pages = $this->pages();
        foreach ($pages as $page) {
            $pageContainers = $page['page']->containers();
            foreach ($pageContainers as $container) {
                if (array_key_exists($container, $this->containers)) {
                    array_push($this->containers[$container], $page);
                } else {
                    $this->containers[$container] = [$page];
                }
            }
        }
    }

    protected function pages()
    {
        if (!$this->pages) {
            $this->pages = $this->site->getAllPages();
        }

        return $this->pages;
    }

    protected function setPageDirty($page)
    {
        foreach ($this->pages as &$p) {
            if ($page['path'] === $p['path']) {
                $p['dirty'] = true;
            }
        }
    }

    protected function savePages()
    {
        foreach ($this->pages() as $page) {
            if (isset($page['dirty']) && $page['dirty'] === true) {
                $this->site->savePage($page['path'], $page['page']);
            }
        }
    }
}
