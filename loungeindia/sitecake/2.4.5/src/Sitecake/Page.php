<?php

namespace Sitecake;

use DOMDocumentWrapper;
use phpQuery;
use phpQueryObject;
use Sitecake\Exception\BadFormatException;
use Sitecake\Util\Beautifier;
use Sitecake\Util\HtmlUtils;
use Sitecake\Util\Utils;

class Page
{
    const SC_BASE_CLASS = 'sc-content';

    protected $source;

    protected $doc;

    protected $containers;

    protected $beautifier;

    public function __construct($html)
    {
        // Store page source
        $this->source = $html;
        // Initialize page Document
        $this->doc = $this->createPhpQueryDocSafe($html);
        // Initialize HTML beautifier
        $this->beautifier = new Beautifier();
    }

    protected function createPhpQueryDocSafe($html)
    {
        $wrapper = new DOMDocumentWrapper($html, null, md5(mt_rand() . mt_rand()));
        phpQuery::$documents[$wrapper->id] = $wrapper;
        phpQuery::selectDocument($wrapper->id);

        return new phpQueryObject($wrapper->id);
    }

    public function __toString()
    {
        return $this->source;
    }

    /**
     * Prefix all resource (images and files) urls
     *
     * @param string $prefix Prefix to strip
     * @param string $base
     *
     * @throws \Exception
     */
    public function prefixResourceUrls($prefix, $base = '')
    {
        foreach (phpQuery::pq('a, img', $this->doc) as $node) {
            $attributes = ['src', 'href', 'srcset'];

            foreach ($attributes as $attribute) {
                $value = $node->hasAttribute($attribute) ? $node->getAttribute($attribute) : false;
                if ($value) {
                    // Strip basedir prefix for resource urls
                    if (!empty($base)) {
                        HtmlUtils::unPrefixNodeAttribute($node, $attribute, $base, function ($url) {
                            return Utils::isScResourceUrl($url);
                        });
                    }

                    // Add passed prefix to resource urls
                    HtmlUtils::prefixNodeAttribute($node, $attribute, $prefix, function ($url) {
                        return Utils::isScResourceUrl($url);
                    });

                    $newValue = $node->getAttribute($attribute);

                    // Need to strip all '../' and duplicate / inside url
                    if (Utils::isScResourceUrl($newValue)) {
                        $newValue = str_replace(['../', './'], '', $newValue);
                        $newValue = str_replace(['//'], '/', $newValue);
                    }

                    if ($value != $newValue) {
                        $this->source = preg_replace(
                            '/' . preg_quote($attribute . '="' . $value . '"', '/') . '/',
                            $attribute . '="' . $newValue . '"',
                            $this->source,
                            1
                        );

                        $this->updateDoc();
                    }
                }
            }
        }
    }

    protected function updateDoc()
    {
        $this->doc->documentWrapper->load($this->source);
    }

    /**
     * Un prefix all resource (images and files) urls
     *
     * @param string $prefix Prefix to strip
     * @param string $base
     *
     * @throws \Exception
     */
    public function unPrefixResourceUrls($prefix, $base = '')
    {
        foreach (phpQuery::pq('a, img', $this->doc) as $node) {
            $attributes = ['src', 'href', 'srcset'];

            foreach ($attributes as $attribute) {
                $attributeValue = $node->hasAttribute($attribute) ? $node->getAttribute($attribute) : false;
                if ($attributeValue) {
                    // Strip passed prefix from resource urls
                    HtmlUtils::unPrefixNodeAttribute($node, $attribute, $prefix, function ($url) {
                        return Utils::isScResourceUrl($url);
                    });

                    $newValue = $node->getAttribute($attribute);

                    // Prepend $base if passed
                    if (!empty($base)) {
                        if (empty($newValue)) {
                            $newValue = $base;
                        } else {
                            // Add site root relative url prefix to resource urls
                            HtmlUtils::prefixNodeAttribute($node, $attribute, $base, function ($url) use ($base) {
                                return Utils::isScResourceUrl($url) && strpos($url, $base) !== 0;
                            });

                            $newValue = $node->getAttribute($attribute);
                        }
                    }

                    // Need to strip duplicate / inside url
                    if (Utils::isScResourceUrl($newValue)) {
                        $newValue = str_replace(['//'], '/', $newValue);
                    }

                    if ($attributeValue != $newValue) {
                        $this->source = preg_replace(
                            '/' . preg_quote($attribute . '="' . $attributeValue . '"', '/') . '/',
                            $attribute . '="' . $newValue . '"',
                            $this->source,
                            1
                        );

                        $this->updateDoc();
                    }
                }
            }
        }
    }

