<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api\Data;

/**
 * Interface ManifestInterface
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface ManifestInterface
{
    /**
     * Returns the manifest id.
     *
     * @return string
     */
    public function getManifestId(): string;

    /**
     * Returns the binary manifest document in PDF format.
     *
     * @return string
     */
    public function getData(): string;

    /**
     * Returns the IDs (DHL GM Numbers / Mail Identifiers) of packages successfully manifested.
     *
     * @return ManifestErrorInterface[]
     */
    public function getErrors(): array;
}
