<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Api\Data\PackageInterface;
use Dhl\Sdk\EcomUs\Service\LabelService\Package;

/**
 * Class LabelResponseMapper
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class LabelResponseMapper
{
    /**
     * Map the webservice data structure to response objects suitable for third-party consumption.
     *
     * @param CreateLabelResponseType $response
     *
     * @return PackageInterface
     */
    public function map(CreateLabelResponseType $response): PackageInterface
    {
        //todo(nr): map label response to package
        return new Package('', '', '', '', []);
    }
}
