<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClasseResource;
use App\Http\Resources\NiveauResource;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $join = request()->input('join');

        $collection = collect(["classes"]);

        $data = Niveau::query()->when($collection->contains($join), function ($query) {
            return $query->with('classes');
        })->get();

        if (!$collection->contains($join)) {
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   => Niveau::all()
            ];
        } else {

            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   => NiveauResource::collection($data)
            ];
        }
    }
}
