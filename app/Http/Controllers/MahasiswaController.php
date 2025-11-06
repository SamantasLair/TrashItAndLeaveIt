<?php
// app/Http/Controllers/MahasiswaController.php
namespace App\Http\Controllers;

use App\Models\Booking; 
use App\Models\User; 
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $bookings = auth()->user()->bookings()
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => auth()->user()->bookings()->count(),
            'pending' => auth()->user()->bookings()->where('status', 'pending')->count(),
            'approved' => auth()->user()->bookings()->where('status', 'approved')->count(),
            'rejected' => auth()->user()->bookings()->where('status', 'rejected')->count(),
        ];

        return view('mahasiswa.dashboard', compact('bookings', 'stats'));
    }
}