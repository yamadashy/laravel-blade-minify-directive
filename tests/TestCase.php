<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use Yamadashy\MinifyDirective\MinifyDirectiveServiceProvider;

abstract class TestCase extends Orchestra
{

    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            MinifyDirectiveServiceProvider::class,
        ];
    }

}
