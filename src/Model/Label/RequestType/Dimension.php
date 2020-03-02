<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label\RequestType;

/**
 * Class Dimension
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class Dimension implements \JsonSerializable
{
    /**
     * @var float
     */
    private $length;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * @var string
     */
    private $unitOfMeasure;

    /**
     * Dimension constructor.
     *
     * @param float $length
     * @param float $width
     * @param float $height
     * @param string $unitOfMeasure
     */
    public function __construct(float $length, float $width, float $height, string $unitOfMeasure)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
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
