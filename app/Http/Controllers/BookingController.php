<?php


// app/Http/Controllers/BookingController.php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create()
    {
        $ruangan = ['R1', 'R2', 'R3', 'R4', 'RPL'];
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $waktu = [
            '07:30-09:10',
            '09:15-10:55',
            '11:00-12:40',
            '13:55-15:30',
            '15:55-17:30'
        ];

        return view('mahasiswa.booking.create', compact('ruangan', 'hari', 'waktu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan' => 'required|in:R1,R2,R3,R4,RPL',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|in:07:30-09:10,09:15-10:55,11:00-12:40,13:55-15:30,15:55-17:30',
            'keperluan' => 'required|string|max:500',
        ]);

        // Get hari from tanggal
        $tanggal = Carbon::parse($validated['tanggal']);
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariIndo[$tanggal->dayOfWeek];

        // Validate hari (only Senin-Jumat)
        if (!in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) {
            return back()->withErrors(['tanggal' => 'Booking hanya bisa dilakukan untuk hari Senin sampai Jumat.'])->withInput();
        }

        // Check if already booked
        $exists = Booking::where('ruangan', $validated['ruangan'])
            ->where('tanggal', $validated['tanggal'])
            ->where('waktu', $validated['waktu'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['ruangan' => 'Ruangan sudah dibooking pada waktu tersebut.'])->withInput();
        }

        Booking::create([
            'user_id' => auth()->id(),
            'ruangan' => $validated['ruangan'],
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
        // Ensure user can only see their own booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('mahasiswa.booking.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        // Ensure user can only delete their own booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow deletion if pending
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status pending yang bisa dihapus.']);
        }

        $booking->delete();

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Booking berhasil dihapus!');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'ruangan' => 'required|in:R1,R2,R3,R4,RPL',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $exists = Booking::where('ruangan', $request->ruangan)
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        return response()->json(['available' => !$exists]);
    }
}