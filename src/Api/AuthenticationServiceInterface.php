<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Api\Data\TokenInterface;
use Dhl\Sdk\EcomUs\Exception\AuthenticationException;

/**
 * Interface AuthenticationServiceInterface
 *
 * Entrypoint for DHL eCommerce US API authentication.
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface AuthenticationServiceInterface
{
    /**
     * Request an authentication token.
     *
     * @param string $username Client ID
     * @param string $password Client secret
     *
     * @return TokenInterface
     *
     * @throws AuthenticationException
     */
    public function authenticate(string $username, string $password): TokenInterface;
}
