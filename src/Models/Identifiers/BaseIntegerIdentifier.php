<?php

namespace EgeaTech\LaravelModels\Models\Identifiers;

use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IntegerIdentifierInterface;

abstract class BaseIntegerIdentifier extends BaseIdentifier implements IntegerIdentifierInterface
{
    public function getValue(): int
    {
        return $this->resourceId;
    }
}
