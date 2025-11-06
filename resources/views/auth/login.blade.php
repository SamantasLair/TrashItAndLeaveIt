
{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - Sistem Booking Lab')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sistem Booking Laboratorium
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Jurusan Ilmu Komputer
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow rounded-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Login ke Akun</h3>
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                <button 
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Daftar disini
                    </a>
                </p>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center">
                    <strong>Demo Account:</strong><br>
                    Bansus: bansus@ilkom.ac.id / password<br>
                    Mahasiswa: mahasiswa@ilkom.ac.id / password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
