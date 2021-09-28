<?php

namespace EgeaTech\LaravelModels\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Filters\FiltersPartial;

trait Queryable
{
    public static function getDefaultSortingField(): string
    {
        return static::fetchDisposableModelInstance()->getKeyName();
    }

    /**
     * @return AllowedFilter[]
     */
    public static function getAllowedFilters(): array
    {
        return collect(static::fetchDisposableModelInstance()->getFillable())
            ->map(fn (string $fillableField) => new AllowedFilter($fillableField, new FiltersPartial($fillableField)))
            ->toArray();
    }

    /**
     * @return string[]|AllowedInclude[]
     */
    public static function getAllowedIncludes(): array
    {
        return [];
    }

    /**
     * @return AllowedSort[]
     */
    public static function getAllowedSorting(): array
    {
        $modelInstance = static::fetchDisposableModelInstance();

        return $modelInstance->timestamps
            ? [AllowedSort::field($modelInstance->getUpdatedAtColumn())]
            : [AllowedSort::field($modelInstance->getKeyName())];
    }

    /**
     * @return string[]
     */
    public static function getAllowedAppendAttributes(): array
    {
        return [];
    }

    private static function fetchDisposableModelInstance(): Model
    {
        return new static();
    }
}
