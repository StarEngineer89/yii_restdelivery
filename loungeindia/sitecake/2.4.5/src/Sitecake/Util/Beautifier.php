<?php

namespace Sitecake\Util;

use Gajus\Dindent\Indenter;

class Beautifier extends Indenter
{
    const INDENT = "\t";

    const PATTERN_OPENING_TAG = '/<([^\s>\/]+)/';

    const PATTERN_CLOSING_TAG = '/<\/([^>]*)>/';

    public function __construct(array $options = [])
    {
        parent::__construct(['indentation_character' => self::INDENT] + $options);
    }

    public function indent($input, $prefixIndentation = '')
    {
        // Fix tags
        $output = $this->fixTags($input);

        // Indent
        $output = parent::indent($output);

        // Add prefix to all except first line if specified
        //if($prefixIndentation)
        //{
        $prefixed = '';
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            $prefixed .= $prefixIndentation . self::INDENT . $line . "\n";
        }

        return $prefixed;

        //}
    }

    protected function fixTags($input)
    {
        // Remove space before closing of opening tag
        $input = preg_replace_callback('/(<[^\/][^>]*)(\s>)/', function ($matches) {
            return $matches[1] . '>';
        }, $input);

        // Fix opening tags
        if (preg_match_all(self::PATTERN_OPENING_TAG, $input, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $match) {
                // Lowercase opening tags
                $input = str_replace($match, strtolower($match), $input);
            }
        }

        // Fix closing tags
        if (preg_match_all(self::PATTERN_CLOSING_TAG, $input, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $match) {
                // Lowercase closing tags
                $input = str_replace($match, strtolower($match), $input);
            }
        }

        return $input;
    }
}
