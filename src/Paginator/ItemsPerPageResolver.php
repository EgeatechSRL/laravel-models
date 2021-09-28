<?php

namespace EgeaTech\LaravelModels\Paginator;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilderRequest;
use EgeaTech\LaravelModels\Interfaces\Paginator\ItemsPerPageResolverInterface;

class ItemsPerPageResolver implements ItemsPerPageResolverInterface
{
    private QueryBuilderRequest $request;

    private int $fallbackSize = 0;

    public function __construct(Request $request)
    {
        $this->request = QueryBuilderRequest::fromRequest($request);
    }

    public function getPageSize(?int $amount = null, bool $useDefinedFallback = false): int
    {
        // User-provided amount should "win" over
        // other input sources
        if (!is_null($amount) && $amount > 0) {
            return $amount;
        }

        // Request-inferred value should be the fallback
        if ($this->requestContainsPageSize()) {
            return $this->getRequestPageSize();
        }

        // Eventually, if no value was found,
        // fallback to the proper value
        return $useDefinedFallback
            ? $this->fallbackSize
            : (int) config('json-api-paginate.max_results');
    }

    public function setFallbackSize(int $fallbackSize): self
    {
        $this->fallbackSize = $fallbackSize;

        return $this;
    }

    private function getRequestPageSize(): int
    {
        $pageData = $this->request->get('page');
        $pageSizeFieldName = config('json-api-paginate.size_parameter');

        $pageSize = $pageData[$pageSizeFieldName] ?? 0;

        return (int) $pageSize;
    }

    private function requestContainsPageSize(): bool
    {
        return $this->getRequestPageSize() > 0;
    }
}
