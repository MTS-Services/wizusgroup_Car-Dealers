<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Container;
use App\Models\Order;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function dashboard(): View
    {
        $data['total_visitors'] = Visitor::count();
        $data['today_visitors'] = Visitor::whereDate('visited_date', Carbon::today())->count();
        $data['active_users'] = User::active()->verified()->count();
        $data['active_admins'] = Admin::active()->verified()->count();
        $data['active_orders'] = Order::where('status', Order::STATUS_SUBMITTED)->orWhere('status', Order::STATUS_CONFIRM)->orWhere('status', Order::STATUS_SHIPPED)->count();
        $data['pending_orders'] = Order::where('status', Order::STATUS_PENDING)->orWhere('status', Order::STATUS_INITIATED)->count();
        $data['cancelled_orders'] = Order::where('status', Order::STATUS_CANCELED)->count();
        $data['today_sales'] = Order::where('status', Order::STATUS_CONFIRM)->whereDate('created_at', Carbon::today())->sum('total');
        $data['active_containers'] = Container::where('status', Container::STATUS_ACTIVE)->orWhere('status', Container::STATUS_SHIPPED)->count();
        // 🔹 Monthly Sales (Eloquent only)
        $orders = Order::where('status', Order::STATUS_DELIVERED)
            ->orWhere('status', Order::STATUS_CONFIRM)
            ->orWhere('status', Order::STATUS_SHIPPED)
            ->whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('n'); // 1 to 12
            });

        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyOrders = $orders[$i] ?? collect();
            $salesData[] = $monthlyOrders->sum('total');
        }

        $data['sales_chart_data'] = json_encode($salesData);
        return view('backend.admin.dashboard.dashboard', $data);
    }
}
