<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $admin = User::create([
            'name' => 'Soumyadip Bhattacharya',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
        ]);

        $admin->assignRole('admin');
    }
}
