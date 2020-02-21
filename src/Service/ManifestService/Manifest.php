<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\ManifestService;

use Dhl\Sdk\EcomUs\Api\Data\ManifestErrorInterface;
use Dhl\Sdk\EcomUs\Api\Data\ManifestInterface;

/**
 * Manifest service response model.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class Manifest implements ManifestInterface
{
    /**
     * @var string
     */
    private $manifestId;

    /**
     * @var string
     */
    private $data;

    /**
     * @var ManifestErrorInterface[]
     */
    private $errors;

    /**
     * Manifest constructor.
     * @param string $manifestId
     * @param string $data
     * @param ManifestErrorInterface[] $errors
     */
    public function __construct(string $manifestId, string $data, array $errors)
    {
        $this->manifestId = $manifestId;
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getManifestId(): string
    {
        return $this->manifestId;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return ManifestErrorInterface[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
