<?php

namespace EgeaTech\LaravelModels\Interfaces\Paginator;

interface ItemsPerPageResolverInterface
{
    /**
     * Retrieves the right amount of items to be fetched
     * in a paginated-query context.
     * The second parameter, if `true`, will lead to loading
     * the fallback value set through `setFallbackSize`.
     *
     * @param null|int $amount
     * @param bool $useDefinedFallback
     * @return int
     */
    public function getPageSize(?int $amount = null, bool $useDefinedFallback = false): int;

    /**
     * Sets a fallback value, usually defined by
     * the instance of the Model being queried.
     *
     * @param int $fallbackSize
     * @return $this
     */
    public function setFallbackSize(int $fallbackSize): self;
}
