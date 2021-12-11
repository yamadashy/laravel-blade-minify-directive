<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective\Tests;

use Yamadashy\MinifyDirective\Minifier;

class MinifierTest extends TestCase
{

    /**
     * @dataProvider dataProviderForTestMinify
     * @param string $originalHtml
     * @param string $expectedMinified
     */
    public function testMinify(string $originalHtml, string $expectedMinified): void
    {
        $minifiedHtml = Minifier::minify($originalHtml);
        $this->assertSame($expectedMinified, $minifiedHtml);
    }

    /**
     * @return string[][]
     */
    public function dataProviderForTestMinify(): array
    {
        return [
            [' <div> mini fied! </div>', '<div> mini fied!</div>'],
            [' <div> mini<div> fied! </div> </div>', '<div> mini<div> fied!</div></div>'],
            [' <div> mini<span> fied! </span> </div>', '<div> mini<span> fied! </span></div>'],
            [' <!-- min --> <div> minify <!-- min --></div> <!-- min -->', '<div> minify</div>'],
            ["mini\n\nfied!", 'minified!'],
            [
                implode("\n", [
                    '<div>',
                    '    <div class="nest" id="nest">',
                    '        aaa',
                    '    </div>',
                    '</div>'
                ]),
                implode("\n", [
                    '<div><div',
                    // NOTE: use newlines before 1st attribute in open tags (to limit line lengths)
                    // @see Minify_HTML::minify
                    'class="nest" id="nest">',
                    'aaa</div></div>',
                ]),
            ]
        ];
    }

}
