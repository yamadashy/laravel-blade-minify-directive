<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective;

use Minify_HTML;

class Minifier
{
    public static function minify(string $html): string
    {
        return Minify_HTML::minify($html);
    }

}
