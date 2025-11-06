
{{-- resources/views/mahasiswa/booking/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Booking Baru')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <a href="{{ route('mahasiswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Form Booking Laboratorium</h3>
        </div>

        <form method="POST" action="{{ route('mahasiswa.booking.store') }}" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="ruangan" class="block text-sm font-medium text-gray-700">Ruangan <span class="text-red-500">*</span></label>
                <select name="ruangan" id="ruangan" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r }}" {{ old('ruangan') === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required min="{{ date('Y-m-d') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Hanya hari Senin - Jumat</p>
            </div>

            <div>
                <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu <span class="text-red-500">*</span></label>
                <select name="waktu" id="waktu" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Waktu --</option>
                    @foreach($waktu as $w)
                        <option value="{{ $w }}" {{ old('waktu') === $w ? 'selected' : '' }}>{{ $w }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan <span class="text-red-500">*</span></label>
                <textarea name="keperluan" id="keperluan" rows="4" required maxlength="500" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('keperluan') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
            </div>

            <div id="availability-message" class="hidden p-4 rounded-md"></div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Ajukan Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Check availability when fields change
    const ruanganSelect = document.getElementById('ruangan');
    const tanggalInput = document.getElementById('tanggal');
    const waktuSelect = document.getElementById('waktu');
    const availabilityMessage = document.getElementById('availability-message');

    function checkAvailability() {
        const ruangan = ruanganSelect.value;
        const tanggal = tanggalInput.value;
        const waktu = waktuSelect.value;

        if (ruangan && tanggal && waktu) {
            fetch(`{{ route('mahasiswa.booking.check') }}?ruangan=${ruangan}&tanggal=${tanggal}&waktu=${waktu}`)
                .then(response => response.json())
                .then(data => {
                    availabilityMessage.classList.remove('hidden');
                    if (data.available) {
                        availabilityMessage.className = 'p-4 rounded-md bg-green-50 border border-green-200 text-green-700';
                        availabilityMessage.textContent = '✓ Ruangan tersedia!';
                    } else {
                        availabilityMessage.className = 'p-4 rounded-md bg-red-50 border border-red-200 text-red-700';
                        availabilityMessage.textContent = '✗ Ruangan sudah dibooking pada waktu tersebut.';
                    }
                });
        }
    }

    ruanganSelect.addEventListener('change', checkAvailability);
    tanggalInput.addEventListener('change', checkAvailability);
    waktuSelect.addEventListener('change', checkAvailability);
</script>
@endsection