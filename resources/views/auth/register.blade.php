@extends('layouts.app')

@section('title', 'Kayıt Ol')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    @include('components.error')

        <h2 class="text-center text-2xl font-semibold text-gray-700">Kayıt Ol</h2>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mt-4">
                <label for="name" class="block text-gray-700">Ad Soyad</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-400"
                    required>
            </div>

            <div class="mt-4">
                <label for="email" class="block text-gray-700">Email Adresi</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-400"
                    required>
            </div>

            <div class="mt-4">
                <label for="password" class="block text-gray-700">Şifre</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-400"
                    required>
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-gray-700">Şifreyi Doğrula</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-400"
                    required>
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-white rounded-lg">Kayıt Ol</button>
            </div>
        </form>
    </div>
@endsection
