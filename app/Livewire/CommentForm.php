<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CommentForm extends Component
{
    public $content;
    public $postId;

    protected $rules = [
        'content' => 'required|string|max:1000',
    ];

    public function submitComment()
    {
        $this->validate();

        $token = session('token');
        if (!$token) {
            $this->dispatch('commentFailed', 'User not authenticated. Please log in to submit a comment.');
            return;
        }

        $response = Http::withToken($token)
            ->post(env('API_BASE_URL') . "/posts/{$this->postId}/comments", [
                'content' => $this->content,
            ]);

        if ($response->successful()) {
            $this->dispatch('commentAdded', 'Comment submitted and waiting for approval.');
            $this->reset('content');
        } else {
            $this->dispatch('commentFailed', 'Failed to submit comment.');
        }
    }

    public function render()
    {
        return view('livewire.comment-form');
    }
}
