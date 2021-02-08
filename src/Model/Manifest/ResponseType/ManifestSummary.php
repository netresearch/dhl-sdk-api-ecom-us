<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest\ResponseType;

/**
 * Class ManifestSummary
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class ManifestSummary
{
    /**
     * @var int
     */
    private $total;

    /**
     * @var \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\Invalid
     */
    private $invalid;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return \Dhl\Sdk\EcomUs\Model\Manifest\ResponseType\Invalid
     */
    public function getInvalid(): Invalid
    {
        return $this->invalid;
    }
}