    public function listResourceUrls($filter = null)
    {
        $urls = [];
        foreach ($this->containerNodes() as $container) {
            if (is_callable($filter)) {
                if ($filter($container)) {
                    $urls = array_merge($urls, $this->listContainerResourceUrls($container));
                }
            } else {
                $urls = array_merge($urls, $this->listContainerResourceUrls($container));
            }
        }

        return $urls;
    }

    protected function containerNodes()
    {
        $containers = [];
        foreach (phpQuery::pq('[class*="' . self::SC_BASE_CLASS . '"]', $this->doc) as $node) {
            $container = phpQuery::pq($node, $this->doc);
            $class = $container->attr('class');
            if (preg_match('/(^|\s)' . preg_quote(self::SC_BASE_CLASS) . '(\-[^\s]+)*(\s|$)/', $class, $matches)) {
                array_push($containers, $container);
            }
        }

        return $containers;
    }

    /**
     * Returns resource URL's (files and images) for specified container
     *
     * @param string $container Container name
     *
     * @return array
     * @throws \Exception
     */
    protected function listContainerResourceUrls($container)
    {
        $urls = [];
        $html = (string)phpQuery::pq($container, $this->doc);
        preg_match_all(
            "/[^\\s\"',]*(?:files|images)\\/[^\\s]*\\-sc[0-9a-f]{13}[^\.]*\\.[0-9a-zA-Z]+/",
            $html,
            $matches
        );
        foreach ($matches[0] as $match) {
            if (Utils::isScResourceUrl($match)) {
                array_push($urls, urldecode($match));
            }
        }

        return $urls;
    }

    public function updateResourcePath($oldPath, $newPath)
    {
        $this->source = preg_replace(
            '/' . preg_quote($oldPath, '/') . '/',
            $newPath,
            $this->source
        );

        $this->updateDoc();
    }

    /**
     * Returns the page title (the title tag).
     * @return string the current value of the title tag
     * @throws \Exception
     */
    public function getPageTitle()
    {
        return phpQuery::pq('title', $this->doc)->html();
    }

    /**
     * Sets the page title (the title tag).
     *
     * @param string $val Title to be set
     *
     * @throws \Exception
     */
    public function setPageTitle($val)
    {
        if ($val === '') {
            // If empty value passed we need to remove title tag
            $this->source = preg_replace('/[ \t]*<title>(.*)<\/title>\s*/', '', $this->source);
        } else {
            $title = phpQuery::pq('title', $this->doc);
            if ($title->count() > 0) {
                $this->source = str_replace((string)$title, sprintf('<title>%s</title>', $val), $this->source);
            } else {
                if ($inserted = HtmlUtils::insertInto($this->source, 'head', sprintf('<title>%s</title>', $val))) {
                    $this->source = $inserted;
                }
            }
        }

        $this->updateDoc();
    }

    /**
     * Reads the page description meta tag.
     * @return string current description text
     * @throws \Exception
     */
    public function getPageDescription()
    {
        $text = '';
        $tag = phpQuery::pq('meta[name="description"]', $this->doc);
        if ($tag->count() > 0) {
            $text = phpQuery::pq($tag->elements[0])->attr('content');
        }

        return $text;
    }

