<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
            // 管理者ユーザー
            Gate::define('admin', function (User $user) {
                return $user->role === 'admin';
            });
            //管理者と社員
            Gate::define('employee',function (User $user) {
                return in_array($user->role, ['admin', 'employee']);
            });


        Paginator::useBootstrap();
    }
}
