<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date' => ['sometimes', 'required', 'date_format:Y-m-d'],
        ]);

        $selectedDay = Carbon::createFromFormat(
            '!Y-m-d',
            $validated['date'] ?? now()->toDateString(),
            config('app.timezone')
        );

        $dayStart = $selectedDay->copy()->startOfDay();
        $dayEnd = $selectedDay->copy()->addDay()->startOfDay();

        $weekStart = $selectedDay->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->addWeek();

        $weekDays = collect(range(0, 6))->map(
            fn ($offset) => $weekStart->copy()->addDays($offset)
        );

        $weekCounts = Booking::query()
            ->where('start_at', '>=', $weekStart)
            ->where('start_at', '<', $weekEnd)
            ->selectRaw('DATE(start_at) as booking_date, COUNT(*) as total')
            ->groupBy('booking_date')
            ->pluck('total', 'booking_date');

        $bookings = Booking::with(['user', 'services'])
            ->where('start_at', '>=', $dayStart)
            ->where('start_at', '<', $dayEnd)
            ->orderBy('start_at')
            ->orderBy('id')
            ->get();

        $confirmedCount = $bookings
            ->where('status', 'confirmed')
            ->count();

        $cancelledCount = $bookings
            ->filter(fn ($booking) => in_array(
                $booking->status,
                ['cancelled', 'canceled'],
                true
            ))
            ->count();

        return view('admin.bookings.index', compact(
            'selectedDay',
            'weekDays',
            'weekCounts',
            'bookings',
            'confirmedCount',
            'cancelledCount'
        ));
    }
}
