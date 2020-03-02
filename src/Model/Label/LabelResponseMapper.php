<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Label;

use Dhl\Sdk\EcomUs\Api\Data\LabelInterface;
use Dhl\Sdk\EcomUs\Service\LabelService\Label;

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
     * @todo(nr): handle multi-label response if necessary
     *
     * @param CreateLabelResponseType $response
     *
     * @return LabelInterface
     */
    public function map(CreateLabelResponseType $response): LabelInterface
    {
        $labels = $response->getLabels();
        $label = $labels[0];

        $labelData = $label->getLabelData();
        if ($label->getEncodeType() === 'BASE64') {
            $labelData = base64_decode($labelData);
        }

        // todo(nr): handle possible decoding errors
        return new Label(
            $label->getPackageId(),
            $label->getDhlPackageId(),
            $label->getTrackingId(),
            $label->getFormat(),
            $labelData ?: ''
        );
    }
}
