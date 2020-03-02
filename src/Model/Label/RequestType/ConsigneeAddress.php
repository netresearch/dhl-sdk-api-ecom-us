<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

/**
 * Class ConsigneeAddress
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ConsigneeAddress implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

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
    private $companyName;

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
     * @var string|null
     */
    private $idNumber;

    /**
     * @var string|null
     */
    private $idType;

    /**
     * ConsigneeAddress constructor.
     *
     * @param string $name
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string $address1
     */
    public function __construct(string $name, string $country, string $postalCode, string $city, string $address1)
    {
        $this->name = $name;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->address1 = $address1;
    }

    /**
     * @param string $companyName
     * @return ConsigneeAddress
     */
    public function setCompanyName(string $companyName): ConsigneeAddress
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param string $address2
     * @return ConsigneeAddress
     */
    public function setAddress2(string $address2): ConsigneeAddress
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @param string $address3
     * @return ConsigneeAddress
     */
    public function setAddress3(string $address3): ConsigneeAddress
    {
        $this->address3 = $address3;
        return $this;
    }

    /**
     * @param string $email
     * @return ConsigneeAddress
     */
    public function setEmail(string $email): ConsigneeAddress
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $phone
     * @return ConsigneeAddress
     */
    public function setPhone(string $phone): ConsigneeAddress
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $state
     * @return ConsigneeAddress
     */
    public function setState(string $state): ConsigneeAddress
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $idNumber
     * @return ConsigneeAddress
     */
    public function setIdNumber(string $idNumber): ConsigneeAddress
    {
        $this->idNumber = $idNumber;
        return $this;
    }

    /**
     * @param string $idType
     * @return ConsigneeAddress
     */
    public function setIdType(string $idType): ConsigneeAddress
    {
        $this->idType = $idType;
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
