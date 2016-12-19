<?php

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
        foreach ($tokenDefinitions as $k=>$v) {
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
