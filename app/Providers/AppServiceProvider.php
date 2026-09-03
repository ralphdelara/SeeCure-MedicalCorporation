<?php

namespace App\Providers;

use App\Models\Consultation;
use App\Models\ConsultationDiagnosis;
use App\Models\ConsultationSoap;
use App\Models\Prescription;
use App\Observers\ConsultationDiagnosisObserver;
use App\Observers\ConsultationObserver;
use App\Observers\ConsultationSoapObserver;
use App\Observers\PrescriptionObserver;
use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
    public function boot(): void
    {
        date_default_timezone_set('Asia/Manila');

        // citext for case insensitive - only for postgresql
        PostgresGrammar::macro('typeCitext', function (Fluent $column) {
            return 'citext';
        });
        Blueprint::macro('citext', function ($column) {
            return $this->addColumn('citext', $column);
        });

        $this->configureDefaults();
        if (config('app.env') === 'production' || config('app.env') === 'staging') {
            URL::forceScheme('https');
        }

        Consultation::observe(ConsultationObserver::class);
        ConsultationSoap::observe(ConsultationSoapObserver::class);
        ConsultationDiagnosis::observe(ConsultationDiagnosisObserver::class);
        Prescription::observe(PrescriptionObserver::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
