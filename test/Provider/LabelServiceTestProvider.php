<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Provider;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;

class LabelServiceTestProvider
{
    /**
     * @return \JsonSerializable[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function labelSuccess(): array
    {
        return [
            '200_ok' => [LabelRequestProvider::validRequest(), LabelResponseProvider::success()]
        ];
    }

    /**
     * @return \JsonSerializable[][]|int[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function labelError(): array
    {
        $validRequest = LabelRequestProvider::validRequest();
        $invalidRequest = LabelRequestProvider::validationErrorRequest();

        return [
            '400_bad_request' => [$invalidRequest, 400, LabelResponseProvider::validationFailed()],
            '400_downstream_error' => [$validRequest, 400, LabelResponseProvider::downstreamValidationFailed()],
            '500_gateway_error' => [$validRequest, 500, LabelResponseProvider::serverError()],
            '500_service_error' => [$validRequest, 500, LabelResponseProvider::serviceError()],
        ];
    }
}
