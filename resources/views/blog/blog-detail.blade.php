@extends('layouts.app')

@section('title', $post['title'])

@section('content')

    <div class="container mx-auto py-6 px-4">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold mb-4">{{ $post['title'] }}</h1>
            <div class="h-48 bg-gray-300 flex items-center justify-center mb-4">
                @if ($post['image'])
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="object-cover h-full w-full">
                @else
                    <span class="text-2xl text-white">No Image</span>
                @endif
            </div>
            <p class="text-gray-700 mb-4">
                {{ $post['content'] }}
            </p>

            <h2 class="text-2xl font-semibold mb-4">Leave a Comment</h2>

            {{-- Success and error messages (JS driven) --}}
            <div id="message-box" class="hidden"></div>
            {{-- Include the Livewire comment form --}}
            @livewire('comment-form', ['postId' => $post['id']])

        </div>

        <h2 class="text-2xl font-semibold mb-4">Comments</h2>
        @if (count($comments) > 0)
            <div class="space-y-4">
                @foreach ($comments as $comment)
                    <div class="border-b pb-4 mb-4">
                        <p class="text-gray-800">{{ $comment['content'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No comments yet.</p>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for success message from Livewire
            Livewire.on('commentAdded', function(message) {
                showMessage(message, 'bg-green-100 text-green-700');
            });

            // Listen for error message from Livewire
            Livewire.on('commentFailed', function(message) {
                showMessage(message, 'bg-red-100 text-red-700');
            });

            // Function to display message dynamically
            function showMessage(message, classes) {
                let messageBox = document.getElementById('message-box');
                messageBox.textContent = message;
                messageBox.className = classes + ' p-4 mb-4 rounded';
                messageBox.classList.remove('hidden');

                // Hide the message after 3 seconds
                setTimeout(() => {
                    messageBox.classList.add('hidden');
                }, 3000);
            }
        });
    </script>
@endpush
