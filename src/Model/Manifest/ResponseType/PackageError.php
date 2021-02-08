<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest\ResponseType;

/**
 * Class PackageError
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class PackageError
{
    /**
     * @var string
     */
    private $dhlPackageId;

    /**
     * @var string
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorDescription;

    /**
     * @return string
     */
    public function getDhlPackageId(): string
    {
        return $this->dhlPackageId;
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorDescription(): string
    {
        return $this->errorDescription;
    }
}
