<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function auth(Request $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            session(['role' => $role]);

            // if superadmin role
            if ($user->hasRole('superadmin')) {
                switch ($role) {
                    case 'admin':
                        $redirect = route('admin.dashboard');
                        break;
                    case 'user':
                        $redirect = route('user.dashboard');
                        break;
                }

                return response()->json([
                    'status' => 'success',
                    'toast' => 'You have been successfully logged in!',
                    'resets' => 'all',
                    'redirect' => $redirect,
                ], 200);
            }

            // if not superadmin role
            if ($user->hasRole($role)) {
                switch ($role) {
                    case 'admin':
                        $redirect = route('admin.dashboard');
                        break;
                    case 'user':
                        $redirect = route('user.dashboard');
                        break;
                }

                return response()->json([
                    'status' => 'success',
                    'toast' => 'You have been successfully logged in!',
                    'resets' => 'all',
                    'redirect' => $redirect,
                ], 200);
            } else {
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'toast' => 'You do not have permission to access this role!',
                    'resets' => 'all',
                    'errors' => [
                        'role' => ['Invalid role selected!'],
                    ],
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'toast' => 'Invalid username or password!',
            'resets' => 'all',
            'errors' => [
                'username' => ['Invalid username or password!'],
            ],
        ]);
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
