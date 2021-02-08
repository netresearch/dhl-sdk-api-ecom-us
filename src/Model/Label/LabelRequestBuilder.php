<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Api\LabelRequestBuilderInterface;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\ConsigneeAddress;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\CustomsDetails;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\Dimension;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\PackageDetail;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\ShipperAddress;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\ShippingCost;
use Dhl\Sdk\EcomUs\Model\Label\RequestType\Weight;

class LabelRequestBuilder implements LabelRequestBuilderInterface
{
    /**
     * The collected data used to build the request
     *
     * @var mixed[]
     */
    private $data = [];

    public function setShipperAccount(
        string $pickupAccount,
        string $distributionCenter,
        string $merchantId = null
    ): LabelRequestBuilderInterface {
        $this->data['shipmentDetails']['pickupAccount'] = $pickupAccount;
        $this->data['shipmentDetails']['distributionCenter'] = $distributionCenter;
        $this->data['shipmentDetails']['merchantId'] = $merchantId;

        return $this;
    }

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
    ): LabelRequestBuilderInterface {
        $this->data['recipient']['country'] = $country;
        $this->data['recipient']['postalCode'] = $postalCode;
        $this->data['recipient']['city'] = $city;
        $this->data['recipient']['streetLines'] = $streetLines;
        $this->data['recipient']['name'] = $name;
        $this->data['recipient']['company'] = $company;
        $this->data['recipient']['email'] = $email;
        $this->data['recipient']['phone'] = $phone;
        $this->data['recipient']['state'] = $state;
        $this->data['recipient']['idNumber'] = $idNumber;
        $this->data['recipient']['idType'] = $idType;

        return $this;
    }

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
    ): LabelRequestBuilderInterface {
        $this->data['pickup']['country'] = $country;
        $this->data['pickup']['postalCode'] = $postalCode;
        $this->data['pickup']['city'] = $city;
        $this->data['pickup']['streetLines'] = $streetLines;
        $this->data['pickup']['company'] = $company;
        $this->data['pickup']['name'] = $name;
        $this->data['pickup']['email'] = $email;
        $this->data['pickup']['phone'] = $phone;
        $this->data['pickup']['state'] = $state;

        return $this;
    }

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
    ): LabelRequestBuilderInterface {
        $this->data['shipper']['country'] = $country;
        $this->data['shipper']['postalCode'] = $postalCode;
        $this->data['shipper']['city'] = $city;
        $this->data['shipper']['streetLines'] = $streetLines;
        $this->data['shipper']['company'] = $company;
        $this->data['shipper']['name'] = $name;
        $this->data['shipper']['email'] = $email;
        $this->data['shipper']['phone'] = $phone;
        $this->data['shipper']['state'] = $state;

        return $this;
    }

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
    ): LabelRequestBuilderInterface {
        $this->data['returnRecipient']['country'] = $country;
        $this->data['returnRecipient']['postalCode'] = $postalCode;
        $this->data['returnRecipient']['city'] = $city;
        $this->data['returnRecipient']['streetLines'] = $streetLines;
        $this->data['returnRecipient']['company'] = $company;
        $this->data['returnRecipient']['name'] = $name;
        $this->data['returnRecipient']['email'] = $email;
        $this->data['returnRecipient']['phone'] = $phone;
        $this->data['returnRecipient']['state'] = $state;

        return $this;
    }

    public function setPackageDetails(
        string $orderedProduct,
        string $currency,
        float $packageWeight,
        string $weightUom
    ): LabelRequestBuilderInterface {
        $this->data['packageDetails']['orderedProduct'] = $orderedProduct;
        $this->data['packageDetails']['currency'] = $currency;
        $this->data['packageDetails']['weight'] = $packageWeight;
        $this->data['packageDetails']['weightUom'] = $weightUom;

        return $this;
    }

    public function setPackageDimensions(
        float $length,
        float $width,
        float $height,
        string $dimensionsUom
    ): LabelRequestBuilderInterface {
        $this->data['packageDetails']['dimensions']['length'] = $length;
        $this->data['packageDetails']['dimensions']['width'] = $width;
        $this->data['packageDetails']['dimensions']['height'] = $height;
        $this->data['packageDetails']['dimensions']['uom'] = $dimensionsUom;

        return $this;
    }

    public function setPackageId(string $packageId, string $packageReference = null): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['packageId'] = $packageId;
        $this->data['packageDetails']['packageReference'] = $packageReference;

        return $this;
    }

    public function setPackageDescription(string $packageDescription): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['packageDescription'] = $packageDescription;

        return $this;
    }

    public function setDeclaredValue(float $declaredValue): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['declaredValue'] = $declaredValue;

        return $this;
    }

    public function setInsuredValue(float $insuredValue): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['insuredValue'] = $insuredValue;

        return $this;
    }

    public function setDutiesPaid($ddp = true): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['dutiesPaid'] = $ddp;

        return $this;
    }

    public function setDeliveryConfirmation(): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['service'] = 'DELCON';

        return $this;
    }

    public function setSignatureConfirmation(): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['service'] = 'SIGCON';

        return $this;
    }

    public function setServiceEndorsement(string $serviceEndorsement): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['serviceEndorsement'] = $serviceEndorsement;

        return $this;
    }

    public function setBillingReference(string $reference, string $batch = null): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['billingRef1'] = $reference;
        $this->data['packageDetails']['billingRef2'] = $batch;

        return $this;
    }

    public function setCharges(
        float $tax = null,
        float $freight = null,
        float $duty = null
    ): LabelRequestBuilderInterface {
        $this->data['packageDetails']['charges']['tax'] = $tax;
        $this->data['packageDetails']['charges']['freight'] = $freight;
        $this->data['packageDetails']['charges']['duty'] = $duty;

        return $this;
    }

    public function setDangerousGoodsCategory(string $dgCategory = null): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['dgCategory'] = $dgCategory;

        return $this;
    }

    public function addExportItem(
        string $description,
        string $countryOfOrigin,
        float $value,
        string $hsCode = null,
        int $qty = null,
        string $sku = null
    ): LabelRequestBuilderInterface {
        if (!isset($this->data['customsDetails']['items'])) {
            $this->data['customsDetails']['items'] = [];
        }

        $this->data['customsDetails']['items'][] = [
            'description' => $description,
            'countryOfOrigin' => $countryOfOrigin,
            'value' => $value,
            'hsCode' => $hsCode,
            'qty' => $qty,
            'sku' => $sku,
        ];

        return $this;
    }

    public function setMailType(int $mailType): LabelRequestBuilderInterface
    {
        $this->data['packageDetails']['mailType'] = $mailType;

        return $this;
    }

    public function create(): \JsonSerializable
    {
        LabelRequestValidator::validate($this->data);

        $consigneeAddress = new ConsigneeAddress(
            $this->data['recipient']['name'],
            $this->data['recipient']['country'],
            $this->data['recipient']['postalCode'],
            $this->data['recipient']['city'],
            $this->data['recipient']['streetLines'][0] ?? ''
        );
        $consigneeAddress->setAddress2($this->data['recipient']['streetLines'][1] ?? '');
        $consigneeAddress->setAddress3($this->data['recipient']['streetLines'][2] ?? '');
        $consigneeAddress->setCompanyName($this->data['recipient']['company'] ?? '');
        $consigneeAddress->setEmail($this->data['recipient']['email'] ?? '');
        $consigneeAddress->setPhone($this->data['recipient']['phone'] ?? '');
        $consigneeAddress->setState($this->data['recipient']['state'] ?? '');
        $consigneeAddress->setIdNumber($this->data['recipient']['idNumber'] ?? '');
        $consigneeAddress->setIdType($this->data['recipient']['idType'] ?? '');

        $weight = new Weight(
            round($this->data['packageDetails']['weight'], 2),
            $this->data['packageDetails']['weightUom']
        );
        $packageDetail = new PackageDetail($this->data['packageDetails']['packageId'], $weight);
        $packageDetail->setPackageDescription($this->data['packageDetails']['packageDescription'] ?? '');
        $packageDetail->setPackageReference($this->data['packageDetails']['packageReference'] ?? '');
        $packageDetail->setService($this->data['packageDetails']['service'] ?? '');
        $packageDetail->setServiceEndorsement($this->data['packageDetails']['serviceEndorsement'] ?? '');
        $packageDetail->setContentCategory($this->data['packageDetails']['dgCategory'] ?? '');
        $packageDetail->setBillingReference1($this->data['packageDetails']['billingRef1'] ?? '');
        $packageDetail->setBillingReference2($this->data['packageDetails']['billingRef2'] ?? '');

        if (!empty($this->data['packageDetails']['dimensions'])) {
            $dimension = new Dimension(
                $this->data['packageDetails']['dimensions']['length'],
                $this->data['packageDetails']['dimensions']['width'],
                $this->data['packageDetails']['dimensions']['height'],
                $this->data['packageDetails']['dimensions']['uom']
            );
            $packageDetail->setDimension($dimension);
        }

        if (
            isset($this->data['packageDetails']['charges'])
            || isset($this->data['packageDetails']['dutiesPaid'])
            || isset($this->data['packageDetails']['declaredValue'])
            || isset($this->data['packageDetails']['insuredValue'])
        ) {
            $shippingCost = new ShippingCost($this->data['packageDetails']['currency']);
            if (isset($this->data['packageDetails']['dutiesPaid'])) {
                $shippingCost->setDutiesPaid($this->data['packageDetails']['dutiesPaid']);
            }
            if (isset($this->data['packageDetails']['declaredValue'])) {
                $shippingCost->setDeclaredValue($this->data['packageDetails']['declaredValue']);
            }
            if (isset($this->data['packageDetails']['insuredValue'])) {
                $shippingCost->setInsuredValue($this->data['packageDetails']['insuredValue']);
            }
            if (!empty($this->data['packageDetails']['charges']['tax'])) {
                $shippingCost->setTax($this->data['packageDetails']['charges']['tax']);
            }
            if (!empty($this->data['packageDetails']['charges']['freight'])) {
                $shippingCost->setFreight($this->data['packageDetails']['charges']['freight']);
            }
            if (!empty($this->data['packageDetails']['charges']['duty'])) {
                $shippingCost->setDuty($this->data['packageDetails']['charges']['duty']);
            }
            $packageDetail->setShippingCost($shippingCost);
        }

        $request = new CreateLabelRequestType(
            $this->data['shipmentDetails']['pickupAccount'],
            $this->data['shipmentDetails']['distributionCenter'],
            $this->data['packageDetails']['orderedProduct'],
            $consigneeAddress,
            $packageDetail
        );

        if (!empty($this->data['shipmentDetails']['merchantId'])) {
            $request->setMerchantId($this->data['shipmentDetails']['merchantId']);
        }

        if (!empty($this->data['returnRecipient'])) {
            $returnAddress = new ShipperAddress(
                $this->data['returnRecipient']['company'],
                $this->data['returnRecipient']['country'],
                $this->data['returnRecipient']['postalCode'],
                $this->data['returnRecipient']['city'],
                $this->data['returnRecipient']['streetLines'][0] ?? ''
            );

            $returnAddress->setName($this->data['returnRecipient']['name'] ?? '');
            $returnAddress->setAddress2($this->data['returnRecipient']['streetLines'][1] ?? '');
            $returnAddress->setAddress3($this->data['returnRecipient']['streetLines'][2] ?? '');
            $returnAddress->setEmail($this->data['returnRecipient']['email'] ?? '');
            $returnAddress->setPhone($this->data['returnRecipient']['phone'] ?? '');
            $returnAddress->setState($this->data['returnRecipient']['state'] ?? '');

            $request->setReturnAddress($returnAddress);
        }

        if (!empty($this->data['pickup'])) {
            $pickupAddress = new ShipperAddress(
                $this->data['pickup']['company'],
                $this->data['pickup']['country'],
                $this->data['pickup']['postalCode'],
                $this->data['pickup']['city'],
                $this->data['pickup']['streetLines'][0] ?? ''
            );

            $pickupAddress->setName($this->data['pickup']['name'] ?? '');
            $pickupAddress->setAddress2($this->data['pickup']['streetLines'][1] ?? '');
            $pickupAddress->setAddress3($this->data['pickup']['streetLines'][2] ?? '');
            $pickupAddress->setEmail($this->data['pickup']['email'] ?? '');
            $pickupAddress->setPhone($this->data['pickup']['phone'] ?? '');
            $pickupAddress->setState($this->data['pickup']['state'] ?? '');

            $request->setPickupAddress($pickupAddress);
        }

        if (!empty($this->data['shipper'])) {
            $shipperAddress = new ShipperAddress(
                $this->data['shipper']['company'],
                $this->data['shipper']['country'],
                $this->data['shipper']['postalCode'],
                $this->data['shipper']['city'],
                $this->data['shipper']['streetLines'][0] ?? ''
            );

            $shipperAddress->setName($this->data['shipper']['name'] ?? '');
            $shipperAddress->setAddress2($this->data['shipper']['streetLines'][1] ?? '');
            $shipperAddress->setAddress3($this->data['shipper']['streetLines'][2] ?? '');
            $shipperAddress->setEmail($this->data['shipper']['email'] ?? '');
            $shipperAddress->setPhone($this->data['shipper']['phone'] ?? '');
            $shipperAddress->setState($this->data['shipper']['state'] ?? '');

            $request->setShipperAddress($shipperAddress);
        }

        if (!empty($this->data['customsDetails']['items'])) {
            $customsDetails = array_map(
                function (array $item) {
                    $customsItem = new CustomsDetails(
                        $item['description'],
                        $item['countryOfOrigin'],
                        $item['value'],
                        $this->data['packageDetails']['currency']
                    );

                    $customsItem->setHsCode($item['hsCode'] ?? '');
                    $customsItem->setSkuNumber($item['sku'] ?? '');
                    if (isset($item['qty'])) {
                        $customsItem->setPackagedQuantity($item['qty']);
                    }

                    return $customsItem;
                },
                $this->data['customsDetails']['items']
            );
            $request->setCustomsDetails($customsDetails);
        }

        $this->data = [];

        return $request;
    }
}
