<?php
declare(strict_types=1);

namespace Yamadashy\MinifyDirective\Tests;

use Illuminate\View\Compilers\BladeCompiler;
use Yamadashy\MinifyDirective\MinifyDirectiveServiceProvider;

class MinifyDirectiveTest extends TestCase
{

    /**
     * @dataProvider dataProviderForTestMinifyDirective
     * @param string $blade
     * @param string $expectedCompiled
     * @param string $expectedEval
     */
    public function testMinifyDirective(string $blade, string $expectedCompiled, string $expectedEval): void
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = app('blade.compiler');
        $compiled = $bladeCompiler->compileString($blade);

        $this->assertSame($expectedCompiled, $compiled);

        ob_start();
        eval(' ?>'.$compiled.'<?php ');
        $evalOutput = ob_get_clean();

        $this->assertSame($expectedEval, $evalOutput);
    }

    /**
     * @return string[][]
     */
    public function dataProviderForTestMinifyDirective(): array
    {
        return [
            [
                implode("\n", [
                    '@minify',
                    '<div>',
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '    <div>',
                    '        <span> minify </span>',
                    '    </div>',
                    '</div>',
                    '@endminify',
                ]),
                implode("\n", [
                    MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '<div>',
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '    <div>',
                    '        <span> minify </span>',
                    '    </div>',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                ]),
                implode("\n", [
                    '<div><div><div> minify</div></div><div>',
                    '<span> minify </span></div></div>'
                ]),
            ],
            [
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '@minify',
                    '<div>',
                    '    minify',
                    '</div>',
                    '@endminify',
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '<div>',
                    '    minify',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '<div>',
                    'minify</div><div>',
                    '    minify',
                    '</div>',
                ]),
            ],
            'nested' => [
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '@minify',
                    '<div>',
                    '    @minify',
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '    @endminify',
                    '</div>',
                    '@endminify',
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '<div>',
                    '    '.MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '    '.MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '<div><div><div> minify</div></div></div><div>',
                    '    minify',
                    '</div>',
                ]),
            ],
            'multiple' => [
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '@minify',
                    '<div>',
                    '    <div> minify </div>',
                    '</div>',
                    '@endminify',
                    '<div>',
                    '    minify',
                    '</div>',
                    '@minify',
                    '<div>',
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '</div>',
                    '@endminify',
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '<div>',
                    '    <div> minify </div>',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                    '<div>',
                    '    minify',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_START_DIRECTIVE_COMPILED,
                    '<div>',
                    '    <div>',
                    '        <div> minify </div>',
                    '    </div>',
                    '</div>',
                    MinifyDirectiveServiceProvider::MINIFY_END_DIRECTIVE_COMPILED,
                    '<div>',
                    '    minify',
                    '</div>',
                ]),
                implode("\n", [
                    '<div>',
                    '    minify',
                    '</div>',
                    '<div><div> minify</div></div><div>',
                    '    minify',
                    '</div>',
                    '<div><div><div> minify</div></div></div><div>',
                    '    minify',
                    '</div>',
                ]),
            ],

        ];
    }

    /**
     * @dataProvider  dataProviderForTestBladeFile
     * @param string $bladeFilePath
     * @param string $expectedOutputFilePath
     */
    public function testBladeFile(string $bladeFilePath, string $expectedOutputFilePath)
    {
        $blade = file_get_contents($bladeFilePath);

        if ($blade === false) {
            throw new \LogicException('File not found. path: '.$bladeFilePath);
        }

        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = app('blade.compiler');
        $compiled = $bladeCompiler->compileString($blade);

        ob_start();
        eval(' ?>'.$compiled.'<?php ');
        $evalOutput = ob_get_clean();

        $expectedOutput = file_get_contents($expectedOutputFilePath);
        $this->assertSame($expectedOutput, $evalOutput);
    }

    /**
     * @return string[][]
     */
    public function dataProviderForTestBladeFile(): array
    {
        return [
            [__DIR__.'/TestResources/test1.blade.php', __DIR__.'/TestResources/test1output.html'],
            [__DIR__.'/TestResources/test2.blade.php', __DIR__.'/TestResources/test2output.html'],
        ];
    }

}
