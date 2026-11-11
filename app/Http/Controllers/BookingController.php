<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSlot;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->get();

        $bookings = Booking::where('status', 'confirmed')
            ->where('end_at', '>', now())
            ->get();

        $slots = AppointmentSlot::where('is_open', true)
            ->where('start_at', '>', now())
            ->orderBy('start_at')
            ->get();

        $slots = $slots->filter(function ($slot) use ($bookings) {
            $end = $slot->start_at->copy()->addMinutes(30);

            return !$bookings->contains(
                function ($booking) use ($slot, $end) {
                    return $booking->start_at->lt($end)
                        && $booking->end_at->gt($slot->start_at);
                }
            );
        });

        return view('bookings.create', compact('services', 'slots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_ids' => ['required', 'array', 'min:1'],

            'service_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('services', 'id')
                    ->where('is_active', true),
            ],

            'start_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after:now',
            ],
        ]);

        $services = Service::whereIn(
            'id',
            $validated['service_ids']
        )->get();

        $start = Carbon::parse($validated['start_at']);
        $end = $start->copy()->addMinutes(30);

        DB::transaction(function () use (
            $request,
            $services,
            $start,
            $end
        ) {
            $slot = AppointmentSlot::where(
                'start_at',
                $start->format('Y-m-d H:i:s')
            )
                ->lockForUpdate()
                ->first();

            if (
                !$slot ||
                !$slot->is_open ||
                $slot->start_at->lte(now())
            ) {
                throw ValidationException::withMessages([
                    'start_at' => 'Izabrani termin nije dostupan!',
                ]);
            }

            $occupied = Booking::where('status', 'confirmed')
                ->where('start_at', '<', $end)
                ->where('end_at', '>', $start)
                ->exists();

            if ($occupied) {
                throw ValidationException::withMessages([
                    'start_at' => 'Termin je vec zauzet!',
                ]);
            }

            $booking = $request->user()->bookings()->create([
                'start_at' => $start,
                'end_at' => $end,
                'status' => 'confirmed',
            ]);

            $booking->services()->sync(
                $services->mapWithKeys(fn ($service) => [
                $service->id => [
                'price_at_booking' => $service->price]
                ])->all());

        }, attempts: 3);

        return redirect()
            ->route('services.index')
            ->with('success', 'Termin je uspesno zakazan!');
    }

    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with('services')
            ->orderBy('start_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $booking = $request->user()
            ->bookings()
            ->findOrFail($booking->id);

        if ($booking->status !== 'confirmed') {
            return back()->with(
                'error',
                'Rezervacija je vec otkazana!'
            );
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Termin je uspesno otkazan!');
    }
}
