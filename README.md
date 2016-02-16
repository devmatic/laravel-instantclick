# An InstantClick middleware for Laravel 5
[![Latest Version on Packagist](https://img.shields.io/packagist/v/diaafares/laravel-instantclick.svg?style=flat-square)](https://packagist.org/packages/diaafares/laravel-instantclick)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/diaafares/laravel-instantclick/master.svg?style=flat-square)](https://travis-ci.org/diaafares/laravel-instantclick)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/4c4ada94-d590-4c27-9118-dad4b5bebe73.svg?style=flat-square)](https://insight.sensiolabs.com/projects/4c4ada94-d590-4c27-9118-dad4b5bebe73)
[![Quality Score](https://img.shields.io/scrutinizer/g/diaafares/laravel-instantclick.svg?style=flat-square)](https://scrutinizer-ci.com/g/diaafares/laravel-instantclick)
[![Total Downloads](https://img.shields.io/packagist/dt/diaafares/laravel-instantclick.svg?style=flat-square)](https://packagist.org/packages/diaafares/laravel-instantclick)

[InstantClick](https://github.com/dieulot/instantclick) is a plugin that makes following links in your website instant by leverages ajax to speed up the loading time of your pages. 

InstantClick uses pushState and Ajax (a combo known as pjax), replacing only the body and the title in the head.

# Ajax brings two nice benefits in and of itself:
-     Your browser doesn’t have to throw and recompile scripts and styles on each page change anymore.
-     You don’t get a white flash while your browser is waiting for a page to display, making your website feel faster. 

This package provides a middleware that can return the response that this plugin expects.

## Video Tutorial & Overview
[![IMAGE ALT TEXT HERE](http://img.youtube.com/vi/IGv8dzD5rQA/0.jpg)](http://www.youtube.com/watch?v=IGv8dzD5rQA)

## Installation & Usage

- You can install the package via composer:
``` bash
$ composer require diaafares/laravel-instantclick
```

- Next you must add the `\DiaaFares\InstantClick\Middleware\FilterIfInstantClick`-middleware to the kernel.
```php
// app/Http/Kernel.php

...
protected $middleware = [
    ...
    \DiaaFares\InstantClick\Middleware\FilterIfInstantClick::class,
];
```
- **Copy the included instantclick.js** to your proper public asset folder then include it at your layout file like this:
```html
	<script src="/path/to/instantclick.js" data-no-instant></script>
    <script data-no-instant>InstantClick.init();</script>
```

- Please refer to [InstantClient documentation](http://instantclick.io/documentation) to know more about InstantClient options and how it works.


## Important Note
please use the included instantclick.js file because I modify it by adding $xhr.setRequestHeader(‘X-INSTANTCLICK’, true) to give the middleware the ability to identify InstantClient requests and give the proper response to it.


## How it Works

The provided middleware provides the behaviour that the Instant Click plugin expects of the server:

> An X-INSTANTCLICK request header is set to differentiate a InstantClick request from normal XHR requests. 
> In this case, if the request is InstantClick, we skip the layout html and just render the inner
> contents of the body.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Diaa Fares](https://github.com/DiaaFares)
- [All Contributors](../../contributors)

The middleware in this package was originally written by [Freek Van der Herten](https://github.com/freekmurze) for return the response that Pjax jquery plugin expects, I edit his middleware and InstantClick plugin to make it work for Laravel. 
His original code can be found [in this repo on GitHub](https://github.com/spatie/laravel-pjax).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
