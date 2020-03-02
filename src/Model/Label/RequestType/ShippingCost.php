<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

/**
 * Class ShippingCost
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ShippingCost implements \JsonSerializable
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var bool
     */
    private $dutiesPaid;

    /**
     * @var float
     */
    private $declaredValue;

    /**
     * @var float
     */
    private $insuredValue;

    /**
     * @var float
     */
    private $tax;

    /**
     * @var float
     */
    private $freight;

    /**
     * @var float
     */
    private $duty;

    /**
     * ShippingCost constructor.
     *
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param bool $dutiesPaid
     * @return ShippingCost
     */
    public function setDutiesPaid(bool $dutiesPaid): ShippingCost
    {
        $this->dutiesPaid = $dutiesPaid;

        return $this;
    }

    /**
     * @param float $declaredValue
     * @return ShippingCost
     */
    public function setDeclaredValue(float $declaredValue): ShippingCost
    {
        $this->declaredValue = $declaredValue;

        return $this;
    }

    /**
     * @param float $insuredValue
     * @return ShippingCost
     */
    public function setInsuredValue(float $insuredValue): ShippingCost
    {
        $this->insuredValue = $insuredValue;

        return $this;
    }

    /**
     * @param float $tax
     * @return ShippingCost
     */
    public function setTax(float $tax): ShippingCost
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @param float $freight
     * @return ShippingCost
     */
    public function setFreight(float $freight): ShippingCost
    {
        $this->freight = $freight;

        return $this;
    }

    /**
     * @param float $duty
     * @return ShippingCost
     */
    public function setDuty(float $duty): ShippingCost
    {
        $this->duty = $duty;

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
