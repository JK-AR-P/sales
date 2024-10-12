<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $role = $request->input('role');

        if ($role === 'user') {
            // Autentikasi untuk user berdasarkan telp dan birthdate
            $credentials = $request->only('telp', 'birthdate');

            $user = User::where('telp', $credentials['telp'])
                ->where('birthdate', $credentials['birthdate'])
                ->first();

            if ($user) {
                Auth::login($user);

                // Cek apakah user memiliki role superadmin
                if ($user->hasRole('superadmin')) {
                    session(['role' => $role]);
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
                        'toast' => 'Superadmin has successfully logged in!',
                        'resets' => 'all',
                        'redirect' => $redirect,
                    ], 200);
                }

                // Jika bukan superadmin, hanya akses role user
                session(['role' => $role]);
                $redirect = route('user.dashboard');

                return response()->json([
                    'status' => 'success',
                    'toast' => 'You have been successfully logged in as User!',
                    'resets' => 'all',
                    'redirect' => $redirect,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'toast' => 'Invalid phone number or birthdate!',
                    'errors' => [
                        'telp' => ['The phone number or birthdate you entered is incorrect.'],
                    ],
                    'resets' => 'none',
                ]);
            }
        } else {
            // Autentikasi untuk admin berdasarkan username dan password
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Cek apakah user memiliki role superadmin
                if ($user->hasRole('superadmin')) {
                    session(['role' => $role]);
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
                        'toast' => 'Superadmin has successfully logged in!',
                        'resets' => 'all',
                        'redirect' => $redirect,
                    ], 200);
                }

                // Jika bukan superadmin, cek role yang diinputkan
                session(['role' => $role]);

                if ($user->hasRole($role)) {
                    switch ($role) {
                        case 'admin':
                            $redirect = route('admin.dashboard');
                            break;
                    }

                    return response()->json([
                        'status' => 'success',
                        'toast' => 'You have been successfully logged in as Admin!',
                        'resets' => 'all',
                        'redirect' => $redirect,
                    ], 200);
                } else {
                    Auth::logout();
                    return response()->json([
                        'status' => 'error',
                        'toast' => 'You do not have permission to access this role!',
                        'errors' => [
                            'role' => ['Invalid role selected!'],
                        ],
                        'resets' => 'none',
                    ]);
                }
            }

            return response()->json([
                'status' => 'error',
                'toast' => 'Invalid username or password!',
                'errors' => [
                    'username' => ['Invalid username or password!'],
                ],
                'resets' => 'none',
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
