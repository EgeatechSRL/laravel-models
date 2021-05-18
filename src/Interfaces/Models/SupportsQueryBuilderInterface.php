<?php

namespace EgeaTech\LaravelModels\Interfaces\Models;

use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

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
