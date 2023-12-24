<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory()->create([
            'name' => 'Alan',
            'email' => 'ferrerolan@icloud.com',
            'password' => bcrypt('123123'),
        ]);
        \App\Models\User::factory(10)->create();

        \App\Models\Property::factory(10)->create(
            [
                'slider' => true,
            ]
        );

        \App\Models\Property::factory(50)->create();

    }
}
