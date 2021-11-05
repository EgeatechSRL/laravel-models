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
        return null === $value
            ? null
            : new $this->identifierClass($value);
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        $serializedValue = $value instanceof IdentifierInterface
            ? $value->getValue()
            : $value;

        $modelKey = ((string) $this->modelKey) ?? $key;

        return [$modelKey => $serializedValue];
    }
}
