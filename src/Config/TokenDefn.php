<?php

namespace Tmilos\Lexer\Config;

class TokenDefn
{
    /** @var string  */
    protected $name;

    /** @var string */
    protected $regex;

    /**
     * @param string $name
     * @param string $regex
     *
     * @param string $modifiers
     */
    public function __construct($name, $regex, $modifiers = 'i')
    {
        $this->name = $name;
        $delimiter = $this->findDelimiter($regex);
        $this->regex = sprintf('%s^%s%s%s', $delimiter, $regex, $delimiter, $modifiers);
        if (preg_match($this->regex, '') === false) {
            throw new \InvalidArgumentException(sprintf('Invalid regex for token %s : %s', $name, $regex));
        }
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $regex
     *
     * @return string
     */
    private function findDelimiter($regex)
    {
        static $choices = ['/', '|', '#', '~', '@'];
        foreach ($choices as $choice) {
            if (strpos($regex, $choice) === false) {
                return $choice;
            }
        }

        throw new \InvalidArgumentException(sprintf('Unable to determine delimiter for regex %s', $regex));
    }
}
