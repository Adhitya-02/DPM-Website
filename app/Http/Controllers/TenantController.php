<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TipeTenant;
use App\Models\GambarTenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use App\Models\UlasanTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tenant::with(['tipe_tenant', 'gambar_tenant'])->orderBy('id', 'desc')->get();
        $tipeTenant = TipeTenant::all();
        return view('tenant.index', compact('data', 'tipeTenant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeTenant = TipeTenant::all();
        return view('tenant.create', compact('tipeTenant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $request->validate([
                'nama' => 'required|string|max:255|unique:tenant,nama',
                'deskripsi' => 'required|string',
                'alamat' => 'required|string|max:500',
                'tipe_tenant_id' => 'required|exists:tipe_tenant,id',
                'harga' => 'nullable|numeric|min:0',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
            ], [
                'nama.required' => 'Nama tenant wajib diisi.',
                'nama.unique' => 'Nama tenant sudah terdaftar.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'tipe_tenant_id.required' => 'Tipe tenant wajib dipilih.',
                'tipe_tenant_id.exists' => 'Tipe tenant tidak valid.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh negatif.',
                'latitude.between' => 'Latitude harus antara -90 sampai 90.',
                'longitude.between' => 'Longitude harus antara -180 sampai 180.',
            ]);

            // Simpan data tenant
            $tenant = Tenant::create($request->all());

            return redirect()->back()->with('success', 'Tenant berhasil ditambahkan.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::with([
            'tipe_tenant',
            'gambar_tenant',
            'ratings',
            'ulasan.user',
            'bookings'
        ])->findOrFail($id);
        
        // Calculate statistics
        $averageRating = $tenant->ratings->avg('rating') ?? 0;
        $totalReviews = $tenant->ratings->count();
        $totalBookings = $tenant->bookings->count();
        $totalRevenue = $tenant->bookings->where('status_pembayaran', 1)->sum(function($booking) {
            return $booking->jumlah * $tenant->harga;
        });

        return view('tenant.show', compact('tenant', 'averageRating', 'totalReviews', 'totalBookings', 'totalRevenue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tipeTenant = TipeTenant::all();
        return view('tenant.edit', compact('tenant', 'tipeTenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);

            // Validasi data
            $request->validate([
                'nama' => 'required|string|max:255|unique:tenant,nama,' . $id,
                'deskripsi' => 'required|string',
                'alamat' => 'required|string|max:500',
                'tipe_tenant_id' => 'required|exists:tipe_tenant,id',
                'harga' => 'nullable|numeric|min:0',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
            ], [
                'nama.required' => 'Nama tenant wajib diisi.',
                'nama.unique' => 'Nama tenant sudah terdaftar.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'tipe_tenant_id.required' => 'Tipe tenant wajib dipilih.',
                'tipe_tenant_id.exists' => 'Tipe tenant tidak valid.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh negatif.',
                'latitude.between' => 'Latitude harus antara -90 sampai 90.',
                'longitude.between' => 'Longitude harus antara -180 sampai 180.',
            ]);

            $tenant->update($request->all());

            return redirect()->back()->with('success', 'Tenant berhasil diperbarui.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            
            // Check if tenant has bookings
            $bookingCount = UserTenantBooking::where('tenant_id', $id)->count();
            if ($bookingCount > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus tenant yang memiliki booking.');
            }

            // Delete related data first
            UserTenantRating::where('tenant_id', $id)->delete();
            UlasanTenant::where('tenant_id', $id)->delete();
            
            // Delete tenant images
            $images = GambarTenant::where('tenant_id', $id)->get();
            foreach ($images as $image) {
                if (Storage::exists('public/gambar_tenant/' . $image->gambar)) {
                    Storage::delete('public/gambar_tenant/' . $image->gambar);
                }
                $image->delete();
            }

            // Delete tenant
            $tenant->delete();
            
            return redirect()->back()->with('success', 'Tenant berhasil dihapus.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus tenant: ' . $e->getMessage());
        }
    }

    /**
     * Update tenant status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $tenant->update(['status' => $request->status]);
            
            $statusText = $request->status ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->back()->with('success', "Tenant berhasil {$statusText}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Get tenant statistics
     */
    public function getStatistics($id)
    {
        try {
            $tenant = Tenant::with(['ratings', 'bookings'])->findOrFail($id);
            
            $statistics = [
                'total_bookings' => $tenant->bookings->count(),
                'total_reviews' => $tenant->ratings->count(),
                'average_rating' => round($tenant->ratings->avg('rating') ?? 0, 1),
                'total_revenue' => $tenant->bookings->where('status_pembayaran', 1)->sum(function($booking) use ($tenant) {
                    return $booking->jumlah * $tenant->harga;
                }),
                'monthly_bookings' => $tenant->bookings->whereMonth('created_at', now()->month)->count(),
            ];
            
            return response()->json(['success' => true, 'data' => $statistics]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}