<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends EloquentBuilder
{
    private $repositoryScopes;

    public function __construct(Model $model, $scopes)
    {
        parent::__construct(app(QueryBuilder::class));

        $this->setModel($model);
        $this->repositoryScopes = $scopes;
    }

    public function callRepositoryScope(string $scope, $parameters = [])
    {
        return $this->callScope($this->repositoryScopes[$scope], $parameters);
    }

    public function setQuery($query)
    {
        if (is_a($query, EloquentBuilder::class)) {
            return parent::setQuery($query->getQuery());
        }

        return parent::setQuery($query);
    }

    public function __call($method, $parameters)
    {
        if (array_key_exists($method, $this->repositoryScopes)) {
            return $this->callRepositoryScope($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
