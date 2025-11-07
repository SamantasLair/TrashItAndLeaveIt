@extends('layouts.dashboard')

@section('title', 'Detail Booking')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <a href="{{ route('bansus.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            ← Kembali ke Daftar Booking
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Detail Booking</h3>
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
        </div>

        <div class="p-6 space-y-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-3">Informasi Mahasiswa</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Nama</div>
                        <div class="mt-1 text-sm text-gray-900 font-medium">{{ $booking->user->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">NIM</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->user->nim }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Email</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->user->email }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Jurusan</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->user->jurusan }}</div>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h4 class="text-sm font-medium text-gray-500 mb-3">Informasi Booking</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Ruangan</div>
                        <div class="mt-1 text-sm text-gray-900 font-semibold">{{ $booking->lab->nama ?? 'Lab Dihapus' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Tanggal</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->tanggal->format('d/m/Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Hari</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->hari }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Waktu</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $booking->waktu }}</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-xs text-gray-500">Keperluan</div>
                <div class="mt-1 text-sm text-gray-900">{{ $booking->keperluan }}</div>
            </div>

            @if($booking->catatan)
                <div class="border-t pt-6">
                    <div class="text-xs text-gray-500">Catatan</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $booking->catatan }}</div>
                </div>
            @endif

            @if($booking->status === 'pending')
                <div class="border-t pt-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Tindakan</h4>
                    
                    <form action="{{ route('bansus.bookings.approve', $booking) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <label for="approve_catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" id="approve_catatan" rows="2" maxlength="500" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm mb-3"></textarea>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">
                            ✓ Setujui Booking
                        </button>
                    </form>

                    <form action="{{ route('bansus.bookings.reject', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="reject_catatan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="catatan" id="reject_catatan" rows="2" maxlength="500" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 text-sm mb-3"></textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
                            ✗ Tolak Booking
                        </button>
                    </form>
                </div>
            @endif

            <div class="border-t pt-4 text-xs text-gray-500">
                Dibuat pada: {{ $booking->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection