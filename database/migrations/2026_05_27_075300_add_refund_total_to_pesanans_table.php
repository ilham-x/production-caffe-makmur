<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {

            $table->bigInteger('refund_total')
                ->default(0)
                ->after('total_harga');

        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {

            $table->dropColumn('refund_total');

        });
    }
};