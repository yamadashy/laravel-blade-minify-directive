<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MinifyDirectiveServiceProvider extends ServiceProvider
{

    public const MINIFY_START_DIRECTIVE_COMPILED = '<?php ob_start(); ?>';
    public const MINIFY_END_DIRECTIVE_COMPILED = '<?php echo \Yamadashy\MinifyDirective\Minifier::minify(ob_get_clean() ?: \'\'); ?>';

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->registerMinifyDirective();
    }

    /**
     * Register @minify @endminify directives.
     */
    public function registerMinifyDirective(): void
    {
        Blade::directive('minify', function() {
            return self::MINIFY_START_DIRECTIVE_COMPILED;
        });

        Blade::directive('endminify', function() {
            return self::MINIFY_END_DIRECTIVE_COMPILED;
        });
    }

}
