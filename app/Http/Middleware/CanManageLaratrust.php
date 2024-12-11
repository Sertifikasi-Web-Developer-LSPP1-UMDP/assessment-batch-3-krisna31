<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageLaratrust
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        if ($user && $user->hasPermission('manage-laratrust')) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Anda Tidak Berhak Mengakses Resource Ini');
    }
}
