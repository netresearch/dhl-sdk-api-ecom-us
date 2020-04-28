<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Provider;

class AuthServiceResponseProvider
{
    public static function success(): string
    {
        return \file_get_contents(__DIR__ . '/_files/200_token.json');
    }

    public static function unauthorized(): string
    {
        return \file_get_contents(__DIR__ . '/_files/401_invalid_credentials.json');
    }
}
