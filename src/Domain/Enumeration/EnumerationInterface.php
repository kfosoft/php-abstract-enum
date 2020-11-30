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
     * @param string $value
     *
     * @return mixed
     */
    public static function from(string $value);

    /**
     * @return mixed
     */
    public function getValue();
}