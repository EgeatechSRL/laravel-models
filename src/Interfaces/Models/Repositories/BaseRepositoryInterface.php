<?php

namespace EgeaTech\LaravelModels\Interfaces\Models\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use EgeaTech\LaravelModels\Interfaces\Models\Identifiers\IdentifierInterface;
use EgeaTech\LaravelRequests\Interfaces\Http\Requests\RequestData\ModelStoreDataInterface;
use EgeaTech\LaravelRequests\Interfaces\Http\Requests\RequestData\ModelUpdateDataInterface;

interface BaseRepositoryInterface
{
    /**
     * Retrieves the list of models in a paginated way
     *
     * @param array $filters
     * @param array $relationsToLoad
     * @param int $itemsPerPage
     * @param int $resultsPage
     * @return LengthAwarePaginator
     */
    public function index(array $filters = [], array $relationsToLoad = [], int $itemsPerPage = 15, int $resultsPage = 0): LengthAwarePaginator;

    /**
     * Retrieves all items matching given criteria
     *
     * @param array $filters
     * @param array $relationsToLoad
     * @return Collection
     */
    public function all(array $filters = [], array $relationsToLoad = []): Collection;

    /**
     * Fetches a single record from DB, given its identifier, optionally
     * loading additional relationships over it
     *
     * @param IdentifierInterface $modelId
     * @param array $relationsToLoad
     * @param bool $failIfNotFound
     * @return Model|null
     */
    public function find(IdentifierInterface $modelId, array $relationsToLoad = [], bool $failIfNotFound = false): ?Model;

    /**
     * Fetches the first record, given some filtering criteria
     *
     * @param array $filters
     * @param array $relationsToLoad
     * @param bool $failIfNotFound
     * @return Model|null
     */
    public function getFirstWhere(array $filters = [], array $relationsToLoad = [], bool $failIfNotFound = false): ?Model;

    /**
     * Fetches a single model from DB, given its identifier
     *
     * @param IdentifierInterface $modelId
     * @param bool $failIfNotFound
     * @return Model|null
     */
    public function show(IdentifierInterface $modelId, bool $failIfNotFound = false): ?Model;

    /**
     * Stores a new Model instance
     *
     * @param ModelStoreDataInterface $modelData
     * @return Model
     */
    public function store(ModelStoreDataInterface $modelData): Model;

    /**
     * Updates the Model identified by given identifier reference
     *
     * @param IdentifierInterface $modelId
     * @param ModelUpdateDataInterface $modelData
     * @return Model
     */
    public function update(IdentifierInterface $modelId, ModelUpdateDataInterface $modelData): Model;

    /**
     * Deletes a Model given its identifier
     *
     * @param IdentifierInterface $modelId
     * @return bool
     */
    public function destroy(IdentifierInterface $modelId): bool;
}
