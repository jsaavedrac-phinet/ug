<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifyRegisters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sponsored:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify if the sponsored have payed the fee until the time set';

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
        Log::info('Verify Registers command is running...');
        $sponsored = \App\User::
        where('role','sponsored')
        ->where(function($query){
            $query->where('created_at',date('Y-m-d',strtotime('1 day ago',strtotime('now'))))
            ->orWhere('created_at',date('Y-m-d',strtotime(strtotime('now'))));
        })->orderBy('full_name','ASC')->get();
        Log::info('Total users filtered: '.count($sponsored));
        foreach ($sponsored as $user) {
            if($user->state != 'payed'){
                $user->state = 'not-payed';
                $user->access = false;
                Log::info('Sponsored : '.$user->full_name .' State: '.$user->state);
            }
        }

    }
}
