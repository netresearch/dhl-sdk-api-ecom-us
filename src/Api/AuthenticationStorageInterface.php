<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Exception\AuthenticationStorageException;

/**
 * Interface AuthenticationStorageInterface
 *
 * Credentials Storage.
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
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
     * @return int
     * @throws AuthenticationStorageException
     */
    public function readTokenExpiry(): int;

    /**
     * @param string $token Bearer token
     * @param int $expiry Expiry timestamp
     * @return void
     * @throws AuthenticationStorageException
     */
    public function saveToken(string $token, int $expiry);
}
