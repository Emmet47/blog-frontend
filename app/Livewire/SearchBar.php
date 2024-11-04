<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchBar extends Component
{
    public $search = "";
    public $results = [];
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 1) {

            $response = Http::get($this->apiBaseUrl . '/posts', [
                'search' => $this->search,
            ]);

            if ($response->successful()) {
                $this->results = collect($response->json('data'))->filter(function ($post) {
                    return str_contains(strtolower($post['title']), strtolower($this->search)) ||
                        str_contains(strtolower($post['content']), strtolower($this->search));
                })->take(7)->toArray();
            }
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-bar', [
            'results' => $this->results
        ]);
    }
}
