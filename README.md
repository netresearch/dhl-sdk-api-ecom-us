# DHL eCommerce US API SDK

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

* Create Label
* Create Manifest

### Label Creation

Create labels for DHL eCommerce including the relevant shipping documents.

#### Public API

The library's components suitable for consumption comprise

* services:
  * service factory
  * label service
  * data transfer object builder
* data transfer objects:
  * authentication storage
  * label with package identifiers and label data

#### Usage

```php
$logger = new \Psr\Log\NullLogger();
$authStorage = new \Dhl\Sdk\EcomUs\Model\Auth\AuthenticationStorage(
    $username = 'u5er',
    $password = 'p4ss'
);

$serviceFactory = new \Dhl\Sdk\EcomUs\Service\ServiceFactory();
$service = $serviceFactory->createLabelService($authStorage, $logger, $sandbox = true);

$requestBuilder = new \Dhl\Sdk\EcomUs\Model\Label\LabelRequestBuilder();
$requestBuilder->setShipperAccount(
    $pickupAccountNumber = '5323000',
    $distributionCenter = 'USMCO1'
);
$requestBuilder->setShipperAddress(
    $country = 'US',
    $postalCode = '33324',
    $city = 'Plantation',
    $streetLines = ['1210 South Pine Island Road'],
    $company = 'DHL eCommerce'
);
$requestBuilder->setReturnAddress(
    $country = 'US',
    $postalCode = '33324',
    $city = 'Plantation',
    $streetLines = ['1210 South Pine Island Road'],
    $company = 'DHL eCommerce'
);
$requestBuilder->setRecipientAddress(
    $country = 'US',
    $postalCode = '90232',
    $city = 'Culver City',
    $streetLines = ['10441 Jefferson Blvd.', 'Suite 200'],
    $name = 'Jane Doe',
    $company = 'Foo Factory',
    $email = 'foo@example.org',
    $phone = '800 123456',
    $state = 'CA'
);

$requestBuilder->setPackageId($uniquePackageId = 'TEST-9876543210');
$requestBuilder->setPackageDetails(
    $shippingProduct = 'PLT',
    $currency = 'USD',
    $packageWeight = 1.2,
    $weightUnit = 'LB'
);

$labelRequest = $requestBuilder->create();
$label = $service->createLabel($labelRequest);
```

### Manifestation

Create a package manifest and retrieve documentation.

#### Public API

The library's components suitable for consumption comprise

* services:
  * service factory
  * manifest service
* data transfer objects:
  * authentication storage
  * manifest with documents and package errors

#### Usage

```php
$logger = new \Psr\Log\NullLogger();
$authStorage = new \Dhl\Sdk\EcomUs\Model\Auth\AuthenticationStorage(
    $username = 'u5er',
    $password = 'p4ss'
);

$serviceFactory = new \Dhl\Sdk\EcomUs\Service\ServiceFactory();
$service = $serviceFactory->createManifestationService($authStorage, $logger, $sandbox = true);

// create manifest for all available packages
$manifest = $service->createManifest($pickupAccountNumber = '5323000');

// OR create manifest for certain packages, identified by number
$manifest = $service->createPackageManifest(
    $pickupAccountNumber = '5323000',
    $packageIds = [
        "TEST-0123456789",
        "TEST-9876543210"
    ]
);

// documentation may not be instantly available, try again later
if ($manifest->getStatus() !== \Dhl\Sdk\EcomUs\Api\Data\ManifestInterface::STATUS_COMPLETED) {
    $manifest = $service->getManifest(
        $pickupAccountNumber = '5323000',
        $requestId = $manifest->getRequestId()
    );
}
```
