<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the super admin user if it doesn't exist
        User::updateOrCreate(
            ['email' => 'admin@presensi.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete the super admin user when rolling back
        User::where('email', 'admin@presensi.test')->delete();
    }
};
