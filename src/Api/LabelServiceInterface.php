<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Api\Data\PackageInterface;
use Dhl\Sdk\EcomUs\Exception\AuthenticationException;
use Dhl\Sdk\EcomUs\Exception\DetailedServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceException;

/**
 * Interface LabelServiceInterface
 *
 * Entrypoint for DHL eCommerce US label operations.
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface LabelServiceInterface
{
    /**
     * @param \JsonSerializable $labelRequest Request body.
     * @return PackageInterface
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createLabel(
        \JsonSerializable $labelRequest
    ): PackageInterface;
}
