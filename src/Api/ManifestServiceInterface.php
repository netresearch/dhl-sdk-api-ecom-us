<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Api\Data\ManifestInterface;
use Dhl\Sdk\EcomUs\Exception\DetailedServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceException;

/**
 * Interface ManifestationServiceInterface
 *
 * Entrypoint for DHL eCommerce US manifest operations.
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface ManifestServiceInterface
{
    /**
     * Create manifest(s) for all pending packages.
     *
     * @param string $pickupAccountNumber
     * @return ManifestInterface[]
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createManifests(string $pickupAccountNumber): array;

    /**
     * Create manifest(s) by submitting a list of DHL package IDs (DHL GM Numbers / Mail Identifiers).
     *
     * This will prevent manifesting all pending packages accidentally. To manifest everything, {@see createManifests}.
     *
     * @param string $pickupAccountNumber
     * @param string[] $packageIds
     * @return ManifestInterface[]
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function creatPackageManifests(string $pickupAccountNumber, array $packageIds): array;
}
