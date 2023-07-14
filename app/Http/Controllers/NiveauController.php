<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;
use App\Traits\JoinQueryParams;
use App\Http\Resources\ClasseResource;
use App\Http\Resources\NiveauResource;
use Symfony\Component\HttpFoundation\Response;

class NiveauController extends Controller
{
    use JoinQueryParams;
    /**
     * Display a listing of the resource.
     */
    protected  $relationsAutorise = ['classes', 'classes.inscriptions'];
    public function index()
    {

        $niveau = $this->loadData(Niveau::query());
        return NiveauResource::collection($niveau->get());
        // $modelClass = Niveau::class;
        // $collections = $this->getModelMethods($modelClass);
        // $collection = collect($collections);

        // $join = request()->input('join');

        // if (!$collection->contains($join)) {
        //     return [
        //         'statusCode' => Response::HTTP_OK,
        //         'message' => '',
        //         'data'   => Niveau::all()
        //     ];
        // }
        // return [
        //     'statusCode' => Response::HTTP_OK,
        //     'message' => '',
        //     'data'   => NiveauResource::collection($this->resolve(Niveau::class, $join))
        // ];
    }

    public function find(Niveau $id)
    {
        $niveau = $id->load($this->loadData(Niveau::query()));
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            'Niveau' => $niveau->libelle,
            'data'   => ClasseResource::collection($niveau->get())
        ];
    }
    public function show(Niveau $niveau)
    {
        return $niveau;
    }
    public function store(Request $request)
    {
        //  $validate = $request->validate([
        //     "libelle" =>"required|string",
        //  ]);
        //  Niveau::create([...$validate, 'etat' => 1]);

        $niveau = Niveau::create(
           $request->validate(["libelle" => "required|string",
           ])
        );

        return  new NiveauResource($this->loadData($niveau, ['classes.eleves']));
    }
}
