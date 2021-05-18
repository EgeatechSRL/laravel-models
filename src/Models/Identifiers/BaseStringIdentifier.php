<?php

namespace EgeaTech\LaravelModels\Models\Identifiers;

use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\StringIdentifierInterface;

abstract class BaseStringIdentifier extends BaseIdentifier implements StringIdentifierInterface
{
    public function getValue(): string
    {
        return $this->resourceId;
    }
}
