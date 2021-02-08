<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service;

use Dhl\Sdk\EcomUs\Api\AuthenticationStorageInterface;
use Dhl\Sdk\EcomUs\Api\LabelServiceInterface;
use Dhl\Sdk\EcomUs\Api\ManifestServiceInterface;
use Dhl\Sdk\EcomUs\Api\ServiceFactoryInterface;
use Dhl\Sdk\EcomUs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\EcomUs\Http\HttpServiceFactory;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\HttpClientDiscovery;
use Psr\Log\LoggerInterface;

class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var string
     */
    private $userAgent;

    /**
     * ServiceFactory constructor.
     *
     * @param string $userAgent
     */
    public function __construct(string $userAgent = '')
    {
        $this->userAgent = $userAgent;
    }

    public function createLabelService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): LabelServiceInterface {
        try {
            $httpClient = HttpClientDiscovery::find();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        $httpServiceFactory = new HttpServiceFactory($httpClient, $this->userAgent);
        return $httpServiceFactory->createLabelService($authStorage, $logger, $sandboxMode);
    }

    public function createManifestationService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ManifestServiceInterface {
        try {
            $httpClient = HttpClientDiscovery::find();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        $httpServiceFactory = new HttpServiceFactory($httpClient, $this->userAgent);
        return $httpServiceFactory->createManifestationService($authStorage, $logger, $sandboxMode);
    }
}
