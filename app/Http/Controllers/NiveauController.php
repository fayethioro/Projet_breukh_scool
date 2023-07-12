<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClasseResource;
use App\Http\Resources\NiveauResource;
use App\Models\Niveau;
use App\Traits\JoinQueryParams;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NiveauController extends Controller
{
    use JoinQueryParams;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $join = request()->input('join');
        
        $collection = collect(["classes"]);
        
        if (!$collection->contains($join)) {
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   => Niveau::all()
            ];
        } 
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   => NiveauResource::collection($this->resolve(Niveau::class , $join))
            ];
        
    }

    public function find(Niveau $id)
    {
        $niveau= $id->load('classes');
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            'Niveau' => $niveau->libelle,
            'data'   => ClasseResource::collection($niveau->classes)
        ];
    }
    public function show(Niveau $niveau)
    {
        return $niveau;
    }
}
