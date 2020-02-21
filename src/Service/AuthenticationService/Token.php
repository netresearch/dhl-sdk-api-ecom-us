<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\AuthenticationService;

/**
 * Authentication service response model.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class Token
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var string
     */
    private $clientId;

    /**
     * Token constructor.
     *
     * @param string $value
     * @param string $type
     * @param int $expiresIn
     * @param string $clientId
     */
    public function __construct(
        string $value,
        string $type,
        int $expiresIn,
        string $clientId
    ) {
        $this->value = $value;
        $this->type = $type;
        $this->expiresIn = $expiresIn;
        $this->clientId = $clientId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }
}
