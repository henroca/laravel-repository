<?php

namespace App\Http\Repositories;

abstract class Base {
    protected $builder;
    protected $scopes;

    public function __construct()
    {
        $this->boot();
    }

    protected abstract function model();

    protected function boot()
    {
        $selfReflection = new \ReflectionObject($this);
        $this->scopes = [];

        foreach (get_class_methods($this) as $method) {
            if (preg_match('/^scope(.+)$/', $method, $matches)) {
                $scopeName = lcfirst($matches[1]);
                $scopeMethod = $selfReflection->getMethod($method)->getClosure($this)->bindTo(null);
                $this->scopes[$scopeName] = $scopeMethod;
            }
        }
    }

    protected function newQuery()
    {
        $model = $this->model();
        return new Builder(new $model, $this->scopes);
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this, 'scope' . ucfirst($method))) {
            return $this->newQuery()->callRepositoryScope($method, $parameters);
        }

        $className = get_class($this);

        throw new BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }
}
