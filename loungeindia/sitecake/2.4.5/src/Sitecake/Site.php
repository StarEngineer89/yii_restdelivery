<?php

namespace Sitecake;

use League\Flysystem\Directory;
use League\Flysystem\Filesystem;
use League\Flysystem\Util;
use LogicException;
use RuntimeException;
use Silex\Application;
use Sitecake\Exception\FileNotFoundException;
use Sitecake\Exception\InternalException;
use Sitecake\Util\HtmlUtils;
use Sitecake\Util\Utils;

class Site
{
    const RESOURCE_TYPE_ALL = 'all';
    const RESOURCE_TYPE_PAGE = 'page';
    const RESOURCE_TYPE_RESOURCE = 'resource';
    const RESOURCE_TYPE_IMAGE = 'image';
    const RESOURCE_TYPE_FILE = 'file';

    const SC_PAGES_EXCLUSION_CHARACTER = '!';

    /**
     * @var Application
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $fs;

    protected $tmp;

    protected $draft;

    protected $backup;

    protected $ignores;

    protected $pageFiles;

    /**
     * Metadata that are stored in draft marker file.
     * Contains next information :
     *      + lastPublished : Timestamp when content was published last time
     *      + files : All site file paths with respective modification times for public [0] and draft [1] versions
     *      + pages : All page file paths with its details :
     *          * id - page id. The service should use the page id to identify and update an appropriate existing page,
     *                 even if its url/path has been changed.
     *          * url - website root/website relative URL/file path.
     *          * idx - nav bar index. -1 if not present in the nav bar or relative position within the nav bar.
     *          * title - page title. Content of the <title> tag.
     *          * navtitle - title used in the nav element.
     *          * desc - meta description. Content of the meta description tag.
     *      + menus : Contain paths of files that contains menu(s) [pages] and list of menu items [items]
     *
     * @var array
     */
    protected $metadata;

    protected $defaultMetadataStructure
        = [
            'lastPublished' => 0,
            'files'         => [],
            'pages'         => [],
            'menus'         => []
        ];

    public function __construct(Filesystem $fs, $config)
    {
        $this->config = $config;
        $this->fs = $fs;

        $this->__ensureDirs();

        $this->ignores = [];
        $this->__loadIgnorePatterns();

        $this->loadMetadata();
    }

