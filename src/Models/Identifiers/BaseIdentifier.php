<?php

namespace EgeaTech\LaravelModels\Models\Identifiers;

use Illuminate\Contracts\Database\Eloquent\Castable;
use EgeaTech\LaravelModels\Casts\ModelIdentifierCast;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IntegerIdentifierInterface;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\StringIdentifierInterface;
use Exception;
use Illuminate\Support\Str;

abstract class BaseIdentifier implements IdentifierInterface, Castable
{
    protected string $modelClass;

    protected $resourceId;

    public function __construct($resourceId)
    {
        $this->ensureValidIdentifier($resourceId);
        $this->setResourceId($resourceId);
    }

    /**
     * Whether current instance holds the same value of
     * another identifier.
     *
     * @param null|IdentifierInterface $otherResource
     * @return bool
     */
    public function is(?IdentifierInterface $otherResource): bool
    {
        if (null === $otherResource) {
            return false;
        }

        return $this->getValue() === $otherResource->getValue();
    }

    /**
     * Whether current instance value differs from another
     * value object instance.
     *
     * @param null|IdentifierInterface $otherResource
     * @return bool
     */
    public function isNot(?IdentifierInterface $otherResource): bool
    {
        return !$this->is($otherResource);
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new ModelIdentifierCast(static::class, ...$arguments);
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    protected function ensureValidIdentifier($identifier): bool
    {
        if (empty($identifier)) {
            throw new Exception("Invalid {$this->getResourceName()} identifier: cannot be empty");
        }

        if ($this instanceof IntegerIdentifierInterface) {
            if (!is_int($identifier)) {
                throw new Exception("Invalid {$this->getResourceName()} identifier: must be an integer");
            }
        }

        if ($this instanceof StringIdentifierInterface) {
            try {
                if (empty(strval($identifier))) {
                    throw new Exception();
                }
            } catch (Exception $exception) {
                // An exception is thrown also if `strval` is called
                // on data structures not implementing `__toString`
                throw new Exception("Invalid {$this->getResourceName()} identifier: must be a valid string");
            }
        }

        return true;
    }

    protected function getResourceName(): string
    {
        return (string) Str::of($this->modelClass)->afterLast('\\');
    }

    private function setResourceId($resourceId): void
    {
        if ($this instanceof StringIdentifierInterface) {
            $this->resourceId = (string) $resourceId;
        }

        if ($this instanceof IntegerIdentifierInterface) {
            $this->resourceId = (int) $resourceId;
        }
    }
}
