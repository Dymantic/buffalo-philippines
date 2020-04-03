<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make {attributes?*} {--regular}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a registered user';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $superadmin = !$this->option('regular');
        $attributes = $this->argument('attributes');
        $data = [
            'name'       => $attributes[0] ?? 'Joe Soap',
            'email'      => $attributes[1] ?? 'joe@example.com',
            'password'   => $attributes[2] ?? 'password',
            'superadmin' => $superadmin
        ];

        User::register($data);
    }
}
