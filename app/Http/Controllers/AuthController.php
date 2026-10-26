<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login', $this->libraryStats());
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,user',
        ]);

        $selectedRole = $request->input('role');
        $allowedRoles = $selectedRole === 'admin'
            ? ['admin']
            : ['anggota', 'user'];

        $user = User::where('email', $request->email)
            ->whereIn('role', $allowedRoles)
            ->where('status', 'aktif')
            ->first();

        if (!$user) {
            return back()->withInput($request->only('email', 'role'))->withErrors([
                'email' => 'Email atau password ' . ($selectedRole === 'admin' ? 'admin' : 'user') . ' tidak sesuai.',
            ]);
        }

        $storedPasswordInfo = password_get_info($user->password);
        $passwordMatches = $storedPasswordInfo['algo'] !== 0
            ? Hash::check($request->password, $user->password)
            : hash_equals($user->password, $request->password);

        if (!$passwordMatches) {
            return back()->withInput($request->only('email', 'role'))->withErrors([
                'email' => 'Email atau password ' . ($selectedRole === 'admin' ? 'admin' : 'user') . ' tidak sesuai.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(
            $selectedRole === 'admin' ? route('dashboard') : route('user.dashboard')
        );
    }

    public function showRegister()
    {
        return view('auth.register', $this->libraryStats());
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nis' => 'required|string|max:50|unique:anggota,nis',
            'kelas' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        $user->forceFill([
            'role' => 'anggota',
            'status' => 'aktif',
        ])->save();
        $user->anggota()->create([
            'nis' => $data['nis'],
            'nama_lengkap' => $data['name'],
            'kelas' => $data['kelas'],
            'alamat' => $data['alamat'],
        ]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function libraryStats(): array
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'aktif')->count();

        return [
            'totalBuku' => Buku::count(),
            'totalAnggota' => Anggota::count(),
            'activePercentage' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0,
        ];
    }
}