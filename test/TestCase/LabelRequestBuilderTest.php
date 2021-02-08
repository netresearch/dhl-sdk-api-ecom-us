<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;
use PHPUnit\Framework\TestCase;

class LabelRequestBuilderTest extends TestCase
{
    /**
     * @return LabelRequestBuilder[]
     */
    public function dataProvider(): array
    {
        $missingPickupAccBuilder = new LabelRequestBuilder();
        $missingPickupAccBuilder->setShipperAccount('', 'USTEST', null);
        $missingPickupAccBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            null,
            null,
            null,
            'CA'
        );
        $missingPickupAccBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');

        $missingRecipientBuilder = new LabelRequestBuilder();
        $missingRecipientBuilder->setShipperAccount('1123456', 'USTEST', '123');

        $missingStateBuilder = new LabelRequestBuilder();
        $missingStateBuilder->setShipperAccount('123456', 'USTEST', '123');
        $missingStateBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $missingStateBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            null,
            null,
            null,
            null
        );

        $missingProductBuilder = new LabelRequestBuilder();
        $missingProductBuilder->setShipperAccount('123456', 'USTEST', '123');
        $missingProductBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $missingProductBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            null,
            null,
            null,
            'CA'
        );
        $missingProductBuilder->setPackageDetails('', 'USD', 1.2, 'LB');

        $missingPackageIdBuilder = new LabelRequestBuilder();
        $missingPackageIdBuilder->setShipperAccount('123456', 'USTEST', '123');
        $missingPackageIdBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $missingPackageIdBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            null,
            null,
            null,
            'CA'
        );
        $missingPackageIdBuilder->setPackageDetails('PLT', 'USD', 1.2, 'LB');
        $missingPackageIdBuilder->setPackageId('');

        $missingWeightBuilder = new LabelRequestBuilder();
        $missingWeightBuilder->setShipperAccount('123456', 'USTEST', '123');
        $missingWeightBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $missingWeightBuilder->setPackageId('123');
        $missingWeightBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            null,
            null,
            null,
            'CA'
        );
        $missingWeightBuilder->setPackageDetails('PLT', 'USD', 0, 'LB');

        return [
            'missing_pickup_acc' => [$missingPickupAccBuilder, LabelRequestValidator::MSG_ACCOUNT_DATA_REQUIRED],
            'missing_recipient' => [$missingRecipientBuilder, LabelRequestValidator::MSG_CONSIGNEE_REQUIRED],
            'missing_state' => [$missingStateBuilder, LabelRequestValidator::MSG_CONSIGNEE_STATE_REQUIRED],
            'missing_ordered_product' => [$missingProductBuilder, LabelRequestValidator::MSG_PRODUCT_REQUIRED],
            'missing_package_id' => [$missingPackageIdBuilder, LabelRequestValidator::MSG_PACKAGE_ID_REQUIRED],
            'missing_package_weight' => [$missingWeightBuilder, LabelRequestValidator::MSG_WEIGHT_REQUIRED]
        ];
    }

    /**
     * Assert valid request is build properly.
     *
     * @test
     * @throws RequestValidatorException
     */
    public function validRequest()
    {
        $builder = new LabelRequestBuilder();
        $builder->setShipperAccount($pickupAcc = '123456', $distCenter = 'USTEST', $merchandId = '123');
        $builder->setShipperAddress(
            $shipperCountry = 'US',
            $shipperPostCode = '12345',
            $shipperCity = 'City',
            $shipperStreet = ['abcd', '123'],
            $shipperCompany = 'Comp',
            $shipperName = 'Test Shipper',
            $shipperEmail = 'shipper@test.co',
            $shipperPhone = '987654321',
            $shipperState = 'CA'
        );
        $builder->setPackageId($packageId = '123', $packageReference = 'ABC');
        $builder->setRecipientAddress(
            $recipientCountry = 'US',
            $recipientPostcode = '94102',
            $recipientCity = 'Testcity',
            $recipientStreet = ['1 Street', '2nd Floor'],
            $recipientName = 'Test Tester',
            $recipientCompany = 'MyCompany',
            $recipientEmail = 'test@test.co',
            $recipientPhone = '123456789',
            $recipientState = 'CA',
            $recipientIdNumber = '987654',
            $recipientIdType = '1'
        );
        $builder->setPackageDetails($orderProduct = 'PLT', $currency = 'USD', $packageWeight = 0.8, $weightUom = 'LB');
        $builder->setReturnAddress(
            $returnCountry = 'US',
            $returnPostCode = '12345',
            $returnCity = 'City',
            $returnStreet = ['123', 'abc'],
            $returnCompany = 'Comp',
            $returnName = 'Test Return',
            $returnEmail = 'return@test.co',
            $returnPhone = '987654321',
            $returnState = 'CA'
        );
        $builder->setPickupAddress(
            $pickupCountry = 'US',
            $pickupPostCode = '12345',
            $pickupCity = 'City',
            $pickupStreet = ['123', 'def'],
            $pickupCompany = 'Comp',
            $pickupName = 'Test Pickup',
            $pickupEmail = 'test@test.co',
            $pickupPhone = '987654321',
            $pickupState = 'CA'
        );

        $builder->setPackageDimensions(
            $dimensionLength = 20,
            $dimensionWidth = 20,
            $dimensionHeight = 20,
            $dimensionUom = 'IN'
        );

        $builder->setPackageDescription($packageDescription = 'This a description');
        $builder->setDeclaredValue($declaredValue = 19.99);
        $builder->setInsuredValue($insuredValue = 19.99);
        $builder->setDutiesPaid();
        $builder->setCharges($tax = 12, $freight = 1.2, $duty = 2.99);
        $builder->setSignatureConfirmation();
        $builder->setServiceEndorsement($serviceEndorsement = 'testserv');
        $builder->setBillingReference($billingRef = 'bil', $billRefBatch = 'and');
        $builder->setDangerousGoodsCategory($dgCategory = '01');
        $builder->setMailType($mailType = 1);
        $builder->addExportItem(
            $exportDescription = 'Export description',
            $countryOfOrigin = 'US',
            $exportValue = 19.99,
            $hsCode = '123456',
            $qty = 1,
            $sku = '24-MB02'
        );
        $requestType = $builder->create();
        $requestJson = json_encode($requestType, JSON_UNESCAPED_UNICODE);
        $request = json_decode($requestJson);

        self::assertSame($pickupAcc, $request->pickup);
        self::assertSame($distCenter, $request->distributionCenter);
        self::assertSame($merchandId, $request->merchantId);
        self::assertSame($orderProduct, $request->orderedProductId);

        self::assertSame($recipientName, $request->consigneeAddress->name);
        self::assertSame($recipientCompany, $request->consigneeAddress->companyName);
        self::assertSame($recipientStreet[0], $request->consigneeAddress->address1);
        self::assertSame($recipientStreet[1], $request->consigneeAddress->address2);
        self::assertSame($recipientCity, $request->consigneeAddress->city);
        self::assertSame($recipientState, $request->consigneeAddress->state);
        self::assertSame($recipientCountry, $request->consigneeAddress->country);
        self::assertSame($recipientPostcode, $request->consigneeAddress->postalCode);
        self::assertSame($recipientEmail, $request->consigneeAddress->email);
        self::assertSame($recipientPhone, $request->consigneeAddress->phone);
        self::assertSame($recipientIdNumber, $request->consigneeAddress->idNumber);
        self::assertSame($recipientIdType, $request->consigneeAddress->idType);

        self::assertSame($returnName, $request->returnAddress->name);
        self::assertSame($returnCompany, $request->returnAddress->companyName);
        self::assertSame($returnStreet[0], $request->returnAddress->address1);
        self::assertSame($returnStreet[1], $request->returnAddress->address2);
        self::assertSame($returnCity, $request->returnAddress->city);
        self::assertSame($returnState, $request->returnAddress->state);
        self::assertSame($returnCountry, $request->returnAddress->country);
        self::assertSame($returnPostCode, $request->returnAddress->postalCode);
        self::assertSame($returnEmail, $request->returnAddress->email);
        self::assertSame($returnPhone, $request->returnAddress->phone);

        self::assertSame($shipperName, $request->shipperAddress->name);
        self::assertSame($shipperCompany, $request->shipperAddress->companyName);
        self::assertSame($shipperStreet[0], $request->shipperAddress->address1);
        self::assertSame($shipperStreet[1], $request->shipperAddress->address2);
        self::assertSame($shipperCity, $request->shipperAddress->city);
        self::assertSame($shipperState, $request->shipperAddress->state);
        self::assertSame($shipperCountry, $request->shipperAddress->country);
        self::assertSame($shipperPostCode, $request->shipperAddress->postalCode);
        self::assertSame($shipperEmail, $request->shipperAddress->email);
        self::assertSame($shipperPhone, $request->shipperAddress->phone);

        self::assertSame($pickupName, $request->pickupAddress->name);
        self::assertSame($pickupCompany, $request->pickupAddress->companyName);
        self::assertSame($pickupStreet[0], $request->pickupAddress->address1);
        self::assertSame($pickupStreet[1], $request->pickupAddress->address2);
        self::assertSame($pickupCity, $request->pickupAddress->city);
        self::assertSame($pickupState, $request->pickupAddress->state);
        self::assertSame($pickupCountry, $request->pickupAddress->country);
        self::assertSame($pickupPostCode, $request->pickupAddress->postalCode);
        self::assertSame($pickupEmail, $request->pickupAddress->email);
        self::assertSame($pickupPhone, $request->pickupAddress->phone);

        self::assertSame($packageId, $request->packageDetail->packageId);
        self::assertSame($packageDescription, $request->packageDetail->packageDescription);
        self::assertSame($packageReference, $request->packageDetail->packageReference);
        self::assertSame('SIGCON', $request->packageDetail->service);
        self::assertSame($serviceEndorsement, $request->packageDetail->serviceEndorsement);
        self::assertSame($dgCategory, $request->packageDetail->contentCategory);
        self::assertSame($billingRef, $request->packageDetail->billingReference1);
        self::assertSame($billRefBatch, $request->packageDetail->billingReference2);

        self::assertSame($packageWeight, $request->packageDetail->weight->value);
        self::assertSame($weightUom, $request->packageDetail->weight->unitOfMeasure);

        self::assertSame($dimensionLength, $request->packageDetail->dimension->length);
        self::assertSame($dimensionWidth, $request->packageDetail->dimension->width);
        self::assertSame($dimensionHeight, $request->packageDetail->dimension->height);
        self::assertSame($dimensionUom, $request->packageDetail->dimension->unitOfMeasure);

        self::assertSame($currency, $request->packageDetail->shippingCost->currency);
        self::assertSame($tax, $request->packageDetail->shippingCost->tax);
        self::assertSame($freight, $request->packageDetail->shippingCost->freight);
        self::assertSame($duty, $request->packageDetail->shippingCost->duty);
        self::assertSame($declaredValue, $request->packageDetail->shippingCost->declaredValue);
        self::assertSame($insuredValue, $request->packageDetail->shippingCost->insuredValue);
        self::assertTrue($request->packageDetail->shippingCost->dutiesPaid);

        self::assertSame($currency, $request->customsDetails[0]->currency);
        self::assertSame($sku, $request->customsDetails[0]->skuNumber);
        self::assertSame($exportDescription, $request->customsDetails[0]->itemDescription);
        self::assertSame($countryOfOrigin, $request->customsDetails[0]->countryOfOrigin);
        self::assertSame($hsCode, $request->customsDetails[0]->hsCode);
        self::assertSame($qty, $request->customsDetails[0]->packagedQuantity);
        self::assertSame($exportValue, $request->customsDetails[0]->itemValue);
    }

    /**
     * Assert invalid requests throw RequestValidatorException.
     *
     * @test
     * @dataProvider dataProvider
     *
     * @param LabelRequestBuilder $builder
     * @param string $exceptionMessage
     * @throws RequestValidatorException
     */
    public function invalidRequest(LabelRequestBuilder $builder, string $exceptionMessage)
    {
        $this->expectException(RequestValidatorException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $builder->create();
    }
}
