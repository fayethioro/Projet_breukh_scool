<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Eleve;
use App\Models\Evenement;
use App\Models\Inscription;
use App\Models\Participation;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserPutRequest;
use App\Http\Resources\EvenementResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        $user = new User();
        $user->nomComplet = $validatedData['nomComplet'];
        $user->role = $validatedData['role'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return [
            'statusCode' => Response::HTTP_CREATED,
            'message' => 'inscription reussi',
            'data'   => $user
        ];
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $user = User::findOrFail($user->id);

            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   =>  $user
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => "La ressource demandée n'a pas été trouvée.",
                'data'   =>  null
            ];
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UserPutRequest $request, User $user)
    {
        $request->validated();

        $user->update(
            $request->only('nomComplet')
        );

        return [
            'statusCode' => Response::HTTP_ACCEPTED,
            'message' => 'Mise à jour reussi',
            'data'   => $user
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            // L'utilisateur existe, supprimez-le
            $user->delete();
            return [
                'statusCode' => Response::HTTP_NO_CONTENT,
                'message' => 'suppression reussi',
                'data'   => $user
            ];
        } else {
            return redirect('http://127.0.0.1:8000/breukh-api/users');
        }
    }

    public function getEvenementByUser($userId)
    {
          $user = User::find($userId)->nomComplet;
          $evenement = Evenement::where('user_id' , $userId)->get();
          return [
            "statutCode" => Response::HTTP_OK,
            "message" => "Les evenements crées par {$user}",
            "evenements" => EvenementResource::collection($evenement)
          ];
    }
    public function getParticipationEleve($eleveId)
    {
        $eleve = Eleve::find($eleveId);
       $inscription = Inscription::where('eleve_id',$eleveId)->get()->pluck('classe_id');
       $classe= Participation::whereIn('classe_id' , $inscription)->get()->pluck('evenement_id');
    $evenement = Evenement::whereIn('id' , $classe)->get();

    return [
        "stautCode" => Response::HTTP_OK,
        "Message" => "les evenementsda que {$eleve->prenom} {$eleve->nom} a participé",
        "evenement" => $evenement
    ];
    }
}
