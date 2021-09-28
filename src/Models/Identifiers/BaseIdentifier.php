<?php

namespace EgeaTech\LaravelModels\Models\Identifiers;

use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IntegerIdentifierInterface;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\StringIdentifierInterface;
use Exception;
use Illuminate\Support\Str;

abstract class BaseIdentifier implements IdentifierInterface
{
    protected string $modelClass;

    protected $resourceId;

    public function __construct($resourceId)
    {
        $this->ensureValidIdentifier($resourceId);
        $this->setResourceId($resourceId);
    }

    public function is(IdentifierInterface $otherResource): bool
    {
        return $this->getValue() === $otherResource->getValue();
    }

    public function isNot(IdentifierInterface $otherResource): bool
    {
        return !$this->is($otherResource);
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