    private function __ensureDirs()
    {
        // check/create directory images
        try {
            if (!$this->fs->ensureDir('images')) {
                throw new LogicException('Could not ensure that the directory /images is present and writable.');
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory /images is present and writable.');
        }
        // check/create files
        try {
            if (!$this->fs->ensureDir('files')) {
                throw new LogicException('Could not ensure that the directory /files is present and writable.');
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory /files is present and writable.');
        }
        // check/create sitecake-temp
        try {
            if (!$this->fs->ensureDir('sitecake-temp')) {
                throw new LogicException('Could not ensure that the directory /sitecake-temp is present and writable.');
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory /sitecake-temp is present and writable.');
        }
        // check/create sitecake-temp/<workid>
        try {
            $work = $this->fs->randomDir('sitecake-temp');
            if ($work === false) {
                throw new LogicException(
                    'Could not ensure that the work directory in /sitecake-temp is present and writable.'
                );
            }
        } catch (RuntimeException $e) {
            throw new LogicException(
                'Could not ensure that the work directory in /sitecake-temp is present and writable.'
            );
        }
        // check/create sitecake-temp/<workid>/tmp
        try {
            $this->tmp = $this->fs->ensureDir($work . '/tmp');
            if ($this->tmp === false) {
                throw new LogicException('Could not ensure that the directory '
                    . $work
                    . '/tmp is present and writable.');
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory '
                . $work
                . '/tmp is present and writable.');
        }
        // check/create sitecake-temp/<workid>/draft
        try {
            $this->draft = $this->fs->ensureDir($work . '/draft');
            if ($this->draft === false) {
                throw new LogicException('Could not ensure that the directory '
                    . $work
                    . '/draft is present and writable.');
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory '
                . $work
                . '/draft is present and writable.');
        }

        // check/create sitecake-backup
        try {
            if (!$this->fs->ensureDir('sitecake-backup')) {
                throw new LogicException(
                    'Could not ensure that the directory /sitecake-backup is present and writable.'
                );
            }
        } catch (RuntimeException $e) {
            throw new LogicException('Could not ensure that the directory /sitecake-backup is present and writable.');
        }
        // check/create sitecake-backup/<workid>
        try {
            $this->backup = $this->fs->randomDir('sitecake-backup');
            if ($work === false) {
                throw new LogicException(
                    'Could not ensure that the work directory in /sitecake-backup is present and writable.'
                );
            }
        } catch (RuntimeException $e) {
            throw new LogicException(
                'Could not ensure that the work directory in /sitecake-backup is present and writable.'
            );
        }
    }

    private function __loadIgnorePatterns()
    {
        if ($this->fs->has('.scignore')) {
            $this->ignores = preg_split('/\R/', $this->fs->read('.scignore'));
        }
        $this->ignores = array_filter(array_merge($this->ignores, [
            '.scignore',
            '.scpages',
            'draft.drt',
            'draft.mkr',
            $this->config['entry_point_file_name'],
            'sitecake/',
            'sitecake-temp/',
            'sitecake-backup/'
        ]));
    }

    /**
     * Retrieves site metadata from file. Also stores internal _metadata property.
     *
     * @return array If metadata written to file can't be un-serialized
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function loadMetadata()
    {
        if (!$this->metadata) {
            if ($this->draftExists()) {
                $this->metadata
                    = @unserialize($this->fs->read($this->draftMarkerPath()));

                if ($this->metadata === null) {
                    throw new InternalException('Metadata could\'t be un-serialized');
                }

                if (empty($this->metadata)) {
                    $this->metadata = $this->defaultMetadataStructure;
                }
            } else {
                $this->metadata = $this->defaultMetadataStructure;
            }
        }

        return $this->metadata;
    }

    protected function draftExists()
    {
        return $this->fs->has($this->draftMarkerPath());
    }

    protected function draftMarkerPath()
    {
        return $this->draftPath() . '/draft.mkr';
    }

    /**
     * Returns the path of the draft directory.
     *
     * @return string the draft dir path
     */
    public function draftPath()
    {
        return $this->draft;
    }

    /**
     * Returns the path of the temporary directory.
     *
     * @return string the tmp dir path
     */
    public function tmpPath()
    {
        return $this->tmp;
    }

    /**
     * Returns a list of CMS related resource file paths from the
     * given directory.
     *
     * @param  string $directory Directory to read from
     *
     * @return array List of resource file paths
     */
    public function listPublicResources($directory = '')
    {
        return $this->listScPaths($directory, self::RESOURCE_TYPE_RESOURCE);
    }

    /**
     * Returns a list of paths of CMS related files from the given
     * directory. It looks for HTML files, images and uploaded files.
     * It ignores entries from .scignore filter the output list.
     *
     * @param  string $directory the root directory to start search into
     * @param  string $type      Indicates what type of resources should be listed (pages, resources or all)
     *
     * @return array            the output paths list
     */
    public function listScPaths(
        $directory = '',
        $type = self::RESOURCE_TYPE_ALL
    ) {
        $ignores = $this->ignores;

        return array_filter(array_merge(
            (
            in_array($type, [self::RESOURCE_TYPE_ALL, self::RESOURCE_TYPE_PAGE]) ?
                $this->findSourceFiles($directory) : []
            ),
            (
            in_array($type, [
                self::RESOURCE_TYPE_ALL,
                self::RESOURCE_TYPE_RESOURCE,
                self::RESOURCE_TYPE_IMAGE
            ]) ?
                $this->fs->listPatternPaths(
                    ltrim($directory . '/images', '/'),
                    '/^.*\-sc[0-9a-f]{13}[^\.]*\..+$/',
                    true
                ) : []
            ),
            (in_array($type, [
                self::RESOURCE_TYPE_ALL,
                self::RESOURCE_TYPE_RESOURCE,
                self::RESOURCE_TYPE_FILE
            ]) ?
                $this->fs->listPatternPaths(
                    ltrim($directory . '/files', '/'),
                    '/^.*\-sc[0-9a-f]{13}[^\.]*\..+$/',
                    true
                ) : []
            )
        ), function ($path) use ($ignores, $directory) {
            foreach ($ignores as $ignore) {
                if (strpos($directory, $ignore) === 0) {
                    continue;
                }
                if ($ignore !== '' && strpos($path, $ignore) === 0) {
                    return false;
                }
            }

            return true;
        });
    }

    protected function findSourceFiles($directory)
    {
        // Get valid page file extensions
        $extensions = $this->getValidPageExtensions();

        // List first level files for passed directory
        $firstLevel = $this->fs->listContents($directory);

        $paths = [];

        foreach ($firstLevel as $file) {
            if (($file['type'] == 'dir'
                    && !in_array($file['path'] . '/', $this->ignores))
                || ($file['type'] == 'file'
                    && !in_array($file['basename'], $this->ignores)
                    && preg_match('/^.*\.(' . implode('|', $extensions)
                        . ')?$/', $file['basename']) === 1)
            ) {
                if ($file['type'] == 'dir') {
                    $paths = array_merge(
                        $paths,
                        $this->fs->listPatternPaths(
                            $file['path'],
                            '/^.*\.(' . implode('|', $extensions) . ')?$/',
                            true
                        )
                    );
                } else {
                    $paths[] = $file['path'];
                }
            }
        }

        return $paths;
    }

    public function getValidPageExtensions()
    {
        $defaultPages = is_array($this->config['site.default_pages'])
            ? $this->config['site.default_pages']
            :
            [$this->config['site.default_pages']];

        return Utils::map(function ($pageName) {
            $nameParts = explode('.', $pageName);

            return array_pop($nameParts);
        }, $defaultPages);
    }

    /**
     * Starts the site draft out of the public content.
     * It copies public pages and resources into the draft folder.
     */
    public function startEdit()
    {
        $this->loadPageFilePaths();

        if (!$this->draftExists()) {
            $this->startDraft();
        } else {
            $this->cleanupDraft();
            $this->updateFromSource();
        }
    }

    /**
     * Returns list of paths of Page files.
     *
     * Files that are considered as Page files are by default all files with valid extensions from root directory
     * and all files stated in .scpages file if it's present.
     * Files from root directory that shouldn't be considered as Page files can be filtered out
     * by stating them inside .scpages prefixed with exclamation mark (!)
     * If directory is stated in .scpages file all files from that directory are considered as Page files
     *
     * @return array
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function loadPageFilePaths()
    {
        if ($this->pageFiles) {
            return $this->pageFiles;
        }

        // Get valid page file extensions
        $extensions = $this->getValidPageExtensions();

        // List all pages in document root
        $pageFilePaths = $this->fs->listPatternPaths('', '/^.*\.(' . implode('|', $extensions) . ')?$/');

        // Filter out entry point file
        if (($index = array_search($this->config['entry_point_file_name'], $pageFilePaths)) !== false) {
            array_splice($pageFilePaths, $index, 1);
            $pageFilePaths = array_values($pageFilePaths);
        }

        // If .scpages file present we need to add page files stated inside and filter out ones that starts with !
        if ($this->fs->has('.scpages')) {
            $scPages = $this->fs->read('.scpages');

            if (!empty($scPages)) {
                // Load page life paths from .scpages
                $scPagePaths = preg_split('/\R/', $this->fs->read('.scpages'));

                foreach ($scPagePaths as $no => $pathEntry) {
                    if (empty($pathEntry)) {
                        continue;
                    }

                    $firstChar = substr($pathEntry, 0, 1);

                    // Read directory pages if directory is passed in .scpages
                    if ($firstChar !== self::SC_PAGES_EXCLUSION_CHARACTER) {
                        // Check if directory is passed
                        if (substr($pathEntry, -1) == '/') {
                            $noTrailingSlash = substr($pathEntry, 0, -1);
                            $pageFilePaths = array_merge(
                                $pageFilePaths,
                                $this->fs->listPatternPaths(
                                    $noTrailingSlash,
                                    '/^.*\.(' . implode('|', $extensions) . ')?$/',
                                    true
                                )
                            );
                            // Check if file extension filter is passed
                        } elseif (preg_match('/\*\.[A-Za-z0-9]+$/', $pathEntry)) {
                            $dir = '';
                            $path = $pathEntry;
                            if (strpos($pathEntry, '/') !== false) {
                                $parts = explode('/', $pathEntry);
                                $path = array_pop($parts);
                                $dir = implode('/', $parts);
                            }
                            $pageFilePaths = array_merge(
                                $pageFilePaths,
                                $this->fs->listPatternPaths(
                                    $dir,
                                    '/^.*\.' . substr($path, 2) . '?$/',
                                    true
                                )
                            );
                            // If regular file path, add it if not already inserted
                        } elseif (array_search($pathEntry, $pageFilePaths) === false) {
                            $pageFilePaths[] = $pathEntry;
                        }
                    } else {
                        // Filter out pages that starts with !
                        $path = substr($pathEntry, 1);
                        $excludePaths = [];
                        if (substr($path, -1) == '/') {
                            $noTrailingSlash = substr($path, 0, -1);
                            $excludePaths = $this->fs->listPatternPaths(
                                $noTrailingSlash,
                                '/^.*\.(' . implode('|', $extensions) . ')?$/',
                                true
                            );
                            // Check if file extension filter is passed
                        } elseif (preg_match('/\*\.[A-Za-z0-9]+$/', $path)) {
                            $dir = '';
                            if (strpos($path, '/') !== false) {
                                $parts = explode('/', $path);
                                $path = array_pop($parts);
                                $dir = implode('/', $parts);
                            }
                            $excludePaths = $this->fs->listPatternPaths(
                                $dir,
                                '/^.*\.' . substr($path, 2) . '?$/',
                                true
                            );
                        } elseif (($index = array_search($path, $pageFilePaths)) !== false) {
                            $excludePaths = [$pageFilePaths[$index]];
                        }

                        $pageFilePaths = array_diff($pageFilePaths, $excludePaths);
                    }
                }
            }
        }

        $this->pageFiles = $pageFilePaths;

        return $this->pageFiles;
    }

    /**
     * Starts site draft. Copies all pages and resources to draft directory.
     * Also prepares container names, prefixes all urls in draft pages
     * and collects all navigation sections that appears inside pages.
     */
    protected function startDraft()
    {
        // Copy and prepare all resources and pages (normalize containers and prefix resource urls) and load navigation
        $paths = $this->listScPaths();
        foreach ($paths as $path) {
            $this->createDraftResource($path);
        }

        $this->processMenus($paths);

        // Set lastPublished metadata value to current timestamp
        $this->saveLastPublished();

        // Set metadata
        $this->writeMetadata();
    }

    protected function createDraftResource($path)
    {
        // Copy page/resource to draft dir
        $draftPath = $this->draftBaseUrl() . $path;
        $this->fs->copy($path, $draftPath);

        // Get file metadata
        $pageMetadata = $this->fs->getMetadata($path);

        // This is a Page. Create draft and process it
        if (!$this->isResourcePath($path)) {
            // Initialize Page
            $page = new Page($this->fs->read($draftPath));

            if ($page->isEditable()) {
                // Normalize container names (add _cnt_ suffixes where no SC identification is set)
                $page->normalizeContainerNames();
            }

            // Prefix resource urls (prepend draft path for all resources urls and basedir path to relative paths)
            $page->prefixResourceUrls($this->draftBaseUrl(), $this->getBase());

            // Update draft file content
            $this->fs->update($draftPath, (string)$page);

            if ($this->isPageFile($path)) {
                $id = Utils::id();
                $this->metadata['pages'][$path] = [
                    // Set page id
                    'id'    => $id,
                    // Set page title
                    'title' => (string)$page->getPageTitle(),
                    // Set page description
                    'desc'  => (string)$page->getPageDescription()
                ];
            }
        }

        $draftMetadata = $this->fs->getMetadata($draftPath);

        // Remember last modification times
        $this->metadata['files'][$path] = [
            $pageMetadata['timestamp'],
            $draftMetadata['timestamp']
        ];
    }

    /**
     * Check if passed path is resource
     *
     * @param string $path
     *
     * @return int
     */
    public function isResourcePath($path)
    {
        return (bool)preg_match('/^.*(files|images)\/.*\-sc[0-9a-f]{13}[^\.]*\..+$/', $path);
    }

    /**
     * Loads navigation sections found within passed page
     *
     * @param Page $page
     *
     * @return bool
     * @throws \Exception
     */

    public function hasMenu(Page $page)
    {
        return count($page->query('[class*="' . Menu::SC_MENU_BASE_CLASS
                . '"]')) > 0;
    }

    /**
     * Loads navigation sections found within passed page
     *
     * @param Page   $page
     * @param string $path
     *
     * @throws \Exception
     */
    protected function processMenu(Page $page, $path)
    {
        foreach ($page->query('[class*="' . Menu::SC_MENU_BASE_CLASS . '"]') as $menu) {
            $menu = new Menu($menu);

            $name = $menu->name();

            if (!isset($this->metadata['menus'][$name])) {
                $this->metadata['menus'][$name] = [
                    'pages' => [],
                    'items' => []
                ];
            }

            if (array_search($path, $this->metadata['menus'][$name]['pages'])
                === false
            ) {
                array_push($this->metadata['menus'][$name]['pages'], $path);
            }

            $menuItems = $menu->items();
            $this->metadata['menus'][$name]['items'] = [];

            if ($menuItems) {
                foreach ($menuItems as $no => &$menuItem) {
                    if (Utils::isExternalLink($menuItem['url'])
                        || HtmlUtils::isAnchorLink($menuItem['url'])
                    ) {
                        $menuItem['type'] = Menu::ITEM_TYPE_CUSTOM;
                    } else {
                        $referencedPagePath = $this->urlToPath($menuItem['url'], $this->isPageFile($path) ? $path : '');
                        if ($referencedPagePath !== false
                            && $this->isPageFile($referencedPagePath)
                        ) {
                            $menuItem['type'] = Menu::ITEM_TYPE_PAGE;
                            $menuItem['reference'] = $referencedPagePath;
                        }
                    }
                    $this->metadata['menus'][$name]['items'][] = $menuItem;
                }
            }
        }
    }

    public function processMenus($paths)
    {
        foreach ($paths as $path) {
            if (!$this->isResourcePath($path)) {
                $page = new Page($this->fs->read($this->draftBaseUrl() . $path));
                // Check for existing navigation in current page and store it if found
                if ($this->hasMenu($page)) {
                    $this->processMenu($page, $path);
                }
            }
        }
    }

    public function isPageFile($path)
    {
        if (is_null($this->pageFiles)) {
            $this->loadPageFilePaths();
        }

        return in_array($path, $this->pageFiles);
    }

    public function pageFileUrl($path)
    {
        if ($this->config['pages.use_default_page_name_in_url']) {
            return $path;
        }

        $defaultIndex = $this->getDefaultIndex();
        $pathParts = explode('/', $path);
        if (array_pop($pathParts) == $defaultIndex) {
            if (($path = implode('/', $pathParts))) {
                return $path . '/';
            }

            return './';
        }

        return $path;
    }

    /**
     * Strips / and . in front of url
     *
     * @param $url
     *
     * @return mixed
     */
    public function pageFilePath($url)
    {
        return ltrim($url, './');
    }

    public function urlToPath($url, $refererPath = '')
    {
        $defaultIndex = $this->getDefaultIndex();

        // By default we return path relative to site root dir (root default page)
        if (empty($refererPath)) {
            $refererPath = $defaultIndex;
        }

        $path = $url;

        // Strip '.' in front of url (if it starts with './') because it's same as if there is no './' prefix
        if (strpos($path, './') === 0) {
            $path = ltrim($path, '.');
        }

        // Strip anchor from URL if present
        if (($pos = strpos($path, '#')) !== false) {
            $path = substr($path, 0, $pos);
        }

        // Strip query string from URL if present
        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }

        // Strip base dir url (just '/' if no base dir) if present
        if (strpos($path, $this->base()) === 0) {
            $path = $this->stripBase($path);
        }

        // If there is still slash at beginning of url remove it
        if (strpos($path, '/') === 0) {
            $path = ltrim($path, '/');
        }

        if (empty($path)) {
            $path = $defaultIndex;
        }

        try {
            $referenceDir = rtrim(
                implode('/', array_slice(explode('/', $refererPath), 0, -1)),
                '/'
            );
            $path = Util::normalizePath((strpos($path, '../') !== false
                    ? $referenceDir . '/' : '') . $path);

            if (empty($path)) {
                $path = $defaultIndex;
            } else {
                if ($this->fs->has($path)) {
                    if ($this->fs->get($path) instanceof Directory) {
                        $path = $this->getDefaultIndex($path);
                    }
                } elseif ($this->fs->has($this->draftBaseUrl() . $path)) {
                    if ($this->fs->get($this->draftBaseUrl() . $path) instanceof Directory) {
                        $path = $this->getDefaultIndex($path);
                    }
                } else {
                    return $path;
                }
            }
        } catch (LogicException $e) {
            return $path;
        }

        return $path;
    }

    public function pathToUrl($path, $refererPath = '')
    {
        if (!empty($this->config['pages.use_document_relative_paths'])) {
            return $this->pageFileUrl($this->base() . $path);
        }

        $pathParts = explode('/', $path);
        $filename = array_pop($pathParts);

        $refererPathParts = array_slice(explode('/', $refererPath), 0, -1);

        $url = '';
        $no = 0;
        foreach ($pathParts as $no => $part) {
            if (isset($refererPathParts[$no])) {
                if ($part == $refererPathParts[$no]) {
                    continue;
                }

                $url = str_repeat('../', count(array_slice($refererPathParts, $no))) .
                    implode('/', array_slice($pathParts, $no));
                break;
            } else {
                $url = implode('/', array_slice($pathParts, $no));
            }
        }

        if (empty($url)) {
            if (empty($pathParts)) {
                $url = str_repeat('../', count($refererPathParts));
            } elseif (isset($refererPathParts[$no + 1])) {
                $url = str_repeat('../', count(array_slice($refererPathParts, $no + 1)));
            }
        }

        return $this->pageFileUrl(($url ? rtrim($url, '/') . '/' : '')
            . $filename);
    }

    /**
     * Returns base dir for website
     * e.g. if site is under http://www.sitecake.com/demo method will return /demo/
     *
     * @return string
     */
    protected function base()
    {
        $self = $_SERVER['PHP_SELF'];

        $serviceURLPosition = strlen($self) - strlen($this->config['SERVICE_URL']) - 1;
        if (strpos($self, '/' . $this->config['SERVICE_URL']) === $serviceURLPosition) {
            $base = str_replace('/' . $this->config['SERVICE_URL'], '', $self);
        } else {
            $base = dirname($self);
        }

        $base = preg_replace('#/+#', '/', $base);

        if ($base === DIRECTORY_SEPARATOR || $base === '.') {
            $base = '';
        }
        $base = implode('/', array_map('rawurlencode', explode('/', $base)));

        return $base . '/';
    }

    public function getBase()
    {
        if (!empty($this->config['pages.use_document_relative_paths'])) {
            return $this->base();
        }

        return '';
    }

    /**
     * Returns passed page url modified by stripping base dir if it exists
     *
     * @param string $url
     *
     * @return string Passed url stripped by base dir if found
     */
    public function stripBase($url)
    {
        $check = $url;
        $base = $this->base();
        if (strpos($check, $base) === 0) {
            return (string)substr($check, strlen($base));
        }

        return $url;
    }

    public function getDefaultIndex($directory = '')
    {
        $paths = $this->listScPagesPaths($directory);

        $defaultPages = is_array($this->config['site.default_pages']) ?
            $this->config['site.default_pages'] :
            [$this->config['site.default_pages']];
        foreach ($defaultPages as $defaultPage) {
            $dir = $directory ? rtrim($directory, '/') . '/' : '';
            if (in_array($dir . $defaultPage, $paths)) {
                return $dir . $defaultPage;
            }
        }

        throw new FileNotFoundException([
            'type'  => 'Default page',
            'files' => '[' . implode(', ', $defaultPages) . ']'
        ], 401);
    }

    /**
     * Returns a list of CMS related page file paths from the
     * given directory.
     *
     * @param  string $directory a directory to read from
     *
     * @return array            a list of page file paths
     */
    public function listScPagesPaths($directory = '')
    {
        return $this->listScPaths($directory, self::RESOURCE_TYPE_PAGE);
    }

    /**
     * Writes site metadata to file.
     *
     * @return bool Operation success
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function writeMetadata()
    {
        if ($this->draftExists()) {
            return $this->fs->update($this->draftMarkerPath(), serialize($this->metadata));
        }

        return $this->fs->write($this->draftMarkerPath(), serialize($this->metadata));
    }

    protected function cleanupDraft()
    {
        $draftResources = $this->draftResources();
        $allResources = $this->listScPaths($this->draftPath());
        foreach ($allResources as $resource) {
            if (!in_array($resource, $draftResources)) {
                $this->fs->delete($resource);
            }
        }
    }

    protected function draftResources()
    {
        $draftPagePaths = $this->listDraftPagePaths();
        $resources = array_merge([], $draftPagePaths);
        foreach ($draftPagePaths as $pagePath) {
            $page = new Page($this->fs->read($pagePath), false);
            $resources = array_merge($resources, $page->listResourceUrls());
        }

        return array_unique($resources);
    }

    /**
     * Returns a list of draft page file paths.
     *
     * @return array a list of draft page file paths
     */
    public function listDraftPagePaths()
    {
        return $this->listScPaths($this->draftPath(), self::RESOURCE_TYPE_PAGE);
    }

    public function updateFromSource()
    {
        // Check if draft is clean
        $isDraftClean = $this->isDraftClean();

        // Get all draft page files to be able to compare and delete files that don't exist any more
        $draftPaths = $this->listScPaths($this->draftPath());

        // Overwrite outdated resources
        $paths = $this->listScPaths();
        foreach ($paths as $path) {
            $draftPath = $this->draftBaseUrl() . $path;

            // Filter out draft path from all draft paths
            if (($index = array_search($draftPath, $draftPaths)) !== false) {
                unset($draftPaths[$index]);
            }

            if (!$this->fs->has($draftPath)) {
                // This is a new resource/page and should be copied to draft
                $this->createDraftResource($path);
            } else {
                // Get public file metadata
                $pageMetadata = $this->fs->getMetadata($path);

                if (isset($this->metadata['files'][$path][0])) {
                    // Check last modification time for resource and overwrite draft file if it is needed and possible
                    if ($pageMetadata['timestamp'] > $this->metadata['files'][$path][0]) {
                        if (!$this->isResourcePath($path)) {
                            // Initialize Page to check if it's editable or has menus
                            $page = new Page($this->fs->read($path));

                            if ($page->isEditable() || $this->hasMenu($page)) {
                                if ($isDraftClean
                                    || $this->config['pages.prioritize_manual_changes']
                                ) {
                                    $this->fs->delete($draftPath);
                                    $this->createDraftResource($path);
                                }
                            } else {
                                $this->fs->delete($draftPath);
                                $this->createDraftResource($path);
                            }
                        } else {
                            $this->fs->delete($draftPath);
                            $this->fs->copy($path, $draftPath);
                        }
                    }
                } else {
                    $draftMetadata = $this->fs->getMetadata($draftPath);
                    if ($isDraftClean || ($this->metadata['lastPublished'] > $draftMetadata['timestamp'])) {
                        $this->fs->delete($draftPath);
                        $this->createDraftResource($path);
                    }

                    // Remember last modification times
                    $this->metadata['files'][$path] = [
                        $pageMetadata['timestamp'],
                        $draftMetadata['timestamp']
                    ];
                }

                // If .scpages file is changed pages won't match so we need to check and add if needed
                if ($this->isPageFile($path)) {
                    if (!isset($this->metadata['pages'][$path])) {
                        $page = new Page($this->fs->read($draftPath));
                        $id = Utils::id();
                        $this->metadata['pages'][$path] = [
                            // Set page id
                            'id'    => $id,
                            // Set page title
                            'title' => (string)$page->getPageTitle(),
                            // Set page description
                            'desc'  => (string)$page->getPageDescription()
                        ];
                    }
                } else {
                    $this->removePathFromMetadata($path, true);
                }
            }
        }

        if (!empty($draftPaths) && ($isDraftClean || $this->config['pages.prioritize_manual_changes'])) {
            foreach ($draftPaths as $draftPath) {
                //$draftMetadata = $this->fs->getMetadata($draftPath);
                /**
                 * TODO: For now if page is deleted manually it's draft should also be deleted. This should be changed when unpublished changes are introduced
                 */
                //if ($this->metadata['lastPublished'] > $draftMetadata['timestamp']) {
                $this->fs->delete($draftPath);
                $path = $this->stripDraftPath($draftPath);
                $this->removePathFromMetadata($path);
                //}
            }
        }

        $this->processMenus($paths);

        // Set metadata
        $this->writeMetadata();
    }

    public function removePathFromMetadata($path, $pageOnly = false)
    {
        if (!$pageOnly) {
            if (isset($this->metadata['files'][$path])) {
                unset($this->metadata['files'][$path]);
            }
            if (!empty($this->metadata['menus'])) {
                foreach ($this->metadata['menus'] as &$menu) {
                    if (($index = array_search($path, $menu['pages'])) !== false) {
                        unset($menu['pages'][$index]);
                    }
                }
            }
        }
        if (isset($this->metadata['pages'][$path])) {
            unset($this->metadata['pages'][$path]);
        }
    }

    public function isDraftClean()
    {
        return !$this->fs->has($this->draftDirtyMarkerPath());
    }

    protected function draftDirtyMarkerPath()
    {
        return $this->draftPath() . '/draft.drt';
    }

    public function restore($version = 0)
    {
    }

    public function getDefaultPublicPage()
    {
        $publicPagePaths = $this->listScPagesPaths();
        $pagePath = $this->getDefaultIndex();
        if (in_array($pagePath, $publicPagePaths)) {
            $draft = new Draft($this->fs->read($pagePath));

            // Normalize resource URLs
            $draft->normalizeResourcePaths($this->base());

            // Set Page ID stored in metadata if exists
            if (!($pageID = $this->getPageID($pagePath))) {
                $pageID = Utils::id();
            }
            $draft->setPageId($pageID);
            $draft->addRobotsNoIndexNoFollow();

            return $draft;
        } else {
            throw new FileNotFoundException([
                'type'  => 'Default page',
                'files' => $pagePath
            ], 401);
        }
    }

    /**
     * Gets page ID for specific page from metadata if it exist, if not returns false
     *
     * @param $path
     *
     * @return bool|int
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function getPageID($path)
    {
        $this->loadMetadata();

        if (!isset($this->metadata['pages'][$this->stripDraftPath($path)])) {
            return false;
        }

        return $this->metadata['pages'][$this->stripDraftPath($path)]['id'];
    }

    protected function stripDraftPath($path)
    {
        return substr($path, strlen($this->draftBaseUrl()));
    }

    protected function draftBaseUrl()
    {
        return $this->draftPath() . '/';
    }

    public function getDefaultDraftPage()
    {
        return $this->getDefaultPage($this->draftPath());
    }

    public function getDefaultPage($directory = '')
    {
        return new Page($this->fs->read($this->getDefaultIndex($directory)));
    }

    public function getDraft($uri)
    {
        $draftPagePaths = $this->listDraftPagePaths();
        $currentWorkingDir = getcwd();
        $executionDirectory = $this->draftBaseUrl();

        if (!empty($uri)) {
            $pagePath = $this->draftBaseUrl() . $uri;

            if ($this->fs->has($pagePath)
                && $this->fs->get($pagePath) instanceof Directory
            ) {
                $pagePath = $this->getDefaultIndex($pagePath);
            }
        } else {
            $pagePath = $this->getDefaultIndex($this->draftPath());
        }

        // Check if we need to change execution directory
        if ($dir = implode('/', array_slice(explode('/', $pagePath), 0, -1))) {
            $executionDirectory = $dir;
        }

        if (in_array($pagePath, $draftPagePaths)) {
            // Move execution to directory where requested page is because of php includes
            chdir($this->fs->getAdapter()->applyPathPrefix($executionDirectory));

            $draft = new Draft($this->fs->read($pagePath));

            // Normalize resource URLs
            $draft->normalizeResourcePaths($this->base());

            // Set Page ID stored in metadata
            $draft->setPageId($this->getPageID($pagePath));

            // Add robots meta tag
            $draft->addRobotsNoIndexNoFollow();

            // Turn execution back to root dir
            chdir($currentWorkingDir);

            return $draft;
        } else {
            throw new FileNotFoundException([
                'type'  => 'Draft Page',
                'files' => $pagePath
            ], 401);
        }
    }

    public function getAllPages()
    {
        $pages = [];
        $draftPagePaths = $this->listDraftPagePaths();
        foreach ($draftPagePaths as $pagePath) {
            array_push($pages, [
                'path' => $pagePath,
                'page' => new Page($this->fs->read($pagePath))
            ]);
        }

        return $pages;
    }

    public function savePage($path, Page $page)
    {
        $this->loadMetadata();
        $this->markDraftDirty();
        $this->fs->update($path, (string)$page);
        $this->saveLastModified($path);
    }

    public function markDraftDirty()
    {
        if (!$this->fs->has($this->draftDirtyMarkerPath())) {
            $this->fs->write($this->draftDirtyMarkerPath(), '');
        }
    }

    public function saveLastModified($path)
    {
        $this->loadMetadata();

        $index = 0;

        $filePath = $path;

        if (strpos($path, $this->draftPath()) === 0) {
            $filePath = $this->stripDraftPath($path);
            $index = 1;
        }

        if (!isset($this->metadata['files'][$filePath])) {
            $this->metadata['files'][$filePath] = [];
        }

        $meta = $this->fs->getMetadata($path);

        $this->metadata['files'][$filePath][$index] = $meta['timestamp'];

        $this->writeMetadata();
    }

    public function updatePage($path, $pageDetails)
    {
        $path = $this->draftBaseUrl() . $path;
        if (!$this->fs->has($path)) {
            throw new FileNotFoundException([
                'type' => 'Source Page',
                'file' => $path
            ], 401);
        }

        $page = new Page($this->fs->read($path));

        $page->setPageTitle($pageDetails['title']);
        $page->setPageDescription($pageDetails['desc']);

        return $page;
    }

    public function updatePageFiles($pages, $pagesMetadata)
    {
        // Update page files
        foreach ($pages as $page) {
            $path = $this->draftBaseUrl() . $page['path'];

            if ($this->fs->has($path)) {
                $this->fs->update($path, (string)$page['page']);
            } else {
                $this->fs->write($path, (string)$page['page']);
            }
            // Update last modified time in metadata
            $this->saveLastModified($path);
        }

        // Save metadata
        $this->savePagesMetadata($pagesMetadata);
    }

    /**
     * Updates all menus in all pages with new menu content
     *
     * @param array $menuData      Menus metadata
     * @param array $pageUpdateMap Map of updated page paths where for updated paths keys are old paths and values are
     *                             new paths, and for deleted paths, keys are numeric
     *
     * @throws \Exception
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function updateMenus($menuData, $pageUpdateMap)
    {
        $this->loadMetadata();

        // We need only to update existing menus. If there is menu that doesn't exist, we do no action
        $sentMenus = [];
        foreach ($menuData as $no => $menu) {
            array_push($sentMenus, $menu['name']);
        }

        foreach ($this->metadata['menus'] as $name => &$menuMetadata) {
            if (!in_array($name, $sentMenus)) {
                continue;
            }
            $pages = [];
            foreach ($menuMetadata['pages'] as $no => $path) {
                // Check if path is changed or deleted
                if (array_key_exists($path, $pageUpdateMap)) {
                    $path = $pageUpdateMap[$path];
                } elseif (is_numeric(array_search($path, $pageUpdateMap))) {
                    continue;
                }

                array_push($pages, $path);

                $draftPath = $this->draftBaseUrl() . $path;

                $page = new Page($this->fs->read($draftPath));

                $menuNameSuffix = $name == Menu::DEFAULT_MENU_NAME ? ''
                    : '-' . $name;
                foreach ($page->query('.' . Menu::SC_MENU_BASE_CLASS . $menuNameSuffix) as $menuContainer) {
                    $menu = new Menu($menuContainer);

                    $menu->items(
                        array_values($menuData[array_search($name, $sentMenus)]['items']),
                        function ($item) use ($path) {
                            if ($item['type'] == Menu::ITEM_TYPE_PAGE) {
                                $item['url'] = $this->pathToUrl($item['reference'], $path);

                                return $item;
                            }

                            return $item;
                        }
                    );
                    $menuMetadata['items'] = $menu->items();

                    $page->findAndReplace(
                        Menu::SC_MENU_BASE_CLASS . ($name == 'main' ? '' : '-' . $name),
                        $menu->render(
                            $this->config['pages.nav.item_template'],
                            function ($url) use ($path) {
                                if (Utils::isExternalLink($url)
                                    || HtmlUtils::isAnchorLink($url)
                                ) {
                                    return false;
                                }

                                return $path == $this->urlToPath($url, $path);
                            },
                            $this->config['pages.nav.active_class']
                        )
                    );
                }

                $this->fs->update($draftPath, (string)$page);

                // Update last modified time in metadata
                $this->saveLastModified($draftPath);
            }
            $menuMetadata['pages'] = array_unique($pages);
        }
        $this->writeMetadata();
    }

    public function savePagesMetadata($pages)
    {
        $this->loadMetadata();
        $this->metadata['pages'] = $pages;
        $this->writeMetadata();
    }

    public function publishDraft()
    {
        if ($this->draftExists()) {
            $this->backup();

            // Get all draft pages with all draft files referenced in those pages
            $draftResources = $this->draftResources();
            // Get public resource paths so we can check if there are any public resources that should be deleted
            $publicResources = $this->listScPaths();

            foreach ($draftResources as $no => $file) {
                // Overwrite live file with draft only if draft actually exists
                if ($this->fs->has($file)) {
                    $publicPath = $this->stripDraftPath($file);
                    if ($this->fs->has($publicPath)) {
                        $this->fs->delete($publicPath);
                        array_splice($publicResources, array_search($publicPath, $publicResources), 1);
                    }
                    $this->fs->copy($file, $publicPath);
                }
            }

            if (!empty($publicResources)) {
                $this->fs->deletePaths($publicResources);
            }

            $this->cleanupPublic();
            $this->saveLastPublished();
            $this->markDraftClean();
        }
    }

    public function backup()
    {
        if ($this->config['site.number_of_backups'] < 1) {
            return;
        }
        $backupPath = $this->newBackupContainerPath();
        $this->fs->createDir($backupPath);
        $this->fs->createDir($backupPath . '/images');
        $this->fs->createDir($backupPath . '/files');
        $this->fs->copyPaths($this->listScPaths(), '', $backupPath);
        $this->cleanupBackup();
    }

    protected function newBackupContainerPath()
    {
        $path = $this->backupPath() . '/' . date('Y-m-d-H.i.s') . '-'
            . substr(uniqid(), -2);

        return $path;
    }

    /**
     * Returns the path of the backup directory.
     *
     * @return string the backup dir path
     */
    public function backupPath()
    {
        return $this->backup;
    }

    /**
     * Remove all backups except for the last recent five.
     */
    protected function cleanupBackup()
    {
        $backups = $this->fs->listContents($this->backupPath());
        usort($backups, function ($a, $b) {
            if ($a['timestamp'] < $b['timestamp']) {
                return -1;
            } elseif ($a['timestamp'] == $b['timestamp']) {
                return 0;
            } else {
                return 1;
            }
        });
        $backups = array_reverse($backups);
        foreach ($backups as $idx => $backup) {
            if ($idx >= $this->config['site.number_of_backups']) {
                $this->fs->deleteDir($backup['path']);
            }
        }
    }

    protected function cleanupPublic()
    {
        $this->loadPageFilePaths();
        $pagePaths = $this->listScPagesPaths();
        foreach ($pagePaths as $pagePath) {
            $page = new Page($this->fs->read($pagePath));

            if ($page->isEditable()) {
                // Remove dynamically added container names
                $page->cleanupContainerNames();
            }

            // Remove draft path prefix from resources and add relative prefix if page file or
            // webroot relative path prefix if include file
            // TODO: write comment why we are making difference here
            if ($this->isPageFile($pagePath)) {
                // For page files we need to add ../ to resource links if needed
                $page->unPrefixResourceUrls(
                    $this->draftBaseUrl(),
                    str_repeat('../', (count(explode('/', $pagePath)) - 1))
                );
            } else {
                $page->unPrefixResourceUrls($this->draftBaseUrl(), $this->getBase());
            }

            // Update source
            $this->fs->update($pagePath, (string)$page);

            // Update last modified time in metadata
            $this->saveLastModified($pagePath);
        }
    }

    public function saveLastPublished()
    {
        $this->loadMetadata();

        $this->metadata['lastPublished'] = time();

        $this->writeMetadata();
    }

    public function markDraftClean()
    {
        if ($this->fs->has($this->draftDirtyMarkerPath())) {
            $this->fs->delete($this->draftDirtyMarkerPath());
        }
    }

    public function newPage($sourcePage, $path)
    {
        $metadata = $this->loadMetadata();

        $sourcePath = '';
        foreach ($metadata['pages'] as $page => $details) {
            if ($details['id'] == $sourcePage['tid']) {
                $sourcePath = $page;
                break;
            }
        }

        $draftPath = $this->draftBaseUrl() . $sourcePath;

        if (empty($sourcePath) || !$this->fs->has($draftPath)) {
            throw new FileNotFoundException([
                'type'  => 'Source Page',
                'files' => $sourcePath
            ], 401);
        }

        $page = new Page($this->fs->read($draftPath));

        // Clear old container names
        $page->cleanupContainerNames();
        // Name unnamed containers
        $page->normalizeContainerNames();
        // Check for existing navigation in current page and store it if found
        if ($this->hasMenu($page)) {
            $this->processMenu($page, $path);
        }

        // Duplicate resources from unnamed containers
        $resources = $page->listResourceUrls(function ($container) use ($page) {
            return $page->isUnnamedContainer($container);
        });
        $sets = [];
        foreach ($resources as $resource) {
            /** @var array $resourceDetails */
            $resourceDetails = Utils::resourceUrlInfo($resource);
            if (array_key_exists($resourceDetails['id'], $sets)) {
                $id = $sets[$resourceDetails['id']];
            } else {
                $id = uniqid();
                $sets[$resourceDetails['id']] = $id;
            }
            $newPath = Utils::resourceUrl(
                $resourceDetails['path'],
                $resourceDetails['name'],
                $id,
                $resourceDetails['subid'],
                $resourceDetails['ext']
            );
            $this->fs->put($newPath, $this->fs->read($resource));
            $page->updateResourcePath($resource, $newPath);
        }

        $page->setPageTitle($sourcePage['title']);
        $page->setPageDescription($sourcePage['desc']);

        return $page;
    }

    public function deleteDraftPages($paths)
    {
        foreach ($paths as $path) {
            $path = $this->draftBaseUrl() . $path;
            $this->fs->delete($path);
        }
    }

    public function editSessionStart()
    {
    }

    protected function removeDraft()
    {
        $this->fs->deletePaths($this->listScPaths($this->draftPath()));
        $this->fs->delete($this->draftMarkerPath());
    }
}
