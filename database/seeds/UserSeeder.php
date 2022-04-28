<?php

use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(DatabaseManager $manager, Hasher $hasher)
    {
        $userId = $manager->table('users')
            ->insertGetId([
                'name' => 'laravel user',
                'email' => 'mail@example.com',
                'password' => $hasher->make('password'),
                'created_at' => Carbon::now()->toDateTimeString()
            ]);

        $manager->table('user_tokens')
            ->insert([
                'user_id' => $userId,
                'api_token' => Str::random(60)
            ]);
    }
}
