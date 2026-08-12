<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create
        {--name= : Ime administratora}
        {--email= : Email administratora}
        {--password= : Lozinka od najmanje 12 znakova}';

    protected $description = 'Kreira administratora za IANUBIH CMS';

    public function handle(): int
    {
        $data = [
            'name' => $this->option('name') ?: $this->ask('Ime administratora'),
            'email' => $this->option('email') ?: $this->ask('Email'),
            'password' => $this->option('password') ?: $this->secret('Lozinka (najmanje 12 znakova)'),
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $data['role'] = User::query()->exists()
            ? User::ROLE_ADMIN
            : User::ROLE_SUPER_ADMIN;

        User::create($data);
        $this->info($data['role'] === User::ROLE_SUPER_ADMIN
            ? 'Glavni administrator je uspješno kreiran.'
            : 'Administrator je uspješno kreiran.');

        return self::SUCCESS;
    }
}
