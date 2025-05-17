<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $this->authorize('booking_management');

        // إحصائيات الحجوزات
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('total');
        $totalEarnings = Booking::sum('earned');

        // الحجوزات حسب الحالة
        $statusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // أكثر الفنادق حجزاً
        $topHotels = Booking::with('hotel')
            ->select('hotel_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('hotel_id')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        // إيرادات الشهر الحالي
        $currentMonthRevenue = Booking::whereMonth('created_at', now()->month)
            ->sum('total');

        // مقارنة مع الشهر الماضي
        $lastMonthRevenue = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');
         $monthlyBookings = Booking::select(
        DB::raw('DATE_FORMAT(arrival_date, "%b %Y") as label'),
                DB::raw('count(*) as count')
            )
            ->where('arrival_date', '>=', now()->subMonths(12))
            ->groupBy('label')
            ->orderByRaw('min(arrival_date)')
            ->get();

        $revenueChange = $lastMonthRevenue ?
            (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        return view('dashboard.index2', compact(
            'totalBookings',
            'totalRevenue',
            'totalEarnings',
            'statusCounts',
            'topHotels',
            'currentMonthRevenue',
            'revenueChange',
            'monthlyBookings'
        ));


    }
    // في الكونترولر
    public function bookingCharts()
    {
        $monthlyBookings = Booking::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'count' => $item->count,
                    'label' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year))
                ];
            });

        $statusData = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'monthly' => $monthlyBookings,
            'status' => $statusData
        ]);
    }

    public function car_index()
    {
        // Car booking statistics
        $totalBookings = Car::count();
        $totalRevenue = Car::sum('total');

        // Bookings by status
        $statusCounts = Car::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top car categories
        $topCategories = Car::with('category')
            ->select('category_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('category_id')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        // Current month revenue
        $currentMonthRevenue = Car::whereMonth('created_at', now()->month)
            ->sum('total');

        // Comparison with last month
        $lastMonthRevenue = Car::whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');

        $revenueChange = $lastMonthRevenue ?
            (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        return view('dashboard.car_index', compact(
            'totalBookings',
            'totalRevenue',
            'statusCounts',
            'topCategories',
            'currentMonthRevenue',
            'revenueChange'
        ));
    }

    public function carCharts()
    {
        // Monthly bookings for cars
        $monthlyBookings = Car::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'count' => $item->count,
                    'label' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y')
                ];
            });

        // Status data
        $statusData = Car::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'monthly' => $monthlyBookings,
            'status' => $statusData
        ]);
    }
}

