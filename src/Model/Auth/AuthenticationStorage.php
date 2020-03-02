<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Auth;

use Dhl\Sdk\EcomUs\Api\AuthenticationStorageInterface;

/**
 * Class AuthenticationStorage
 *
 * Default authentication storage implementation. Token will be discarded when
 * storage object gets destroyed. To persist and re-use the token, implement a
 * custom storage (e.g. session storage, database storage).
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class AuthenticationStorage implements AuthenticationStorageInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token = '';

    /**
     * @var int
     */
    private $expiry = 0;

    /**
     * AuthenticationStorage constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function readToken(): string
    {
        return $this->token;
    }

    public function readTokenExpiry(): int
    {
        return $this->expiry;
    }

    public function saveToken(string $token, int $expiry)
    {
        $this->token = $token;
        $this->expiry = $expiry;
    }
}
