<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Exception;

/**
 * Class AuthenticationException
 *
 * @internal Only used by authentication plugin to break the chain.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class AuthenticationException extends DetailedServiceException
{
}
