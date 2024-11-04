<div id="search-bar" class="relative">
    <form role="search" class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search blogs..."
               class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </form>

    @if (count($results) > 0)
        <ul class="absolute z-10 w-full bg-white shadow-lg rounded-lg mt-1">
            @foreach ($results as $result)
                <li class="border-b border-gray-200 hover:bg-gray-100">
                    <a href="{{ url('/blog/' . $result['id']) }}" class="block p-4">
                        <span class="font-semibold text-lg">{{ $result['title'] }}</span>
                        <p class="text-gray-500 text-sm">{{ Str::limit($result['content'], 100) }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
