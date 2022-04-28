<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(AuthorsTableSeeder::class);
        // $this->call(PublishersTableSeeder::class);
        // $this->call(BooksdetailsTableSeeder::class);
        $this->call([
            UserSeeder::class
        ]);
    }
}
