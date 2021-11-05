<?php

namespace EgeaTech\LaravelModels\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;

class ModelIdentifierCast implements CastsAttributes
{
    private string $identifierClass;
    private ?string $modelKey;

    public function __construct(string $identifierClass, ?string $customModelKey = null)
    {
        $this->identifierClass = $identifierClass;
        $this->modelKey = $customModelKey;
    }

    public function get($model, string $key, $value, array $attributes): ?IdentifierInterface
    {
        if (null !== $value) {
            $value = new $this->identifierClass($value);
        } elseif (
            $this->modelKey
            && array_key_exists((string) $this->modelKey, $attributes)
            && null !== $attributes[$this->modelKey]
        ) {
            $value = new $this->identifierClass($attributes[$this->modelKey]);
        }

        return $value;
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        $serializedValue = $value instanceof IdentifierInterface
            ? $value->getValue()
            : $value;

        $attributesToReturn = [$key => $serializedValue];

        if (
            $this->modelKey
            && array_key_exists((string) $this->modelKey, $attributes)
            && null !== $attributes[$this->modelKey]
        ) {
            $attributesToReturn[$this->modelKey] = $serializedValue;
        }

        return $attributesToReturn;
    }
}
