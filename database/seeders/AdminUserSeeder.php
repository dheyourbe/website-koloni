<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user with specific credentials
        $admin = User::updateOrCreate(
            ['email' => 'admin@official.coloni'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@official.coloni',
                'no_wa' => '08123456789',
                'password' => 'password123',
                'points' => 0,
                'is_admin' => true,
            ]
        );
        
        // Create sample users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'no_wa' => '082345678901',
            'password' => 'password123',
            'points' => 0,
        ]);
        
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'no_wa' => '083456789012',
            'password' => 'password123',
            'points' => 0,
        ]);
        
        // Create sample products
        Product::create([
            'category' => 'minuman',
            'title' => 'Cappuccino',
            'description' => 'Kopi espresso dengan foam susu yang creamy dan lezat',
            'price' => 25000,
            'photo' => null,
        ]);
        
        Product::create([
            'category' => 'minuman',
            'title' => 'Latte',
            'description' => 'Perpaduan sempurna espresso dengan susu steamed yang smooth',
            'price' => 28000,
            'photo' => null,
        ]);
        
        Product::create([
            'category' => 'makanan',
            'title' => 'Croissant',
            'description' => 'Pastry Prancis yang renyah di luar dan lembut di dalam',
            'price' => 15000,
            'photo' => null,
        ]);
        
        Product::create([
            'category' => 'makanan',
            'title' => 'Sandwich Club',
            'description' => 'Sandwich dengan isian ayam, bacon, selada, dan tomat',
            'price' => 35000,
            'photo' => null,
        ]);
        
        Product::create([
            'category' => 'minuman',
            'title' => 'Americano',
            'description' => 'Espresso shot dengan air panas, kopi hitam yang kuat',
            'price' => 20000,
            'photo' => null,
        ]);
    }
}
