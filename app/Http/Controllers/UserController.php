<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\UserTenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use App\Models\UlasanTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Load users with their tenant relationship
            $users = User::with(['userTenant.tenant'])->orderBy('id', 'desc')->get();
            $tenant = Tenant::orderBy('nama', 'asc')->get();
            
            return view('user.index', compact('users', 'tenant'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        try {
            $tenant = Tenant::orderBy('nama', 'asc')->get();
            return view('user.create', compact('tenant'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */    
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255|min:2',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('user', 'email')
                ],
                'no_hp' => 'nullable|string|max:15|regex:/^[0-9+\-\s()]+$/',
                'tipe_user_id' => 'required|integer|in:1,2,3',
                'tenant_id' => 'nullable|exists:tenant,id'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.min' => 'Nama minimal 2 karakter.',
                'nama.max' => 'Nama maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
                'email.max' => 'Email maksimal 255 karakter.',
                'no_hp.regex' => 'Format nomor HP tidak valid.',
                'no_hp.max' => 'Nomor HP maksimal 15 karakter.',
                'tipe_user_id.required' => 'Tipe user wajib dipilih.',
                'tipe_user_id.in' => 'Tipe user tidak valid.',
                'tenant_id.exists' => 'Tenant yang dipilih tidak ditemukan.'
            ]);

            $data = $request->only(['nama', 'email', 'no_hp', 'tipe_user_id']);
            $tenantId = $request->input('tenant_id');
            
            // Set default password
            $data['password'] = Hash::make('12345678');
            
            // Begin transaction
            DB::beginTransaction();
            
            // Create user
            $user = User::create($data);
            
            // Create UserTenant relationship if tenant is selected and user type is tenant manager
            if ($tenantId && $data['tipe_user_id'] == 2) {
                // Check if tenant is already assigned to another user
                $existingAssignment = UserTenant::where('tenant_id', $tenantId)->first();
                if ($existingAssignment) {
                    DB::rollback();
                    return redirect()->back()
                        ->withErrors(['tenant_id' => 'Tenant ini sudah ditugaskan ke pengguna lain.'])
                        ->withInput();
                }
                
                UserTenant::create([
                    'user_id' => $user->id, 
                    'tenant_id' => $tenantId
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                'Berhasil membuat akun untuk "' . $user->nama . '". Password default: 12345678'
            );
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with([
                'userTenant.tenant',
                'bookings.tenant',
                'ratings.tenant',
                'ulasan.tenant'
            ])->findOrFail($id);
            
            // Get user statistics
            $stats = [
                'total_bookings' => $user->bookings->count(),
                'total_ratings' => $user->ratings->count(),
                'total_reviews' => $user->ulasan->count(),
                'average_rating_given' => round($user->ratings->avg('rating') ?? 0, 1)
            ];
            
            return view('user.show', compact('user', 'stats'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'User tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::with('userTenant.tenant')->findOrFail($id);
            $tenant = Tenant::orderBy('nama', 'asc')->get();
            $userTenant = UserTenant::where('user_id', $id)->first();
            
            return view('user.edit', compact('user', 'tenant', 'userTenant'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'User tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255|min:2',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('user', 'email')->ignore($id)
                ],
                'no_hp' => 'nullable|string|max:15|regex:/^[0-9+\-\s()]+$/',
                'tipe_user_id' => 'required|integer|in:1,2,3',
                'tenant' => 'nullable|exists:tenant,id'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.min' => 'Nama minimal 2 karakter.',
                'nama.max' => 'Nama maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
                'email.max' => 'Email maksimal 255 karakter.',
                'no_hp.regex' => 'Format nomor HP tidak valid.',
                'no_hp.max' => 'Nomor HP maksimal 15 karakter.',
                'tipe_user_id.required' => 'Tipe user wajib dipilih.',
                'tipe_user_id.in' => 'Tipe user tidak valid.',
                'tenant.exists' => 'Tenant yang dipilih tidak ditemukan.'
            ]);
            
            DB::beginTransaction();
            
            // Update user data
            $userData = $request->only(['nama', 'email', 'no_hp', 'tipe_user_id']);
            $user->update($userData);
            
            // Handle tenant relationship
            $tenantId = $request->input('tenant');
            
            // Delete existing tenant relationship
            UserTenant::where('user_id', $id)->delete();
            
            // Create new tenant relationship if needed
            if ($tenantId && $userData['tipe_user_id'] == 2) {
                // Check if tenant is already assigned to another user
                $existingAssignment = UserTenant::where('tenant_id', $tenantId)
                    ->where('user_id', '!=', $id)
                    ->first();
                    
                if ($existingAssignment) {
                    DB::rollback();
                    return redirect()->back()
                        ->withErrors(['tenant' => 'Tenant ini sudah ditugaskan ke pengguna lain.'])
                        ->withInput();
                }
                
                UserTenant::create([
                    'user_id' => $id, 
                    'tenant_id' => $tenantId
                ]);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Berhasil mengubah data user "' . $user->nama . '".');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah data: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $userName = $user->nama;
            
            // Check if user has bookings
            $bookingCount = UserTenantBooking::where('user_id', $id)->count();
            if ($bookingCount > 0) {
                return redirect()->back()->with('error', 
                    'Tidak dapat menghapus user "' . $userName . '" karena memiliki ' . $bookingCount . ' booking.'
                );
            }
            
            DB::beginTransaction();
            
            // Delete related data
            UserTenant::where('user_id', $id)->delete();
            UserTenantRating::where('user_id', $id)->delete();
            UlasanTenant::where('user_id', $id)->delete();
            
            // Delete user
            $user->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Berhasil menghapus user "' . $userName . '".');
            
        } catch (\Exception $e) {
            DB::rollback();
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
            
            // Reset password to default
            $user->update([
                'password' => Hash::make('12345678')
            ]);
            
            return redirect()->back()->with('success', 
                'Password user "' . $user->nama . '" berhasil direset ke 12345678.'
            );
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat reset password: ' . $e->getMessage()
            );
        }
    }

    /**
     * Change user password with current password verification
     */
    public function changePassword(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Validasi untuk ubah password
            $request->validate([
                'current_password' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed'
                ],
                'password_confirmation' => 'required|same:password'
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password baru minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
                'password_confirmation.same' => 'Konfirmasi password harus sama dengan password baru.'
            ]);

            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Password saat ini salah.'])
                    ->withInput();
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 
                'Password berhasil diubah untuk user "' . $user->nama . '". Silakan login ulang dengan password baru.'
            );
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat mengubah password: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get user statistics for API
     */
    public function getUserStats(string $id)
    {
        try {
            $user = User::with(['bookings', 'ratings', 'ulasan'])->findOrFail($id);
            
            $stats = [
                'total_bookings' => $user->bookings->count(),
                'completed_bookings' => $user->bookings->where('status', 2)->count(),
                'pending_bookings' => $user->bookings->where('status', 1)->count(),
                'total_ratings' => $user->ratings->count(),
                'total_reviews' => $user->ulasan->count(),
                'average_rating_given' => round($user->ratings->avg('rating') ?? 0, 1),
                'last_login' => $user->last_login ?? null,
                'created_at' => $user->created_at,
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Assuming you have a status field in your user table
            $newStatus = $user->status == 1 ? 0 : 1;
            $user->update(['status' => $newStatus]);
            
            $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->back()->with('success', 
                'User "' . $user->nama . '" berhasil ' . $statusText . '.'
            );
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat mengubah status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        try {
            $userIds = $request->input('user_ids', []);
            
            if (empty($userIds)) {
                return redirect()->back()->with('error', 'Tidak ada user yang dipilih.');
            }
            
            // Check for users with bookings
            $usersWithBookings = User::whereIn('id', $userIds)
                ->whereHas('bookings')
                ->pluck('nama')
                ->toArray();
                
            if (!empty($usersWithBookings)) {
                return redirect()->back()->with('error', 
                    'Tidak dapat menghapus user: ' . implode(', ', $usersWithBookings) . 
                    ' karena memiliki booking.'
                );
            }
            
            DB::beginTransaction();
            
            // Delete related data
            UserTenant::whereIn('user_id', $userIds)->delete();
            UserTenantRating::whereIn('user_id', $userIds)->delete();
            UlasanTenant::whereIn('user_id', $userIds)->delete();
            
            // Delete users
            $deletedCount = User::whereIn('id', $userIds)->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                'Berhasil menghapus ' . $deletedCount . ' user.'
            );
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat menghapus user: ' . $e->getMessage()
            );
        }
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        try {
            $format = $request->get('format', 'csv'); // csv, excel
            $users = User::with(['userTenant.tenant'])->get();
            
            $data = [];
            $data[] = ['No', 'Nama', 'Email', 'No HP', 'Tipe User', 'Tenant', 'Tanggal Dibuat']; // Header
            
            foreach ($users as $index => $user) {
                $tipeUser = $user->tipe_user_id == 1 ? 'Dinas' : 
                           ($user->tipe_user_id == 2 ? 'Tenant' : 'Pengunjung');
                           
                $tenant = $user->userTenant && $user->userTenant->tenant ? 
                         $user->userTenant->tenant->nama : '-';
                
                $data[] = [
                    $index + 1,
                    $user->nama,
                    $user->email,
                    $user->no_hp ?? '-',
                    $tipeUser,
                    $tenant,
                    date('d/m/Y H:i', $user->created_at ?? time())
                ];
            }
            
            if ($format === 'csv') {
                return $this->exportToCsv($data);
            } else {
                return $this->exportToExcel($data);
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat export data: ' . $e->getMessage()
            );
        }
    }

    /**
     * Export to CSV
     */
    private function exportToCsv($data)
    {
        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to Excel (simple HTML table)
     */
    private function exportToExcel($data)
    {
        $filename = 'users_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $html = '<table border="1">';
        $html .= '<tr><th colspan="7" style="text-align:center;font-weight:bold;">Data Pengguna SIPETA</th></tr>';
        
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        
        return response($html, 200, $headers);
    }

    /**
     * Search users
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $tipeUser = $request->get('tipe_user_id', '');
            
            $users = User::with(['userTenant.tenant'])
                ->when($query, function($q) use ($query) {
                    return $q->where(function($subQ) use ($query) {
                        $subQ->where('nama', 'LIKE', "%{$query}%")
                             ->orWhere('email', 'LIKE', "%{$query}%")
                             ->orWhere('no_hp', 'LIKE', "%{$query}%");
                    });
                })
                ->when($tipeUser, function($q) use ($tipeUser) {
                    return $q->where('tipe_user_id', $tipeUser);
                })
                ->orderBy('nama', 'asc')
                ->get();
            
            $tenant = Tenant::orderBy('nama', 'asc')->get();
            
            return view('user.index', compact('users', 'tenant'))
                ->with('search_query', $query)
                ->with('search_tipe_user', $tipeUser);
                
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 
                'Terjadi kesalahan saat mencari: ' . $e->getMessage()
            );
        }
    }
}