<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $today = Carbon::now()->toDateString();

        $revenue = DB::table('bills')
            ->whereDate('created_at', $today)
            ->count();

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $revenueMonth = DB::table('my_courses')
            ->join('bills', 'my_courses.id', '=', 'bills.my_course_id')
            ->where('bills.status', 2)
            ->whereBetween('my_courses.ngayMua', [$currentMonthStart, $currentMonthEnd])
            ->sum('my_courses.giaCa');

        $previousMonthRevenue = DB::table('my_courses')
            ->join('bills', 'my_courses.id', '=', 'bills.my_course_id')
            ->where('bills.status', 2)
            ->whereBetween('my_courses.ngayMua', [$previousMonthStart, $previousMonthEnd])
            ->sum('my_courses.giaCa');

        $percentage = ($previousMonthRevenue != 0) ? (($revenueMonth - $previousMonthRevenue) / $previousMonthRevenue) * 100 : 0;
        // $percentage = min($percentage, 100);
        // $percentage = max($percentage, -100);

        $totalUsersMonth = DB::table('users')
            ->where('phanQuyen', 0)
            ->whereBetween('updated_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $totalUsersPreviousMonth = DB::table('users')
            ->where('phanQuyen', 0)
            ->whereBetween('updated_at', [$previousMonthStart, $previousMonthEnd])
            ->count();
        $percentageUser = ($totalUsersPreviousMonth != 0) ? (($totalUsersMonth - $totalUsersPreviousMonth) / $totalUsersPreviousMonth) * 100 : 0;
        // $percentageUser = min($percentageUser, 50);
        // $percentageUser = max($percentageUser, -50);
        View::share('totalUsersMonth', $totalUsersMonth);
        View::share('percentageUser', $percentageUser);
        View::share('revenueMonth', $revenueMonth);
        View::share('percentage', $percentage);
        View::share('revenue', $revenue);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
