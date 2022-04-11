<?php

use App\Customer;
use App\Report;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Customer::class, 2)
            ->create()
            ->each(function ($customer) {
                factory(Report:: class, 2)
                    ->make()
                    ->each(function ($report) use ($customer) {
                        $customer->reports()->save($report);
                    });
            });
    }
}
