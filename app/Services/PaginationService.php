<?php

namespace App\Services;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquenBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationService
{
    /** @var EloquenBuilder|QueryBuilder $builder */
    protected $builder;

    protected array $searchables;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function setSearchables(array $searchables): self
    {
        $this->searchables = $searchables;

        return $this;
    }

    public function build(): LengthAwarePaginator
    {
        $builder = $this->builder;

        if (request()->filled('search')) {
            $builder->where(function ($query) {
                foreach ($this->searchables as $searchable) {
                    $query->orWhere($searchable, 'LIKE', '%' . request('search') . '%');
                }
            });
        }

        if (request()->filled('sort')) {
            $builder->orderBy(request('sort'), request('direction', 'asc'));
        } else {
            $builder->latest('id');
        }

        /** @var LengthAwarePaginator $paginator */
        $paginator = $builder->paginate(request('per_page'));

        return $paginator->withQueryString();
    }

    public static function make($builder): self
    {
        return new static($builder);
    }
}
