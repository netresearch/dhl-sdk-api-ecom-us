<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\LabelService;

use Dhl\Sdk\EcomUs\Api\Data\PackageInterface;

/**
 * Label service response model.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class Package implements PackageInterface
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
     * @var string[]
     */
    private $labels;

    /**
     * Package constructor.
     * @param string $packageId
     * @param string $dhlPackageId
     * @param string $trackingNumber
     * @param string $format
     * @param string[] $labels
     */
    public function __construct(
        string $packageId,
        string $dhlPackageId,
        string $trackingNumber,
        string $format,
        array $labels
    ) {
        $this->packageId = $packageId;
        $this->dhlPackageId = $dhlPackageId;
        $this->trackingNumber = $trackingNumber;
        $this->format = $format;
        $this->labels = $labels;
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
     * @return string[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
