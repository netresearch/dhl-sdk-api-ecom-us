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
     * Create manifest for all pending packages.
     *
     * @param string $pickupAccountNumber
     * @return ManifestInterface
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createManifest(string $pickupAccountNumber): ManifestInterface;

    /**
     * Create manifest by submitting a list of package IDs.
     *
     * Pass in either Customer Confirmation Numbers or DHL GM Numbers.
     *
     * This method will prevent manifesting all pending packages accidentally.
     * To manifest everything, {@see createManifest}.
     *
     * @param string $pickupAccountNumber
     * @param string[] $packageIds
     * @param string[] $dhlPackageIds
     * @return ManifestInterface
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createPackageManifest(
        string $pickupAccountNumber,
        array $packageIds = [],
        array $dhlPackageIds = []
    ): ManifestInterface;

    /**
     * Download a previously created manifest, identified by request ID.
     *
     * @param string $pickupAccountNumber Pickup Account Number
     * @param string $requestId Manifest ID
     * @return ManifestInterface
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function getManifest(string $pickupAccountNumber, string $requestId): ManifestInterface;
}
