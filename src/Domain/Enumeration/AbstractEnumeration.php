<?php
namespace KFOSOFT\Domain\Enumeration;

use InvalidArgumentException;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use Serializable;

abstract class AbstractEnumeration implements EnumerationInterface, Serializable, JsonSerializable
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * Constructor.
     *
     * @param mixed $value
     * @throws ReflectionException
     */
    public function __construct($value)
    {
        if (null === static::getConstantName($value)) {
            throw new InvalidArgumentException(sprintf('The enumeration value "%s" did not match any constant in %s', $value, get_called_class()));
        }

        $this->value = $value;
    }

    /**
     * @return array|static[]
     * @throws ReflectionException
     */
    public static function all(): array
    {
        $values = [];
        foreach (static::getConstants() as $name => $value) {
            $values[] = new static($value);
        }

        return $values;
    }

    /**
     * @return array|string[]
     * @throws ReflectionException
     */
    public static function allValues(): array
    {
        $values = [];
        foreach (static::getConstants() as $name => $value) {
            $values[] = $value;
        }

        return $values;
    }

    /**
     * @param array $input
     *
     * @return array
     * @throws ReflectionException
     */
    public static function cast(array $input): array
    {
        $values = [];
        foreach ($input as $value) {
            $values[] = new static($value);
        }

        return $values;
    }

    /**
     * Create an enumeration object based on a constant name.
     *
     * @param string $name
     *
     * @return static
     * @throws ReflectionException
     */
    public static function fromName(string $name)
    {
        if (!defined('static::' . strtoupper($name))) {
            throw new InvalidArgumentException(sprintf('%s::%s was not defined', get_called_class(), strtoupper($name)));
        }

        return new static(constant('static::' . strtoupper($name)));
    }

    /**
     * Create an enumeration object based on a value of const name.
     *
     * @param string $value
     *
     * @return static
     * @throws ReflectionException
     */
    public static function from(string $value): self
    {
        return new static(self::getConstantName($value));
    }

    /**
     * @param $value
     *
     * @return bool
     * @throws ReflectionException
     */
    public static function valid($value): bool
    {
        try {
            self::getConstantName($value);
        } catch (InvalidArgumentException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     *
     * @return string
     * @throws ReflectionException
     */
    private static function getConstantName($value): string
    {
        $name = null;
        foreach (static::getConstants() as $constantName => $constantValue) {
            if ($value == $constantValue) {
                if (null !== $name) {
                    throw new InvalidArgumentException(sprintf('The enumeration value "%1$s" is ambiguous, it matches multiple constants: %2$s::%3$s and %2$s::%4$s', $value, get_called_class(), $name, $constantName));
                }

                $name = $constantName;
            }
        }

        if (null === $name) {
            throw new InvalidArgumentException(sprintf('Could not convert the value "%s" to a known %s', $value, get_called_class()));
        }

        return $name;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private static function getConstants(): array
    {
        $reflection = new ReflectionClass(get_called_class());

        return $reflection->getConstants();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getName(): string
    {
        return static::getConstantName($this->value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param array $values
     *
     * @return bool
     * @throws ReflectionException
     */
    public function in(array $values): bool
    {
        foreach ($values as $value) {
            if ($this->getValue() === (string) $value) {
                return true;
            }

            if (null === static::getConstantName($value)) {
                throw new InvalidArgumentException(sprintf('The enumeration value "%s" did not match any constant in %s', $value, get_called_class()));
            }
        }

        return false;
    }

    /**
     * @param $value
     *
     * @return bool
     * @throws ReflectionException
     */
    public function is($value): bool
    {
        if (is_array($value)) {
            throw new InvalidArgumentException(sprintf('You cannot pass an array to %1$s::is(), use %1$s::in() instead', get_called_class()));
        }

        if ($this->value === (string) $value) {
            return true;
        }

        if (null === static::getConstantName($value)) {
            throw new InvalidArgumentException(sprintf('The enumeration value "%s" did not match any constant in %s', $value, get_called_class()));
        }

        return false;
    }

    /**
     * @param $value
     *
     * @return bool
     * @throws ReflectionException
     */
    public function isNot($value): bool
    {
        if (is_array($value)) {
            throw new InvalidArgumentException(sprintf('You cannot pass an array to %1$s::isNot(), use %1$s::notIn() instead', get_called_class()));
        }

        return !$this->is($value);
    }

    /**
     * @param array $values
     *
     * @return bool
     * @throws ReflectionException
     */
    public function notIn(array $values): bool
    {
        return !$this->in($values);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     * @throws ReflectionException
     */
    public function unserialize($serialized)
    {
        if (null === static::getConstantName($serialized)) {
            throw new InvalidArgumentException(sprintf('The enumeration value "%s" did not match any constant in %s', $serialized, get_called_class()));
        }

        $this->value = $serialized;
    }
}

