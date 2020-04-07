<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifyReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sponsored:return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify if the sponsored have return (1, 2 or 3) the fee until the time set';

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
        Log::info('Verify Returns command is running...');
        $todayIs = \App\Helpers\Dates::getNameDay(date('Y-m-d',strtotime('now')));
        $sponsored = [];
        if($todayIs == 'Miercoles'){
            $sponsored = \App\User::
            where('role','sponsored')
            ->where(function($query){
                $query->where('created_at',date('Y-m-d',strtotime('23 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('22 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('13 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('12 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('34 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('33 days ago',strtotime('now'))))
                ;
            })->orderBy('full_name','ASC')->get();
        }

        if($todayIs == 'Sabado'){
            $sponsored = \App\User::
            where('role','sponsored')
            ->where(function($query){
                $query->where('created_at',date('Y-m-d',strtotime('11 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('12 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('22 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('23 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('32 days ago',strtotime('now'))))
                ->orWhere('created_at',date('Y-m-d',strtotime('33 days ago',strtotime('now'))))
                ;
            })->orderBy('full_name','ASC')->get();
        }

        Log::info('Total users filtered: '.count($sponsored));
        foreach ($sponsored as $user) {
            if($user->isFirstReturnDay() && $user->state != 'return-1'){
                $user->state = 'not-return-1';
                $user->access = false;
                $user->disabledBranch();
                $user->save();
                Log::info('Sponsored : '.$user->full_name .' State: '.$user->state);
            }
            if($user->isSecondReturnDay() && $user->state != 'return-2'){
                $user->state = 'not-return-2';
                $user->access = false;
                $user->disabledBranch();
                $user->save();
                Log::info('Sponsored : '.$user->full_name .' State: '.$user->state);
            }
            if($user->isThirdReturnDay() && $user->state != 'return-3'){
                $user->state = 'not-return-3';
                $user->access = false;
                $user->disabledBranch();
                $user->save();
                Log::info('Sponsored : '.$user->full_name .' State: '.$user->state);
            }

            if($user->isThirdReturnDay() && $user->state == 'return-3'){
                $user->state = 'completed';
                $user->access = false;
                Log::info('Sponsored Completed: '.$user->full_name .' State: '.$user->state);
            }
        }
    }
}
