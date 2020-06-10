<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api\Data\Manifest;

/**
 * Manifestation document.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface DocumentInterface
{
    /**
     * Obtain identifier for the document.
     *
     * @return string
     */
    public function getDocumentId(): string;

    /**
     * Obtain the date the document was created.
     *
     * @return string
     */
    public function getDateCreated(): string;

    /**
     * Obtain the format of the document, e.g. PDF, PNG.
     *
     * @return string
     */
    public function getFormat(): string;

    /**
     * Obtain the binary document data.
     *
     * @return string
     */
    public function getData(): string;
}
