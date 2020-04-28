<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;

/**
 * Interface LabelRequestBuilderInterface
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface LabelRequestBuilderInterface
{
    /**
     * Set shipper account (required).
     *
     * @param string $pickupAccount
     * @param string $distributionCenter
     * @param string|null $merchantId
     *
     * @return LabelRequestBuilderInterface
     */
    public function setShipperAccount(
        string $pickupAccount,
        string $distributionCenter,
        string $merchantId = null
    ): LabelRequestBuilderInterface;

    /**
     * Set consignee address for a shipment (required).
     *
     * ID type possible values:
     * - 1 (National ID Number)
     * - 2 (Military Number)
     * - 3 (Passport Number)
     * - 4 (Other)
     *
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string[] $streetLines
     * @param string $name
     * @param string|null $company
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $state
     * @param string|null $idNumber
     * @param string|null $idType
     *
     * @return LabelRequestBuilderInterface
     */
    public function setRecipientAddress(
        string $country,
        string $postalCode,
        string $city,
        array $streetLines,
        string $name,
        string $company = null,
        string $email = null,
        string $phone = null,
        string $state = null,
        string $idNumber = null,
        string $idType = null
    ): LabelRequestBuilderInterface;

    /**
     * Set address where the package is picked up from (optional).
     *
     * If not provided, the address associated with the pickup account will be used.
     *
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string[] $streetLines
     * @param string $company
     * @param string|null $name
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $state
     * @return LabelRequestBuilderInterface
     */
    public function setPickupAddress(
        string $country,
        string $postalCode,
        string $city,
        array $streetLines,
        string $company,
        string $name = null,
        string $email = null,
        string $phone = null,
        string $state = null
    ): LabelRequestBuilderInterface;

    /**
     * Set address where the shipper of the package is located (optional).
     *
     * If not provided, the pickup address will be used.
     *
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string[] $streetLines
     * @param string $company
     * @param string|null $name
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $state
     * @return LabelRequestBuilderInterface
     */
    public function setShipperAddress(
        string $country,
        string $postalCode,
        string $city,
        array $streetLines,
        string $company,
        string $name = null,
        string $email = null,
        string $phone = null,
        string $state = null
    ): LabelRequestBuilderInterface;

    /**
     * Set return address for the shipment if it cannot be delivered (optional).
     *
     * The return shipment address is already stored with the merchant account but may be overridden if necessary.
     *
     * @param string $country
     * @param string $postalCode
     * @param string $city
     * @param string[] $streetLines
     * @param string $company
     * @param string|null $name
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $state
     * @return LabelRequestBuilderInterface
     */
    public function setReturnAddress(
        string $country,
        string $postalCode,
        string $city,
        array $streetLines,
        string $company,
        string $name = null,
        string $email = null,
        string $phone = null,
        string $state = null
    ): LabelRequestBuilderInterface;

    /**
     * Set package details.
     *
     * Weight unit possible values:
     * - LB
     * - OZ
     * - KG
     * - G
     *
     * @param string $orderedProduct DHL eCommerce three-character product code.
     * @param string $currency Three-character ISO Currency code, used for all monetary values.
     * @param float $packageWeight
     * @param string $weightUom
     *
     * @return LabelRequestBuilderInterface
     */
    public function setPackageDetails(
        string $orderedProduct,
        string $currency,
        float $packageWeight,
        string $weightUom
    ): LabelRequestBuilderInterface;

    /**
     * Set package dimensions.
     *
     * Dimensions unit possible values:
     * - IN (inches)
     * - CM (centimeters)
     *
     * @param float $length
     * @param float $width
     * @param float $height
     * @param string $dimensionsUom
     *
     * @return LabelRequestBuilderInterface
     */
    public function setPackageDimensions(
        float $length,
        float $width,
        float $height,
        string $dimensionsUom
    ): LabelRequestBuilderInterface;

    /**
     * Set package id (required) and prefix (optional).
     *
     * @param string $packageId Customer Confirmation Number (CCN).
     * @param string $packageReference Prefix to the human readable Package ID.
     *
     * @return LabelRequestBuilderInterface
     */
    public function setPackageId(string $packageId, string $packageReference = null): LabelRequestBuilderInterface;

    /**
     * Set description of the contents of the package (See reference for general categories).
     *
     * @param string $packageDescription
     *
     * @return LabelRequestBuilderInterface
     */
    public function setPackageDescription(string $packageDescription): LabelRequestBuilderInterface;

    /**
     * Set the total declared value for the package. While not mandatory, best practice is to provide if available.
     *
     * @param float $declaredValue
     *
     * @return LabelRequestBuilderInterface
     */
    public function setDeclaredValue(float $declaredValue): LabelRequestBuilderInterface;

    /**
     * Set the total insured value of the package (optional).
     *
     * @param float $insuredValue
     *
     * @return LabelRequestBuilderInterface
     */
    public function setInsuredValue(float $insuredValue): LabelRequestBuilderInterface;

    /**
     * Declare whether duties and taxes are paid by the shipper or not (only applicable to international shipments).
     *
     * Possible values:
     * - true: DDP (Delivered Duties Paid)
     * - false: DDU (Delivered Duties Unpaid)
     *
     * @param bool $ddp
     *
     * @return LabelRequestBuilderInterface
     */
    public function setDutiesPaid($ddp = true): LabelRequestBuilderInterface;

    /**
     * Set DELCON service.
     *
     * @see setSignatureConfirmation
     *
     * @return LabelRequestBuilderInterface
     */
    public function setDeliveryConfirmation(): LabelRequestBuilderInterface;

    /**
     * Set SIGCON service.
     *
     * @see setDeliveryConfirmation
     *
     * @return LabelRequestBuilderInterface
     */
    public function setSignatureConfirmation(): LabelRequestBuilderInterface;

    /**
     * Set ancillary service endorsements on how to handle undeliverable-as-addressed.
     *
     * Possible values:
     * - 1 (Address Service Requested)
     * - 2 (Forwarding Service Requested)
     * - 3 (Change Service Requested)
     * - 4 (Return Service Requested)
     *
     * @param string $serviceEndorsement
     *
     * @return LabelRequestBuilderInterface
     */
    public function setServiceEndorsement(string $serviceEndorsement): LabelRequestBuilderInterface;

    /**
     * Add a string of characters that can be used to aggregate billing data (may not be unique per parcel).
     *
     * @param string $reference Primary aggregate
     * @param string|null $batch Secondary aggregate
     *
     * @return LabelRequestBuilderInterface
     */
    public function setBillingReference(string $reference, string $batch = null): LabelRequestBuilderInterface;

    /**
     * @param float|null $tax Tax charges for the package.
     * @param float|null $freight Freight charges for the package.
     * @param float|null $duty Duty charges for the package.
     * @return LabelRequestBuilderInterface
     */
    public function setCharges(
        float $tax = null,
        float $freight = null,
        float $duty = null
    ): LabelRequestBuilderInterface;

    /**
     * Set the shipment's two-digit content category code (optional).
     *
     * @param string $dgCategory
     *
     * @return LabelRequestBuilderInterface
     */
    public function setDangerousGoodsCategory(string $dgCategory = null): LabelRequestBuilderInterface;

    /**
     * Add customs item for international packages.
     *
     * @param string $description Detailed export description of the commodity item.
     * @param string $countryOfOrigin Two-character country code.
     * @param float $value The commercial value of the commodity item (per each).
     * @param string|null $hsCode Harmonized tariff schedule number.
     * @param int|null $qty Quantity of the same item in the package.
     * @param string|null $sku SKU number, item code.
     * @return LabelRequestBuilderInterface
     */
    public function addExportItem(
        string $description,
        string $countryOfOrigin,
        float $value,
        string $hsCode = null,
        int $qty = null,
        string $sku = null
    ): LabelRequestBuilderInterface;

    /**
     * Sets the mail type of the shipment. Refer to the mail type matrix for a list of valid mail types.
     *
     * @deprecated | While the mail types are still listed in the reference docs, there is no such field in the request.
     *
     * @param int $mailType
     *
     * @return LabelRequestBuilderInterface
     */
    public function setMailType(int $mailType): LabelRequestBuilderInterface;

    /**
     * Create the label request and reset the builder data.
     *
     * @return \JsonSerializable
     * @throws RequestValidatorException
     */
    public function create(): \JsonSerializable;
}
