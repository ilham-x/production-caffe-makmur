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
        Schema::table('users', function (Blueprint $table) {
            $table->string('shift')->after('id')->default('pagi')->nullable();
            $table->datetime('waktu_shift')->after('shift')->nullable();
            $table->datetime('waktu_selesai_shift')->after('waktu_shift')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cashier', function (Blueprint $table) {
            //
        });
    }
};
