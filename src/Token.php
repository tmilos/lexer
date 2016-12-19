<?php

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
}
