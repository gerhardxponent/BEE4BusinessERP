<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // Enforce that the user must be enabled (enabled === 1)
                if ((int)$user->enabled !== 1) {
                    Log::warning('Disabled user attempted login.', ['email' => $user->email]);
                    return null;
                }

                // Handle cookies as before
                if (Cookie::has('email')) {
                    if (Cookie::get('email') != $user->email) {
                        Cookie::expire('email');
                        Cookie::has('msEmail') && Cookie::expire('msEmail');
                        Cookie::has('accessToken') && Cookie::expire('accessToken');
                        Cookie::has('refreshToken') && Cookie::expire('refreshToken');
                        Cookie::has('tokenExpires') && Cookie::expire('tokenExpires');

                        Cookie::queue('email', $user->email, 1440 * 90);
                    }
                } else {
                    Cookie::queue('email', $user->email, 1440 * 90);
                }

                return $user;
            }
            return null;
        });
    }
}