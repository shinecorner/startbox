<?php

use App\Models\Provider;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        factory(User::class, 10)->create();

        $admin = User::where('email', 'test@example.com')->first();
        if (!$admin) {
            User::create([
                'organization_id' => 1,
                'profileable_type' => Provider::class,
                'profileable_id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'StartBox',
                'email' => 'test@example.com',
                'password' => bcrypt('admin-123'),
                'token' => Str::random(20),
                'sso_id' => Str::random(20),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
