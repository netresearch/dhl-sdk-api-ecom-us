<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Exception\AuthenticationStorageException;

/**
 * @api
 */
interface AuthenticationStorageInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string
     * @throws AuthenticationStorageException
     */
    public function readToken(): string;

    /**
     * @param string $token Bearer token
     * @param int $lifetime Expiry time in seconds
     * @return void
     * @throws AuthenticationStorageException
     */
    public function saveToken(string $token, int $lifetime);
}
