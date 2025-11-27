<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogRequestTime
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $startTime = now(); // Laravel's now() gives you a Carbon instance

        // Proceed with the request
        $response = $next($request);

        $end = microtime(true);
        $endTime = now();
        $duration = ($end - $start) * 1000; // Duration in milliseconds

        if ($duration < 1000) {
            $durationReadable = round($duration, 2) . ' ms';
        } elseif ($duration < 60000) {
            $durationReadable = round($duration / 1000, 2) . ' s';
        } elseif ($duration < 3600000) {
            $durationReadable = round($duration / 60000, 2) . ' min';
        } else {
            $durationReadable = round($duration / 3600000, 2) . ' h';
        }
        DB::table('request_logs')->insert([
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => $duration,
            'request_time' => $durationReadable,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response;
    }
}
