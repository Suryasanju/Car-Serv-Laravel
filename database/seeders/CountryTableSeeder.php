<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'country_name' => 'India'
        ]);
        Country::create([
            'country_name' => 'Srilanka'
        ]);
        Country::create([
            'country_name' => 'Pakistan'
        ]);
        Country::create([
            'country_name' => 'China'
        ]);
        Country::create([
            'country_name' => 'Japan'
        ]);
        Country::create([
            'country_name' => 'Singapore'
        ]);
        Country::create([
            'country_name' => 'USA'
        ]);
    }
}
