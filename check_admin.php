<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$admin = User::where('name', 'Izzatillo')->first();

if ($admin) {
    echo "✅ User found!\n";
    echo "Name: " . $admin->name . "\n";
    echo "Phone: " . $admin->phone . "\n";
    echo "Role: " . ($admin->role ?? 'NULL') . "\n";
    echo "Is Admin: " . ($admin->isAdmin() ? 'YES' : 'NO') . "\n\n";
    
    if (!$admin->isAdmin()) {
        echo "⚠️  User doesn't have admin role. Setting it now...\n";
        $admin->role = 'admin';
        $admin->save();
        echo "✅ Admin role set successfully!\n";
    } else {
        echo "✅ User already has admin role!\n";
    }
} else {
    echo "❌ User 'Izzatillo' not found!\n";
}
