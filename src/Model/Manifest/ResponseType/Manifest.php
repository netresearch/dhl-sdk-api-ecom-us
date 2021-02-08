<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest\ResponseType;

/**
 * Class Manifest
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class Manifest
{
    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var string
     */
    private $manifestId;

    /**
     * @var string
     */
    private $distributionCenter;

    /**
     * @var bool
     */
    private $isInternational;

    /**
     * @var int
     */
    private $total;

    /**
     * @var string
     */
    private $manifestData;

    /**
     * @var string
     */
    private $encodeType;

    /**
     * @var string
     */
    private $format;

    /**
     * @return string
     */
    public function getCreatedOn(): string
    {
        return $this->createdOn;
    }

    /**
     * @return string
     */
    public function getManifestId(): string
    {
        return $this->manifestId;
    }

    /**
     * @return string
     */
    public function getDistributionCenter(): string
    {
        return $this->distributionCenter;
    }

    /**
     * @return bool
     */
    public function isInternational(): bool
    {
        return $this->isInternational;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return string
     */
    public function getManifestData(): string
    {
        return $this->manifestData;
    }

    /**
     * @return string
     */
    public function getEncodeType(): string
    {
        return $this->encodeType;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
