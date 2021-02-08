<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

class PackageDetail implements \JsonSerializable
{
    /**
     * @var string
     */
    private $packageId;

    /**
     * @var Weight
     */
    private $weight;

    /**
     * @var Dimension|null
     */
    private $dimension;

    /**
     * @var string|null
     */
    private $packageDescription;

    /**
     * @var string|null
     */
    private $packageReference;

    /**
     * @var string|null
     */
    private $service;

    /**
     * @var string|null
     */
    private $serviceEndorsement;

    /**
     * @var string|null
     */
    private $contentCategory;

    /**
     * @var string|null
     */
    private $billingReference1;

    /**
     * @var string|null
     */
    private $billingReference2;

    /**
     * @var ShippingCost|null
     */
    private $shippingCost;

    /**
     * PackageDetail constructor.
     *
     * @param string $packageId
     * @param Weight $weight
     */
    public function __construct(string $packageId, Weight $weight)
    {
        $this->packageId = $packageId;
        $this->weight = $weight;
    }

    /**
     * @param Dimension $dimension
     * @return PackageDetail
     */
    public function setDimension(Dimension $dimension): PackageDetail
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @param string $packageDescription
     * @return PackageDetail
     */
    public function setPackageDescription(string $packageDescription): PackageDetail
    {
        $this->packageDescription = $packageDescription;

        return $this;
    }

    /**
     * @param string $packageReference
     * @return PackageDetail
     */
    public function setPackageReference(string $packageReference): PackageDetail
    {
        $this->packageReference = $packageReference;

        return $this;
    }

    /**
     * @param string $service
     * @return PackageDetail
     */
    public function setService(string $service): PackageDetail
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @param string $serviceEndorsement
     * @return PackageDetail
     */
    public function setServiceEndorsement(string $serviceEndorsement): PackageDetail
    {
        $this->serviceEndorsement = $serviceEndorsement;

        return $this;
    }

    /**
     * @param string $contentCategory
     * @return PackageDetail
     */
    public function setContentCategory(string $contentCategory): PackageDetail
    {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    /**
     * @param string $billingReference1
     * @return PackageDetail
     */
    public function setBillingReference1(string $billingReference1): PackageDetail
    {
        $this->billingReference1 = $billingReference1;

        return $this;
    }

    /**
     * @param string $billingReference2
     * @return PackageDetail
     */
    public function setBillingReference2(string $billingReference2): PackageDetail
    {
        $this->billingReference2 = $billingReference2;

        return $this;
    }

    /**
     * @param ShippingCost $shippingCost
     * @return PackageDetail
     */
    public function setShippingCost(ShippingCost $shippingCost): PackageDetail
    {
        $this->shippingCost = $shippingCost;

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
