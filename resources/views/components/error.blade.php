@if (Session::has('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-5">
        {{ Session::get('success') }}
    </div>
@elseif (Session::has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5">
        {{ Session::get('error') }}
    </div>
@endif
