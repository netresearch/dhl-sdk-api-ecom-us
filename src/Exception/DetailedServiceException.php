<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Exception;

/**
 * Class DetailedServiceException
 *
 * A special instance of the ServiceException which is able to
 * provide a meaningful error message, suitable for UI display.
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class DetailedServiceException extends ServiceException
{
}
