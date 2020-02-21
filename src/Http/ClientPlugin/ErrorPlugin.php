<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Http\ClientPlugin;

use Dhl\Sdk\EcomUs\Exception\AuthenticationErrorException;
use Dhl\Sdk\EcomUs\Exception\DetailedErrorException;
use Http\Client\Common\Plugin;
use Http\Client\Exception\HttpException;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Convert errors into exceptions, parse exception message from response if available.
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
final class ErrorPlugin implements Plugin
{
    /**
     * HTTP response codes
     */
    private const HTTP_UNAUTHORIZED = 401;

    /**
     * Returns TRUE if the response contains a parsable body.
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    private function isDetailedErrorResponse(ResponseInterface $response): bool
    {
        $contentTypes = $response->getHeader('Content-Type');
        return $contentTypes && (strpos($contentTypes[0], 'json') !== false);
    }

    /**
     * Returns the formatted error message.
     *
     * @see https://tools.ietf.org/html/rfc7807
     *
     * @param int $statusCode The response status code
     * @param string $reasonPhrase The response reason phrase
     * @param string[]|string[][] $responseData The response data in application/problem+json format
     * @return string
     */
    private function formatErrorMessage(int $statusCode, string $reasonPhrase, array $responseData): string
    {
        if (isset($responseData['title']) && is_string($responseData['title'])) {
            $title = sprintf('[%s] %s. ', $statusCode, $responseData['title']);
        } else {
            $title = sprintf('[%s] %s. ', $statusCode, $reasonPhrase);
        }

        if (!is_array($responseData['invalidParams'])) {
            return $title;
        }

        $issues = array_map(
            function (array $issue) {
                return sprintf('%s (%s): %s.', $issue['name'], $issue['path'], $issue['reason']);
            },
            $responseData['invalidParams']
        );

        return $title . implode(' ', $issues);
    }

    /**
     * Handles client/server errors with error messages in response body.
     *
     * @param int $statusCode
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws AuthenticationErrorException
     * @throws DetailedErrorException
     */
    private function handleDetailedError(int $statusCode, RequestInterface $request, ResponseInterface $response)
    {
        $responseJson = (string) $response->getBody();
        $responseData = \json_decode($responseJson, true);
        $errorMessage = $this->formatErrorMessage($statusCode, $response->getReasonPhrase(), $responseData);

        if ($statusCode === self::HTTP_UNAUTHORIZED) {
            throw new AuthenticationErrorException($errorMessage, $request, $response);
        }

        throw new DetailedErrorException($errorMessage, $request, $response);
    }

    /**
     * Handles all client/server errors when response does not contains body with error message.
     *
     * @param int $statusCode
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws AuthenticationErrorException
     * @throws HttpException
     */
    private function handleError(int $statusCode, RequestInterface $request, ResponseInterface $response)
    {
        if ($statusCode === self::HTTP_UNAUTHORIZED) {
            throw new AuthenticationErrorException(
                'Authentication failed. Please check your access credentials.',
                $request,
                $response
            );
        }

        throw new HttpException($response->getReasonPhrase(), $request, $response);
    }

    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @param RequestInterface $request
     * @param callable $next Next middleware in the chain, the request is passed as the first argument
     * @param callable $first First middleware in the chain, used to to restart a request
     *
     * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient).
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        /** @var Promise $promise */
        $promise = $next($request);

        // a response is available. transform error responses into exceptions
        $fnFulfilled = function (ResponseInterface $response) use ($request) {
            $statusCode = $response->getStatusCode();

            $this->isDetailedErrorResponse($response)
                ? $this->handleDetailedError($statusCode, $request, $response)
                : $this->handleError($statusCode, $request, $response);

            // no error
            return $response;
        };

        return $promise->then($fnFulfilled);
    }
}
