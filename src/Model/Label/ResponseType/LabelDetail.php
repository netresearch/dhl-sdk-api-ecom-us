<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\ResponseType;

/**
 * Class LabelDetail
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class LabelDetail
{
    /**
     * @var string|null
     */
    private $serviceLevel;

    /**
     * @var string|null
     */
    private $outboundSortCode;

    /**
     * @var string|null
     */
    private $sortingSetupVersion;

    /**
     * @var string|null
     */
    private $inboundSortCode;

    /**
     * @var string|null
     */
    private $serviceEndorsement;

    /**
     * @var string|null
     */
    private $intendedReceivingFacility;

    /**
     * @var string|null
     */
    private $mailBanner;

    /**
     * @var bool
     */
    private $customsDetailsProvided;

    /**
     * @return string|null
     */
    public function getServiceLevel(): ?string
    {
        return $this->serviceLevel;
    }

    /**
     * @return string|null
     */
    public function getOutboundSortCode(): ?string
    {
        return $this->outboundSortCode;
    }

    /**
     * @return string|null
     */
    public function getSortingSetupVersion(): ?string
    {
        return $this->sortingSetupVersion;
    }

    /**
     * @return string|null
     */
    public function getInboundSortCode(): ?string
    {
        return $this->inboundSortCode;
    }

    /**
     * @return string|null
     */
    public function getServiceEndorsement(): ?string
    {
        return $this->serviceEndorsement;
    }

    /**
     * @return string|null
     */
    public function getIntendedReceivingFacility(): ?string
    {
        return $this->intendedReceivingFacility;
    }

    /**
     * @return string|null
     */
    public function getMailBanner(): ?string
    {
        return $this->mailBanner;
    }

    /**
     * @return bool
     */
    public function isCustomsDetailsProvided(): bool
    {
        return $this->customsDetailsProvided;
    }
}
