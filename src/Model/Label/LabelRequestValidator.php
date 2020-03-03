<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Exception\RequestValidatorException;

/**
 * Class LabelRequestValidator
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class LabelRequestValidator
{
    public const MSG_ACCOUNT_DATA_REQUIRED = 'Pickup account number and primary distribution center are required.';
    public const MSG_CONSIGNEE_REQUIRED = 'Recipient address is required.';
    public const MSG_CONSIGNEE_STATE_REQUIRED = 'Recipient state is required for US addresses.';
    public const MSG_PRODUCT_REQUIRED = 'Three-character product code is required.';
    public const MSG_PACKAGE_ID_REQUIRED = 'Package ID is required.';
    public const MSG_WEIGHT_REQUIRED = 'Package weight details are required.';

    /**
     * Validate request data before sending it to the web service.
     *
     * @param mixed[][] $data
     *
     * @throws RequestValidatorException
     */
    public static function validate(array $data): void
    {
        if (empty($data['shipmentDetails']['pickupAccount']) || empty($data['shipmentDetails']['distributionCenter'])) {
            throw new RequestValidatorException(self::MSG_ACCOUNT_DATA_REQUIRED);
        }

        if (empty($data['recipient'])) {
            throw new RequestValidatorException(self::MSG_CONSIGNEE_REQUIRED);
        }

        if (($data['recipient']['country'] === 'US') && empty($data['recipient']['state'])) {
            throw new RequestValidatorException(self::MSG_CONSIGNEE_STATE_REQUIRED);
        }

        if (empty($data['packageDetails']['orderedProduct'])) {
            throw new RequestValidatorException(self::MSG_PRODUCT_REQUIRED);
        }

        if (empty($data['packageDetails']['packageId'])) {
            throw new RequestValidatorException(self::MSG_PACKAGE_ID_REQUIRED);
        }

        if (empty($data['packageDetails']['weight'])) {
            throw new RequestValidatorException(self::MSG_WEIGHT_REQUIRED);
        }
    }
}
