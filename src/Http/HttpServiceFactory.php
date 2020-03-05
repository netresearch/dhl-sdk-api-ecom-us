<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Http;

use Dhl\Sdk\EcomUs\Api\AuthenticationStorageInterface;
use Dhl\Sdk\EcomUs\Api\LabelServiceInterface;
use Dhl\Sdk\EcomUs\Api\ManifestServiceInterface;
use Dhl\Sdk\EcomUs\Api\ServiceFactoryInterface;
use Dhl\Sdk\EcomUs\Exception\ServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\EcomUs\Http\ClientPlugin\AuthenticationPlugin;
use Dhl\Sdk\EcomUs\Http\ClientPlugin\ErrorPlugin;
use Dhl\Sdk\EcomUs\Model\Auth\AuthenticationResponseMapper;
use Dhl\Sdk\EcomUs\Model\Label\LabelResponseMapper;
use Dhl\Sdk\EcomUs\Model\Manifest\ManifestResponseMapper;
use Dhl\Sdk\EcomUs\Serializer\JsonSerializer;
use Dhl\Sdk\EcomUs\Service\AuthenticationService;
use Dhl\Sdk\EcomUs\Service\LabelService;
use Dhl\Sdk\EcomUs\Service\ManifestService;
use Http\Client\Common\Plugin\ContentLengthPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Formatter\FullHttpMessageFormatter;
use Psr\Log\LoggerInterface;

/**
 * Create a service instance for REST web service communication.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class HttpServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * HttpServiceFactory constructor.
     *
     * @param HttpClient $httpClient
     * @param string $userAgent
     */
    public function __construct(HttpClient $httpClient, string $userAgent = '')
    {
        $this->httpClient = $httpClient;
        $this->userAgent = $userAgent;
    }

    /**
     * @param LoggerInterface $logger
     * @param bool $sandboxMode
     * @return AuthenticationService
     * @throws ServiceException
     */
    private function createAuthenticationService(
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): AuthenticationService {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => $this->userAgent,
        ];

        $client = new PluginClient(
            $this->httpClient,
            [
                new HeaderSetPlugin(array_filter($headers)),
                new ContentLengthPlugin(),
                new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
                new ErrorPlugin(),
            ]
        );

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        return new AuthenticationService(
            $client,
            $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL,
            new JsonSerializer(),
            $requestFactory,
            $streamFactory,
            new AuthenticationResponseMapper()
        );
    }

    public function createLabelService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): LabelServiceInterface {
        $authService = $this->createAuthenticationService($logger, $sandboxMode);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent,
        ];

        $client = new PluginClient(
            $this->httpClient,
            [
                new HeaderDefaultsPlugin(array_filter($headers)),
                new AuthenticationPlugin($authService, $authStorage),
                new ContentLengthPlugin(),
                new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
                new ErrorPlugin(),
            ]
        );

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        return new LabelService(
            $client,
            $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL,
            new JsonSerializer(),
            $requestFactory,
            $streamFactory,
            new LabelResponseMapper()
        );
    }

    public function createManifestationService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ManifestServiceInterface {
        $authService = $this->createAuthenticationService($logger, $sandboxMode);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent,
        ];

        $client = new PluginClient(
            $this->httpClient,
            [
                new HeaderSetPlugin(array_filter($headers)),
                new ContentLengthPlugin(),
                new AuthenticationPlugin($authService, $authStorage),
                new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
                new ErrorPlugin(),
            ]
        );

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        return new ManifestService(
            $client,
            $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL,
            new JsonSerializer(),
            $requestFactory,
            $streamFactory,
            new ManifestResponseMapper()
        );
    }
}
