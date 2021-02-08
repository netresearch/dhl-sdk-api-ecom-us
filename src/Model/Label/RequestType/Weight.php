<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

class Weight implements \JsonSerializable
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $unitOfMeasure;

    /**
     * Weight constructor.
     *
     * @param float $value
     * @param string $unitOfMeasure
     */
    public function __construct(float $value, string $unitOfMeasure)
    {
        $this->value = $value;
        $this->unitOfMeasure = $unitOfMeasure;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
