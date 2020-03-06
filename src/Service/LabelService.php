<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;
use Dhl\Sdk\EcomUs\Api\LabelServiceInterface;
use Dhl\Sdk\EcomUs\Exception\AuthenticationException;
use Dhl\Sdk\EcomUs\Exception\AuthenticationStorageException;
use Dhl\Sdk\EcomUs\Exception\DetailedErrorException;
use Dhl\Sdk\EcomUs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\EcomUs\Model\Label\CreateLabelResponseType;
use Dhl\Sdk\EcomUs\Model\Label\LabelResponseMapper;
use Dhl\Sdk\EcomUs\Serializer\JsonSerializer;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * LabelService
 *
 * Entrypoint for DHL eCommerce US label operations.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class LabelService implements LabelServiceInterface
{
    private const RESOURCE = 'shipping/v4/label';

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
     * @var LabelResponseMapper
     */
    private $responseMapper;

    /**
     * LabelService constructor.
     *
     * @param HttpClient $client
     * @param string $baseUrl
     * @param JsonSerializer $serializer
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     * @param LabelResponseMapper $responseMapper
     */
    public function __construct(
        HttpClient $client,
        string $baseUrl,
        JsonSerializer $serializer,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        LabelResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->serializer = $serializer;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->responseMapper = $responseMapper;
    }

    public function createLabel(
        \JsonSerializable $labelRequest,
        string $format = self::LABEL_FORMAT_PNG
    ): LabelInterface {
        $uri = $this->baseUrl . self::RESOURCE . '?format=' . $format;

        try {
            $payload = $this->serializer->encode($labelRequest);
            $stream = $this->streamFactory->createStream($payload);

            $httpRequest = $this->requestFactory->createRequest('POST', $uri)->withBody($stream);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            /** @var CreateLabelResponseType $labelResponse */
            $labelResponse = $this->serializer->decode($responseJson, CreateLabelResponseType::class);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            if ($exception instanceof AuthenticationException || $exception instanceof AuthenticationStorageException) {
                throw ServiceExceptionFactory::createDetailedServiceException($exception);
            }

            throw ServiceExceptionFactory::create($exception);
        }

        return $this->responseMapper->map($labelResponse);
    }
}
