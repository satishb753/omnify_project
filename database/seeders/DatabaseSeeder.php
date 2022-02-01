<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $url = "https://github.com/kennethllamasares/laravel-timezones/blob/master/resources/timezones.json";
        $timezonesJSON = file_get_contents($url);
        $timezones = json_decode($timezonesJSON);
    }
}
