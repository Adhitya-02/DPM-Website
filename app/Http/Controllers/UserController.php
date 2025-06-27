<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\UserTenant;
use Illuminate\Http\Request;

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
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
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
        $req = $request->all();
        
        try {
            // Handle password update
            if (isset($req['password']) && !empty($req['password'])) {
                $req['password'] = bcrypt($req['password']);
                $user->update($req);
                return redirect()->back()->with('success', 'Berhasil merubah password user.');
            }

            // Handle tenant assignment
            if (isset($req['tenant'])) {
                // Delete existing tenant relationship
                UserTenant::where('user_id', $id)->delete();
                
                // Create new tenant relationship if tenant is selected
                if ($req['tenant'] && $req['tenant'] != "") {
                    UserTenant::create([
                        'user_id' => $id, 
                        'tenant_id' => $req['tenant']
                    ]);
                }
                
                // Remove tenant from user data before updating user
                unset($req['tenant']);
            }

            // Remove password from update data if it's empty
            if (isset($req['password']) && empty($req['password'])) {
                unset($req['password']);
            }

            // Update user data
            $user->update($req);
            
            return redirect()->back()->with('success', 'Berhasil mengubah data user.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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