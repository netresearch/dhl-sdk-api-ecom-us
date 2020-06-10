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
use Dhl\Sdk\EcomUs\Service\ManifestService\ManifestDocument;
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
     * @return ManifestInterface
     */
    public function map(DownloadManifestResponseType $downloadResponse): ManifestInterface
    {
        $documents = array_map(
            function (ApiManifest $manifest) {
                $data = $manifest->getManifestData();
                return new ManifestDocument(
                    $manifest->getManifestId(),
                    $manifest->getCreatedOn(),
                    $manifest->getFormat(),
                    $manifest->getEncodeType() === 'BASE64' ? base64_decode($data) : $data
                );
            },
            $downloadResponse->getManifests()
        );

        $errors = array_map(
            function (PackageError $error) {
                return new ManifestError(
                    $error->getDhlPackageId(),
                    $error->getErrorCode(),
                    $error->getErrorDescription()
                );
            },
            $downloadResponse->getManifestSummary()->getInvalid()->getDhlPackageIds()
        );

        return new Manifest(
            $downloadResponse->getRequestId(),
            $downloadResponse->getTimestamp(),
            $downloadResponse->getStatus(),
            $documents,
            $errors
        );
    }
}
