<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Provider;

/**
 * Class LabelResponseProvider
 *
 * @author  Andreas Müller <andreas.mueller@netresearch.de>
 * @link    https://www.netresearch.de
 */
class LabelResponseProvider
{
    public static function success(): string
    {
        return \file_get_contents(__DIR__ . '/_files/200.json');
    }

    public static function validationFailed(): string
    {
        return \file_get_contents(__DIR__ . '/_files/400_validation_failed.json');
    }

    public static function downstreamValidationFailed(): string
    {
        return \file_get_contents(__DIR__ . '/_files/400_downstream_validation_failed.json');
    }

    public static function unauthorized(): string
    {
        return \file_get_contents(__DIR__ . '/_files/401_invalid_token.json');
    }

    public static function serverError(): string
    {
        return \file_get_contents(__DIR__ . '/_files/500_gateway_error.json');
    }

    public static function serviceError(): string
    {
        return \file_get_contents(__DIR__ . '/_files/500_unknown_exception.json');
    }
}
