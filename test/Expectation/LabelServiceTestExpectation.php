<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Test\Expectation;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;
use Dhl\Sdk\EcomUs\Model\Label\CreateLabelRequestType;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\RequestInterface;
use Psr\Log\Test\TestLogger;

/**
 * Class LabelServiceExpectation
 *
 * @author  Andreas Müller <andreas.mueller@netresearch.de>
 * @link    https://www.netresearch.de
 */
class LabelServiceTestExpectation
{
    /**
     * Assert that the properties in the request object match the serialized request payload.
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $requestJson
     */
    public static function assertLabelRequest(CreateLabelRequestType $labelRequest, string $requestJson)
    {
        $expected = json_decode(json_encode($labelRequest), true);
        $actual = json_decode($requestJson, true);

        Assert::assertSame($expected['pickup'], $actual['pickup']);
        Assert::assertSame($expected['distributionCenter'], $actual['distributionCenter']);
        Assert::assertSame($expected['orderedProductId'], $actual['orderedProductId']);
        Assert::assertSame($expected['consigneeAddress']['name'], $actual['consigneeAddress']['name']);
        Assert::assertSame($expected['consigneeAddress']['country'], $actual['consigneeAddress']['country']);
        Assert::assertSame($expected['consigneeAddress']['postalCode'], $actual['consigneeAddress']['postalCode']);
        Assert::assertSame($expected['consigneeAddress']['address1'], $actual['consigneeAddress']['address1']);
        Assert::assertSame($expected['consigneeAddress']['state'], $actual['consigneeAddress']['state']);
        Assert::assertSame($expected['shipperAddress']['companyName'], $actual['shipperAddress']['companyName']);
        Assert::assertSame($expected['shipperAddress']['country'], $actual['shipperAddress']['country']);
        Assert::assertSame($expected['shipperAddress']['postalCode'], $actual['shipperAddress']['postalCode']);
        Assert::assertSame($expected['shipperAddress']['city'], $actual['shipperAddress']['city']);
        Assert::assertSame($expected['shipperAddress']['address1'], $actual['shipperAddress']['address1']);
        Assert::assertSame($expected['packageDetail']['packageId'], $actual['packageDetail']['packageId']);
        Assert::assertSame($expected['packageDetail']['packageId'], $actual['packageDetail']['packageId']);
        Assert::assertSame($expected['packageDetail']['weight'], $actual['packageDetail']['weight']);
    }

    /**
     * Assert that the properties from the response are mapped to the label object.
     *
     * @param LabelInterface $label
     * @param string $responseJson
     */
    public static function assertLabelResponse(LabelInterface $label, string $responseJson)
    {
        $responseData = json_decode($responseJson, true);
        Assert::assertSame($responseData['labels'][0]['packageId'], $label->getPackageId());
        Assert::assertSame($responseData['labels'][0]['dhlPackageId'], $label->getDhlPackageId());
        Assert::assertSame($responseData['labels'][0]['trackingId'], $label->getTrackingId());
        Assert::assertSame($responseData['labels'][0]['format'], $label->getFormat());
    }

    /**
     * Assert that there was an error logged for error responses
     *
     * @param \Throwable $exception
     * @param TestLogger $logger
     */
    public static function assertExceptionLogged(\Throwable $exception, TestLogger $logger)
    {
        Assert::assertTrue($logger->hasErrorRecords(), 'No error logged');
        Assert::assertTrue($logger->hasErrorThatContains($exception->getMessage()), 'Error message not logged');
    }

    /**
     * Assert that error communication was logged
     *
     * @param string $responseJson
     * @param RequestInterface $request
     * @param TestLogger $logger
     */
    public static function assertErrorLogged(string $responseJson, RequestInterface $request, TestLogger $logger)
    {
        $statusRegex = '|^HTTP/\d\.\d\s\d{3}\s[\w\s]+$|m';

        $hasRequest = $logger->hasErrorThatContains($request->getUri()->getQuery());
        $hasResponseStatus = $logger->hasErrorThatMatches($statusRegex);
        $hasResponse = $logger->hasErrorThatContains($responseJson);

        Assert::assertTrue($hasRequest, 'Logged messages do not contain request.');
        Assert::assertTrue($hasResponseStatus, 'Logged messages do not contain response status code.');
        Assert::assertTrue($hasResponse, 'Logged messages do not contain response.');
    }

    /**
     * Assert that successful communication was logged
     *
     * @param string $responseJson
     * @param RequestInterface $request
     * @param TestLogger $logger
     */
    public static function assertCommunicationLogged(
        string $responseJson,
        RequestInterface $request,
        TestLogger $logger
    ) {
        $statusRegex = '|^HTTP/\d\.\d\s\d{3}\s[\w\s]+$|m';

        $hasRequest = $logger->hasInfoThatContains($request->getUri()->getQuery());
        $hasResponseStatus = $logger->hasInfoThatMatches($statusRegex);
        $hasResponse = $logger->hasInfoThatContains($responseJson);

        Assert::assertTrue($hasRequest, 'Logged messages do not contain request.');
        Assert::assertTrue($hasResponseStatus, 'Logged messages do not contain response status code.');
        Assert::assertTrue($hasResponse, 'Logged messages do not contain response.');
    }
}
