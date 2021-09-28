<?php

namespace EgeaTech\LaravelModels\Models\Repositories;


use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;
use EgeaTech\LaravelModels\Interfaces\Models\Repositories\BaseRepositoryInterface;
use EgeaTech\LaravelModels\Interfaces\Models\QueryBuilder\SupportsQueryBuilderInterface;
use EgeaTech\LaravelRequests\Interfaces\Http\Requests\RequestData\ModelStoreDataInterface;
use EgeaTech\LaravelRequests\Interfaces\Http\Requests\RequestData\ModelUpdateDataInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model|SupportsQueryBuilderInterface
     */
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(array $filters = [], array $relationsToLoad = [], int $itemsPerPage = 15, int $resultsPage = 0): LengthAwarePaginator
    {
        return $this->model instanceof SupportsQueryBuilderInterface
            ? $this->getRecordsViaAdvancedQueryBuilder($filters)
            : $this->getRecordsViaModelQuery($filters, $relationsToLoad);
    }

    public function allWhere(array $filters = [], array $relationsToLoad = []): Collection
    {
        return $this
            ->getIndexQueryViaModel($filters, $relationsToLoad)
            ->get();
    }

    public function find(IdentifierInterface $modelId, array $relationsToLoad = [], bool $failIfNotFound = false): ?Model
    {
        try {
            $cleanModelInstance = new $this->model();
            $modelQuery = $cleanModelInstance->with($relationsToLoad);

            return $failIfNotFound
                ? $modelQuery->findOrFail($modelId)
                : $modelQuery->find($modelId);
        } catch (QueryException $exception) {
            throw (new ModelNotFoundException())
                ->setModel(get_class($this->model), $modelId->getValue());
        }
    }

    public function findManyByIds(array $modelIds, array $relationsToLoad = [], bool $failIfNotFound = false): Collection
    {
        try {
            $cleanModelInstance = new $this->model();
            $modelQuery = $cleanModelInstance->with($relationsToLoad);

            $results = $modelQuery->findMany($modelIds);
            if ($failIfNotFound && $results->count() > 0) {
                throw (new ModelNotFoundException());
            } else {
                return $results;
            }
        } catch (QueryException $exception) {
            throw (new ModelNotFoundException());
        }
    }

    public function getFirstWhere(array $filters = [], array $relationsToLoad = [], bool $failIfNotFound = false): ?Model
    {
        $cleanModelInstance = new $this->model();
        $query = $cleanModelInstance
            ->with($relationsToLoad)
            ->where($filters);

        return $failIfNotFound
            ? $query->firstOrFail()
            : $query->first();
    }

    public function show(IdentifierInterface $modelId, bool $failIfNotFound = false): ?Model
    {
        try {
            return $this->model instanceof SupportsQueryBuilderInterface
                ? $this->findRecordViaAdvancedQueryBuilder($modelId, $failIfNotFound)
                : $this->find($modelId, [], $failIfNotFound);
        } catch (QueryException $exception) {
            throw (new ModelNotFoundException())
                ->setModel(get_class($this->model), $modelId->getValue());
        }
    }

    public function store(ModelStoreDataInterface $modelData): Model
    {
        $cleanModelInstance = new $this->model();
        $modelInstance = $cleanModelInstance->fill($modelData->getData());
        $modelInstance->save();

        return $modelInstance;
    }

    public function update(IdentifierInterface $modelId, ModelUpdateDataInterface $modelData): Model
    {
        $modelInstance = $this->find($modelId, [], true);

        if ($modelInstance) {
            $modelInstance->fill($modelData->getData());
        }

        $modelInstance->save();

        return $modelInstance;
    }

    public function destroy(IdentifierInterface $modelId): bool
    {
        return $this->find($modelId, [], true)->delete();
    }

    /**
     * Defines the query being executed when fetching
     * group of records using the enhanced query
     * builder
     *
     * @param array $additionalFilters
     * @return QueryBuilder
     */
    protected function getAdvancedIndexQuery(array $additionalFilters): QueryBuilder
    {
        return QueryBuilder::for($this->model)
            ->allowedFilters($this->model::getAllowedFilters())
            ->allowedIncludes($this->model::getAllowedIncludes())
            ->defaultSort($this->model::getDefaultSortingField())
            ->allowedSorts($this->model::getAllowedSorting())
            ->allowedAppends($this->model::getAllowedAppendAttributes())
            ->where($additionalFilters);
    }

    /**
     * Method to be used when fetching a set of models which
     * implement `SupportsQueryBuilderInterface`.
     * The querying process will be done through Spatie's
     * QueryBuilder library.
     *
     * @param array $additionalFilters
     * @return LengthAwarePaginator
     */
    private function getRecordsViaAdvancedQueryBuilder(array $additionalFilters = []): LengthAwarePaginator
    {
        return $this
            ->getAdvancedIndexQuery($additionalFilters)
            ->jsonPaginate()
            ->appends(request()->query());
    }

    /**
     * Method to be used when fetching a model which
     * implements `SupportsQueryBuilderInterface`.
     * The querying process will be done through Spatie's
     * QueryBuilder library.
     *
     * @param IdentifierInterface $modelId
     * @param bool $failIfNotFound
     * @return null|Model
     */
    private function findRecordViaAdvancedQueryBuilder(IdentifierInterface $modelId, bool $failIfNotFound = false): ?Model
    {
        $query = QueryBuilder::for($this->model)
            ->allowedFilters($this->model::getAllowedFilters())
            ->allowedIncludes($this->model::getAllowedIncludes())
            ->defaultSort($this->model::getDefaultSortingField())
            ->allowedSorts($this->model::getAllowedSorting())
            ->allowedAppends($this->model::getAllowedAppendAttributes());

        return $failIfNotFound
            ? $query->findOrFail($modelId)
            : $query->find($modelId);
    }

    /**
     * Defines the base query being executed when
     * retrieving a group of records in the standard
     * Laravel way
     *
     * @param array $filters
     * @param array $relationsToLoad
     * @return Builder
     */
    protected function getIndexQueryViaModel(array $filters = [], array $relationsToLoad = []): Builder
    {
        return $this->model
            ->with($relationsToLoad)
            ->where($filters);
    }

    /**
     * Simple method to fetch Model records in a paginated
     * form
     *
     * @param array $filters
     * @param array $relationsToLoad
     * @return LengthAwarePaginator
     */
    private function getRecordsViaModelQuery(array $filters = [], array $relationsToLoad = []): LengthAwarePaginator
    {
        return $this
            ->getIndexQueryViaModel($filters, $relationsToLoad)
            ->jsonPaginate();
    }
}
