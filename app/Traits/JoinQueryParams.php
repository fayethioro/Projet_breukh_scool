<?php

namespace  App\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait JoinQueryParams
{
    public function loadData(Model|QueryBuilder|EloquentBuilder|HasMany $query, ? array $relations=null):Model|QueryBuilder|EloquentBuilder|HasMany
    {

        $relations = $relations ?? $this->relationsAutorise ?? [] ;
        foreach ($relations as $relation) {
            $query->when(
                $this->hasJoin($relation),
                fn ($q) => $query instanceof Model ? $query->load($relation) : $q->with($relation)
            );
        }
        return $query;
    }


    public function getModelMethods(string $modelClass)
    {
        // Instanciation de la classe ReflectionClass pour le modèle spécifié
        $reflectionClass = new ReflectionClass($modelClass);

        // Récupération de toutes les méthodes du modèle
        $methods = $reflectionClass->getMethods();

        // Filtrer les méthodes pour ne garder que celles de la classe du modèle
        $filteredMethods = [];
        foreach ($methods as $method) {
            if (
                $method->class === $modelClass &&
                $method->name !== 'factory' &&
                $method->name !== 'newFactory'
            ) {
                $filteredMethods[] = $method->name;
            }
        }
        return $filteredMethods;
    }

    public function hasJoin($relation): bool
    {
        $join = request()->input('join');
        if (!$join) {
            return false;
        }
        $tabjoin = array_map('trim', explode(',', $join));
        return in_array($relation, $tabjoin);
    }



    // ...
}
