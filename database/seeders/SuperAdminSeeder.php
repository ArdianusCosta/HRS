<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@hrs.com'],
            ['name' => 'Admin', 'admin123' => bcrypt('admin123')]
        );
    
        $role = Role::firstOrCreate(['name' => 'super_admin']);
    
        $user->syncRoles([$role]);
    }
}
