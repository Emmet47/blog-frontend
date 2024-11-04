@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Profile Details</h2>


            @if ($errors->any())
                <div class="mb-4">
                    <div class="text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="mb-4 text-green-600">{{ Session::get('success') }}</div>
            @elseif (Session::has('error'))
                <div class="mb-4 text-red-600">{{ Session::get('error') }}</div>
            @endif


            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')


                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ $user['name'] }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" value="{{ $user['email'] }}" disabled
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Enter your new password">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Şifreyi Onayla</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Confirm your password">
                </div>

                <div class="mt-8">
                    <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-md hover:bg-yellow-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
