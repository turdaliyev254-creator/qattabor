<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "🌱 Starting database seeding...\n\n";

        // Seed Regions and Locations
        echo "📍 Seeding regions and locations...\n";
        $this->call(LocationSeeder::class);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@qattabor.uz'],
            [
                'name' => 'Izzatillo',
                'phone' => '+998999139757',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        echo "✅ Admin user created: admin@qattabor.uz / admin123\n";

        // Create Test User
        $user = User::firstOrCreate(
            ['email' => 'user@qattabor.uz'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
        echo "✅ Test user created: user@qattabor.uz / user123\n\n";

        echo "\n🎉 Database seeding completed successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🔐 Admin Login:\n";
        echo "   Email: admin@qattabor.uz\n";
        echo "   Password: admin123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🌐 Access: http://127.0.0.1:8000/admin\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
