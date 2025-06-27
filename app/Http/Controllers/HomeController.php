<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\GambarTenant;
use App\Models\Tenant;
use App\Models\TipeTenant;
use App\Models\UlasanTenant;
use App\Models\UserTenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;


class HomeController extends Controller
{
    public function home()
    {
        return view('home.beranda');
    }

    public function pariwisata(Request $request)
    {
        $query = Tenant::query();
        
        // Filter berdasarkan tipe tenant menggunakan scope
        $query->byType($request->tipe_tenant_id);
        
        // Search menggunakan scope
        $query->search($request->search);
        
        // Enhanced search functionality menggunakan helper functions jika ada search term
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            // Get all data first
            $allData = $query->get();
            
            // Apply fuzzy search menggunakan helper function
            $data = fuzzySearch($allData, $searchTerm, ['nama', 'deskripsi', 'alamat']);
            
            // Sort by relevance score
            $data = $data->sortByDesc(function($item) use ($searchTerm) {
                return calculateSearchScore($item, $searchTerm, ['nama', 'deskripsi', 'alamat']);
            });
        } else {
            // Jika tidak ada search, tampilkan semua dengan order default
            $data = $query->orderBy('id', 'desc')->get();
        }
        
        return view('home.pariwisata', compact('data'));
    }

    public function tentang_kami()
    {
        return view('home.tentang_kami');
    }

    public function booking()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        $tenant = Tenant::where('tipe_tenant_id', 1)->get();
        return view('home.booking', compact('tenant'));
    }

    private function generateBookingCode()
    {
        return strtoupper(uniqid('BOOK-'));
    }

    public function booking_post(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        $id_pariwisata = $request->get('tenant_id');
        $tanggal = $request->get('tanggal_pemesanan');
        $jumlah_tiket = $request->get('jumlah_tiket');

        $data = [
            'tenant_id' => $id_pariwisata,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah_tiket,
        ];
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->id;
        $data['kode_booking'] = $this->generateBookingCode();
        $user_tenant_boo = UserTenantBooking::create($data);

        try {
            // Konfigurasi Midtrans dengan SSL fix
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY', '');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            
            // Set CURL options untuk mengatasi SSL error
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 3,
                CURLOPT_USERAGENT => 'Laravel-Midtrans-Integration/1.0',
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
            ];

            $tenant = Tenant::where('id', $data['tenant_id'])->first();

            $params = [
                'transaction_details' => [
                    'order_id' => (string) $user_tenant_boo->id,
                    'gross_amount' => (int)($data['jumlah'] * $tenant->harga),
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name ?? 'Customer',
                    'email' => Auth::user()->email ?? 'customer@example.com',
                ],
                'item_details' => [
                    [
                        'id' => $tenant->id,
                        'price' => (int) $tenant->harga,
                        'quantity' => (int) $data['jumlah'],
                        'name' => $tenant->nama,
                    ]
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $user_tenant_boo->update(['snap_token' => $snapToken]);
            $user_tenant_boo->save();

            return redirect()->route('tiket_qr_code', ['id' => $user_tenant_boo->id]);
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Midtrans Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Hapus booking yang gagal
            $user_tenant_boo->delete();
            
            // Redirect dengan error message
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function tanggal_pemesanan(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        $id_pariwisata = $request->get('id_pariwisata');
        return view('home.tanggal_pemesanan', compact('id_pariwisata'));
    }

    public function detail_pemesanan($id)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melihat detail pemesanan.');
        }

        return view('home.detail_pemesanan');
    }

    public function tiket_qr_code()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melihat tiket.');
        }

        $id = request()->get('id');
        $data = UserTenantBooking::where('id', $id)->firstOrFail();
        $tenant = Tenant::where('id', $data->tenant_id)->first();
        $midtrans_client_key = env('MIDTRANS_CLIENT_KEY', '');

        // Ambil ulasan dan rating jika ada
        $ulasan = UlasanTenant::where('tenant_id', $tenant->id)->where('user_id', Auth::user()->id)->first();
        $rating = UserTenantRating::where('tenant_id', $tenant->id)->where('user_id', Auth::user()->id)->first();

        return view('home.tiket_qr_code', compact('data', 'tenant', 'midtrans_client_key', 'ulasan', 'rating'));
    }

    public function riwayat_pemesanan()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melihat riwayat pemesanan.');
        }

        $data = UserTenantBooking::where('user_id', Auth::user()->id)->get();
        return view('home.riwayat_pemesanan', compact('data'));
    }

    public function detail_pariwisata($id)
    {
        $data = Tenant::where('id', $id)->firstOrFail();
        $tipe_tenant = TipeTenant::where('id', $data->tipe_tenant_id)->first();
        $gambar = GambarTenant::where('tenant_id', $id)->get();
        $ulasan = UlasanTenant::where('tenant_id', $id)->get();
        $rating = UserTenantRating::where('tenant_id', $id)->get();

        // Hitung rata-rata rating
        $average_rating = $rating->avg('rating');

        $rekomendasi_restorant = Tenant::select(
            'tenant.*',
            DB::raw("(6371 * acos(cos(radians($data->latitude)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians($data->longitude)) 
                    + sin(radians($data->latitude)) 
                    * sin(radians(latitude)))) AS distance")
        )
            ->where('tipe_tenant_id', 2)
            // ->having('distance', '<', 50) // Filter jarak kurang dari 50 km
            ->orderBy('distance', 'asc')
            ->take(4) // Ambil 4 restoran terdekat
            ->get();

        $rekomendasi_hotel = Tenant::select(
            'tenant.*',
            DB::raw("(6371 * acos(cos(radians($data->latitude)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians($data->longitude)) 
                    + sin(radians($data->latitude)) 
                    * sin(radians(latitude)))) AS distance")
        )
            ->where('tipe_tenant_id', 3)
            // ->having('distance', '<', 50) // Filter jarak kurang dari 50 km
            ->orderBy('distance', 'asc')
            ->take(4) // Ambil 4 hotel terdekat
            ->get();

        return view('home.detail_pariwisata', compact('data', 'gambar', 'ulasan', 'rating', 'tipe_tenant', 'rekomendasi_restorant', 'rekomendasi_hotel', 'average_rating'));
    }

    public function ulasan(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk memberikan ulasan.');
        }

        // $request->validate([
        //     'tenant_id' => 'required|exists:tenant,id',
        //     'rating' => 'required|integer|min:1|max:5',
        //     'ulasan_tenant' => 'required|string|max:1000',
        // ]);

        // Simpan rating
        UserTenantRating::create([
            'tenant_id' => $request->tenant_id,
            'user_id' => Auth::user()->id,
            'rating' => $request->rating,
        ]);

        // Simpan ulasan
        UlasanTenant::create([
            'tenant_id' => $request->tenant_id,
            'user_id' => Auth::user()->id,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('detail_pariwisata', ['id' => $request->tenant_id])
            ->with('success', 'Ulasan dan rating berhasil disimpan.');
    }

    public function deleteUlasan($id)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $ulasan = UlasanTenant::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $rating = UserTenantRating::where('tenant_id', $ulasan->tenant_id)->where('user_id', Auth::user()->id)->first();

        // Delete rating
        if ($rating) {
            $rating->delete();
        }

        // Delete ulasan
        $ulasan->delete();

        return redirect()->route('detail_pariwisata', ['id' => $ulasan->tenant_id])
            ->with('success', 'Ulasan dan rating berhasil dihapus.');
    }

    public function login()
    {
        return view('home.login');
    }

    public function register()
    {
        return view('home.register');
    }

    public function forgot_password()
    {
        return view('home.forgot_password');
    }

    public function profile()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk melihat profil.');
        }

        return view('home.profile');
    }

    public function edit_profile()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu untuk mengedit profil.');
        }

        return view('home.edit_profile');
    }

    public function midtrans(Request $request)
    {
        $data = $request->all();

        // Check if transaction_status is 'capture' or 'settlement'
        if (
            isset($data['transaction_status']) &&
            in_array($data['transaction_status'], ['capture', 'settlement'])
        ) {
            // Find booking by order_id
            $booking = \App\Models\UserTenantBooking::where('id', $data['order_id'])->first();

            if ($booking) {
                $booking->status_pembayaran = 1;
                $booking->save();
            }
        }

        // Always respond with 200 OK to Midtrans
        return response()->json(['status' => 'success'], 200);
    }
}