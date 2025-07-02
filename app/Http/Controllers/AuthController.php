<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Email atau password salah']);
        }

        // Login berhasil, simpan user ke session
        Auth::login($user);
        if($user->tipe_user_id == 1){
            return redirect()->route('user.index')->with('success', 'Login berhasil');
        }else if($user->tipe_user_id == 3){
            return redirect()->route('home')->with('success', 'Login berhasil');
        }

        // Redirect ke halaman dashboard atau halaman yang diinginkan
        return redirect()->route('user_tenant_booking.index')->with('success', 'Login berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function logout()
    {
        if(Auth::check()){
            if(Auth::user()->tipe_user_id == 3){
                Auth::logout();
                return redirect()->route('user.login');
            }
            Auth::logout();
            return redirect()->route('login');
        }else{
            return redirect()->route('user.login');
        }
    }

    public function register_store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:user,email',
            'no_hp' => 'required',
            'password' => 'required|string|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tipe_user_id' => 3,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login')->with('success', 'Register successful');
    }

    /**
     * Process forgot password form - METHOD UTAMA
     */
    public function forgotPasswordPost(Request $request)
    {
        // Log untuk debugging
        Log::info('=== FORGOT PASSWORD REQUEST ===', [
            'method' => $request->method(),
            'url' => $request->url(),
            'email' => $request->input('email'),
            'has_password' => !empty($request->input('password')),
            'has_confirmation' => !empty($request->input('password_confirmation')),
            'all_inputs' => $request->except(['password', 'password_confirmation'])
        ]);

        try {
            // Ambil input
            $email = trim($request->input('email'));
            $password = $request->input('password');
            $passwordConfirmation = $request->input('password_confirmation');

            // Validasi step by step untuk debugging yang lebih baik
            if (empty($email)) {
                Log::warning('Email kosong');
                return redirect()->back()
                    ->with('error', 'Email wajib diisi.')
                    ->withInput();
            }

            if (empty($password)) {
                Log::warning('Password kosong');
                return redirect()->back()
                    ->with('error', 'Password baru wajib diisi.')
                    ->withInput();
            }

            if (empty($passwordConfirmation)) {
                Log::warning('Password confirmation kosong');
                return redirect()->back()
                    ->with('error', 'Konfirmasi password wajib diisi.')
                    ->withInput();
            }

            if ($password !== $passwordConfirmation) {
                Log::warning('Password tidak cocok', [
                    'password_length' => strlen($password),
                    'confirmation_length' => strlen($passwordConfirmation)
                ]);
                return redirect()->back()
                    ->with('error', 'Konfirmasi password tidak cocok.')
                    ->withInput($request->except(['password', 'password_confirmation']));
            }

            if (strlen($password) < 8) {
                Log::warning('Password terlalu pendek', ['length' => strlen($password)]);
                return redirect()->back()
                    ->with('error', 'Password minimal 8 karakter.')
                    ->withInput($request->except(['password', 'password_confirmation']));
            }

            // Validasi email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Email format tidak valid', ['email' => $email]);
                return redirect()->back()
                    ->with('error', 'Format email tidak valid.')
                    ->withInput();
            }

            Log::info('Validasi berhasil, mencari user...');

            // Cari user dengan raw query untuk memastikan
            $user = DB::table('user')->where('email', $email)->first();

            if (!$user) {
                Log::warning('User tidak ditemukan', ['email' => $email]);
                
                // Log semua email yang ada untuk debugging
                $allEmails = DB::table('user')->pluck('email')->toArray();
                Log::info('Email yang tersedia:', $allEmails);

                return redirect()->back()
                    ->with('error', 'Email tidak ditemukan dalam sistem.')
                    ->withInput($request->except(['password', 'password_confirmation']));
            }

            Log::info('User ditemukan', [
                'user_id' => $user->id,
                'email' => $user->email,
                'nama' => $user->nama ?? 'N/A'
            ]);

            // Hash password baru
            $hashedPassword = Hash::make($password);
            Log::info('Password di-hash', ['hash_length' => strlen($hashedPassword)]);

            // Update password dengan raw query untuk memastikan
            $updateResult = DB::table('user')
                ->where('id', $user->id)
                ->update(['password' => $hashedPassword]);

            Log::info('Update result', [
                'affected_rows' => $updateResult,
                'user_id' => $user->id
            ]);

            if ($updateResult > 0) {
                // Verifikasi bahwa password benar-benar berubah
                $updatedUser = DB::table('user')->where('id', $user->id)->first();
                $passwordChanged = $updatedUser->password !== $user->password;

                Log::info('Verifikasi update', [
                    'password_changed' => $passwordChanged,
                    'old_hash_length' => strlen($user->password),
                    'new_hash_length' => strlen($updatedUser->password)
                ]);

                if ($passwordChanged) {
                    Log::info('=== PASSWORD RESET SUCCESS ===', [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);

                    // Redirect ke halaman login dengan pesan sukses
                    return redirect()->route('user.login')
                        ->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
                } else {
                    Log::error('Password tidak berubah meskipun update berhasil');
                    return redirect()->back()
                        ->with('error', 'Terjadi masalah saat menyimpan password. Silakan coba lagi.')
                        ->withInput($request->except(['password', 'password_confirmation']));
                }
            } else {
                Log::error('Update query tidak mengubah data', [
                    'affected_rows' => $updateResult,
                    'user_id' => $user->id
                ]);

                return redirect()->back()
                    ->with('error', 'Gagal mengubah password. Silakan coba lagi.')
                    ->withInput($request->except(['password', 'password_confirmation']));
            }

        } catch (\Exception $e) {
            Log::error('=== FORGOT PASSWORD ERROR ===', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.')
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Test method untuk debugging - bisa dihapus setelah selesai
     */
    public function testPasswordReset(Request $request)
    {
        try {
            // Test koneksi database
            $userCount = User::count();
            
            // Test user pertama
            $firstUser = User::first();
            
            if ($firstUser) {
                // Test update password
                $oldPassword = $firstUser->password;
                $newPassword = Hash::make('testpassword123');
                
                // Update menggunakan DB direct
                $result = DB::table('user')
                    ->where('id', $firstUser->id)
                    ->update(['password' => $newPassword]);
                
                // Ambil password yang baru disimpan
                $updatedUser = User::find($firstUser->id);
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database connection and update test OK',
                    'user_count' => $userCount,
                    'test_user_email' => $firstUser->email,
                    'test_user_id' => $firstUser->id,
                    'update_result' => $result,
                    'password_changed' => $oldPassword !== $updatedUser->password,
                    'old_password_length' => strlen($oldPassword),
                    'new_password_length' => strlen($updatedUser->password)
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users found in database',
                    'user_count' => $userCount
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Debug users method
     */
    public function debugUsers()
    {
        try {
            $users = User::select('id', 'email', 'nama')->get();
            return response()->json([
                'status' => 'success',
                'total_users' => $users->count(),
                'users' => $users->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}