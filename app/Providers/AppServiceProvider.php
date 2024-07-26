<?php

namespace App\Providers;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production') || $this->app->environment('staging')) {
            URL::forceScheme('https');
        }
        View::share('uptPusatId', env('UPT_PUSAT_ID', 1000));
        Blade::directive('statusimport', function ($expression) {
            return "<?php echo  App\Helpers\StatusImportHelper::statusRender($expression) ?>";
        });

        Blade::directive('aktifitas', function ($expression) {

            return "<?php echo  App\Helpers\StatusImportHelper::aktifitasRender($expression) ?>";
        });
        Blade::directive('negara', function ($expression) {

            return "<?php echo  App\Helpers\BarantinApiHelper::getMasterNegaraByID($expression)['nama'] ?? 'NEGARA' ?>";
        });
        Blade::directive('provinsi', function ($expression) {

            return "<?php echo  App\Helpers\BarantinApiHelper:: getMasterProvinsiByID($expression)['nama'] ?? 'PROVINSI' ?>";
        });
        Blade::directive('kota', function ($expression) {
            return "<?php echo  App\Helpers\BarantinApiHelper::getMasterKotaByID($expression)['nama'] ?? 'KOTA' ?>";
        });
        Blade::directive('upt', function ($expression) {
            return "<?php echo  App\Helpers\BarantinApiHelper:: getMasterUptByID($expression)['nama'] ?? 'UPT PUSAT' ?>";
        });
    }
}
