<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'full_name' => 'Admin WMX',
            'email' => 'admin@wmx.com',
            'instagram' => 'wmx_admin',
            'own_referral_code' => 'WMX-ADMIN',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        // Create default package
        Package::create([
            'name' => 'Paket WMX Gaming',
            'price' => 200000,
            'regular_hours' => 7,
            'vip_hours' => 3,
            'coupon_count' => 1,
            'active_days' => 7,
            'is_active' => true,
        ]);

        // Create sample user for testing
        User::create([
            'full_name' => 'Test User',
            'email' => 'user@test.com',
            'instagram' => 'testuser',
            'own_referral_code' => User::generateReferralCode(),
            'password' => 'password',
            'role' => 'user',
        ]);
    }
}
