<?php

namespace Tmilos\Lexer\Config;

interface LexerConfig
{
    /**
     * @return TokenDefn[]
     */
    public function getTokenDefinitions();
}
