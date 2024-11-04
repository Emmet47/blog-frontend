<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Blogs</h2>
        <!-- Sorting dropdown -->
        <div class="relative">
            <select wire:model="sort"
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="most_popular">Most Popular</option>
                <option value="least_popular">Least Popular</option>
            </select>
        </div>
    </div>

    <!-- Blog list -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($posts as $post)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if (isset($post['image']))
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="h-48 w-full object-cover">
                @else
                    <div class="h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-2xl text-white">No Image</span>
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $post['title'] }}</h3>
                    <p class="text-gray-700">{{ Str::limit($post['content'], 100) }}</p>

                    <div class="flex justify-between items-center mt-4">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-1">Category:</span>
                            @php
                                foreach ($categories as $category) {
                                    if ($category['id'] === $post['category_id']) {
                                        $categoryName = $category['name'];
                                        $categoryColor = [
                                            'text_color' => $category['text_color'],
                                            'bg_color' => $category['bg_color'],
                                        ];
                                        break;
                                    }
                                }
                            @endphp
                            <a class="px-2 py-1 rounded-lg border hover:shadow-md"
                                style="background-color: {{ $categoryColor['bg_color'] }}; color: {{ $categoryColor['text_color'] }}; border-color: {{ $categoryColor['text_color'] }};">
                                {{ $categoryName }}
                            </a>
                        </div>
                        <a href="{{ route('blog.show', $post['id']) }}"
                            class="text-indigo-600 hover:text-indigo-800 font-semibold">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
