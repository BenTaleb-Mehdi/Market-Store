<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test regular user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'address' => '456 User Street, User City',
            'phone' => '+0987654321',
            'is_admin' => false,
        ]);
        
        $this->info("Regular user created: {$user->name} ({$user->email})");
        return 0;
    }
}