    /**
     * Sets the page description meta tag with the given content.
     *
     * @param string $text Description to be set
     *
     * @throws \Exception
     */
    public function setPageDescription($text)
    {
        if ($text === '') {
            // If text is empty we need to remove meta description tag
            $this->source = preg_replace(
                '/[ \t]*<meta.+(name[^=]*=[^"\']*(\'|")description(\'|"))[^>]*>\s*/',
                '',
                $this->source
            );
        } else {
            $meta = sprintf('<meta name="description" content="%s">', $text);

            // Try to find and replace current meta description tag
            $metaDesc = phpQuery::pq('meta[name="description"]', $this->doc);
            if ($metaDesc->count() > 0) {
                $this->source = preg_replace(
                    '/<meta.+(name[^=]*=[^"\']*(\'|")description(\'|"))[^>]*>/',
                    $meta,
                    $this->source
                );
            } else {
                // Try to insert meta description tag into head
                if ($inserted = HtmlUtils::insertInto($this->source, 'head', $meta)) {
                    $this->source = $inserted;
                } else {
                    // No head tags present. Try to find title tag and insert meta description after it
                    if ($inserted = HtmlUtils::insertAfter($this->source, 'title', $meta)) {
                        $this->source = $inserted;
                    }
                }
            }
        }

        $this->updateDoc();
    }

    /**
     * Sets container content (beautified)
     *
     * @param string $containerName Container name
     * @param string $content Content to set into container
     *
     * @throws \Exception
     */
    public function setContainerContent($containerName, $content)
    {
        $this->findAndReplace(self::SC_BASE_CLASS . '-' . $containerName, $content);
    }

    public function findAndReplace($selector, $content)
    {
        foreach (phpQuery::pq('.' . $selector, $this->doc) as $no => $node) {
            $containerDetails = $this->containerDetails($selector, $no);
            $updated = $containerDetails['openingTag'] . "\n" .
                       $this->beautifier->indent($content, $containerDetails['whitespace']) .
                       $containerDetails['whitespace'];

            $this->source = mb_substr($this->source, 0, $containerDetails['positions'][0]) . $updated .
                            mb_substr($this->source, $containerDetails['positions'][1]);

            $this->updateDoc();
        }
    }

    /**
     * Returns details for specific container based on passed container name and it's position inside page.
     * Returned array ic containing next details :
     *      + whitespace - whitespace before specific container inside that row
     *      + openingTag - container opening tag
     *      + tagName - container's tag name
     *      + positions - start and end position of specific container inside the file
     *
     * @param string $selector Container selector
     * @param int $position Order number of appearance of specific container inside the file
     *                        (There can be more than one container with the same name)
     *
     * @return array
     */
    protected function containerDetails($selector, $position)
    {
        /*$found = Utils::match(
            '/([ \t]*)(<(?:"[^"]*"[\'"]*|\'[^\']*\'[\'"]*|[^\'">])+>)/',
            $this->source,
            $matches,
            PREG_OFFSET_CAPTURE
        );*/
        // To find tag name  ad brackets around \w+
        $found = Utils::match(
            '/([ \t]*)(<\/?\w+(?:(?:\s+\w+\s*(?:=\s*(?:".*?"|\'.*?\'|[\^\'">\s]+)?)?)+\s*|\s*)\/?>)/',
            $this->source,
            $matches,
            PREG_OFFSET_CAPTURE
        );
        $return = [];
        if (!empty($found) && !empty($matches[2])) {
            $positionCounter = 0;
            foreach ($matches[2] as $no => $element) {
                if (preg_match('/<([^\s]+).*("|\s)' . preg_quote($selector) . '(\s|"|\')[^>]*>/', $element[0], $m)) {
                    if ($positionCounter < $position) {
                        $positionCounter++;
                        continue;
                    }

                    $tag = $m[1];
                    $return['whitespace'] = $matches[1][$no][0];
                    $return['openingTag'] = $m[0];
                    $return['tagName'] = $tag;
                    $return['positions'] = [$element[1]];
                    $innerElementCount = 0;

                    for ($i = ($no + 1); $i < count($matches[2]); $i++) {
                        $el = $matches[2][$i];
                        if (preg_match('/<' . preg_quote($tag) . '/', $el[0])) {
                            $innerElementCount++;
                        }

                        if (preg_match('/<\/' . preg_quote($tag) . '>/', $el[0])) {
                            if ($innerElementCount) {
                                $innerElementCount--;
                            } else {
                                $return['positions'][] = $el[1];
                                break 2;
                            }
                        }
                    }

                    throw new BadFormatException([
                        'name' => $selector
                    ]);
                }
            }
        }

        return $return;
    }

