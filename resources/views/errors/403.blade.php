@extends('layouts.app')

@section('title', '403 - Akses Dilarang')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h2 class="mt-6 text-center text-9xl font-extrabold text-yellow-500">
                403
            </h2>
            <h3 class="mt-2 text-center text-3xl font-extrabold text-gray-900">
                Akses Dilarang
            </h3>
            <p class="mt-4 text-center text-sm text-gray-600">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>
        </div>
        
        <div class="mt-6">
            <a href="{{ url('/') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection