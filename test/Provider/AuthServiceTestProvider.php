<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Provider;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;

class AuthServiceTestProvider
{
    /**
     * @return \JsonSerializable[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function authenticationSuccess(): array
    {
        return [
            '200_ok' => [
                LabelRequestProvider::validRequest(),
                LabelResponseProvider::success(),
                AuthServiceResponseProvider::success(),
            ]
        ];
    }

    /**
     * @return \JsonSerializable[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function authenticationFailure()
    {
        return [
            '401_unauthorized' => [
                LabelRequestProvider::validRequest(),
                LabelResponseProvider::unauthorized(),
                AuthServiceResponseProvider::unauthorized(),
            ],
        ];
    }
}
