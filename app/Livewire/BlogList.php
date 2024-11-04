<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class BlogList extends Component
{
    public $sort = 'newest';
    public $posts = [];
    public $categories = [];

    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }


    public function mount($categories)
    {
        $this->categories = $categories;
        $this->fetchPosts();
    }

    public function updatedSort()
    {
        $this->fetchPosts();
    }

    public function fetchPosts()
    {
        $response = Http::get($this->apiBaseUrl . '/posts', [
            'sort' => $this->sort,
        ]);

        if ($response->successful()) {
            $posts = $response->json('data');
            $this->posts = $this->fixImageUrls($posts);
        } else {
            dd('API request failed:', $response->status(), $response->body());
        }
    }

    private function fixImageUrls($posts)
    {
        $baseUrl = 'http://localhost:80/';

        foreach ($posts as &$post) {
            if (isset($post['image'])) {
                if (!str_starts_with($post['image'], 'http')) {
                    $post['image'] = $baseUrl . ltrim($post['image'], '/');
                }
            }
        }

        return $posts;
    }


    public function render()
    {
        return view('livewire.blog-list', [
            'posts' => $this->posts,
            'categories' => $this->categories,
        ]);
    }
}
