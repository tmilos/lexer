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

interface LexerConfig
{
    /**
     * @return TokenDefn[]
     */
    public function getTokenDefinitions();
}
