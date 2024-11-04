<div>
    <form wire:submit.prevent="submitComment" class="mb-4">
        <div class="mb-4">
            <textarea wire:model="content" rows="4" placeholder="Leave your comment here"
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            Post Comment
        </button>
    </form>
</div>
