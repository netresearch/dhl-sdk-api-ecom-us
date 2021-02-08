<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Model\Label\RequestType\ConsigneeAddress;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\CustomsDetails;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\PackageDetail;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\ShipperAddress;

class CreateLabelRequestType implements \JsonSerializable
{
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
     * @var ConsigneeAddress
     */
    private $consigneeAddress;

    /**
     * @var PackageDetail
     */
    private $packageDetail;

    /**
     * @var string|null
     */
    private $merchantId;

    /**
     * @var ShipperAddress|null
     */
    private $returnAddress;

    /**
     * @var ShipperAddress|null
     */
    private $pickupAddress;

    /**
     * @var ShipperAddress|null
     */
    private $shipperAddress;

    /**
     * @var CustomsDetails[]|null
     */
    private $customsDetails;

    /**
     * CreateLabelRequestType constructor.
     *
     * @param string $pickup
     * @param string $distributionCenter
     * @param string $orderedProductId
     * @param ConsigneeAddress $consigneeAddress
     * @param PackageDetail $packageDetail
     */
    public function __construct(
        string $pickup,
        string $distributionCenter,
        string $orderedProductId,
        ConsigneeAddress $consigneeAddress,
        PackageDetail $packageDetail
    ) {
        $this->pickup = $pickup;
        $this->distributionCenter = $distributionCenter;
        $this->orderedProductId = $orderedProductId;
        $this->consigneeAddress = $consigneeAddress;
        $this->packageDetail = $packageDetail;
    }

    /**
     * @param string $merchantId
     * @return CreateLabelRequestType
     */
    public function setMerchantId(string $merchantId): CreateLabelRequestType
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * @param ShipperAddress $returnAddress
     * @return CreateLabelRequestType
     */
    public function setReturnAddress(ShipperAddress $returnAddress): CreateLabelRequestType
    {
        $this->returnAddress = $returnAddress;
        return $this;
    }

    /**
     * @param ShipperAddress $pickupAddress
     * @return CreateLabelRequestType
     */
    public function setPickupAddress(ShipperAddress $pickupAddress): CreateLabelRequestType
    {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }

    /**
     * @param ShipperAddress $shipperAddress
     * @return CreateLabelRequestType
     */
    public function setShipperAddress(ShipperAddress $shipperAddress): CreateLabelRequestType
    {
        $this->shipperAddress = $shipperAddress;
        return $this;
    }

    /**
     * @param CustomsDetails[] $customsDetails
     * @return CreateLabelRequestType
     */
    public function setCustomsDetails(array $customsDetails): CreateLabelRequestType
    {
        $this->customsDetails = $customsDetails;
        return $this;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
