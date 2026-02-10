<?php

namespace App\Enum;

class ProductCondition
{
    public const NEW = 'new';
    public const GOOD = 'good';
    public const FAIR = 'fair';

    private $value;

    private static $validValues = [
        self::NEW,
        self::GOOD,
        self::FAIR
    ];

    private function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid condition "%s". Must be one of: %s', $value, implode(', ', self::$validValues))
            );
        }
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function getValidValues(): array
    {
        return self::$validValues;
    }

    public static function isValid(?string $value): bool
    {
        return $value !== null && in_array($value, self::$validValues, true);
    }
}
