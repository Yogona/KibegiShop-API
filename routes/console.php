<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('db:reboot', function(){
    echo "Rolling back all tables...";
    Artisan::call('migrate:reset');
    echo "\nDone!";
    echo "\nMigrating tables...";
    Artisan::call('migrate');
    echo "\nDone!";
    echo "\nSeeding roles...";
    Artisan::call('db:seed --class=RoleSeeder');
    echo "\nDone!";
})->purpose('Reseting database, rebuild and reseed.');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
