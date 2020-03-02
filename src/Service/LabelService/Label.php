<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\LabelService;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;

/**
 * Label service response model.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
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
    private $trackingNumber;

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
     * @param string $trackingNumber
     * @param string $format
     * @param string $labelData
     */
    public function __construct(
        string $packageId,
        string $dhlPackageId,
        string $trackingNumber,
        string $format,
        string $labelData
    ) {
        $this->packageId = $packageId;
        $this->dhlPackageId = $dhlPackageId;
        $this->trackingNumber = $trackingNumber;
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
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
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
