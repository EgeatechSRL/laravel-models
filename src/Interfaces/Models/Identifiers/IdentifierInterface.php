<?php

namespace EgeaTech\LaravelModels\Interfaces\Models\Identifiers;

interface IdentifierInterface
{
    /**
     * The actual value for Model primary key.
     *
     * @return int|string
     */
    public function getValue();

    /**
     * Utility method to check whether an instance IS the same as another.
     *
     * @param IdentifierInterface $otherResource
     * @return bool
     */
    public function is(self $otherResource): bool;

    /**
     * Utility method to check whether an instance IS NOT the same as another.
     *
     * @param IdentifierInterface $otherResource
     * @return bool
     */
    public function isNot(self $otherResource): bool;

    /**
     * Compulsory requiring implementation of the `__toString` method,
     * in order to avoid the need of explicitly calling the `getValue()`
     * method when dealing with those classes at database query level.
     *
     * @return string
     */
    public function __toString(): string;
}
