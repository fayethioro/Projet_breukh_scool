<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

class ModelUtil
{

    
    
  
    
    public static function getModelRelations($model)
    {
        $relations = [];
    
        $modelInstance = new $model;
        $modelReflection = new ReflectionClass($modelInstance);
    
        $methods = $modelReflection->getMethods(ReflectionMethod::IS_PUBLIC);
    
        foreach ($methods as $method) {
            $methodName = $method->getName();
    
            $returnType = $method->getReturnType();
            if ($returnType && $returnType->getName() === Relation::class) {
                $relations[] = $methodName;
            }
        }
    
        return $relations;
    }
    
    
    
}
