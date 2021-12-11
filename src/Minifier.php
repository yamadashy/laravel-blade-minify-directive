<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective;

use Minify_HTML;

class Minifier
{

    /**
     * @param string $html
     * @return string
     */
    public static function minify($html): string
    {
        return Minify_HTML::minify($html);
    }

}
