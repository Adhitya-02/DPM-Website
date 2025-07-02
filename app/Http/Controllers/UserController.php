<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\UserTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $tenant = Tenant::all();
        return view('user.index', compact('users', 'tenant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $tenant = Tenant::all();
        return view('user.create', compact('tenant'));
    }

    /**
     * Store a newly created resource in storage.
     */    
    public function store(Request $request)
    {
        // Validate the request - PERBAIKAN DI SINI
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',  // GANTI dari users ke user
            'no_hp' => 'nullable|string|max:15',
            'tipe_user_id' => 'required|integer',
            'tenant_id' => 'nullable|exists:tenant,id'
        ]);

        $data = $request->all();
        $tenantId = $data['tenant_id'] ?? null;
        unset($data['tenant_id']);
        
        // Set default password
        $data['password'] = bcrypt('12345678');
        
        try {
            $user = User::create($data);
            
            // Create UserTenant relationship if tenant is selected
            if ($tenantId && $tenantId != "") {
                UserTenant::create([
                    'user_id' => $user->id, 
                    'tenant_id' => $tenantId
                ]);
            }
            
            session()->flash('success', 'Berhasil membuat akun. Password defaultnya adalah 12345678.');
            return redirect()->back();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('userTenant.tenant')->findOrFail($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('userTenant.tenant')->findOrFail($id);
        $tenant = Tenant::all();
        $userTenant = UserTenant::where('user_id', $id)->first();
        
        return view('user.edit', compact('user', 'tenant', 'userTenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Jika request untuk ubah password
        if ($request->has('password') && $request->filled('password')) {
            
            // Validasi untuk ubah password
            $request->validate([
                'current_password' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
                    'confirmed'
                ],
                'password_confirmation' => 'required|same:password'
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password baru minimal 8 karakter.',
                'password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
                'password_confirmation.same' => 'Konfirmasi password harus sama dengan password baru.'
            ]);
    
            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
            }
    
            // Update password
            $user->update([
                'password' => Hash::make($request->password)
            ]);
    
            return redirect()->back()->with('success', 'Password berhasil diubah. Silakan login ulang dengan password baru.');
        }
    
        // Jika request untuk update data user lain
        $req = $request->all();
        
        if (isset($req['tenant'])) {
            UserTenant::where('user_id', $id)->delete();
            UserTenant::create(['user_id' => $id, 'tenant_id' => $req['tenant']]);
            unset($req['tenant']);
            $user->update($req);
            
            return redirect()->back()->with('success', 'Berhasil mengubah data user');
        } else {
            unset($req['tenant']);
            $user->update($req);
            return redirect()->back()->with('success', 'Berhasil mengubah data user');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Delete user tenant relationship first
            UserTenant::where('user_id', $id)->delete();
            
            // Delete user
            $user = User::findOrFail($id);
            $user->delete();
            
            return redirect()->back()->with('success', 'Berhasil menghapus user.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Reset user password to default
     */
    public function resetPassword(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['password' => bcrypt('12345678')]);
            
            return redirect()->back()->with('success', 'Password berhasil direset ke 12345678.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat reset password: ' . $e->getMessage());
        }
    }
}