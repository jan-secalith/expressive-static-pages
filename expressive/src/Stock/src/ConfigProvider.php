<?php

declare(strict_types=1);

namespace Stock;

use Zend\Hydrator\ObjectProperty;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Handler\ScanBarcodeInHandler::class => Handler\ScanBarcodeInHandlerFactory::class,
                Handler\ProductListHandler::class => Handler\ProductListHandlerFactory::class,
                Handler\SearchBarcodeHandler::class => Handler\SearchBarcodeHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'stock'    => [__DIR__ . '/../templates/stock'],
                'stock-form'    => [__DIR__ . '/../templates/stock-form'],
            ],
        ];
    }

}
