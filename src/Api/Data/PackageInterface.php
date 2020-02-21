<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api\Data;

/**
 * Interface PackageInterface
 *
 * @api
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
interface PackageInterface
{
    /**
     * Returns the package id reference for which label was created (Customer Confirmation Number, CCN).
     *
     * @return string
     */
    public function getPackageId(): string;

    /**
     * Returns the package id generated with the label (DHL GM Number / Mail Identifier).
     *
     * @return string
     */
    public function getDhlPackageId(): string;

    /**
     * Returns the tracking number (DSP Tracking Number). Provided only for some labels.
     *
     * @return string
     */
    public function getTrackingNumber(): string;

    /**
     * Returns the format of returned label.
     *
     * @return string
     */
    public function getFormat(): string;

    /**
     * Returns the BASE64 encoded labels.
     *
     * @return string[]
     */
    public function getLabels(): array;
}
