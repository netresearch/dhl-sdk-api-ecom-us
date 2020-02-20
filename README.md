# DHL eCommerce Label API SDK

The DHL eCommerce US API SDK package offers an interface to the following web services:

- DHL eCommerce Solutions Americas API, version 4

## Requirements

### System Requirements

- PHP 7.1+ with JSON extension

### Package Requirements

- `netresearch/jsonmapper`: Mapper for deserialization of JSON response messages into PHP objects
- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `psr/http-client`: PSR-18 HTTP client interfaces
- `psr/http-factory`: PSR-7 HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `psr/http-client-implementation`: Any package that provides a PSR-18 compatible HTTP client
- `psr/http-factory-implementation`: Any package that provides PSR-7 compatible HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages

### Development Package Requirements

- `nyholm/psr7`: PSR-7 HTTP message factory & message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
$ composer require dhl/sdk-api-ecom-us
```

## Uninstallation

```bash
$ composer remove dhl/sdk-api-ecom-us
```

## Testing

```bash
$ ./vendor/bin/phpunit -c test/phpunit.xml
```

## Features

The DHL eCommerce US API SDK supports the following features:

* Authenticate
* Create Label
* Create Manifest

### Authentication

The DHL eCommerce US API requires token based authentication.
This operation allows to obtain a token by submitting username and password.

#### Public API

t.b.d.

#### Usage

t.b.d.

### Label Creation

t.b.d.

#### Public API

t.b.d.

#### Usage

t.b.d.

### Manifestation

t.b.d.

#### Public API

t.b.d.

#### Usage

t.b.d.

