<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\ResponseType;

/**
 * Class Label
 *
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class Label
{
    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var string
     */
    private $packageId;

    /**
     * @var string
     */
    private $dhlPackageId;

    /**
     * @var string|null
     */
    private $trackingId;

    /**
     * @var string
     */
    private $labelData;

    /**
     * @var string
     */
    private $encodeType;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Label\ResponseType\LabelDetail|null
     */
    private $labelDetail;

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
        return (string) $this->trackingId;
    }

    /**
     * @return string
     */
    public function getLabelData(): string
    {
        return $this->labelData;
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

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Label\ResponseType\LabelDetail|null
     */
    public function getLabelDetail(): ?\Dhl\Sdk\EcomUs\Model\Label\ResponseType\LabelDetail
    {
        return $this->labelDetail;
    }
}
