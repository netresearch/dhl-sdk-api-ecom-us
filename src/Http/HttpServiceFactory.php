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
use Dhl\Sdk\EcomUs\Http\ClientPlugin\AuthenticationPlugin;
use Dhl\Sdk\EcomUs\Http\ClientPlugin\ErrorPlugin;
use Dhl\Sdk\EcomUs\Model\Auth\AuthenticationResponseMapper;
use Dhl\Sdk\EcomUs\Model\Label\LabelResponseMapper;
use Dhl\Sdk\EcomUs\Model\Manifest\ManifestResponseMapper;
use Dhl\Sdk\EcomUs\Serializer\JsonSerializer;
use Dhl\Sdk\EcomUs\Service\AuthenticationService;
use Dhl\Sdk\EcomUs\Service\LabelService;
use Dhl\Sdk\EcomUs\Service\ManifestService;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
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
     * HttpServiceFactory constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function createAuthenticationService(
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): AuthenticationService {
        $serializer = new JsonSerializer();

        $plugins = [
            new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
            new ErrorPlugin(),
        ];
        $client = new PluginClient($this->httpClient, $plugins);

        $baseUrl = $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $responseMapper = new AuthenticationResponseMapper();

        return new AuthenticationService(
            $client,
            $baseUrl,
            $serializer,
            $requestFactory,
            $streamFactory,
            $responseMapper
        );
    }

    public function createLabelService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): LabelServiceInterface {
        $serializer = new JsonSerializer();
        $authService = $this->createAuthenticationService($logger, $sandboxMode);

        // todo(nr): set user agent header
        $plugins = [
            new HeaderDefaultsPlugin(['Accept' => 'application/json', 'Content-Type' => 'application/json']),
            new AuthenticationPlugin($authService, $authStorage),
            new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
            new ErrorPlugin(),
        ];
        $client = new PluginClient($this->httpClient, $plugins);

        $baseUrl = $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseMapper = new LabelResponseMapper();

        return new LabelService(
            $client,
            $baseUrl,
            $serializer,
            $requestFactory,
            $streamFactory,
            $responseMapper
        );
    }

    public function createManifestationService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ManifestServiceInterface {
        $serializer = new JsonSerializer();
        $authService = $this->createAuthenticationService($logger, $sandboxMode);

        // todo(nr): set user agent header
        $plugins = [
            new HeaderDefaultsPlugin(['Accept' => 'application/json', 'Content-Type' => 'application/json']),
            new AuthenticationPlugin($authService, $authStorage),
            new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
            new ErrorPlugin(),
        ];
        $client = new PluginClient($this->httpClient, $plugins);

        $baseUrl = $sandboxMode ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseMapper = new ManifestResponseMapper();

        return new ManifestService(
            $client,
            $baseUrl,
            $serializer,
            $requestFactory,
            $streamFactory,
            $responseMapper
        );
    }
}
