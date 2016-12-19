<?php

/*
 * This file is part of the Tmilos/Lexer package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tmilos\Lexer\Config;

class LexerArrayConfig implements LexerConfig
{
    /** @var TokenDefn[] */
    private $definitions = [];

    /**
     * @param TokenDefn[] $tokenDefinitions
     */
    public function __construct(array $tokenDefinitions)
    {
        foreach ($tokenDefinitions as $k => $v) {
            if ($v instanceof TokenDefn) {
                $this->addTokenDefinition($v);
            } elseif (is_string($k) && is_string($v)) {
                $this->addTokenDefinition(new TokenDefn($v, $k));
            }
        }
    }

    /**
     * @param TokenDefn $tokenDefn
     */
    public function addTokenDefinition(TokenDefn $tokenDefn)
    {
        $this->definitions[] = $tokenDefn;
    }

    public function getTokenDefinitions()
    {
        return $this->definitions;
    }
}
