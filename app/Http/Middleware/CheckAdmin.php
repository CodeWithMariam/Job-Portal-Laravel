<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();
    dd($user);

    Log::info('CheckAdmin middleware is being processed.');


    Log::info('User Info:', ['user' => $user]);

    if ($user === null) {
        return redirect()->route('home'); // User not logged in, redirect to home
    }

    if ($user->role !== 'admin') {
        session()->flash('error', 'Unauthorized access');
        return redirect()->route('account.profile');
    }

    return $next($request);
}

}
