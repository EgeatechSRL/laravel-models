<?php


namespace EgeaTech\LaravelModels\Interfaces\Models\Identifiers;


interface IntegerIdentifierInterface extends IdentifierInterface
{
    /**
     * Specific override of the main `getValue` method,
     * suitable for entities having an autoincrement primary key
     *
     * @return int
     */
    public function getValue(): int;
}
