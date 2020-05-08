<?php

namespace App\Console\Command;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email=admin@example.com} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a default superadmin user';

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
        $email = $this->argument('email');
        $password = $this->argument('password');
        $hashedPassword = Hash::make($password);

        $this->line("Creating superadmin with email - '$email' and password - '$password'");
        $this->line("User role and password will be updated if this user already exists");

        Model::unguard();

        $user = User::firstOrNew([
            'email' =>  $email
        ],
        [
            'password'  => $hashedPassword,
            'admin_role'  =>  'superadmin'
        ]);
        $user->save();

        Model::reguard();

        if($user)
        {
            $this->comment('user created successfully!');
        } else {
            $this->error('user not created successfully');
        }
    }
}
