<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use App\Enums\AuditTypeEnum;
use App\Models\User;
use App\Models\UserAudit;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();

        // Override default login authentication
        $this->configureAuthentication();
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn (Request $request) => Inertia::render('auth/login', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'status'           => $request->session()->get('status'),
        ]));

        Fortify::confirmPasswordView(fn () => Inertia::render('auth/confirm-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

    }

    /**
     * Configure custom blind index authentication.
     */
    private function configureAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::whereBlind('username_index', 'username_index', $request->username)->first();

            // prevents the bot account login
            if ($user?->is_bot) {
                return null;
            }

            if ($user && Hash::check($request->password, $user->password)) {
                UserAudit::create([
                    'user_id'       => $user->id,
                    'audit_type_id' => AuditTypeEnum::UPDATE,
                    'data'          => json_encode([
                        'title'  => 'User has logged in to system.',
                        'fields' => [],
                    ]),
                    'created_by' => $user->id,
                ]);

                return $user;
            }

            return null;
        });
    }
}
