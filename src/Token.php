<?php

/*
 * This file is part of the Tmilos/Lexer package.
 *
 * (c) Milos Tomic <tmilos@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tmilos\Lexer;

class Token
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /** @var int */
    protected $offset;

    /** @var int */
    protected $position;

    /**
     * @param string $name
     * @param string $value
     * @param string $offset
     * @param string $count
     */
    public function __construct($name, $value, $offset, $count)
    {
        $this->name = $name;
        $this->value = $value;
        $this->offset = $offset;
        $this->position = $count;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function is($token)
    {
        if ($token instanceof self) {
            return $this->name === $token->getName();
        } elseif (is_string($token)) {
            return $this->name === $token;
        } else {
            throw new \InvalidArgumentException('Expected string or Token');
        }
    }
}
