<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tenant;
use App\Models\UserTenantBooking;
use App\Models\UserTenantRating;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with comprehensive statistics
     */
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::count();
        $totalAdmins = User::where('tipe_user_id', 1)->count();
        $totalTenantManagers = User::where('tipe_user_id', 2)->count();
        $totalCustomers = User::where('tipe_user_id', 3)->count();
        $totalDestinations = Tenant::count();
        
        // Booking Statistics
        $totalBookings = UserTenantBooking::count();
        $paidBookings = UserTenantBooking::where('status_pembayaran', 1)->count();
        $unpaidBookings = UserTenantBooking::where('status_pembayaran', 0)->count();
        $completedBookings = UserTenantBooking::where('status', 2)->count();
        
        // Revenue Statistics
        $totalRevenue = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->where('user_tenant_booking.status_pembayaran', 1)
            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
            
        $monthlyRevenue = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->where('user_tenant_booking.status_pembayaran', 1)
            ->whereMonth('user_tenant_booking.tanggal', now()->month)
            ->whereYear('user_tenant_booking.tanggal', now()->year)
            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
            
        $todayRevenue = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->where('user_tenant_booking.status_pembayaran', 1)
            ->whereDate('user_tenant_booking.tanggal', today())
            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
        
        // Calculate average transaction
        $avgTransaction = $paidBookings > 0 ? $totalRevenue / $paidBookings : 0;
        
        // Monthly Growth Statistics
        $thisMonth = now();
        $lastMonth = now()->subMonth();
        
        $thisMonthBookings = UserTenantBooking::whereMonth('tanggal', $thisMonth->month)
            ->whereYear('tanggal', $thisMonth->year)->count();
        $lastMonthBookings = UserTenantBooking::whereMonth('tanggal', $lastMonth->month)
            ->whereYear('tanggal', $lastMonth->year)->count();
        
        $bookingGrowth = $lastMonthBookings > 0 ? 
            (($thisMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100 : 0;
        
        // Recent Activities (Latest 10 bookings)
        $recentActivities = UserTenantBooking::with(['user', 'tenant'])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
        
        // Top Destinations by visitors
        $topDestinations = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->select(
                'tenant.id',
                'tenant.nama',
                DB::raw('SUM(user_tenant_booking.jumlah) as total_visitors'),
                DB::raw('COUNT(user_tenant_booking.id) as total_bookings'),
                DB::raw('SUM(CASE WHEN user_tenant_booking.status_pembayaran = 1 THEN user_tenant_booking.jumlah * tenant.harga ELSE 0 END) as total_revenue')
            )
            ->groupBy('tenant.id', 'tenant.nama')
            ->orderBy('total_visitors', 'desc')
            ->take(5)
            ->get();
        
        // Monthly booking trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bookings = UserTenantBooking::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->count();
            
            $revenue = DB::table('user_tenant_booking')
                ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                ->where('user_tenant_booking.status_pembayaran', 1)
                ->whereMonth('user_tenant_booking.tanggal', $date->month)
                ->whereYear('user_tenant_booking.tanggal', $date->year)
                ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
                
            $monthlyTrend[] = [
                'month' => $date->format('M Y'),
                'bookings' => $bookings,
                'revenue' => $revenue
            ];
        }
        
        // Destination type statistics
        $destinationTypes = DB::table('tenant')
            ->join('tipe_tenant', 'tipe_tenant.id', '=', 'tenant.tipe_tenant_id')
            ->select('tipe_tenant.nama as type_name', DB::raw('COUNT(tenant.id) as count'))
            ->groupBy('tipe_tenant.id', 'tipe_tenant.nama')
            ->get();
        
        // Pending payments that need attention
        $pendingPayments = UserTenantBooking::with(['user', 'tenant'])
            ->where('status_pembayaran', 0)
            ->where('tanggal', '>=', now()->subDays(7)) // Last 7 days
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
        
        // System alerts
        $alerts = [];
        
        // Check for high number of unpaid bookings
        if ($unpaidBookings > ($totalBookings * 0.3)) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "Perhatian: {$unpaidBookings} booking belum terbayar dari total {$totalBookings} booking",
                'action' => 'Tinjau pembayaran yang tertunda'
            ];
        }
        
        // Check for new destinations without bookings
        $destinationsWithoutBookings = Tenant::whereDoesntHave('bookings')->count();
        if ($destinationsWithoutBookings > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$destinationsWithoutBookings} destinasi belum memiliki booking",
                'action' => 'Promosikan destinasi baru'
            ];
        }
        
        return view('dashboard.index', compact(
            'totalUsers',
            'totalAdmins', 
            'totalTenantManagers',
            'totalCustomers',
            'totalDestinations',
            'totalBookings',
            'paidBookings',
            'unpaidBookings',
            'completedBookings',
            'totalRevenue',
            'monthlyRevenue',
            'todayRevenue',
            'avgTransaction',
            'bookingGrowth',
            'recentActivities',
            'topDestinations',
            'monthlyTrend',
            'destinationTypes',
            'pendingPayments',
            'alerts'
        ));
    }

    /**
     * Get dashboard data for AJAX requests
     */
    public function getData(Request $request)
    {
        $period = $request->get('period', 'month'); // day, week, month, year
        
        switch ($period) {
            case 'day':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default: // month
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
        }
        
        $bookings = UserTenantBooking::whereBetween('tanggal', [$startDate, $endDate])->count();
        $revenue = DB::table('user_tenant_booking')
            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
            ->where('user_tenant_booking.status_pembayaran', 1)
            ->whereBetween('user_tenant_booking.tanggal', [$startDate, $endDate])
            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
        
        return response()->json([
            'period' => $period,
            'bookings' => $bookings,
            'revenue' => $revenue,
            'formatted_revenue' => 'Rp ' . number_format($revenue, 0, ',', '.')
        ]);
    }

    /**
     * Get chart data for dashboard
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'bookings'); // bookings, revenue, visitors
        $period = $request->get('period', 'month'); // day, week, month
        
        $data = [];
        $labels = [];
        
        switch ($period) {
            case 'day':
                // Last 7 days
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $labels[] = $date->format('d M');
                    
                    if ($type === 'bookings') {
                        $data[] = UserTenantBooking::whereDate('tanggal', $date)->count();
                    } elseif ($type === 'revenue') {
                        $revenue = DB::table('user_tenant_booking')
                            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                            ->where('user_tenant_booking.status_pembayaran', 1)
                            ->whereDate('user_tenant_booking.tanggal', $date)
                            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
                        $data[] = $revenue;
                    } else { // visitors
                        $visitors = UserTenantBooking::whereDate('tanggal', $date)
                            ->sum('jumlah');
                        $data[] = $visitors;
                    }
                }
                break;
                
            case 'week':
                // Last 4 weeks
                for ($i = 3; $i >= 0; $i--) {
                    $startWeek = now()->subWeeks($i)->startOfWeek();
                    $endWeek = now()->subWeeks($i)->endOfWeek();
                    $labels[] = 'Week ' . $startWeek->format('d M');
                    
                    if ($type === 'bookings') {
                        $data[] = UserTenantBooking::whereBetween('tanggal', [$startWeek, $endWeek])->count();
                    } elseif ($type === 'revenue') {
                        $revenue = DB::table('user_tenant_booking')
                            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                            ->where('user_tenant_booking.status_pembayaran', 1)
                            ->whereBetween('user_tenant_booking.tanggal', [$startWeek, $endWeek])
                            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
                        $data[] = $revenue;
                    } else {
                        $visitors = UserTenantBooking::whereBetween('tanggal', [$startWeek, $endWeek])
                            ->sum('jumlah');
                        $data[] = $visitors;
                    }
                }
                break;
                
            default: // month
                // Last 6 months
                for ($i = 5; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $labels[] = $date->format('M Y');
                    
                    if ($type === 'bookings') {
                        $data[] = UserTenantBooking::whereMonth('tanggal', $date->month)
                            ->whereYear('tanggal', $date->year)->count();
                    } elseif ($type === 'revenue') {
                        $revenue = DB::table('user_tenant_booking')
                            ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                            ->where('user_tenant_booking.status_pembayaran', 1)
                            ->whereMonth('user_tenant_booking.tanggal', $date->month)
                            ->whereYear('user_tenant_booking.tanggal', $date->year)
                            ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga'));
                        $data[] = $revenue;
                    } else {
                        $visitors = UserTenantBooking::whereMonth('tanggal', $date->month)
                            ->whereYear('tanggal', $date->year)
                            ->sum('jumlah');
                        $data[] = $visitors;
                    }
                }
                break;
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'type' => $type,
            'period' => $period
        ]);
    }

    /**
     * Export dashboard report
     */
    public function exportReport(Request $request)
    {
        $format = $request->get('format', 'pdf'); // pdf, excel, csv
        $period = $request->get('period', 'month');
        
        // Get data based on period
        switch ($period) {
            case 'day':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
        }
        
        $reportData = [
            'period' => $period,
            'start_date' => $startDate->format('d M Y'),
            'end_date' => $endDate->format('d M Y'),
            'total_bookings' => UserTenantBooking::whereBetween('tanggal', [$startDate, $endDate])->count(),
            'paid_bookings' => UserTenantBooking::whereBetween('tanggal', [$startDate, $endDate])
                ->where('status_pembayaran', 1)->count(),
            'total_revenue' => DB::table('user_tenant_booking')
                ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                ->where('user_tenant_booking.status_pembayaran', 1)
                ->whereBetween('user_tenant_booking.tanggal', [$startDate, $endDate])
                ->sum(DB::raw('user_tenant_booking.jumlah * tenant.harga')),
            'total_visitors' => UserTenantBooking::whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah'),
            'top_destinations' => DB::table('user_tenant_booking')
                ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                ->whereBetween('user_tenant_booking.tanggal', [$startDate, $endDate])
                ->select(
                    'tenant.nama',
                    DB::raw('SUM(user_tenant_booking.jumlah) as visitors'),
                    DB::raw('COUNT(user_tenant_booking.id) as bookings')
                )
                ->groupBy('tenant.id', 'tenant.nama')
                ->orderBy('visitors', 'desc')
                ->take(10)
                ->get()
        ];
        
        if ($format === 'pdf') {
            return $this->exportToPdf($reportData);
        } elseif ($format === 'excel') {
            return $this->exportToExcel($reportData);
        } else {
            return $this->exportToCsv($reportData);
        }
    }

    private function exportToPdf($data)
    {
        // Simple HTML to PDF export
        $html = view('dashboard.report_pdf', compact('data'))->render();
        
        $filename = 'dashboard_report_' . $data['period'] . '_' . date('Y-m-d') . '.pdf';
        
        // For production, you might want to use a proper PDF library like DOMPDF or TCPDF
        return response($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    private function exportToExcel($data)
    {
        $filename = 'dashboard_report_' . $data['period'] . '_' . date('Y-m-d') . '.xls';
        
        $html = '<table border="1">';
        $html .= '<tr><th>Periode</th><td>' . ucfirst($data['period']) . '</td></tr>';
        $html .= '<tr><th>Tanggal</th><td>' . $data['start_date'] . ' - ' . $data['end_date'] . '</td></tr>';
        $html .= '<tr><th>Total Booking</th><td>' . $data['total_bookings'] . '</td></tr>';
        $html .= '<tr><th>Booking Terbayar</th><td>' . $data['paid_bookings'] . '</td></tr>';
        $html .= '<tr><th>Total Pendapatan</th><td>Rp ' . number_format($data['total_revenue'], 0, ',', '.') . '</td></tr>';
        $html .= '<tr><th>Total Pengunjung</th><td>' . $data['total_visitors'] . '</td></tr>';
        $html .= '</table>';
        
        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    private function exportToCsv($data)
    {
        $filename = 'dashboard_report_' . $data['period'] . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Dashboard Report - SIPETA']);
            fputcsv($file, ['Periode', ucfirst($data['period'])]);
            fputcsv($file, ['Tanggal', $data['start_date'] . ' - ' . $data['end_date']]);
            fputcsv($file, []);
            
            // Summary
            fputcsv($file, ['Metrik', 'Nilai']);
            fputcsv($file, ['Total Booking', $data['total_bookings']]);
            fputcsv($file, ['Booking Terbayar', $data['paid_bookings']]);
            fputcsv($file, ['Total Pendapatan', 'Rp ' . number_format($data['total_revenue'], 0, ',', '.')]);
            fputcsv($file, ['Total Pengunjung', $data['total_visitors']]);
            fputcsv($file, []);
            
            // Top Destinations
            fputcsv($file, ['Destinasi Terpopuler']);
            fputcsv($file, ['Nama Destinasi', 'Pengunjung', 'Booking']);
            foreach ($data['top_destinations'] as $dest) {
                fputcsv($file, [$dest->nama, $dest->visitors, $dest->bookings]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}