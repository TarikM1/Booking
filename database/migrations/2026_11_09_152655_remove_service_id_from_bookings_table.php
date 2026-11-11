<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->restrictOnDelete();
        });

        $bookings = DB::table('bookings')->get();

        foreach ($bookings as $booking) {
            $serviceId = DB::table('booking_service')
                ->where('booking_id', $booking->id)
                ->orderBy('service_id')
                ->value('service_id');

            if ($serviceId !== null) {
                DB::table('bookings')
                    ->where('id', $booking->id)
                    ->update(['service_id' => $serviceId]);
            }
        }
    }
};
