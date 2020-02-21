<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest;

use Dhl\Sdk\EcomUs\Api\Data\ManifestInterface;
use Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\Manifest as ApiManifest;
use Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\PackageError;
use Dhl\Sdk\EcomUs\Service\ManifestService\Manifest;
use Dhl\Sdk\EcomUs\Service\ManifestService\ManifestError;

/**
 * Class ManifestResponseMapper
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ManifestResponseMapper
{
    /**
     * Map the webservice data structure to response objects suitable for third-party consumption.
     *
     * @param DownloadManifestResponseType $downloadResponse
     *
     * @return ManifestInterface[]
     */
    public function map(DownloadManifestResponseType $downloadResponse): array
    {
        return array_map(
            function (ApiManifest $manifest) {
                $errors = array_map(
                    function (PackageError $error) {
                        return new ManifestError(
                            $error->getDhlPackageId(),
                            $error->getErrorCode(),
                            $error->getErrorDescription()
                        );
                    },
                    $manifest->getManifestSummary()->getInvalid()->getDhlPackageIds()
                );

                return new Manifest($manifest->getManifestId(), $manifest->getManifestData(), $errors);
            },
            $downloadResponse->getManifests()
        );
    }
}
