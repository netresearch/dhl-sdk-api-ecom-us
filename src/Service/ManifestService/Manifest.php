<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\ManifestService;

use Dhl\Sdk\EcomUs\Api\Data\Manifest\DocumentInterface;
use Dhl\Sdk\EcomUs\Api\Data\Manifest\ErrorInterface;
use Dhl\Sdk\EcomUs\Api\Data\ManifestInterface;

class Manifest implements ManifestInterface
{
    /**
     * @var string
     */
    private $requestId;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $status;

    /**
     * @var DocumentInterface[]
     */
    private $documents;

    /**
     * @var ErrorInterface[]
     */
    private $errors;

    /**
     * Manifest constructor.
     *
     * @param string $requestId
     * @param string $timestamp
     * @param string $status
     * @param DocumentInterface[] $documents
     * @param ErrorInterface[] $errors
     */
    public function __construct(
        string $requestId,
        string $timestamp,
        string $status,
        array $documents,
        array $errors
    ) {
        $this->requestId = $requestId;
        $this->timestamp = $timestamp;
        $this->status = $status;
        $this->documents = $documents;
        $this->errors = $errors;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDocuments(): array
    {
        return $this->documents;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
