@extends('layouts.app')

@section('title', 'Ana Sayfa')

@section('content')

    <div class="container mx-auto py-6 px-4">
        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-500 text-white p-4 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4">
                <div class="bg-green-500 text-white p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-4">
            <div class="lg:w-1/4 bg-white shadow p-4 rounded-lg">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Search</h2>
                    @livewire('search-bar')
                </div>

                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-4">Categories</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($categories as $category)
                            <a class="px-2 py-1 rounded-lg border hover:shadow-md"
                                style="background-color: {{ $category['bg_color'] }}; color: {{ $category['text_color'] }}; border-color: {{ $category['text_color'] }};">
                                {{ $category['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="lg:w-3/4">
                @livewire('blog-list', ['categories' => $categories])
            </div>
        </div>
    </div>

@endsection
