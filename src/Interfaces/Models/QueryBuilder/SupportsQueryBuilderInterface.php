<?php

namespace EgeaTech\LaravelModels\Interfaces\Models\QueryBuilder;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

interface SupportsQueryBuilderInterface
{
    public static function getDefaultSortingField(): string;

    /**
     * @return AllowedFilter[]
     */
    public static function getAllowedFilters(): array;

    /**
     * @return AllowedInclude[]
     */
    public static function getAllowedIncludes(): array;

    /**
     * @return AllowedSort[]
     */
    public static function getAllowedSorting(): array;

    /**
     * @return string[]
     */
    public static function getAllowedAppendAttributes(): array;
}
