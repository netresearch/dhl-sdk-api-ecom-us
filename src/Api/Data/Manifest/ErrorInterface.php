<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api\Data\Manifest;

interface ErrorInterface
{
    /**
     * @return string
     */
    public function getPackageId(): string;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
}
