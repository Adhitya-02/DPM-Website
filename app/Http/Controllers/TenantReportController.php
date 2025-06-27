<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Tenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TenantReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenantFilter = $request->query('tenant_filter');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $reportType = $request->query('report_type', 'visitor'); // visitor, revenue, rating
        
        // Build query conditions
        $conditions = ['user_tenant_booking.status = 2']; // Only confirmed visits
        $params = [];
        
        if ($tenantFilter) {
            $conditions[] = 't.id = ?';
            $params[] = $tenantFilter;
        }
        
        if ($dateFrom) {
            $conditions[] = 'DATE(tanggal) >= ?';
            $params[] = $dateFrom;
        }
        
        if ($dateTo) {
            $conditions[] = 'DATE(tanggal) <= ?';
            $params[] = $dateTo;
        }
        
        $whereClause = implode(' AND ', $conditions);
        
        // Generate different reports based on type
        switch ($reportType) {
            case 'revenue':
                $data = $this->getRevenueReport($whereClause, $params);
                break;
            case 'rating':
                $data = $this->getRatingReport($whereClause, $params);
                break;
            default:
                $data = $this->getVisitorReport($whereClause, $params);
                break;
        }
        
        $tenants = Tenant::where('tipe_tenant_id', 1)->orderBy('nama')->get();
        
        // Additional statistics
        $statistics = $this->getStatistics($tenantFilter, $dateFrom, $dateTo);
        
        return view('tenant_report.index', compact('data', 'tenants', 'statistics', 'reportType'));
    }
    
    /**
     * Get visitor report data
     */
    private function getVisitorReport($whereClause, $params)
    {
        $query = "
            SELECT 
                DATE(tanggal) as tanggal, 
                SUM(jumlah) as jumlah_pengunjung, 
                t.id, 
                t.nama as tenant_name,
                COUNT(DISTINCT user_tenant_booking.id) as total_transaksi
            FROM user_tenant_booking 
            JOIN tenant t ON t.id = user_tenant_booking.tenant_id
            WHERE {$whereClause}
            GROUP BY DATE(tanggal), t.id, t.nama
            ORDER BY DATE(tanggal) DESC, SUM(jumlah) DESC, t.nama
        ";
        
        return DB::select($query, $params);
    }
    
    /**
     * Get revenue report data
     */
    private function getRevenueReport($whereClause, $params)
    {
        $query = "
            SELECT 
                DATE(tanggal) as tanggal,
                SUM(user_tenant_booking.jumlah * t.harga) as total_pendapatan,
                SUM(jumlah) as jumlah_pengunjung,
                t.id,
                t.nama as tenant_name,
                t.harga as harga_tiket
            FROM user_tenant_booking 
            JOIN tenant t ON t.id = user_tenant_booking.tenant_id
            WHERE {$whereClause} AND user_tenant_booking.status_pembayaran = 1
            GROUP BY DATE(tanggal), t.id, t.nama, t.harga
            ORDER BY DATE(tanggal) DESC, total_pendapatan DESC, t.nama
        ";
        
        return DB::select($query, $params);
    }
    
    /**
     * Get rating report data
     */
    private function getRatingReport($whereClause, $params)
    {
        // Modify where clause for rating table
        $ratingWhereClause = str_replace('user_tenant_booking.', 'utb.', $whereClause);
        
        $query = "
            SELECT 
                DATE(utb.tanggal) as tanggal,
                AVG(utr.rating) as rata_rata_rating,
                COUNT(utr.rating) as jumlah_review,
                t.id,
                t.nama as tenant_name,
                SUM(utb.jumlah) as jumlah_pengunjung
            FROM user_tenant_rating utr
            JOIN tenant t ON t.id = utr.tenant_id
            JOIN user_tenant_booking utb ON utb.tenant_id = t.id AND utb.user_id = utr.user_id
            WHERE {$ratingWhereClause}
            GROUP BY DATE(utb.tanggal), t.id, t.nama
            ORDER BY DATE(utb.tanggal) DESC, rata_rata_rating DESC, t.nama
        ";
        
        return DB::select($query, $params);
    }
    
    /**
     * Get summary statistics
     */
    private function getStatistics($tenantFilter = null, $dateFrom = null, $dateTo = null)
    {
        // Base query untuk semua kalkulasi
        $baseQuery = UserTenantBooking::where('status', 2);
        
        if ($tenantFilter) {
            $baseQuery->where('tenant_id', $tenantFilter);
        }
        
        if ($dateFrom) {
            $baseQuery->whereDate('tanggal', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $baseQuery->whereDate('tanggal', '<=', $dateTo);
        }
        
        // Total pengunjung
        $totalPengunjung = (clone $baseQuery)->sum('jumlah');
        
        // Total transaksi
        $totalTransaksi = (clone $baseQuery)->count();
        
        // Total pendapatan - join dengan tenant untuk mendapatkan harga
        $totalPendapatan = (clone $baseQuery)->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                                           ->where('user_tenant_booking.status_pembayaran', 1)
                                           ->selectRaw('SUM(user_tenant_booking.jumlah * tenant.harga) as total')
                                           ->value('total') ?? 0;
        
        // Rata-rata pengunjung harian
        $dailyStats = (clone $baseQuery)->selectRaw('DATE(tanggal) as date, SUM(jumlah) as daily_visitors')
                                       ->groupBy(DB::raw('DATE(tanggal)'))
                                       ->get();
        
        $rataRataPengunjungHarian = $dailyStats->count() > 0 ? $dailyStats->avg('daily_visitors') : 0;
        
        // Tenant terpopuler
        $tenantTerpopuler = UserTenantBooking::where('status', 2)
                                           ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id');
        
        if ($dateFrom) {
            $tenantTerpopuler->whereDate('user_tenant_booking.tanggal', '>=', $dateFrom);
        }
        if ($dateTo) {
            $tenantTerpopuler->whereDate('user_tenant_booking.tanggal', '<=', $dateTo);
        }
        
        $tenantTerpopuler = $tenantTerpopuler->selectRaw('tenant.nama, SUM(user_tenant_booking.jumlah) as total_visitors')
                                          ->groupBy('tenant.id', 'tenant.nama')
                                          ->orderByDesc('total_visitors')
                                          ->first();
        
        return [
            'total_pengunjung' => $totalPengunjung ?? 0,
            'total_transaksi' => $totalTransaksi ?? 0,
            'total_pendapatan' => $totalPendapatan ?? 0,
            'rata_rata_pengunjung_harian' => round($rataRataPengunjungHarian, 1),
            'tenant_terpopuler' => $tenantTerpopuler
        ];
    }

    /**
     * Export report to CSV
     */
    public function exportCsv(Request $request)
    {
        $tenantFilter = $request->query('tenant_filter');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $reportType = $request->query('report_type', 'visitor');
        
        // Build query conditions (same as index method)
        $conditions = ['user_tenant_booking.status = 2'];
        $params = [];
        
        if ($tenantFilter) {
            $conditions[] = 't.id = ?';
            $params[] = $tenantFilter;
        }
        
        if ($dateFrom) {
            $conditions[] = 'DATE(tanggal) >= ?';
            $params[] = $dateFrom;
        }
        
        if ($dateTo) {
            $conditions[] = 'DATE(tanggal) <= ?';
            $params[] = $dateTo;
        }
        
        $whereClause = implode(' AND ', $conditions);
        
        // Get data based on report type
        switch ($reportType) {
            case 'revenue':
                $data = $this->getRevenueReport($whereClause, $params);
                $filename = 'laporan_pendapatan_' . date('Y-m-d') . '.csv';
                break;
            case 'rating':
                $data = $this->getRatingReport($whereClause, $params);
                $filename = 'laporan_rating_' . date('Y-m-d') . '.csv';
                break;
            default:
                $data = $this->getVisitorReport($whereClause, $params);
                $filename = 'laporan_pengunjung_' . date('Y-m-d') . '.csv';
                break;
        }
        
        // Create CSV content
        $csvContent = $this->generateCsvContent($data, $reportType);
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    
    /**
     * Generate CSV content based on report type
     */
    private function generateCsvContent($data, $reportType)
    {
        $output = fopen('php://temp', 'w');
        
        // Write headers based on report type
        switch ($reportType) {
            case 'revenue':
                fputcsv($output, ['Tanggal', 'Nama Tenant', 'Jumlah Pengunjung', 'Harga Tiket', 'Total Pendapatan']);
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row->tanggal,
                        $row->tenant_name,
                        $row->jumlah_pengunjung,
                        'Rp ' . number_format($row->harga_tiket, 0, ',', '.'),
                        'Rp ' . number_format($row->total_pendapatan, 0, ',', '.')
                    ]);
                }
                break;
                
            case 'rating':
                fputcsv($output, ['Tanggal', 'Nama Tenant', 'Jumlah Pengunjung', 'Jumlah Review', 'Rata-rata Rating']);
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row->tanggal,
                        $row->tenant_name,
                        $row->jumlah_pengunjung,
                        $row->jumlah_review,
                        number_format($row->rata_rata_rating, 1)
                    ]);
                }
                break;
                
            default:
                fputcsv($output, ['Tanggal', 'Nama Tenant', 'Jumlah Pengunjung', 'Total Transaksi']);
                foreach ($data as $row) {
                    fputcsv($output, [
                        $row->tanggal,
                        $row->tenant_name,
                        $row->jumlah_pengunjung,
                        $row->total_transaksi
                    ]);
                }
                break;
        }
        
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);
        
        return $csvContent;
    }

    /**
     * Get chart data for dashboard
     */
    public function getChartData(Request $request)
    {
        $tenantFilter = $request->query('tenant_filter');
        $days = $request->query('days', 30); // Default 30 days
        
        $query = UserTenantBooking::where('status', 2)
                    ->where('tanggal', '>=', Carbon::now()->subDays($days));
        
        if ($tenantFilter) {
            $query->where('tenant_id', $tenantFilter);
        }
        
        $chartData = $query->selectRaw('DATE(tanggal) as date, SUM(jumlah) as visitors')
                          ->groupBy(DB::raw('DATE(tanggal)'))
                          ->orderBy('date')
                          ->get();
        
        return response()->json([
            'success' => true,
            'data' => $chartData
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        
        // Get detailed statistics for specific tenant
        $statistics = [
            'total_pengunjung' => UserTenantBooking::where('tenant_id', $id)
                                                 ->where('status', 2)
                                                 ->sum('jumlah'),
            'total_pendapatan' => UserTenantBooking::where('tenant_id', $id)
                                    ->where('status', 2)
                                    ->where('status_pembayaran', 1)
                                    ->sum(DB::raw('jumlah * ' . ($tenant->harga ?? 0))),
            'rata_rata_rating' => UserTenantRating::where('tenant_id', $id)->avg('rating') ?? 0,
            'total_review' => UserTenantRating::where('tenant_id', $id)->count(),
        ];
        
        // Monthly data for the last 12 months
        $monthlyData = UserTenantBooking::where('tenant_id', $id)
                        ->where('status', 2)
                        ->where('tanggal', '>=', Carbon::now()->subMonths(12))
                        ->selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, SUM(jumlah) as visitors')
                        ->groupBy('year', 'month')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
        
        return view('tenant_report.show', compact('tenant', 'statistics', 'monthlyData'));
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
}