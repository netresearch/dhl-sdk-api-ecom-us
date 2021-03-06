<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\EcomUs\Api;

use Dhl\Sdk\EcomUs\Exception\ServiceException;
use Psr\Log\LoggerInterface;

/**
 * @api
 */
interface ServiceFactoryInterface
{
    public const SANDBOX_BASE_URL = 'https://api-sandbox.dhlecs.com/';
    public const PRODUCTION_BASE_URL = 'https://api.dhlecs.com/';

    /**
     * Create the label creation service.
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param LoggerInterface $logger
     * @param bool $sandboxMode
     *
     * @return LabelServiceInterface
     * @throws ServiceException
     */
    public function createLabelService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): LabelServiceInterface;

    /**
     * Create the label manifestation service.
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param LoggerInterface $logger
     * @param bool $sandboxMode
     *
     * @return ManifestServiceInterface
     * @throws ServiceException
     */
    public function createManifestationService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ManifestServiceInterface;
}
