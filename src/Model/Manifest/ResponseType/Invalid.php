<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest\ResponseType;

/**
 * Class Invalid
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class Invalid
{
    /**
     * @var int
     */
    private $total;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\PackageError[]|null
     */
    private $dhlPackageIds;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\PackageError[]
     */
    public function getDhlPackageIds(): array
    {
        return $this->dhlPackageIds ?? [];
    }
}
