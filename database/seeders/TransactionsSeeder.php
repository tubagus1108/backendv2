<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i < 1700; $i++)
        {
            Transaction::create([
                'invoice_num' => $faker->randomDigit,
                'rec_id' => $faker->randomDigit,
                'customer_rate' => '15000',
                'fee' => '70000',
                'bank_id' => $faker->randomDigit,
                'user_id' => $faker->randomDigit,
            ]);
        }
    }
}
