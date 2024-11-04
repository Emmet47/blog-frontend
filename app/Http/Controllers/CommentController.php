<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $token = session('token');

        if (!$token) {
            return redirect()->back()->withErrors('User not authenticated. Please log in to submit a comment.');
        }


        $response = Http::withToken($token)
            ->post("{$this->apiBaseUrl}/posts/{$postId}/comments", [
                'content' => $request->input('content'),
            ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Comment submitted and waiting for approval.');
        }

        return redirect()->back()->withErrors('Failed to submit comment: ' . $response->json()['message']);
    }
}
