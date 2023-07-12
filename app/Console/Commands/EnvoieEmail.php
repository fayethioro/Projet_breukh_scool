<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Eleve;
use App\Models\Classe;
use App\Mail\EnvoieMail;
use App\Models\Evenement;
use App\Models\Inscription;
use App\Models\Participation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use App\Notifications\NotificationEvenement;

class EnvoieEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:envoie-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function handle()
    {


        $dateRappel = Carbon::now()->addDay(); // Date et heure actuelles + 24 heures


        $evenements = Evenement::where('date_evenement', '<=', $dateRappel)
            ->with('classes.inscriptions.eleve')
            ->pluck('id');
            $event = Evenement::where('date_evenement', '<=', $dateRappel)->first();


        $participation = Participation::where('evenement_id', '=', $evenements)->pluck('classe_id');

        $eleves = Inscription::whereIn('classe_id', $participation)
            ->pluck('eleve_id');

        foreach ($eleves as $eleve) {
            /** @var Eleve $ele */
            $ele = Eleve::where('id', $eleve)->first();
            $ele->notify(new  NotificationEvenement($event , $ele->prenom));
        }
    }
}
