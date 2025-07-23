<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    
    protected $signature = 'users:list {role?} {id?}';

    
    protected $description = 'List User\'s Informations';


    public function handle()
    {
        $role = $this->argument('role');
        if ($role && !in_array($role, ['client', 'admin'])) {
            return $this->error("Invalid role. Allowed values are: client, admin.");
        }
        $id = $this->argument('id');
        $query = User::query();

        if($role && $id){
            $query->where(function ($q) use ($role , $id){
                $q->where('role',$role)->orWhere('id',$id);
            });
            $this->info("Filtering users where role = '$role' OR id = $id");
        }
        elseif($role){
            $query->where('role',$role);
            $this->info('Filtering Users Via Roles');
        }elseif($id){
            $query->where('id',$id);
            $this->info('Filtering Users Via ID');
        }

        $users = $query->get(['id','name','role','email','phone']);
        $this->table(
            ['id','name','email','role','phone'],
            $users->map(fn($user) => [$user->id, $user->name, $user->email, $user->role , $user->phone])->toArray()
        );
    }
}
