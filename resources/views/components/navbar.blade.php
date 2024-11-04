<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-lg font-semibold text-yellow-400">KLE</a>
            </div>
            <div class="flex items-center">
                @if (session('token'))
                    <div class="relative">
                        <button id="userMenuButton" class="text-gray-700 focus:outline-none">
                            {{ session('user_name') }}
                        </button>
                        <div id="userDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-20">
                            <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                            @if (session('user_role') === 'author' || session('user_role') === 'admin')
                                <a href="{{ route('blog.create') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Post Blog</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Log
                                    out</button>
                            </form>
                        </div>

                    </div>
                @else
                    <a href="/login" class="ml-4 text-gray-700">Log in</a>
                    <a href="/register" class="ml-4 text-gray-700">Register</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');

        userMenuButton.addEventListener('click', function() {
            userDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const isClickInside = userMenuButton.contains(event.target) || userDropdown.contains(event.target);
            if (!isClickInside) {
                userDropdown.classList.add('hidden');
            }
        });
    });
</script>
