<?php

namespace EthicalJobs\Foundation\Testing;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require base_path('bootstrap/app.php');

        $dotenv = new \Dotenv\Dotenv(base_path('.env.testing'));

        $dotenv->overload(); // Forces overide of existing env variables for docker.

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
