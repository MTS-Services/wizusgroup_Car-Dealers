<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        if ($route && (str_starts_with($route->getName(), 'frontend.') || str_starts_with($route->getName(), 'user.'))) {
            $ip = $request->ip();
            $today = Carbon::today();

            $alreadyVisited = Visitor::where('ip_address', $ip)
                ->whereDate('visited_date', $today)
                ->exists();

            if (!$alreadyVisited) {
                Visitor::create([
                    'ip_address' => $ip,
                    'visited_date' => $today,
                ]);
            }
        }

        return $next($request);
    }
}
