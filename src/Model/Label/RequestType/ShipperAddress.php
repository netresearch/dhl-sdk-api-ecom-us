<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

class ShipperAddress implements \JsonSerializable
{
    /**
     * @var string
     */
    private $companyName;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $address2;

    /**
     * @var string|null
     */
    private $address3;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $state;

    /**
     * ShipperAddress constructor.
     *
     * @param string $companyName
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string $address1
     */
    public function __construct(
        string $companyName,
        string $country,
        string $postalCode,
        string $city,
        string $address1
    ) {
        $this->companyName = $companyName;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->address1 = $address1;
    }

    /**
     * @param string $name
     * @return ShipperAddress
     */
    public function setName(string $name): ShipperAddress
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $address2
     * @return ShipperAddress
     */
    public function setAddress2(string $address2): ShipperAddress
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @param string $address3
     * @return ShipperAddress
     */
    public function setAddress3(string $address3): ShipperAddress
    {
        $this->address3 = $address3;
        return $this;
    }

    /**
     * @param string $email
     * @return ShipperAddress
     */
    public function setEmail(string $email): ShipperAddress
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $phone
     * @return ShipperAddress
     */
    public function setPhone(string $phone): ShipperAddress
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $state
     * @return ShipperAddress
     */
    public function setState(string $state): ShipperAddress
    {
        $this->state = $state;
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
