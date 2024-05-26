<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

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
            'name' => 'Admin',
            'email' => 'super@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'verification_status' => 'Verified',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Jason Lee',
            'email' => 'instructor@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'verification_status' => 'Verified',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'instructor2@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'verification_status' => 'Verified',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \App\Models\User::factory(10)->create();

        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
        ]);
    }
}
