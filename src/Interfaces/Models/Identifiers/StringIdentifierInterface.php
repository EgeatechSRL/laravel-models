<?php

namespace EgeaTech\LaravelModels\Interfaces\Models\Identifiers;

interface StringIdentifierInterface extends IdentifierInterface
{
    /**
     * Specific override of the main `getValue` method,
     * suitable for entities having a string primary key.
     *
     * @return string
     */
    public function getValue(): string;
}
