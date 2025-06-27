<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\UserTenantBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
class TenantReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query_param_tenant_filter = $request->query('tenant_filter');
        
        if ($query_param_tenant_filter) {
            $query = "
                SELECT DATE(user_tenant_booking.tanggal) as tanggal, 
                       SUM(user_tenant_booking.jumlah) as jumlah_pengunjung, 
                       t.id, 
                       t.nama as tenant_name 
                FROM user_tenant_booking 
                JOIN tenant t ON t.id = user_tenant_booking.tenant_id
                WHERE user_tenant_booking.status = 2 AND t.id = ?
                GROUP BY DATE(user_tenant_booking.tanggal), t.id, t.nama
                ORDER BY DATE(user_tenant_booking.tanggal) DESC, SUM(user_tenant_booking.jumlah) DESC, t.nama
            ";
            $data = DB::select($query, [$query_param_tenant_filter]);
        } else {
            $query = "
                SELECT DATE(user_tenant_booking.tanggal) as tanggal, 
                       SUM(user_tenant_booking.jumlah) as jumlah_pengunjung, 
                       t.id, 
                       t.nama as tenant_name 
                FROM user_tenant_booking 
                JOIN tenant t ON t.id = user_tenant_booking.tenant_id
                WHERE user_tenant_booking.status = 2 
                GROUP BY DATE(user_tenant_booking.tanggal), t.id, t.nama
                ORDER BY DATE(user_tenant_booking.tanggal) DESC, SUM(user_tenant_booking.jumlah) DESC, t.nama
            ";
            $data = DB::select($query);
        }
        
        $tenants = Tenant::where('tipe_tenant_id', 1)->get();
        
        // Hitung statistik tambahan
        $totalRevenue = $this->getTotalRevenue($query_param_tenant_filter);
        $totalBookings = $this->getTotalBookings($query_param_tenant_filter);
        $totalVisitors = $this->getTotalVisitors($query_param_tenant_filter);
        
        return view('tenant_report.index', compact('data', 'tenants', 'totalRevenue', 'totalBookings', 'totalVisitors'));
    }

    /**
     * Get total revenue
     */
    private function getTotalRevenue($tenantFilter = null)
    {
        $query = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->where('user_tenant_booking.status', 2)
            ->where('user_tenant_booking.status_pembayaran', 1);
            
        if ($tenantFilter) {
            $query->where('tenant.id', $tenantFilter);
        }
        
        return $query->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga')) ?? 0;
    }

    /**
     * Get total bookings count
     */
    private function getTotalBookings($tenantFilter = null)
    {
        $query = DB::table('user_tenant_booking')
            ->where('user_tenant_booking.status', 2);
            
        if ($tenantFilter) {
            $query->where('user_tenant_booking.tenant_id', $tenantFilter);
        }
        
        return $query->count();
    }

    /**
     * Get total visitors
     */
    private function getTotalVisitors($tenantFilter = null)
    {
        $query = DB::table('user_tenant_booking')
            ->where('user_tenant_booking.status', 2);
            
        if ($tenantFilter) {
            $query->where('user_tenant_booking.tenant_id', $tenantFilter);
        }
        
        return $query->sum('user_tenant_booking.jumlah') ?? 0;
    }

    /**
     * Get monthly report data
     */
    public function getMonthlyReport(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $tenantId = $request->get('tenant_id');
        
        $query = "
            SELECT 
                MONTH(user_tenant_booking.tanggal) as bulan,
                YEAR(user_tenant_booking.tanggal) as tahun,
                SUM(user_tenant_booking.jumlah) as total_pengunjung,
                COUNT(user_tenant_booking.id) as total_booking,
                SUM(user_tenant_booking.jumlah * tenant.harga) as total_revenue
            FROM user_tenant_booking 
            JOIN tenant ON tenant.id = user_tenant_booking.tenant_id
            WHERE user_tenant_booking.status = 2 
            AND YEAR(user_tenant_booking.tanggal) = ?
        ";
        
        $params = [$year];
        
        if ($tenantId) {
            $query .= " AND tenant.id = ?";
            $params[] = $tenantId;
        }
        
        $query .= " GROUP BY YEAR(user_tenant_booking.tanggal), MONTH(user_tenant_booking.tanggal)
                   ORDER BY tahun DESC, bulan DESC";
        
        $data = DB::select($query, $params);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Export report to Excel/CSV
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv'); // csv or excel
        $tenantFilter = $request->get('tenant_filter');
        
        // Get data
        if ($tenantFilter) {
            $query = "
                SELECT DATE(user_tenant_booking.tanggal) as tanggal, 
                       SUM(user_tenant_booking.jumlah) as jumlah_pengunjung, 
                       t.nama as tenant_name,
                       SUM(user_tenant_booking.jumlah * t.harga) as revenue
                FROM user_tenant_booking 
                JOIN tenant t ON t.id = user_tenant_booking.tenant_id
                WHERE user_tenant_booking.status = 2 AND t.id = ?
                GROUP BY DATE(user_tenant_booking.tanggal), t.id, t.nama
                ORDER BY DATE(user_tenant_booking.tanggal) DESC
            ";
            $data = DB::select($query, [$tenantFilter]);
        } else {
            $query = "
                SELECT DATE(user_tenant_booking.tanggal) as tanggal, 
                       SUM(user_tenant_booking.jumlah) as jumlah_pengunjung, 
                       t.nama as tenant_name,
                       SUM(user_tenant_booking.jumlah * t.harga) as revenue
                FROM user_tenant_booking 
                JOIN tenant t ON t.id = user_tenant_booking.tenant_id
                WHERE user_tenant_booking.status = 2 
                GROUP BY DATE(user_tenant_booking.tanggal), t.id, t.nama
                ORDER BY DATE(user_tenant_booking.tanggal) DESC
            ";
            $data = DB::select($query);
        }
        
        // Convert to array for export
        $exportData = [];
        $exportData[] = ['Tanggal', 'Nama Tenant', 'Jumlah Pengunjung', 'Revenue']; // Header
        
        foreach ($data as $row) {
            $exportData[] = [
                $row->tanggal,
                $row->tenant_name,
                $row->jumlah_pengunjung,
                'Rp ' . number_format($row->revenue ?? 0, 0, ',', '.')
            ];
        }
        
        if ($format === 'csv') {
            return $this->exportToCsv($exportData);
        } else {
            return $this->exportToExcel($exportData);
        }
    }

    /**
     * Export to CSV
     */
    private function exportToCsv($data)
    {
        $filename = 'tenant_report_' . date('Y-m-d') . '.csv';
        
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
        $filename = 'tenant_report_' . date('Y-m-d') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $html = '<table border="1">';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . $cell . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        
        return response($html, 200, $headers);
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
        
        // Get detailed report for specific tenant
        $query = "
            SELECT DATE(user_tenant_booking.tanggal) as tanggal, 
                   SUM(user_tenant_booking.jumlah) as jumlah_pengunjung,
                   COUNT(user_tenant_booking.id) as total_booking,
                   SUM(user_tenant_booking.jumlah * tenant.harga) as revenue
            FROM user_tenant_booking 
            JOIN tenant ON tenant.id = user_tenant_booking.tenant_id
            WHERE user_tenant_booking.status = 2 AND tenant.id = ?
            GROUP BY DATE(user_tenant_booking.tanggal)
            ORDER BY DATE(user_tenant_booking.tanggal) DESC
            LIMIT 30
        ";
        
        $data = DB::select($query, [$id]);
        
        return view('tenant_report.show', compact('tenant', 'data'));
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