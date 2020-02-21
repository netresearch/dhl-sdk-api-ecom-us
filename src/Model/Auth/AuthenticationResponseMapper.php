<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Auth;

use Dhl\Sdk\EcomUs\Model\Auth\ResponseType\AuthenticationResponseType;
use Dhl\Sdk\EcomUs\Service\AuthenticationService\Token;

/**
 * Class AuthenticationResponseMapper
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class AuthenticationResponseMapper
{
    /**
     * Map the webservice data structure to response object.
     *
     * @param AuthenticationResponseType $response
     * @return Token
     */
    public function map(AuthenticationResponseType $response): Token
    {
        return new Token(
            $response->getAccessToken(),
            $response->getTokenType(),
            $response->getExpiresIn(),
            $response->getClientId()
        );
    }
}
