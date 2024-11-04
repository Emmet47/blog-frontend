@extends('layouts.app')

@section('title', 'Giriş Yap')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    @include('components.error')

        <h2 class="text-center text-2xl font-semibold text-gray-700">Giriş Yap</h2>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
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

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-white rounded-lg">Giriş Yap</button>
            </div>
        </form>
    </div>
@endsection
