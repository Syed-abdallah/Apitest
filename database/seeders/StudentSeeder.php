<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Student;
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::Create();
        foreach (range(1,5) as $value) {
            Student::create([
            'name'=>$faker->name(),
            'city'=>$faker->city(),
            'fee'=>433.12,
            ]);

        }
    }
}
