
{{-- resources/views/mahasiswa/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard Mahasiswa</h2>
        <a href="{{ route('mahasiswa.booking.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
            + Booking Baru
        </a>
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

    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Booking</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ruangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $booking->ruangan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->hari }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->waktu }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ Str::limit($booking->keperluan, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($booking->status === 'pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($booking->status === 'approved')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('mahasiswa.booking.show', $booking) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    Detail
                                </a>
                                @if($booking->status === 'pending')
                                    <form action="{{ route('mahasiswa.booking.destroy', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada booking. <a href="{{ route('mahasiswa.booking.create') }}" class="text-blue-600 hover:text-blue-800">Buat booking pertama Anda!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection