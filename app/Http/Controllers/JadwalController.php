<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lab;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()
            ->where('status', 'approved')
            ->where('tanggal', '>=', today());

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $bookings = $query->with('lab')
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->paginate(20);
        
        $labs = Lab::all();

        return view('mahasiswa.jadwal.index', compact('bookings', 'labs'));
    }
}