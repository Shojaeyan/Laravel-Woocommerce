# LaravelWoocommerce

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

A simple Laravel wrapper for the official WooCommerce REST API PHP Library from Automattic.


## Installation

##Step 1: Install through Composer
```bash
composer require guidemaster/laravel-woocommerce
```
##Step 2: Publish configuration
```bash
php artisan vendor:publish --tag=GuideMaster\LaravelWoocommerce\LaravelWoocommerceServiceProvide
```
##Step 3: Customize configuration
You can directly edit the configuration in config/woocommerce.php or copy these values to your .env file.

```bash
WOOCOMMERCE_STORE_URL=https://example-store.org
WOOCOMMERCE_CONSUMER_KEY=ck_your-consumer-key
WOOCOMMERCE_CONSUMER_SECRET=cs_your-consumer-secret
WOOCOMMERCE_VERIFY_SSL=false
WOOCOMMERCE_VERSION=v1
WOOCOMMERCE_WP_API=true
WOOCOMMERCE_WP_QUERY_STRING_AUTH=false
WOOCOMMERCE_WP_TIMEOUT=15```


## Examples

### Get the index of all available endpoints
```php
use Woocommerce;

return Woocommerce::get('');
```

### View all orders
```php
use Woocommerce;

return Woocommerce::get('orders');
```

### View all completed orders created after a specific date
#### For legacy API versions 
(WC 2.4.x or later, WP 4.1 or later) use this syntax

```php
use Woocommerce;

$data = [
    'status' => 'completed',
    'filter' => [
        'created_at_min' => '2016-01-14'
    ]
];

$result = Woocommerce::get('orders', $data);

foreach($result['orders'] as $order)
{
    // do something with $order
}

// you can also use array access
$orders = Woocommerce::get('orders', $data)['orders'];

foreach($orders as $order)
{
    // do something with $order
}
```

#### For current API versions 
(WC 2.6.x or later, WP 4.4 or later) use this syntax.
`after` needs to be a ISO-8601 compliant date!≠

```php
use Woocommerce;

$data = [
    'status' => 'completed',
    'after' => '2016-01-14T00:00:00'
    ]
];

$result = Woocommerce::get('orders', $data);

foreach($result['orders'] as $order)
{
    // do something with $order
}

// you can also use array access
$orders = Woocommerce::get('orders', $data)['orders'];

foreach($orders as $order)
{
    // do something with $order
}
```

### Update a product
```php
use Woocommerce;

$data = [
    'product' => [
        'title' => 'Updated title'
    ]
];

return Woocommerce::put('products/1', $data);
```

### Pagination
So you don't have to mess around with the request and response header and the calculations this wrapper will do all the heavy lifting for you.
(WC 2.6.x or later, WP 4.4 or later) 

```php
use Woocommerce;

// assuming we have 474 orders in pur result
// we will request page 5 with 25 results per page
$params = [
    'per_page' => 25,
    'page' => 5
];

Woocommerce::get('orders', $params);

Woocommerce::totalResults(); // 474
Woocommerce::firstPage(); // 1
Woocommerce::lastPage(); // 19
Woocommerce::currentPage(); // 5 
Woocommerce::totalPages(); // 19
Woocommerce::previousPage(); // 4
Woocommerce::nextPage(); // 6
Woocommerce::hasPreviousPage(); // true 
Woocommerce::hasNextPage(); // true
Woocommerce::hasNotPreviousPage(); // false 
Woocommerce::hasNotNextPage(); // false
```

### HTTP Request & Response (Headers)

```php
use Woocommerce;

// first send a request
Woocommerce::get('orders');

// get the request
Woocommerce::getRequest();

// get the response headers
Woocommerce::getResponse();

// get the total number of results
Woocommerce::getResponse()->getHeaders()['X-WP-Total']
```

### More Examples
Refer to [WooCommerce REST API Documentation](https://woocommerce.github.io/woocommerce-rest-api-docs) for more examples and documentation.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

```bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Author Name][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/guidemaster/laravel-woocommerce.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/guidemaster/laravel-woocommerce.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/guidemaster/laravel-woocommerce/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/guidemaster/laravel-woocommerce
[link-downloads]: https://packagist.org/packages/guidemaster/laravel-woocommerce
[link-travis]: https://travis-ci.org/guidemaster/laravel-woocommerce
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/guidemaster
[link-contributors]: ../../contributors
