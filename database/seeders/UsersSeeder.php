<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserProfile;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(
            [
                'uuid' => Str::uuid(),
                'name' => 'Administrator',
                'email' => 'admin@thk-hd.vn',
                'password' => 'admin',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'remember_token' => Str::random(10),
            ]
        );

        $user->profile()->save(UserProfile::factory()->make());
        // assign Administrator role
        $user->assignRole('Administrator');

        // Fake 100 users
        User::factory(100)->create()->each(function ($user) {
            $user->profile()->save(UserProfile::factory()->make());
            // assign Demo role
            $user->assignRole('Demo');
        });
    }
}
