<?php

namespace EgeaTech\LaravelModels\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;

class ModelIdentifierCast implements CastsAttributes
{
    private string $identifierClass;

    public function __construct(string $identifierClass)
    {
        $this->identifierClass = $identifierClass;
    }

    public function get($model, string $key, $value, array $attributes): ?IdentifierInterface
    {
        return null === $value
            ? null
            : new $this->identifierClass($value);
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        $serializedValue = $value instanceof IdentifierInterface
            ? $value->getValue()
            : $value;

        return [$key => $serializedValue];
    }
}
