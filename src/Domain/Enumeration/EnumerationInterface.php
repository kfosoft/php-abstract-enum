<?php

namespace KFOSOFT\Domain\Enumeration;

interface EnumerationInterface
{
    /**
     * @param string $name
     *
     * @return static
     */
    public static function fromName(string $name);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public static function from($value);

    /**
     * @return mixed
     */
    public function getValue();
}