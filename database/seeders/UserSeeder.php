<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([
            'email' => 'admin@admin.com',
        ],[
            'name' => 'Berat',
            'surname' => 'Kara',
            'password' => bcrypt('Laravel123!'),
            'phone_verification_code' => '123456',
            'email_verified_at' => Carbon::now(),
            'phone_verified_at' => Carbon::now(),
        ]);
    }
}
