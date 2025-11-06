{{-- resources/views/bansus/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard Bansus')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard Bansus</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola semua booking laboratorium</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-gray-500 text-sm font-medium">Total Booking</div>
            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-gray-500 text-sm font-medium">Pending</div>
            <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-gray-500 text-sm font-medium">Disetujui</div>
            <div class="text-3xl font-bold text-green-600 mt-2">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-gray-500 text-sm font-medium">Ditolak</div>
            <div class="text-3xl font-bold text-red-600 mt-2">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('bansus.bookings.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-block">
            Lihat Semua Booking
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Booking Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentBookings as $booking)
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                        {{ $booking->ruangan }}
                                    </span>
                                    @if($booking->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($booking->status === 'approved')
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-900 mt-2">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->tanggal->format('d/m/Y') }} • {{ $booking->waktu }}</p>
                            </div>
                            <a href="{{ route('bansus.bookings.show', $booking) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada booking
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h3>
                <p class="text-xs text-gray-500 mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($todayBookings as $booking)
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                        {{ $booking->ruangan }}
                                    </span>
                                    <span class="text-xs text-gray-600">{{ $booking->waktu }}</span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mt-2">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($booking->keperluan, 50) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        Tidak ada jadwal hari ini
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection