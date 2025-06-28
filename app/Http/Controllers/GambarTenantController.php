<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\GambarTenant;
use App\Models\Tenant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GambarTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('gambar_tenant.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->back()->with('info', 'Gunakan menu edit untuk mengelola gambar tenant.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->tambah_gambar($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        $data = GambarTenant::where('tenant_id', $id)->get();
        return view('gambar_tenant.show', compact('data', 'tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $data = GambarTenant::where('tenant_id', $id)->orderBy('is_gambar_utama', 'desc')->get();
            return view('gambar_tenant.index', compact('data', 'id', 'tenant'));
        } catch (\Exception $e) {
            return redirect()->route('tenant.index')->with('error', 'Tenant tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $gambar = GambarTenant::findOrFail($id);
            
            // Update status gambar utama
            if ($request->has('set_as_main')) {
                // Reset semua gambar utama untuk tenant ini
                GambarTenant::where('tenant_id', $gambar->tenant_id)
                    ->update(['is_gambar_utama' => 0]);
                
                // Set gambar ini sebagai utama
                $gambar->update(['is_gambar_utama' => 1]);
                
                return redirect()->back()->with('success', 'Gambar berhasil dijadikan gambar utama.');
            }
            
            return redirect()->back()->with('info', 'Tidak ada perubahan yang dilakukan.');
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
            $gambar = GambarTenant::findOrFail($id);
            $tenant_id = $gambar->tenant_id;
            
            // Hapus file fisik dari storage
            $filePath = public_path('gambar_tenant/' . $gambar->gambar);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            
            // Hapus record dari database
            $gambar->delete();
            
            return redirect()->route('gambar_tenant.edit', $tenant_id)
                ->with('success', 'Gambar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus gambar: ' . $e->getMessage());
        }
    }

    /**
     * Upload gambar tenant
     */
    public function tambah_gambar(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tenant_id' => 'required|exists:tenant,id',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
                'gambar_utama' => 'nullable'
            ], [
                'gambar.required' => 'File gambar wajib dipilih.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif.',
                'gambar.max' => 'Ukuran gambar maksimal 5MB.',
                'tenant_id.exists' => 'Tenant tidak ditemukan.'
            ]);

            $tenant_id = $request->tenant_id;
            $gambar = $request->file('gambar');
            $gambar_utama = $request->has('gambar_utama') ? 1 : 0;
            
            // Generate nama file yang unique
            $nama_gambar = $tenant_id . '_' . time() . '_' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
            $nama_gambar .= '.' . $gambar->getClientOriginalExtension();

            // Pastikan direktori ada
            $uploadPath = public_path('gambar_tenant');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Upload file
            $gambar->move($uploadPath, $nama_gambar);

            // Jika ini gambar utama, reset gambar utama lainnya
            if ($gambar_utama) {
                GambarTenant::where('tenant_id', $tenant_id)
                    ->update(['is_gambar_utama' => 0]);
            }

            // Simpan ke database
            $data = [
                'tenant_id' => $tenant_id,
                'gambar' => $nama_gambar,
                'is_gambar_utama' => $gambar_utama
            ];
            
            $create = GambarTenant::create($data);
            
            if ($create) {
                return redirect()->route('gambar_tenant.edit', $tenant_id)
                    ->with('success', 'Gambar berhasil diupload.');
            } else {
                return redirect()->route('gambar_tenant.edit', $tenant_id)
                    ->with('error', 'Gagal menyimpan gambar ke database.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat upload gambar: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Set gambar sebagai gambar utama
     */
    public function setAsMain(Request $request, $id)
    {
        try {
            $gambar = GambarTenant::findOrFail($id);
            
            // Reset semua gambar utama untuk tenant ini
            GambarTenant::where('tenant_id', $gambar->tenant_id)
                ->update(['is_gambar_utama' => 0]);
            
            // Set gambar ini sebagai utama
            $gambar->update(['is_gambar_utama' => 1]);
            
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dijadikan gambar utama.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get gambar untuk AJAX
     */
    public function getImages($tenantId)
    {
        try {
            $images = GambarTenant::where('tenant_id', $tenantId)
                ->orderBy('is_gambar_utama', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $images
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}