    /**
     * Returns weather page is editable (does it contains .sc-content containers)
     * @return bool
     * @throws \Exception
     */
    public function isEditable()
    {
        return count($this->query('[class*="' . self::SC_BASE_CLASS . '"]')) > 0;
    }

    /**
     * Returns array of elements defined by passed selector
     *
     * @param string $selector
     *
     * @return phpQueryObject|false
     * @throws \Exception
     */
    public function query($selector)
    {
        return phpQuery::pq($selector, $this->doc);
    }

    /**
     * Turns all the unnamed containers (having just .sc-content class specified) in the page to named containers.
     * Method adds sc-content-<code>'-_cnt_' . mt_rand() . mt_rand()</code> class to each container that is not named
     * @throws \Exception
     */
    public function normalizeContainerNames()
    {
        $found = Utils::match(
            '/(?:\sclass\=\s*[\"\'])(.+?(?=\"|\').*?)(?:[\"\'])/',
            $this->source,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        if (!empty($found) && !empty($matches[1])) {
            $offset = 0;
            foreach ($matches[1] as $match) {
                if (preg_match('/(^|\s)' . preg_quote(self::SC_BASE_CLASS) . '($|\-|\s)/', $match[0]) &&
                    !preg_match('/(^|\s)' . preg_quote(self::SC_BASE_CLASS) . '\-[^\s]+($|\s)/', $match[0])
                ) {
                    $generatedClass = self::SC_BASE_CLASS . '-_cnt_' . mt_rand() . mt_rand();
                    $class = $match[0] . ' ' . $generatedClass;
                    $beforeClassString = mb_substr($this->source, 0, ($match[1] + $offset));
                    $afterClassPosition = mb_strlen($beforeClassString) + mb_strlen($match[0]);
                    $this->source = $beforeClassString . $class .
                                    mb_substr($this->source, $afterClassPosition);
                    $offset += mb_strlen(' ' . $generatedClass);
                }
            }

            $this->updateDoc();
        }
    }

    public function cleanupContainerNames()
    {
        foreach ($this->containerNodes() as $node) {
            $container = phpQuery::pq($node, $this->doc);
            $class = $container->attr('class');
            if (preg_match('/(^|\s)(' . preg_quote(self::SC_BASE_CLASS) . '\-_cnt_[0-9]+)/', $class, $matches)) {
                $this->source = preg_replace(
                    '/' . preg_quote($matches[0]) . '/',
                    '',
                    $this->source
                );

                $this->updateDoc();
            }
        }
    }

    /**
     * @param phpQueryObject $container
     *
     * @return bool
     */
    public function isUnnamedContainer($container)
    {
        $class = $container->attr('class');

        return (bool)preg_match('/(^|\s)(' . preg_quote(self::SC_BASE_CLASS) . '\-_cnt_[0-9]+)($|\s)/', $class);
    }

    /**
     * Returns a list of container names.
     *
     * @return array a list of container names
     */
    public function containers()
    {
        if (!$this->containers) {
            $this->containers = [];
            foreach ($this->containerNodes() as $container) {
                preg_match(
                    '/(^|\s)' . preg_quote(self::SC_BASE_CLASS) . '-([^\s]+)/',
                    $container->attr('class'),
                    $matches
                );
                if (isset($matches[2])) {
                    if (array_search($matches[2], $this->containers) === false) {
                        array_push($this->containers, $matches[2]);
                    }
                }
            }
        }

        return $this->containers;
    }

    protected function evaluate($content)
    {
        ob_start();
        eval('?>' . $content);
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}
