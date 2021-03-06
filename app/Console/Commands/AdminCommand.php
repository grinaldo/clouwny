<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:new-admin {username} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new super admin.';

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
        $username = $this->argument('username');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $admin_class = \Config::get('auth.providers.users.model');
        $admin = new $admin_class();
        $admin->username = $username;
        $admin->email = $email;
        $admin->name = 'Super Admin';
        $admin->password = \Hash::make($password);
        $admin->active = true;
        $admin->role = $admin::ROLE_SUPER_ADMIN;

        if ($admin->save()) {
            $this->info('New Admin has been successfully created!!');
        } else {
            $this->error('Failed to create new admin.');
        }
    }
}
