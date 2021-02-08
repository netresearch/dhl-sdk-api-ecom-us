<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\LabelService;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;

class Label implements LabelInterface
{
    /**
     * @var string
     */
    private $packageId;

    /**
     * @var string
     */
    private $dhlPackageId;

    /**
     * @var string
     */
    private $trackingId;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $labelData;

    /**
     * Label constructor.
     * @param string $packageId
     * @param string $dhlPackageId
     * @param string $trackingId
     * @param string $format
     * @param string $labelData
     */
    public function __construct(
        string $packageId,
        string $dhlPackageId,
        string $trackingId,
        string $format,
        string $labelData
    ) {
        $this->packageId = $packageId;
        $this->dhlPackageId = $dhlPackageId;
        $this->trackingId = $trackingId;
        $this->format = $format;
        $this->labelData = $labelData;
    }

    /**
     * @return string
     */
    public function getPackageId(): string
    {
        return $this->packageId;
    }

    /**
     * @return string
     */
    public function getDhlPackageId(): string
    {
        return $this->dhlPackageId;
    }

    /**
     * @return string
     */
    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getLabelData(): string
    {
        return $this->labelData;
    }
}
