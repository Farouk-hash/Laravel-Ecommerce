<?php

namespace App\Console\Commands;

use App\Events\UserSubcriber;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

class passing extends Command
{
    
    protected $signature = 'make:passing';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        

    }

}
