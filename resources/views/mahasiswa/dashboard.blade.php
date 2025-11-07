@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard Mahasiswa</h2>
        
        <div class="flex space-x-2">
            <a href="{{ route('mahasiswa.jadwal.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">
                Lihat Jadwal Terisi
            </a>
            <a href="{{ route('mahasiswa.booking.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                + Booking Baru
            </a>
        </div>

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
                                    {{ $booking->lab->nama ?? 'Lab Dihapus' }}
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
                                    <form id="cancel-form-{{ $booking->id }}" action="{{ route('mahasiswa.booking.destroy', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="text-red-600 hover:text-red-900 open-cancel-modal-btn" 
                                                data-form-id="cancel-form-{{ $booking->id }}">
                                            Batalkan
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

<div id="cancel-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display: none; z-index: 50;">
    <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Batalkan Booking?</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin membatalkan booking ini? Tindakan ini tidak dapat diurungkan.
                </p>
            </div>
            <div class="items-center px-4 py-3 gap-2 flex justify-center">
                <button id="cancel-modal-close-btn" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Tidak
                </button>
                <button id="cancel-modal-confirm-btn" type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('cancel-modal');
        const closeModalBtn = document.getElementById('cancel-modal-close-btn');
        const confirmModalBtn = document.getElementById('cancel-modal-confirm-btn');
        const openModalBtns = document.querySelectorAll('.open-cancel-modal-btn');

        let formToSubmit = null;

        openModalBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const formId = this.getAttribute('data-form-id');
                formToSubmit = document.getElementById(formId);
                if (modal) {
                    modal.style.display = 'flex';
                }
            });
        });

        function closeModal() {
            if (modal) {
                modal.style.display = 'none';
            }
            formToSubmit = null;
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (confirmModalBtn) {
            confirmModalBtn.addEventListener('click', function () {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
                closeModal();
            });
        }

        if (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }
    });
</script>