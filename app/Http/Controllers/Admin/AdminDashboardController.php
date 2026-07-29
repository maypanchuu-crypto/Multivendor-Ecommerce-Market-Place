<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Order; // 👈 1. Order Model ကို Import လုပ်ပါ
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Stores (Vendors Count)
        $totalStores = User::where('role', 'vendor')->count();

        // 2. Active Users (Admin မှလွဲ၍ Customer ရော Vendor ပါ ရေတွက်မည်)
        $activeUsers = User::whereIn('role', ['customer', 'vendor'])->count();

        // 3. Daily Revenue (ဒီနေ့ရရှိသော 2% Admin Commission စုစုပေါင်း)
        $todayOrderItems = OrderItem::whereDate('created_at', Carbon::today())->get();

        $dailyRevenue = $todayOrderItems->sum(function ($item) {
            return $item->admin_commission > 0
                ? $item->admin_commission
                : (($item->price * $item->quantity) * 0.02);
        });

        // 4. Revenue Growth Data
        $orderItemsRaw = OrderItem::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(CASE WHEN admin_commission > 0 THEN admin_commission ELSE (price * quantity * 0.02) END) as total_commission')
            ->whereRaw('YEAR(created_at) >= ?', [2024])
            ->groupBy('year', 'month', 'day')
            ->get();

        $revenueData = [];
        $currentYear = date('Y');

        for ($y = 2024; $y <= $currentYear; $y++) {
            $revenueData[$y] = [];
            for ($m = 1; $m <= 12; $m++) {
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);
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

        // 👈 2. Blade View တွင် သုံးနိုင်ရန် $orders ကို Database မှ ဆွဲထုတ်ပါ (Eager Loading သုံးထားပါသည်)
        $orders = Order::with(['items.product', 'items.vendor'])->latest()->get();

        return view('admin.dashboard', compact(
            'totalStores',
            'activeUsers',
            'dailyRevenue',
            'revenueData',
            'registrationsData',
            'orders' // 👈 3. Compact ထဲတွင် 'orders' ကို ထည့်ပေးပါ
        ));
    }
}