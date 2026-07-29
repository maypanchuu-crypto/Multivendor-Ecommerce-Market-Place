<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Stores (Vendors Count)
        $totalStores = User::where('role', 'vendor')->count();

        // 2. Active Users (Admin မှလွဲ၍ Customer ရော Vendor ပါ ရေတွက်မည်)
        $activeUsers = User::whereIn('role', ['customer', 'vendor'])->count();

        // 3. Daily Revenue (ဒီနေ့အတွက် paid ဖြစ်ပြီးသော Order များမှရရှိသော 2% Admin Commission စုစုပေါင်း)
        $todayOrderItems = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'paid');
        })->whereDate('created_at', Carbon::today())->get();

        $dailyRevenue = $todayOrderItems->sum(function ($item) {
            // admin_commission ရှိရင် ၎င်းကိုယူမည်၊ မရှိရင် (Price * Qty) ရဲ့ 2% တွက်မည်
            return $item->admin_commission > 0
                ? $item->admin_commission
                : (($item->price * $item->quantity) * 0.02);
        });

        // 4. Revenue Growth Data (ရက်အလိုက် paid ဖြစ်ပြီးသော Admin Commission အစစ်ဆွဲထုတ်ခြင်း)
        $orderItemsRaw = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'paid');
        })
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(CASE WHEN admin_commission > 0 THEN admin_commission ELSE (price * quantity * 0.02) END) as total_commission')
            ->whereRaw('YEAR(created_at) >= ?', [2024])
            ->groupBy('year', 'month', 'day')
            ->get();

        $revenueData = [];
        $currentYear = date('Y');

        for ($y = 2024; $y <= $currentYear; $y++) {
            $revenueData[$y] = [];
            for ($m = 1; $m <= 12; $m++) {
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);
                // လတစ်လစီအတွက် ရက်အလိုက် Default 0 သတ်မှတ်မည်
                $revenueData[$y][$m] = array_fill(1, $daysInMonth, 0);
            }
        }

        foreach ($orderItemsRaw as $data) {
            if (isset($revenueData[$data->year][$data->month][$data->day])) {
                $revenueData[$data->year][$data->month][$data->day] = round($data->total_commission, 2);
            }
        }

        // 5. Registrations Growth Chart Data
        $registrationsRaw = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->whereRaw('YEAR(created_at) >= ?', [2024])
            ->groupBy('year', 'month')
            ->get();

        $registrationsData = [];
        for ($y = 2024; $y <= $currentYear; $y++) {
            $registrationsData[$y] = array_fill(0, 12, 0);
        }

        foreach ($registrationsRaw as $data) {
            if (isset($registrationsData[$data->year])) {
                $registrationsData[$data->year][$data->month - 1] = $data->count;
            }
        }

        return view('admin.dashboard', compact(
            'totalStores',
            'activeUsers',
            'dailyRevenue',
            'revenueData',
            'registrationsData'
        ));
    }
}