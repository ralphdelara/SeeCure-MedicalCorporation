<?php

namespace App\Providers;

use App\Models\Billing;
use App\Models\BillingDetail;
use App\Models\Cashier;
use App\Models\Consultation;
use App\Models\ConsultationSoap;
use App\Models\Diagnosis;
use App\Models\Inventory;
use App\Models\InventoryStockMovement;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Models\Prescription;
use App\Models\User;
use App\Models\Visit;
use App\Observers\BillingDetailObserver;
use App\Observers\BillingObserver;
use App\Observers\CashierObserver;
use App\Observers\ConsultationObserver;
use App\Observers\ConsultationSoapObserver;
use App\Observers\DiagnosisObserver;
use App\Observers\InventoryObserver;
use App\Observers\InventoryStockMovementObserver;
use App\Observers\PatientObserver;
use App\Observers\PaymentObserver;
use App\Observers\PharmacyDetailObserver;
use App\Observers\PharmacyObserver;
use App\Observers\PrescriptionObserver;
use App\Observers\UserObserver;
use App\Observers\VisitObserver;
use Carbon\CarbonImmutable;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

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
        Auth::macro('systemUser', function () {
            // If a user is logged in, return that user instance
            if (Auth::check()) {
                return Auth::user();
            }

            // Using ->first() directly avoids loading ALL users into memory via ::all()
            return User::first();
        });

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

        Visit::observe(VisitObserver::class);
        Consultation::observe(ConsultationObserver::class);
        ConsultationSoap::observe(ConsultationSoapObserver::class);
        Diagnosis::observe(DiagnosisObserver::class);
        Prescription::observe(PrescriptionObserver::class);
        Billing::observe(BillingObserver::class);
        BillingDetail::observe(BillingDetailObserver::class);
        Cashier::observe(CashierObserver::class);
        Inventory::observe(InventoryObserver::class);
        InventoryStockMovement::observe(InventoryStockMovementObserver::class);
        Pharmacy::observe(PharmacyObserver::class);
        PharmacyDetail::observe(PharmacyDetailObserver::class);
        Payment::observe(PaymentObserver::class);
        Patient::observe(PatientObserver::class);
        User::observe(UserObserver::class);

        Storage::extend('google', function ($app, $config) {
            $client = new Client;
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $service = new Drive($client);

            // This is the core fix: We catch Spatie's directory queries dynamically
            $adapter = new class($service, $config['folderId']) extends GoogleDriveAdapter
            {
                public function listContents(string $path, bool $deep): iterable
                {
                    // If Spatie looks for the string name, clear it out to read the real folder ID
                    if ($path === config('backup.backup.name')) {
                        return parent::listContents('', $deep);
                    }

                    return parent::listContents($path, $deep);
                }

                public function directoryExists(string $path): bool
                {
                    if ($path === config('backup.backup.name')) {
                        return true; // Lie to Spatie so it thinks the folder exists
                    }

                    return parent::directoryExists($path);
                }
            };

            return new FilesystemAdapter(
                new Filesystem($adapter),
                $adapter,
                $config,
            );
        });
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
