<?php

use Illuminate\Database\Seeder;

class BooksdetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Bookdetail::class, 50)->create();
    }
}
