<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($columns, $search) {
            $this->where(function ($query) use ($columns, $search) {
                foreach (\Arr::wrap($columns) as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            });

            return $this;
        });

        Builder::macro('whenLimit', function ($limit) {
            return $this->limit($limit ?? null);
        });

        Builder::macro('whenOffset', function ($offset) {
            return $this->when($offset, function ($query, $offset) {
                $query->offset($offset);
            });
        });

        Builder::macro('whenOrderBy', function ($orderBys) {
            return $this->when($orderBys, function ($query, $orderBys) {
                foreach (\Arr::wrap($orderBys) as $orderBy) {
                    $column = Arr::get($orderBy, 'field') ?? null;
                    $sort = Arr::get($orderBy, 'type') ?? null;
                    ($column && $sort) ? $query->orderBy($column, $sort) : (($column) ? $query->orderBy($column) : $query);
                }
            });
        });
    }
}
