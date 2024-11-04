<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');

        if (is_null($this->apiBaseUrl)) {
            throw new \Exception('API_BASE_URL environment variable is not set.');
        }
    }


    public function showProfilePage()
    {
        $user = $this->getProfile();

        if ($user) {
            return view('auth.profile', ['user' => $user]);
        }

        return redirect()->route('login')->withErrors('Profile data could not be retrieved.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $response = Http::baseUrl($this->apiBaseUrl)->post('/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            $token = $responseData['token'];
            session(['token' => $token]);

            if (isset($responseData['user'])) {
                session(['user_name' => $responseData['user']['name']]);
                session(['user_role' => $responseData['user']['role']]);
            }

            return redirect('/')->with('success', 'Login successful');
        } elseif ($response->status() == 422) {
            return redirect()->route('login')->withErrors($responseData['errors'])->withInput();
        } elseif ($response->status() == 401) {
            return redirect()->route('login')->withErrors(['email' => 'The provided credentials are incorrect'])->withInput();
        }

        return redirect()->route('login')->withErrors('Something went wrong');
    }

    public function logout(Request $request)
    {
        $token = session('token');

        if ($token) {
            $response = Http::withToken($token)->baseUrl($this->apiBaseUrl)->post('/logout');

            if ($response->successful()) {
                session()->forget(['token', 'user_name', 'user_role']);
                return redirect('/')->with('success', 'Logged out successfully');
            }
        }

        return redirect('/')->withErrors('Failed to log out.');
    }


    public function getProfile()
    {
        $token = session('token');

        if (!$token) {
            return null;
        }

        $response = Http::withToken($token)->baseUrl($this->apiBaseUrl)->get('/profile');

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }


    public function updateProfile(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'You need to be logged in.');
        }

        $data = [
            'name' => $request->input('name'),
        ];

        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $data['password'] = $request->input('password');
            $data['password_confirmation'] = $request->input('password_confirmation');
        }

        $response = Http::withToken($token)
            ->baseUrl($this->apiBaseUrl)
            ->put('/profile', $data);

        if ($response->successful()) {
            session(['user_name' => $data['name']]);
            return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
        } elseif ($response->status() == 422) {
            return redirect()->back()->withErrors($response->json('errors'))->withInput();
        }

        return redirect()->back()->withErrors('Something went wrong during profile update: ' . $response->body());
    }

    public function register(Request $request)
    {
        $response = Http::baseUrl($this->apiBaseUrl)->post('/register', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            $token = $responseData['token'];
            session(['token' => $token]);

            return redirect()->route('login')->with('success', 'Registration successful');
        } elseif ($response->status() == 422) {
            return redirect()->back()->withErrors($responseData['errors'])->withInput();
        } elseif ($response->status() == 409) {
            return redirect()->back()->withErrors(['email' => 'This email is already registered.'])->withInput();
        }

        return redirect()->back()->withErrors('Something went wrong during registration');
    }
}
