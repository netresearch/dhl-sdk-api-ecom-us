<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest;

use Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\ManifestSummary;

/**
 * Class CreateManifestResponseType
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class DownloadManifestResponseType
{
    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $pickup;

    /**
     * @var string
     */
    private $requestId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\Manifest[]
     */
    private $manifests;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\ManifestSummary
     */
    private $manifestSummary;

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getPickup(): string
    {
        return $this->pickup;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\Manifest[]
     */
    public function getManifests(): array
    {
        return $this->manifests ?? [];
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\ManifestSummary
     */
    public function getManifestSummary(): ManifestSummary
    {
        return $this->manifestSummary;
    }
}
