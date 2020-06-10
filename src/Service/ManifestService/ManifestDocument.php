<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Service\ManifestService;

use Dhl\Sdk\EcomUs\Api\Data\Manifest\DocumentInterface;

/**
 * Manifest document response model.
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class ManifestDocument implements DocumentInterface
{
    /**
     * @var string
     */
    private $documentId;

    /**
     * @var string
     */
    private $dateCreated;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $data;

    /**
     * ManifestDocument constructor.
     *
     * @param string $documentId
     * @param string $dateCreated
     * @param string $format
     * @param string $data
     */
    public function __construct(string $documentId, string $dateCreated, string $format, string $data)
    {
        $this->documentId = $documentId;
        $this->dateCreated = $dateCreated;
        $this->format = $format;
        $this->data = $data;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getData(): string
    {
        return $this->data;
    }
}
