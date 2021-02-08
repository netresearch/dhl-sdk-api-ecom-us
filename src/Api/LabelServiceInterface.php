<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;
use Dhl\Sdk\EcomUs\Exception\DetailedServiceException;
use Dhl\Sdk\EcomUs\Exception\ServiceException;

/**
 * @api
 */
interface LabelServiceInterface
{
    public const LABEL_FORMAT_PNG = 'PNG';
    public const LABEL_FORMAT_ZPL = 'ZPL';

    /**
     * @param \JsonSerializable $labelRequest Request body.
     * @param string $format Mandatory parameter to define file format. One of PNG|ZPL
     *
     * @return LabelInterface
     *
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createLabel(
        \JsonSerializable $labelRequest,
        string $format = self::LABEL_FORMAT_PNG
    ): LabelInterface;
}
