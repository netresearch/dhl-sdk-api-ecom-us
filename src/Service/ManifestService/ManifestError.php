<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\ManifestService;

use Dhl\Sdk\EcomUs\Api\Data\Manifest\ErrorInterface;

class ManifestError implements ErrorInterface
{
    /**
     * @var string
     */
    private $packageId;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * ManifestError constructor.
     *
     * @param string $packageId
     * @param string $code
     * @param string $description
     */
    public function __construct(string $packageId, string $code, string $description)
    {
        $this->packageId = $packageId;
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPackageId(): string
    {
        return $this->packageId;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
