<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Http\ClientPlugin;

use Dhl\Sdk\EcomUs\Api\AuthenticationStorageInterface;
use Dhl\Sdk\EcomUs\Exception\AuthenticationException;
use Dhl\Sdk\EcomUs\Exception\AuthenticationStorageException;
use Dhl\Sdk\EcomUs\Service\AuthenticationService;
use Http\Client\Common\Plugin;
use Http\Client\Exception\TransferException;
use Http\Message\Authentication\Bearer;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

/**
 * Class AuthenticationPlugin
 *
 * On authentication errors, renew token and try again.
 */
final class AuthenticationPlugin implements Plugin
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * @var AuthenticationStorageInterface
     */
    private $authStorage;

    /**
     * @var int
     */
    private $maxRetry = 1;

    /**
     * AuthenticationPlugin constructor.
     *
     * @param AuthenticationService $authService
     * @param AuthenticationStorageInterface $authStorage
     */
    public function __construct(
        AuthenticationService $authService,
        AuthenticationStorageInterface $authStorage
    ) {
        $this->authService = $authService;
        $this->authStorage = $authStorage;
    }

    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @param RequestInterface $request
     * @param callable $next Next middleware in the chain, the request is passed as the first argument
     * @param callable $first First middleware in the chain, used to to restart a request
     *
     * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient).
     *
     * @throws AuthenticationException
     * @throws AuthenticationStorageException
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $authToken = $this->authStorage->readToken();
        if (!$authToken) {
            // perform authentication with basic auth
            $authToken = $this->renewToken();
        }

        $authentication = new Bearer($authToken);
        /** @var RequestInterface $request */
        $request = $authentication->authenticate($request);

        /** @var Promise $promise */
        $promise = $next($request);

        $fnRejected = function (TransferException $exception) use ($request, $next, $first) {
            if (($this->maxRetry > 0) && ($exception->getCode() === 401)) {
                $this->maxRetry--;

                // perform authentication with basic auth
                $this->renewToken();

                // try again
                $promise = $this->handleRequest($request, $next, $first);

                return $promise->wait();
            }

            throw $exception;
        };

        return $promise->then(null, $fnRejected);
    }

    /**
     * Request a new token using basic authentication.
     *
     * If request fails, an SDK service exception is thrown (not an instance
     * of `\Http\Client\Exception`) which will immediately terminate the original
     * request and break the plugin chain.
     *
     * @link http://docs.php-http.org/en/latest/plugins/build-your-own.html
     *
     * @return string
     * @throws AuthenticationException
     * @throws AuthenticationStorageException
     */
    private function renewToken(): string
    {
        // perform authentication with basic auth
        $authResponse = $this->authService->authenticate(
            $this->authStorage->getUsername(),
            $this->authStorage->getPassword()
        );

        $this->authStorage->saveToken($authResponse->getValue(), $authResponse->getExpiresIn());

        return $authResponse->getValue();
    }
}
