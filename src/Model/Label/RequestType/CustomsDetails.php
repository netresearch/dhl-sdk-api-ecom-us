<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

/**
 * Class CustomsDetails
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class CustomsDetails implements \JsonSerializable
{
    /**
     * @var string
     */
    private $itemDescription;

    /**
     * @var string
     */
    private $countryOfOrigin;

    /**
     * @var float
     */
    private $itemValue;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $hsCode;

    /**
     * @var int|null
     */
    private $packagedQuantity;

    /**
     * @var string|null
     */
    private $skuNumber;

    /**
     * CustomsDetails constructor.
     *
     * @param string $itemDescription
     * @param string $countryOfOrigin
     * @param float $itemValue
     * @param string $currency
     */
    public function __construct(string $itemDescription, string $countryOfOrigin, float $itemValue, string $currency)
    {
        $this->itemDescription = $itemDescription;
        $this->countryOfOrigin = $countryOfOrigin;
        $this->itemValue = $itemValue;
        $this->currency = $currency;
    }

    /**
     * @param string $hsCode
     * @return CustomsDetails
     */
    public function setHsCode(string $hsCode): CustomsDetails
    {
        $this->hsCode = $hsCode;

        return $this;
    }

    /**
     * @param int $packagedQuantity
     * @return CustomsDetails
     */
    public function setPackagedQuantity(int $packagedQuantity): CustomsDetails
    {
        $this->packagedQuantity = $packagedQuantity;

        return $this;
    }

    /**
     * @param string $skuNumber
     * @return CustomsDetails
     */
    public function setSkuNumber(string $skuNumber): CustomsDetails
    {
        $this->skuNumber = $skuNumber;

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
