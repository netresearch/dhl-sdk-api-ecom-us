<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api\Data;

use Dhl\Sdk\EcomUs\Api\Data\Manifest\DocumentInterface;
use Dhl\Sdk\EcomUs\Api\Data\Manifest\ErrorInterface;

/**
 * @api
 */
interface ManifestInterface
{
    public const STATUS_CREATED = 'CREATED';
    public const STATUS_IN_PROGRESS = 'IN PROGRESS';
    public const STATUS_COMPLETED = 'COMPLETED';

    /**
     * Returns the ID of the manifestation request.
     *
     * @return string
     */
    public function getRequestId(): string;

    /**
     * Returns the manifest timestamp.
     *
     * @return string
     */
    public function getTimestamp(): string;

    /**
     * Returns the status of the manifestation request: "CREATED", "IN PROGRESS", "COMPLETED".
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Returns the downloaded binary manifest documents.
     *
     * @see getDocumentsLink
     * @return DocumentInterface[]
     */
    public function getDocuments(): array;

    /**
     * Returns error information of packages failed to be manifested.
     *
     * @return ErrorInterface[]
     */
    public function getErrors(): array;
}
