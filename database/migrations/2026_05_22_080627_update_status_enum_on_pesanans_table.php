<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {

            $table->enum('status', [
                'menunggu',
                'pending_payment',
                'dibayar',
                'diproses',
                'selesai',
                'complain',
                'refund',
                'cancel'
            ])->default('menunggu')->change();

        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {

            $table->enum('status', [
                'menunggu',
                'pending_payment',
                'dibayar',
                'selesai'
            ])->default('menunggu')->change();

        });
    }
};