<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $bendaharaRole = Role::create(['name' => 'bendahara']);
        $ortuRole = Role::create(['name' => 'ortu']);
        
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'id_pertanyaan' => 5,
            'jawaban' => 'Bandung'
        ]);
        $admin->assignRole('admin');
        
        // Create bendahara user
        $bendahara = User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => Hash::make('bendahara123'),
            'id_pertanyaan' => 5,
            'jawaban' => 'Bandung'
        ]);
        $bendahara->assignRole('bendahara');
    }
}
