<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service;

use Dhl\Sdk\EcomUs\Api\Data\ManifestInterface;
use Dhl\Sdk\EcomUs\Api\ManifestServiceInterface;
use Dhl\Sdk\EcomUs\Exception\AuthenticationException;
use Dhl\Sdk\EcomUs\Exception\AuthenticationStorageException;
use Dhl\Sdk\EcomUs\Exception\DetailedErrorException;
use Dhl\Sdk\EcomUs\Exception\DetailedServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\EcomUs\Model\Manifest\CreateManifestRequestType;
use Dhl\Sdk\EcomUs\Model\Manifest\CreateManifestResponseType;
use Dhl\Sdk\EcomUs\Model\Manifest\DownloadManifestResponseType;
use Dhl\Sdk\EcomUs\Model\Manifest\ManifestResponseMapper;
use Dhl\Sdk\EcomUs\Serializer\JsonSerializer;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * ManifestService
 *
 * Entrypoint for DHL eCommerce US manifestation operations.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ManifestService implements ManifestServiceInterface
{
    private const RESOURCE = 'shipping/v4/manifest';

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var JsonSerializer
     */
    private $serializer;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var ManifestResponseMapper
     */
    private $responseMapper;

    /**
     * ManifestService constructor.
     *
     * @param HttpClient $client
     * @param string $baseUrl
     * @param JsonSerializer $serializer
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     * @param ManifestResponseMapper $responseMapper
     */
    public function __construct(
        HttpClient $client,
        string $baseUrl,
        JsonSerializer $serializer,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        ManifestResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->serializer = $serializer;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->responseMapper = $responseMapper;
    }

    /**
     * Create manifest(s) for given packages.
     *
     * @param string $pickupAccountNumber
     * @param string[] $packageIds
     * @param string[] $dhlPackageIds
     *
     * @return ManifestInterface
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    private function manifest(
        string $pickupAccountNumber,
        array $packageIds = [],
        array $dhlPackageIds = []
    ): ManifestInterface {
        $uri = $this->baseUrl . self::RESOURCE;
        $manifestRequest = new CreateManifestRequestType($pickupAccountNumber, $packageIds, $dhlPackageIds);

        try {
            // create manifests
            $payload = $this->serializer->encode($manifestRequest);
            $stream = $this->streamFactory->createStream($payload);

            $httpRequest = $this->requestFactory->createRequest('POST', $uri)->withBody($stream);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            /** @var CreateManifestResponseType $manifestResponse */
            $manifestResponse = $this->serializer->decode($responseJson, CreateManifestResponseType::class);

            // download manifests
            $httpRequest = $this->requestFactory->createRequest('GET', $manifestResponse->getLink());
            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            /** @var DownloadManifestResponseType $downloadResponse */
            $downloadResponse = $this->serializer->decode($responseJson, DownloadManifestResponseType::class);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            if ($exception instanceof AuthenticationException || $exception instanceof AuthenticationStorageException) {
                throw ServiceExceptionFactory::createDetailedServiceException($exception);
            }

            throw ServiceExceptionFactory::create($exception);
        }

        return $this->responseMapper->map($downloadResponse);
    }

    public function createManifest(string $pickupAccountNumber): ManifestInterface
    {
        return $this->manifest($pickupAccountNumber, []);
    }

    public function createPackageManifest(
        string $pickupAccountNumber,
        array $packageIds = [],
        array $dhlPackageIds = []
    ): ManifestInterface {
        if (empty($packageIds) && empty($dhlPackageIds)) {
            // prevent manifesting all pending packages, do not send request
            throw new DetailedServiceException('No packages given to manifest.');
        }

        return $this->manifest($pickupAccountNumber, $packageIds, $dhlPackageIds);
    }

    public function getManifest(string $pickupAccountNumber, string $requestId): ManifestInterface
    {
        $uri = sprintf('%s%s/%s/%s', $this->baseUrl, self::RESOURCE, $pickupAccountNumber, $requestId);

        try {
            $httpRequest = $this->requestFactory->createRequest('GET', $uri);
            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            /** @var DownloadManifestResponseType $downloadResponse */
            $downloadResponse = $this->serializer->decode($responseJson, DownloadManifestResponseType::class);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            if ($exception instanceof AuthenticationException || $exception instanceof AuthenticationStorageException) {
                throw ServiceExceptionFactory::createDetailedServiceException($exception);
            }

            throw ServiceExceptionFactory::create($exception);
        }

        return $this->responseMapper->map($downloadResponse);
    }
}
