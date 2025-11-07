<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use Illuminate\Http\Request;

class BansusController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
        ];

        $recentBookings = Booking::with('user', 'lab')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $todayBookings = Booking::with('user', 'lab')
            ->whereDate('tanggal', today())
            ->where('status', 'approved')
            ->orderBy('waktu')
            ->get();

        return view('bansus.dashboard', compact('stats', 'recentBookings', 'todayBookings'));
    }

    public function index(Request $request)
    {
        $query = Booking::with('user', 'lab');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $bookings = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $labs = Lab::all();

        return view('bansus.booking.index', compact('bookings', 'labs'));
    }

    public function show(Booking $booking)
    {
        $booking->load('user', 'lab');
        return view('bansus.booking.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'approved',
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil disetujui!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'catatan' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil ditolak!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bansus.bookings.index')->with('success', 'Booking berhasil dihapus permanen.');
    }
}