<?php
// app/Http/Controllers/BansusController.php
namespace App\Http\Controllers;

use App\Models\Booking;
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

        $recentBookings = Booking::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $todayBookings = Booking::with('user')
            ->whereDate('tanggal', today())
            ->where('status', 'approved')
            ->orderBy('waktu')
            ->get();

        return view('bansus.dashboard', compact('stats', 'recentBookings', 'todayBookings'));
    }

    public function index(Request $request)
    {
        $query = Booking::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ruangan')) {
            $query->where('ruangan', $request->ruangan);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $bookings = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('bansus.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('user');
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
}