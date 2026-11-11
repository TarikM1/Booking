<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSlot;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSlotController extends Controller
{
    public function index()
    {
        $slots = AppointmentSlot::where('start_at', '>=', now())
            ->orderBy('start_at')
            ->get();

        $bookings = Booking::where('status', 'confirmed')
            ->where('end_at', '>', now())
            ->get();

        foreach ($slots as $slot) {
            $end = $slot->start_at->copy()->addMinutes(30);

            $isReserved = $bookings->contains(
                function ($booking) use ($slot, $end) {
                    return $booking->start_at->lt($end)
                        && $booking->end_at->gt($slot->start_at);
                }
            );

            $slot->setAttribute('is_reserved', $isReserved);
        }

        return view('admin.slots.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $start = Carbon::parse(
            $validated['date'] . ' ' . $validated['start_time']
        );

        $end = Carbon::parse(
            $validated['date'] . ' ' . $validated['end_time']
        );

        if ($start->lte(now()) || $end->lte($start)) {
            return back()->withErrors([
                'start_time' => 'Izaberi ispravan buduci period.',
            ])->withInput();
        }

        if (
            $start->minute % 30 !== 0 ||
            $end->minute % 30 !== 0
        ) {
            return back()->withErrors([
                'start_time' => 'Termini moraju biti na pun sat ili pola sata.',
            ])->withInput();
        }

        if ($end->gt($start->copy()->addHours(12))) {
            return back()->withErrors([
                'end_time' => 'Period ne moze biti duzi od 12 sati.',
            ])->withInput();
        }

        [$opened, $alreadyOpen, $reserved] = DB::transaction(
            function () use ($start, $end) {

                $opened = 0;
                $alreadyOpen = 0;
                $reserved = 0;

                for (
                    $time = $start->copy();
                    $time->lt($end);
                    $time->addMinutes(30)
                ) {
                    $slot = AppointmentSlot::where(
                        'start_at',
                        $time->format('Y-m-d H:i:s')
                    )
                        ->lockForUpdate()
                        ->first();

                    $slotEnd = $time->copy()->addMinutes(30);

                    $occupied = Booking::where('status', 'confirmed')
                        ->where('start_at', '<', $slotEnd)
                        ->where('end_at', '>', $time)
                        ->exists();

                    if ($occupied) {
                        $reserved++;
                        continue;
                    }

                    if ($slot) {
                        if (!$slot->is_open) {
                            $slot->update([
                                'is_open' => true,
                            ]);

                            $opened++;
                        } else {
                            $alreadyOpen++;
                        }
                    } else {
                        AppointmentSlot::create([
                            'start_at' => $time->format('Y-m-d H:i:s'),
                            'is_open' => true,
                        ]);

                        $opened++;
                    }
                }

                return [$opened, $alreadyOpen, $reserved];

            },
            attempts: 3
        );

        return redirect()
            ->route('admin.slots.index')
            ->with(
                'success',
                "Otvoreno: {$opened}. " .
                "Vec otvoreno: {$alreadyOpen}. " .
                "Rezervisano (preskoceno): {$reserved}."
            );
    }

    public function close(AppointmentSlot $slot)
    {
        return DB::transaction(function () use ($slot) {

            $slot = AppointmentSlot::whereKey($slot->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($slot->start_at->lte(now())) {
                return back()->with(
                    'error',
                    'Prosli termin nije moguce menjati!'
                );
            }

            if (!$slot->is_open) {
                return back()->with(
                    'error',
                    'Termin je vec zatvoren!'
                );
            }

            $end = $slot->start_at->copy()->addMinutes(30);

            $occupied = Booking::where('status', 'confirmed')
                ->where('start_at', '<', $end)
                ->where('end_at', '>', $slot->start_at)
                ->exists();

            if ($occupied) {
                return back()->with(
                    'error',
                    'Termin je vec rezervisan!'
                );
            }

            $slot->update([
                'is_open' => false,
            ]);

            return redirect()
                ->route('admin.slots.index')
                ->with(
                    'success',
                    'Termin je uspesno zatvoren!'
                );

        }, attempts: 3);
    }
}
