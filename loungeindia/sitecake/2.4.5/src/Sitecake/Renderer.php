<?php
namespace Sitecake;

use Sitecake\Util\HtmlUtils;

class Renderer
{
    /**
     * @var array Options with paths
     */
    protected $options;

    /**
     * @var Site Reference to Site object
     */
    protected $site;

    public function __construct($_site, $options)
    {
        $this->site = $_site;
        $this->options = $options;
    }

    public function loginResponse()
    {
        return $this->injectLoginDialog($this->site->getDefaultPublicPage());
    }

    /**
     * @param Draft $draft
     *
     * @return mixed
     * @throws \Exception
     */
    protected function injectLoginDialog($draft)
    {
        $draft->appendCodeToHead($this->clientCodeLogin());

        $draft->adjustLinks($this->options['entry_point_file_name'], function ($url) {
            $path = $this->site->urlToPath($url, $this->site->getDefaultIndex());
            if (!$this->site->isPageFile($path)) {
                return false;
            }
            return $path;
        });

        return $draft->render();
    }

    protected function clientCodeLogin()
    {
        $globals = 'var sitecakeGlobals = {' .
                   "editMode: false, " .
                   'serverVersionId: "2.4.5", ' .
                   'phpVersion: "' . phpversion() . '@' . PHP_OS . '", ' .
                   'serviceUrl:"' . $this->options['SERVICE_URL'] . '", ' .
                   'configUrl:"' . $this->options['EDITOR_CONFIG_URL'] . '", ' .
                   'forceLoginDialog: true' .
                   '};';

        return HtmlUtils::wrapToScriptTag($globals) .
               HtmlUtils::scriptTag($this->options['EDITOR_LOGIN_URL'], [
                   'data-cfasync' => 'false'
               ]);
    }

    public function editResponse($page)
    {
        $this->site->startEdit();

        return $this->injectEditorCode($this->site->getDraft($page), $page, $this->site->isDraftClean());
    }

    /**
     * @param Draft $draft
     * @param string $page
     * @param bool $published
     *
     * @return mixed
     * @throws \Exception
     */
    protected function injectEditorCode($draft, $page, $published)
    {
        $draft->appendCodeToHead(HtmlUtils::css($this->options['PAGEMANAGER_CSS_URL']));
        $draft->appendCodeToHead($this->clientCodeEditor($published));
        $draft->appendCodeToHead(HtmlUtils::scriptTag($this->options['PAGEMANAGER_VENDORS_URL']));
        $draft->appendCodeToHead(HtmlUtils::scriptTag($this->options['PAGEMANAGER_JS_URL']));

        $draft->adjustLinks($this->options['entry_point_file_name'], function ($url) use ($page) {
            $path = $this->site->urlToPath($url, $page);
            if (!$this->site->isPageFile($path)) {
                return false;
            }
            return $path;
        });

        return $draft->render();
    }

    protected function clientCodeEditor($published)
    {
        $globals = 'var sitecakeGlobals = {' .
                   'editMode: true, ' .
                   'serverVersionId: "2.4.5", ' .
                   'phpVersion: "' . phpversion() . '@' . PHP_OS . '", ' .
                   'serviceUrl: "' . $this->options['SERVICE_URL'] . '", ' .
                   'configUrl: "' . $this->options['EDITOR_CONFIG_URL'] . '", ' .
                   'draftPublished: ' . ($published ? 'true' : 'false') . ', ' .
                   'entryPoint: "' . $this->options['entry_point_file_name'] . '",'  .
                   'indexPageName: "' . $this->site->getDefaultIndex() . '"' .
                   '};';

        return HtmlUtils::wrapToScriptTag($globals) .
               HtmlUtils::scriptTag($this->options['EDITOR_EDIT_URL'], [
                   'data-cfasync' => 'false'
               ]);
    }
}
