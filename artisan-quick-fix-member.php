<?php
// Run this script with: php artisan tinker --execute="require 'artisan-quick-fix-member.php'"

use App\Models\User;

$userId = 1; // Change this to your member's user ID
$user = User::find($userId);
if ($user) {
    $user->role = 'member';
    $user->save();
    echo "User #{$userId} role set to 'member'.\n";
} else {
    echo "User not found.\n";
}
