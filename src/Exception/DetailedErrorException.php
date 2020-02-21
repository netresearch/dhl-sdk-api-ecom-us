<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Exception;

use Http\Client\Exception\HttpException;

/**
 * A detailed HTTP exception.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class DetailedErrorException extends HttpException
{
}
