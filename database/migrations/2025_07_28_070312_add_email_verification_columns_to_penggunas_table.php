<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penggunas', function (Blueprint $table) {
            // Tambah kolom email_verified_at setelah kolom email
            $table->timestamp('email_verified_at')->nullable()->after('email');
            
            // Tambah kolom remember_token setelah kolom password
            $table->string('remember_token', 100)->nullable()->after('password');
            
            // Tambah index untuk performa yang lebih baik
            $table->index('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('penggunas', function (Blueprint $table) {
            $table->dropIndex(['email_verified_at']);
            $table->dropColumn(['email_verified_at', 'remember_token']);
        });
    }
};
