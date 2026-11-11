<?php

namespace Tests\Feature;

use App\Models\AppointmentSlot;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_booked_slot_cannot_be_booked_again_until_cancelled(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $service = Service::create([
            'name' => 'Musko sisanje',
            'description' => 'Test usluga',
            'price' => 1200,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $start = Carbon::tomorrow()->setTime(12, 0, 0);

        AppointmentSlot::create([
            'start_at' => $start,
            'is_open' => true,
        ]);

        $data = [
            'service_ids' => [$service->id],
            'start_at' => $start->format('Y-m-d H:i:s'),
        ];

        $this->actingAs($firstUser)
            ->post(route('bookings.store'), $data)
            ->assertRedirect(route('services.index'));

        $booking = Booking::firstOrFail();

        $this->actingAs($secondUser)
            ->post(route('bookings.store'), $data)
            ->assertSessionHasErrors('start_at');

        $this->assertDatabaseCount('bookings', 1);

        $this->actingAs($firstUser)
            ->patch(route('bookings.cancel', $booking))
            ->assertRedirect(route('bookings.index'));

        $this->actingAs($secondUser)
            ->post(route('bookings.store'), $data)
            ->assertRedirect(route('services.index'));

        $this->assertDatabaseCount('bookings', 2);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_booking_keeps_original_price_after_service_price_changes(): void
    {
        $user = User::factory()->create();

        $service = Service::create([
            'name' => 'Brijanje',
            'description' => 'Test usluga',
            'price' => 1000,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $start = Carbon::tomorrow()->setTime(13, 0, 0);

        AppointmentSlot::create([
            'start_at' => $start,
            'is_open' => true,
        ]);

        $this->actingAs($user)
            ->post(route('bookings.store'), [
                'service_ids' => [$service->id],
                'start_at' => $start->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect(route('services.index'));

        $booking = Booking::with('services')->firstOrFail();

        $this->assertEquals(
            1000,
            (float) $booking->services->first()->pivot->price_at_booking
        );

        $service->update([
            'price' => 1500,
        ]);

        $booking->refresh()->load('services');

        $this->assertEquals(
            1000,
            (float) $booking->services->first()->pivot->price_at_booking
        );

        $this->assertEquals(
            1500,
            (float) $service->fresh()->price
        );
    }
}
