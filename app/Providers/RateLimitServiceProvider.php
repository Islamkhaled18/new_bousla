<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('clients.login', function (Request $request) {
            $credential = $request->filled('email')
                ? $request->input('email')
                : $request->input('phone');

            return Limit::perMinute(5)
                ->by(($credential ?? 'unknown') . '|' . $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'محاولات تسجيل دخول كتيرة. حاول تاني بعد دقيقة.'
                    ], 429);
                });
        });

        RateLimiter::for('clients.register', function (Request $request) {
            return Limit::perHour(3)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'تم تسجيل حسابات كتير. حاول تاني بعد ساعة.'
                    ], 429);
                });
        });
    }
}
