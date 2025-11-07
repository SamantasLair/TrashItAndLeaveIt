<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create()
    {
        $labs = Lab::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $waktu = [
            '07:30-09:10',
            '09:15-10:55',
            '11:00-12:40',
            '13:55-15:30',
            '15:55-17:30'
        ];

        return view('mahasiswa.booking.create', compact('labs', 'hari', 'waktu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|in:07:30-09:10,09:15-10:55,11:00-12:40,13:55-15:30,15:55-17:30',
            'keperluan' => 'required|string|max:500',
        ]);

        $tanggal = Carbon::parse($validated['tanggal']);
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariIndo[$tanggal->dayOfWeek];

        if (!in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) {
            return back()->withErrors(['tanggal' => 'Booking hanya bisa dilakukan untuk hari Senin sampai Jumat.'])->withInput();
        }

        $exists = Booking::where('lab_id', $validated['lab_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('waktu', $validated['waktu'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['lab_id' => 'Ruangan sudah dibooking pada waktu tersebut.'])->withInput();
        }

        Booking::create([
            'user_id' => auth()->id(),
            'lab_id' => $validated['lab_id'],
            'hari' => $hari,
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'keperluan' => $validated['keperluan'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Booking berhasil dibuat! Menunggu persetujuan Bansus.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        return view('mahasiswa.booking.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status pending yang bisa dihapus.']);
        }

        $booking->delete();

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Booking berhasil dihapus!');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $exists = Booking::where('lab_id', $request->lab_id)
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        return response()->json(['available' => !$exists]);
    }
}