<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAllowMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) 
        {
            $userRole = auth()->user()->role;
            if ($userRole == 'admin') 
            {
                return $next($request);
            }
            elseif ($userRole == 'employee' && $request->route()->named('items.search', 'items.detail')) 
            {
                // employee の場合は items.index, items.search, items.detail にのみアクセスを許可する
                return $next($request);
            }
        // ログインしていないか、ロールが admin または employee でない場合は home にリダイレクトする   
        }
        return redirect()->route('login'); 
    }
}