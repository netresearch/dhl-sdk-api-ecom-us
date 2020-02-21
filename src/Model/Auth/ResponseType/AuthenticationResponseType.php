<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Auth\ResponseType;

/**
 * Authentication response representation.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class AuthenticationResponseType
{
    /**
     * @var string
     */
    private $access_token;

    /**
     * @var string
     */
    private $token_type;

    /**
     * @var int
     */
    private $expires_in;

    /**
     * @var string
     */
    private $client_id;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->client_id;
    }
}
