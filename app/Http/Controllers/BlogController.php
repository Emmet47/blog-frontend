<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
    {
        $postsResponse = Http::baseUrl($this->apiBaseUrl)->get('/posts');
        $categoriesResponse = Http::baseUrl($this->apiBaseUrl)->get('/categories');

        if ($postsResponse->successful() && $categoriesResponse->successful()) {
            $posts = $this->fixImageUrls($postsResponse->json()['data']);
            $categories = $categoriesResponse->json()['data'];
            return view('home', compact('posts', 'categories'));
        }

        return redirect()->back()->withErrors('Failed to fetch posts or categories.');
    }

    private function fixImageUrls($posts)
    {
        $baseUrl = 'http://localhost:80/images/';

        foreach ($posts as &$post) {
            if (isset($post['image'])) {

                if (!str_starts_with($post['image'], 'http')) {
                    $post['image'] = $baseUrl . ltrim($post['image'], '/');
                }
            }
        }

        return $posts;
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $searchTerm = $request->input('search');

        $response = Http::baseUrl($this->apiBaseUrl)->post('/posts/search', [
            'query' => $searchTerm,
        ]);

        if ($response->successful()) {
            $posts = $response->json()['data'];
            $categoriesResponse = Http::baseUrl($this->apiBaseUrl)->get('/categories');

            if ($categoriesResponse->successful()) {
                $categories = $categoriesResponse->json()['data'];
                return view('home', compact('posts', 'categories'));
            }

            return redirect()->back()->withErrors('Failed to fetch categories.');
        }

        return redirect()->back()->withErrors('Failed to fetch posts. Status: ' . $response->status() . ' Body: ' . $response->body());
    }


    public function postsByCategory($categoryId)
    {
        $response = Http::baseUrl($this->apiBaseUrl)->get("/categories/{$categoryId}/posts");

        $categoriesResponse = Http::baseUrl($this->apiBaseUrl)->get('/categories');

        if ($response->successful() && $categoriesResponse->successful()) {
            $posts = $response->json()['data'];
            $categories = $categoriesResponse->json()['data'];

            return view('home', compact('posts', 'categories'));
        }

        return redirect()->back()->withErrors('Failed to fetch posts or categories.');
    }
    public function store(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->back()->withErrors('User not authenticated. Please log in to submit a post.');
        }

        if (!$request->hasFile('image')) {
            return redirect()->back()->withErrors('Image is required.');
        }


        $file = $request->file('image');
        if (!$file->isValid()) {
            return redirect()->back()->withErrors('Uploaded image is not valid.');
        }

        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->attach('image', fopen($file->getPathname(), 'r'), $file->getClientOriginalName())
            ->post("{$this->apiBaseUrl}/posts", $data);
        if ($response->successful()) {
            return redirect()->route('blog.index')->with('success', 'Post created successfully.');
        }

        return redirect()->back()->withErrors('Failed to create post: ' . $response->json()['message']);
    }

    public function create()
    {
        $categoriesResponse = Http::baseUrl($this->apiBaseUrl)->get('/categories');

        if ($categoriesResponse->successful()) {
            $categories = $categoriesResponse->json()['data'];
            return view('blog.add-blog', compact('categories'));
        }

        return redirect()->back()->withErrors('Failed to fetch categories.');
    }

    public function show($id)
    {
        $postResponse = Http::baseUrl($this->apiBaseUrl)->get("/posts/{$id}");

        if ($postResponse->successful()) {
            $post = $postResponse->json()['data'] ?? null;

            if (is_null($post)) {
                return redirect()->back()->withErrors('Post not found.');
            }

            $post = $this->fixImageUrl($post);

            $commentsResponse = Http::baseUrl($this->apiBaseUrl)->get("/posts/{$id}/comments");
            $comments = $commentsResponse->successful() ? $commentsResponse->json()['data'] ?? [] : [];

            return view('blog.blog-detail', compact('post', 'comments'));
        }

        return redirect()->back()->withErrors('Failed to fetch post.');
    }

    private function fixImageUrl($post)
    {
        $baseUrl = 'http://localhost:80/';
        if (isset($post['image'])) {

            if (!str_starts_with($post['image'], 'http')) {
                $post['image'] = $baseUrl . ltrim($post['image'], '/');
            }
        }

        return $post;
    }
}
