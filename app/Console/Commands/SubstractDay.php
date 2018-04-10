<?php

namespace App\Console\Commands;

use App\Organization;
use App\Mail\DaysExpiring;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SubstractDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:substractDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Substracts a day of each organization, this is meant to be run daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Organization::all()->chunk(100, function ($organizations) {
            foreach ($organizations as $organization) {
                if ($organization->remaining_days > 0) {
                    $organization->remaining_days -= 1;
                    $organization->save();
                    if ($organization->remaining_days == 10 ||
                        $organization->remaining_days == 5 ||
                        $organization->remaining_days == 1) {
                        Mail::to($organization->creator)->queue(new DaysExpiring($organization));
                    }
                }
            }
        });
    }
}
