<?php

namespace Tests\Tmilos\Lexer;

use Tmilos\Lexer\Config\LexerArrayConfig;
use Tmilos\Lexer\Lexer;
use Tmilos\Lexer\Token;

class LexerTest extends \PHPUnit_Framework_TestCase
{
    public function test_static_scan_algebra()
    {
        $config = $this->getAlgebraConfig();

        $tokens = Lexer::scan($config, '2 +3 /4 -1 ');
        $this->assertEquals(
            ['number', 'plus', 'number', 'div', 'number', 'minus', 'number'],
            array_map(function (Token $t) { return $t->getName(); }, $tokens)
        );
        $this->assertEquals(
            ['2', '+', '3', '/', '4', '-', '1'],
            array_map(function (Token $t) { return $t->getValue(); }, $tokens)
        );
    }

    public function test_move_next()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');

        $this->assertNull($lexer->getLookahead());
        $this->assertNull($lexer->getToken());

        $this->assertTrue($lexer->moveNext());

        $this->assertInstanceOf(Token::class, $lexer->getLookahead());
        $this->assertEquals('number', $lexer->getLookahead()->getName());
        $this->assertEquals('2', $lexer->getLookahead()->getValue());

        $this->assertNull($lexer->getToken());

        $this->assertTrue($lexer->moveNext());

        $this->assertInstanceOf(Token::class, $lexer->getLookahead());
        $this->assertEquals('plus', $lexer->getLookahead()->getName());
        $this->assertEquals('+', $lexer->getLookahead()->getValue());

        $this->assertInstanceOf(Token::class, $lexer->getToken());
        $this->assertEquals('number', $lexer->getToken()->getName());
        $this->assertEquals('2', $lexer->getToken()->getValue());

        $this->assertTrue($lexer->moveNext());
        $this->assertTrue($lexer->moveNext());
        $this->assertTrue($lexer->moveNext());
        $this->assertTrue($lexer->moveNext());
        $this->assertTrue($lexer->moveNext());

        $this->assertInstanceOf(Token::class, $lexer->getLookahead());
        $this->assertEquals('number', $lexer->getLookahead()->getName());
        $this->assertEquals('1', $lexer->getLookahead()->getValue());

        $this->assertInstanceOf(Token::class, $lexer->getToken());
        $this->assertEquals('minus', $lexer->getToken()->getName());
        $this->assertEquals('-', $lexer->getToken()->getValue());

        $this->assertFalse($lexer->moveNext());

        $this->assertNull($lexer->getLookahead());

        $this->assertInstanceOf(Token::class, $lexer->getToken());
        $this->assertEquals('number', $lexer->getToken()->getName());
        $this->assertEquals('1', $lexer->getToken()->getValue());

        $this->assertFalse($lexer->moveNext());
        $this->assertNull($lexer->getToken());
        $this->assertNull($lexer->getLookahead());
    }

    public function test_peek()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');

        $lexer->moveNext();
        $lexer->moveNext();

        $token = $lexer->peek();
        $this->assertEquals('3', $token->getValue());

        $token = $lexer->peek();
        $this->assertEquals('/', $token->getValue());

        $lexer->moveNext();
        $token = $lexer->peek();
        $this->assertEquals('/', $token->getValue());

        $lexer->resetPeek();
        $token = $lexer->peek();
        $this->assertEquals('/', $token->getValue());
    }

    public function test_skip_until()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');
        $lexer->moveNext();

        $lexer->skipUntil('minus');

        $this->assertEquals('minus', $lexer->getLookahead()->getName());
        $this->assertEquals('4', $lexer->getToken()->getValue());
    }

    public function test_is_next_token()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');

        $this->assertFalse($lexer->isNextToken('number'));
        $lexer->moveNext();
        $this->assertTrue($lexer->isNextToken('number'));
        $lexer->moveNext();
        $this->assertTrue($lexer->isNextTokenAny(['minus', 'plus']));
    }

    public function test_reset_position()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');
        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();

        $lexer->resetPosition();
        $lexer->moveNext();

        $this->assertEquals('2', $lexer->getLookahead()->getValue());
    }

    public function test_glimpse()
    {
        $lexer = new Lexer($this->getAlgebraConfig());
        $lexer->setInput('2 +3 /4 -1 ');

        $lexer->moveNext();

        $this->assertEquals('+', $lexer->glimpse()->getValue());
        $this->assertEquals('+', $lexer->glimpse()->getValue());
        $this->assertEquals('+', $lexer->glimpse()->getValue());
    }

    private function getAlgebraConfig()
    {
        return new LexerArrayConfig([
            '\\s' => '',
            '\\d+' => 'number',
            '\\+' => 'plus',
            '-' => 'minus',
            '\\*' => 'mul',
            '/' => 'div',
        ]);
    }
}
