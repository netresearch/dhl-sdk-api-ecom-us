<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Provider;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;
use Dhl\Sdk\EcomUs\Model\Label\LabelRequestBuilder;

/**
 * Class LabelRequestProvider
 *
 * @author  Andreas Müller <andreas.mueller@netresearch.de>
 * @link    https://www.netresearch.de
 */
class LabelRequestProvider
{
    /**
     * @return \JsonSerializable
     * @throws RequestValidatorException
     */
    public static function validRequest(): \JsonSerializable
    {
        $requestBuilder = new LabelRequestBuilder();
        $requestBuilder->setShipperAccount('123456', 'USTEST');
        $requestBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $requestBuilder->setReturnAddress('US', '12345', 'City', ['123'], 'Comp');
        $requestBuilder->setPackageId('123');
        $requestBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            'foo',
            'foo@foo.foo',
            '123456',
            'CA'
        );
        $requestBuilder->setPackageDetails('PLT', 'USD', 1.2, 'LB');

        return $requestBuilder->create();
    }

    /**
     * Set no return address to trigger a validation error.
     *
     * @return \JsonSerializable
     * @throws RequestValidatorException
     */
    public static function validationErrorRequest(): \JsonSerializable
    {
        $requestBuilder = new LabelRequestBuilder();
        $requestBuilder->setShipperAccount('5351244', 'USMCO1', '123');
        $requestBuilder->setShipperAddress('US', '12345', 'City', ['123'], 'Comp');
        $requestBuilder->setPackageId('123');
        $requestBuilder->setRecipientAddress(
            'US',
            '94102',
            'Testcity',
            ['1 Street', ''],
            'Test Tester',
            'foo',
            'foo@test.foo',
            '123456',
            'CA'
        );
        $requestBuilder->setPackageDetails('PLT', 'USD', 1.2, 'LB');

        return $requestBuilder->create();
    }
}
