<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Model\Manifest;

/**
 * Class CreateManifestResponseType
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 *
 * !!! Do not change the annotation statements as this class is passed through the JsonMapper
 *     which requires the full namespace annotation in order to map the JSON response correctly.
 */
class CreateManifestRequestType implements \JsonSerializable
{
    /**
     * @var string
     */
    private $pickup;

    /**
     * @var string[]
     */
    private $packageIds;

    /**
     * CreateManifestRequestType constructor.
     *
     * @param string $pickup
     * @param string[] $packageIds
     */
    public function __construct(string $pickup, array $packageIds = [])
    {
        $this->pickup = $pickup;
        $this->packageIds = $packageIds;
    }

    /**
     * @todo(nr): check if empty manifests array is filtered away / if request is still valid then
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return  [
            'pickup' => $this->pickup,
            'manifests' => [
                ['packageIds' => $this->packageIds],
            ]
        ];
    }
}