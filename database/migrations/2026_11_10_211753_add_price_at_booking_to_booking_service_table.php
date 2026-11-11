<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_service', function (Blueprint $table) {
            $table->decimal('price_at_booking', 8, 2)->nullable();
        });

        DB::table('booking_service')
            ->whereNull('price_at_booking')
            ->update([
                'price_at_booking' => DB::raw(
                    '(SELECT price FROM services WHERE services.id = booking_service.service_id)'
                ),
            ]);
    }

    public function down(): void
    {
        Schema::table('booking_service', function (Blueprint $table) {
            $table->dropColumn('price_at_booking');
        });
    }
};
