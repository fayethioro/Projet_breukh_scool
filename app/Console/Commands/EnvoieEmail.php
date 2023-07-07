<?php

namespace App\Console\Commands;

use App\Mail\EnvoieMail;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Mail;

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
        Mail::to('destinataire@example.com')->send(new EnvoieMail);
        $this->info('E-mail est envoyée');
    }
}
