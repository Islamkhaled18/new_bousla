<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $period = $request->get('period', 'days');

        $stats = $this->getUserRegistrationStats($period);

        return view('dashboard', compact('stats', 'period'));
    }

    private function getUserRegistrationStats($period)
    {
        $stats = [
            'labels' => [],
            'clients' => [],
            'doctors' => []
        ];

        switch ($period) {
            case 'days':
                // آخر 7 أيام
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $stats['labels'][] = $date->format('d M');

                    $stats['clients'][] = User::where('type', 'client')
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->count();

                    $stats['doctors'][] = User::where('type', 'doctor')
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->count();
                }
                break;

            case 'months':
                // آخر 12 شهر
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $stats['labels'][] = $date->format('M Y');

                    $stats['clients'][] = User::where('type', 'client')
                        ->whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();

                    $stats['doctors'][] = User::where('type', 'doctor')
                        ->whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
                }
                break;

            case 'years':
                // آخر 5 سنين
                for ($i = 4; $i >= 0; $i--) {
                    $year = Carbon::now()->subYears($i)->year;
                    $stats['labels'][] = $year;

                    $stats['clients'][] = User::where('type', 'client')
                        ->whereYear('created_at', $year)
                        ->count();

                    $stats['doctors'][] = User::where('type', 'doctor')
                        ->whereYear('created_at', $year)
                        ->count();
                }
                break;
        }

        return $stats;
    }
}
