<?php

declare(strict_types=1);

namespace App\Http\Integrations\BackendConnector\Requests\Brewery;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

final class ListBreweries extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        protected ?array $filters,
        protected int $page = 1,
        protected int $perPage = 10,
        protected ?string $sort = null,
        protected ?string $sortDirection = null
    ) {
    }

    /**
     * The default body for the request
     */
    protected function defaultBody(): array
    {
        $body = [
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];

        if ($this->sort) {
            $body['sort'] = $this->sort;
        }
        if ($this->sortDirection) {
            $body['sort_direction'] = $this->sortDirection;
        }

        $body = array_merge($body, $this->filters);

        return $body;
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/breweries/index';
    }

}
