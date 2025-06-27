<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\TipeTenant;
use App\Models\GambarTenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use App\Models\UlasanTenant;
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
                'nama' => 'required|unique:tenant,nama',
                'deskripsi' => 'required',
                'alamat' => 'required',
                'tipe_tenant_id' => 'required',
            ]);

            // Gunakan DB::table karena struktur timestamp tidak standar Laravel
            $result = DB::table('tenant')->insert([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tipe_tenant_id' => $request->tipe_tenant_id,
                'harga' => $request->harga ?? 0,
                'is_status_aktif' => $request->is_status_aktif ?? 1,
                'status' => $request->status ?? 'aktif',
                'nama_pengelola' => $request->nama_pengelola ?? '',
                'created_at' => time(), // Unix timestamp untuk int(11)
                'update_at' => time(),  // Unix timestamp untuk int(11)
            ]);

            if ($result) {
                return redirect()->back()->with('success', 'Tenant berhasil ditambahkan.');
            } else {
                return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data.'])->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (isset($e->errors()['nama'])) {
                return redirect()->back()->withErrors(['nama' => 'Nama tenant sudah terdaftar.'])->withInput();
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])->withInput();
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
        $totalRevenue = $tenant->bookings->where('status_pembayaran', 1)->sum(function($booking) use ($tenant) {
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
            // Validasi untuk update (exclude current id untuk unique)
            $request->validate([
                'nama' => 'required|unique:tenant,nama,' . $id,
                'deskripsi' => 'required',
                'alamat' => 'required',
                'tipe_tenant_id' => 'required',
            ]);

            // Update menggunakan DB::table untuk menghindari masalah timestamp
            $result = DB::table('tenant')->where('id', $id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tipe_tenant_id' => $request->tipe_tenant_id,
                'harga' => $request->harga ?? 0,
                'is_status_aktif' => $request->is_status_aktif ?? 1,
                'status' => $request->status ?? 'aktif',
                'nama_pengelola' => $request->nama_pengelola ?? '',
                'update_at' => time(), // Unix timestamp untuk int(11)
            ]);

            if ($result !== false) {
                return redirect()->back()->with('success', 'Tenant berhasil diperbarui.');
            } else {
                return redirect()->back()->withErrors(['error' => 'Gagal memperbarui data.'])->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (isset($e->errors()['nama'])) {
                return redirect()->back()->withErrors(['nama' => 'Nama tenant sudah terdaftar.'])->withInput();
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Check if tenant has bookings
            $bookingCount = UserTenantBooking::where('tenant_id', $id)->count();
            if ($bookingCount > 0) {
                return redirect()->back()->withErrors(['error' => 'Tidak dapat menghapus tenant yang memiliki booking.']);
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

            // Delete tenant menggunakan DB::table
            DB::table('tenant')->where('id', $id)->delete();
            
            return redirect()->back()->with('success', 'Tenant berhasil dihapus.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus tenant: ' . $e->getMessage()]);
        }
    }

    /**
     * Update tenant status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $result = DB::table('tenant')->where('id', $id)->update([
                'status' => $request->status,
                'update_at' => time(), // Unix timestamp untuk int(11)
            ]);
            
            if ($result) {
                $statusText = $request->status ? 'diaktifkan' : 'dinonaktifkan';
                return redirect()->back()->with('success', "Tenant berhasil {$statusText}.");
            } else {
                return redirect()->back()->withErrors(['error' => 'Gagal mengubah status.']);
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage()]);
        }
    }

    /**
     * Get tenant statistics for API
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