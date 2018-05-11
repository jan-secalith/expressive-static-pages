<?php

declare(strict_types=1);

namespace RestableSite;

/**
 * The configuration provider for the RestableSite module
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
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'app'    => $this->getApplicationConfig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                StaticPages\Handler\RequestDemoPageHandler::class => StaticPages\Handler\RequestDemoPageHandlerFactory::class,
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
                'staticpages'    => [__DIR__ . '/../templates/staticpages'],
                'restablesite-layout' => [__DIR__ . '/../templates/layout'],
                'restablesite-staticpages-form' => [__DIR__ . '/../templates/staticpages/form'],
            ],
        ];
    }

    public function getApplicationConfig()
    {
        return [
            'application' => [
                [
                    'application_id' => '1',
                    'application_name' => 'restablesite',
                ]
            ],
            'route' => [
                'restable.site.page.homepage' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'static_pages' => [
                        'view_template_model' => [
                            'layout' => 'restablesite-layout::restable-site',
                            'template' => 'staticpages::page-features',
                        ],
                    ],
                ],
                'restable.site.page.features' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-features',
                            ],
                        ],
                    ],
                ],
                'restable.site.page.pricing' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-pricing',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
