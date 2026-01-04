<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$admin = User::where('email', 'admin@qattabor.uz')->first();

if ($admin) {
    $admin->name = 'Izzatillo';
    $admin->phone = '+998999139757';
    $admin->role = 'admin';
    $admin->save();
    
    echo "✅ Admin credentials updated!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Name: " . $admin->name . "\n";
    echo "Phone: " . $admin->phone . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "\nNow login at: http://127.0.0.1:8000/login\n";
} else {
    echo "❌ Admin user not found!\n";
}
