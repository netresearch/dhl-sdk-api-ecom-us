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
use Dhl\Sdk\EcomUs\Test\Provider\AuthServiceTestProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class AuthenticationServiceTest extends TestCase
{
    /**
     * @return \JsonSerializable[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function successDataProvider(): array
    {
        return AuthServiceTestProvider::authenticationSuccess();
    }

    /**
     * @return \JsonSerializable[][]|int[][]|string[][]
     * @throws RequestValidatorException
     */
    public static function errorDataProvider(): array
    {
        return AuthServiceTestProvider::authenticationFailure();
    }

    /**
     * Scenario: The storage contains a valid token. Auth service is not invoked.
     *
     * - Assert auth token remains unchanged.
     *
     * @test
     * @dataProvider successDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $labelResponseBody
     * @throws ServiceException
     */
    public function validTokenStored(
        CreateLabelRequestType $labelRequest,
        string $labelResponseBody
    ) {
        $token = 'test1234';

        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $authStorage->saveToken($token, 3600);
        $logger = new NullLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->addResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($labelResponseBody))
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);
        $service->createLabel($labelRequest);

        self::assertSame($token, $authStorage->readToken(), 'Token was unexpectedly changed.');
    }

    /**
     * Scenario: The storage contains no token but username/password. Auth service is invoked before label request.
     *
     * - Assert auth token from service response is stored.
     *
     * @test
     * @dataProvider successDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $labelResponseBody
     * @param string $authResponseBody
     * @throws ServiceException
     */
    public function noTokenStored(
        CreateLabelRequestType $labelRequest,
        string $labelResponseBody,
        string $authResponseBody
    ) {
        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $logger = new NullLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->addResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($authResponseBody))
        );
        $httpClient->addResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($labelResponseBody))
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);
        $service->createLabel($labelRequest);

        $authResponse = json_decode($authResponseBody);
        self::assertSame($authResponse->access_token, $authStorage->readToken());
    }

    /**
     * Scenario: The storage contains an expired token and username/password.
     *           Auth service is invoked before label request.
     *
     * - Assert auth token from service response is stored.
     *
     * @test
     * @dataProvider successDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $labelResponseBody
     * @param string $authResponseBody
     * @throws ServiceException
     */
    public function expiredTokenStored(
        CreateLabelRequestType $labelRequest,
        string $labelResponseBody,
        string $authResponseBody
    ) {
        $token = 'test1234';

        $authStorage = new AuthenticationStorage('u5er', 'p4ss');
        $authStorage->saveToken($token, -1);
        $logger = new NullLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->addResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($authResponseBody))
        );
        $httpClient->addResponse(
            $responseFactory
                ->createResponse(200, 'OK')
                ->withBody($streamFactory->createStream($labelResponseBody))
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);
        $service->createLabel($labelRequest);

        $authResponse = json_decode($authResponseBody);
        self::assertSame($authResponse->access_token, $authStorage->readToken());
    }

    /**
     * Scenario: The storage contains invalid token/username/password. Both endpoints return errors.
     *
     * - Assert detailed service exception being thrown.
     *
     * @test
     * @dataProvider errorDataProvider
     *
     * @param CreateLabelRequestType $labelRequest
     * @param string $labelResponseBody
     * @param string $authResponseBody
     * @throws ServiceException
     */
    public function invalidCredentialsStored(
        CreateLabelRequestType $labelRequest,
        string $labelResponseBody,
        string $authResponseBody
    ) {
        $authResponse = json_decode($authResponseBody);
        $responseStatus = 401;

        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionMessage(sprintf('[%s] %s', $responseStatus, $authResponse->title));

        $token = 'wR0nG-t0k3n';

        $authStorage = new AuthenticationStorage('u5er', 'wR0nG-p4ss');
        $authStorage->saveToken($token, 3600);
        $logger = new NullLogger();

        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpClient->addResponse(
            $responseFactory
                ->createResponse($responseStatus)
                ->withBody($streamFactory->createStream($labelResponseBody))
                ->withHeader('Content-Type', 'application/problem+json')
        );
        $httpClient->addResponse(
            $responseFactory
                ->createResponse($responseStatus)
                ->withBody($streamFactory->createStream($authResponseBody))
                ->withHeader('Content-Type', 'application/problem+json')
        );

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createLabelService($authStorage, $logger, true);
        $service->createLabel($labelRequest);
    }
}
