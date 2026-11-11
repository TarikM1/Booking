<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('service_id')
                ->constrained()
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(['booking_id', 'service_id']);
        });

        $bookings = DB::table('bookings')
            ->whereNotNull('service_id')
            ->get(['id', 'service_id']);

        foreach ($bookings as $booking) {
            DB::table('booking_service')->insert([
                'booking_id' => $booking->id,
                'service_id' => $booking->service_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_service');
    }
};
