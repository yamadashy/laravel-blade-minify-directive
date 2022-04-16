<div align="center">
  <h1>Laravel Blade Minify Directive</h1>
  <code>@minify</code> directive to partially compress HTML.
</div>
<br>
<p align="center">
  <a href="https://github.com/yamadashy/laravel-blade-minify-directive/actions"><img src="https://img.shields.io/github/workflow/status/yamadashy/laravel-blade-minify-directive/Tests?label=tests&logo=github" alt="Test Status"></a>
  <a href="https://packagist.org/packages/yamadashy/laravel-blade-minify-directive"><img src="https://poser.pugx.org/yamadashy/laravel-blade-minify-directive/v/stable.svg" alt="Latest Version"></a>
  <a href="https://github.com/yamadashy/laravel-blade-minify-directive/blob/master/LICENSE.md"><img src="https://poser.pugx.org/yamadashy/laravel-blade-minify-directive/license.svg" alt="License"></a>
</p>


# Motivation
There are various minify libraries available, all of which minify the entire page.
However, minifying the whole page may break the design, making it difficult to implement in a large project.

If you want to apply it to a part of the page instead of the whole page, this library is useful.

# Installation
You can install the package via composer:
```
composer require yamadashy/laravel-blade-minify-directive
```

# Usage

Enclose the part you want to minify with `@minify` and `@endminify`.
```blade
<div>
    <!-- comment will not remove -->
    <div>
        <div>not minified</div>
    </div>
</div>
@minify
<div>
    <!-- comment will remove -->
    <div>
        <div>minified</div>
    </div>
</div>
@endminify
<div>
    <div>not minified</div>
</div>
```

Converted like this.
```html
<div>
    <!-- comment will not remove -->
    <div>
        <div>not minified</div>
    </div>
</div>
<div><div><div>minified</div></div></div>
<div>
    <div>not minified</div>
</div>
```

# License
Distributed under the MIT License. See `LICENSE.txt` for more information.
