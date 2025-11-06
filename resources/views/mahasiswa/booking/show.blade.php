
{{-- resources/views/mahasiswa/booking/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Detail Booking')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <a href="{{ route('mahasiswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            ← Kembali ke Dashboard
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

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="text-sm font-medium text-gray-500">Ruangan</div>
                    <div class="mt-1 text-sm text-gray-900 font-semibold">{{ $booking->ruangan }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Tanggal</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $booking->tanggal->format('d/m/Y') }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Hari</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $booking->hari }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Waktu</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $booking->waktu }}</div>
                </div>
            </div>

            <div>
                <div class="text-sm font-medium text-gray-500">Keperluan</div>
                <div class="mt-1 text-sm text-gray-900">{{ $booking->keperluan }}</div>
            </div>

            @if($booking->catatan)
                <div class="border-t pt-4">
                    <div class="text-sm font-medium text-gray-500">Catatan dari Bansus</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $booking->catatan }}</div>
                </div>
            @endif

            <div class="border-t pt-4 text-xs text-gray-500">
                Dibuat pada: {{ $booking->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection