<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service;

use Dhl\Sdk\EcomUs\Exception\DetailedServiceException;
use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;
use Dhl\Sdk\EcomUs\Exception\ServiceException;
use Dhl\Sdk\EcomUs\Http\HttpServiceFactory;
use Dhl\Sdk\EcomUs\Model\Auth\AuthenticationStorage;
use Dhl\Sdk\EcomUs\Model\Label\CreateLabelRequestType;
use Dhl\Sdk\EcomUs\Test\Expectation\LabelServiceTestExpectation as Expectation;
use Dhl\Sdk\EcomUs\Test\Provider\LabelServiceTestProvider;
use Http\Client\Exception\NetworkException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class LabelServiceTest extends TestCase
{
    /**
     * @return \JsonSerializable[][]|string[][]
     * @throws RequestValidatorException
     */
    public function successDataProvider(): array
    {
        return LabelServiceTestProvider::labelSuccess();
    }

    /**
     * @return \JsonSerializable[][]|int[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function errorDataProvider(): array
    {
        return LabelServiceTestProvider::labelError();
    }

    /**
     * @test
     * @dataProvider successDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $responseBody
     * @throws ServiceException
     */
    public function labelSuccess(CreateLabelRequestType $labelRequest, string $responseBody)
    {
        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $authStorage->saveToken('123123123123', 3600);
        $logger = new TestLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->setDefaultResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($responseBody))
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);
        $label = $service->createLabel($labelRequest);

        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string)$lastRequest->getBody();

        Expectation::assertLabelRequest($labelRequest, $requestBody);
        Expectation::assertLabelResponse($label, $responseBody);
        Expectation::assertCommunicationLogged($responseBody, $lastRequest, $logger);
    }

    /**
     * @test
     * @dataProvider errorDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param int $responseStatus
     * @param string $responseBody
     * @throws ServiceException
     */
    public function labelError(CreateLabelRequestType $labelRequest, int $responseStatus, string $responseBody)
    {
        $labelResponse = json_decode($responseBody);
        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionCode($responseStatus);
        $this->expectExceptionMessage(sprintf('[%s] %s', $responseStatus, $labelResponse->title));

        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $authStorage->saveToken('123123123123', 3600);
        $logger = new TestLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->setDefaultResponse(
            $responseFactory
                ->createResponse($responseStatus)
                ->withBody($streamFactory->createStream($responseBody))
                ->withHeader('Content-Type', 'application/problem+json')
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);

        try {
            $service->createLabel($labelRequest);
        } catch (ServiceException $exception) {
            $lastRequest = $httpClient->getLastRequest();

            Expectation::assertExceptionLogged($exception, $logger);
            Expectation::assertErrorLogged($responseBody, $lastRequest, $logger);

            throw $exception;
        }
    }

    /**
     * @test
     * @dataProvider successDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @throws ServiceException
     */
    public function networkError(CreateLabelRequestType $labelRequest)
    {
        $this->expectException(ServiceException::class);

        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $authStorage->saveToken('123123123123', 3600);
        $logger = new TestLogger();

        $httpClient = new Client();
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $payload = json_encode($labelRequest);
        $stream = $streamFactory->createStream($payload);

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);

        $httpRequest = $requestFactory->createRequest('POST', 'http://thersnothing.com');
        $httpRequest->withBody($stream);
        $httpClient->setDefaultException(
            new NetworkException('Could not resolve host: shagflksagfda.com', $httpRequest)
        );

        try {
            $service->createLabel($labelRequest);
        } catch (ServiceException $exception) {
            Expectation::assertExceptionLogged($exception, $logger);

            throw $exception;
        }
    }
}
