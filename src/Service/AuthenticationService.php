<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service;

use Dhl\Sdk\EcomUs\Exception\AuthenticationException;
use Dhl\Sdk\EcomUs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\EcomUs\Model\Auth\AuthenticationResponseMapper;
use Dhl\Sdk\EcomUs\Model\Auth\AuthenticationResponseType;
use Dhl\Sdk\EcomUs\Serializer\JsonSerializer;
use Dhl\Sdk\EcomUs\Service\AuthenticationService\Token;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class AuthenticationService
 *
 * Entrypoint for DHL eCommerce API authentication.
 */
class AuthenticationService
{
    private const RESOURCE = 'auth/v4/accesstoken';

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
     * @var AuthenticationResponseMapper
     */
    private $responseMapper;

    /**
     * AuthenticationService constructor.
     *
     * @param HttpClient $client
     * @param string $baseUrl
     * @param JsonSerializer $serializer
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     * @param AuthenticationResponseMapper $responseMapper
     */
    public function __construct(
        HttpClient $client,
        string $baseUrl,
        JsonSerializer $serializer,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        AuthenticationResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->serializer = $serializer;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->responseMapper = $responseMapper;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Token
     * @throws AuthenticationException
     */
    public function authenticate(
        string $username,
        string $password
    ): Token {
        try {
            $basicAuth = \sprintf('Basic %s', \base64_encode(\sprintf('%s:%s', $username, $password)));

            $httpRequest = $this->requestFactory->createRequest('POST', $this->baseUrl . self::RESOURCE)
                ->withBody($this->streamFactory->createStream('grant_type=client_credentials'))
                ->withAddedHeader('Authorization', $basicAuth);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            /** @var AuthenticationResponseType $authResponse */
            $authResponse = $this->serializer->decode($responseJson, AuthenticationResponseType::class);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        }

        return $this->responseMapper->map($authResponse);
    }
}
