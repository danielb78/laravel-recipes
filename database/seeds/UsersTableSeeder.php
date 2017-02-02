<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            User::create([
                'facebook_id' => $faker->creditCardNumber,
                'name'        => $faker->name,
                'email'       => $faker->email,
                'password'    => bcrypt('clever'),
            ]);
        }
    }
}
