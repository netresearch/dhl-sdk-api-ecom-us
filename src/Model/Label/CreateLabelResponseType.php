<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Model\Label\ResponseType\Label;

/**
 * Class CreateLabelResponseType
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class CreateLabelResponseType
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
    private $distributionCenter;

    /**
     * @var string
     */
    private $orderedProductId;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Label\ResponseType\Label[]
     */
    private $labels;

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
    public function getDistributionCenter(): string
    {
        return $this->distributionCenter;
    }

    /**
     * @return string
     */
    public function getOrderedProductId(): string
    {
        return $this->orderedProductId;
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Label\ResponseType\Label[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
