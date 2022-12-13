<?php

namespace App\Providers;

use App\Facades\MappingFacade;
use App\Interfaces\ResponseLoaderInterface;
use App\Services\JsonResponseLoaderService;
use App\Services\XmlResponseLoaderService;
use App\Services\YamlMappingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(ResponseLoaderInterface::class, function ($app, $parameters) {
            return $app->make($parameters[0]->getHeader('content-type')[0] == "application/json" ? JsonResponseLoaderService::class : XmlResponseLoaderService::class);
        });
        MappingFacade::proxy(YamlMappingService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
