<?php

namespace  App\Traits;

use App\Models\Niveau;
use Illuminate\Support\Facades\DB;


trait JoinQueryParams
{
    public function resolve($model , $relation)
    {
       return $model::with($relation)->get();
    }

    // ...
}
