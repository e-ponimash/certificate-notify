<?php

namespace App\Providers;

use App\Services\CertificateParser;
use App\Services\HTMLCertificateParser;
use Illuminate\Support\ServiceProvider;

class CertificateParserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CertificateParser::class, function (){
            return new HTMLCertificateParser;
        });
    }

}
