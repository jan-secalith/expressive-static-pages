<?php

declare(strict_types=1);

namespace RestableSite;

use Zend\Hydrator\ObjectProperty;

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
            'templates' => $this->getTemplates(),
            'app' => $this->getApplicationConfig(),
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
            'table_service' => [
                'RestableSite\StaticPages\RequestDemo\TableService' => [
                    'gateway' => [
                        'name' => 'RestableSite\StaticPages\RequestDemo\TableGateway',
                    ],
                ],
            ],
            'gateway' => [
                'RestableSite\StaticPages\RequestDemo\TableGateway' => [
                    'name' => 'RestableSite\StaticPages\RequestDemo\TableGateway',
                    'table' => [
                        'name' => 'form_request_demo',
                        'object' => \RestableSite\StaticPages\Model\RequestDemoFormTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalSQLiteAdapter',
                    ],
                    'model' => [
                        "object" => StaticPages\Model\RequestDemoModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
            ],
            'route' => [
                'home' => [
                    'cache_response' => [
                        'enabled' => false,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-homepage-2018',
                            ],
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
                'restable.site.page.features.pos' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-features-pos',
                            ],
                        ],
                    ],
                ],
                'restable.site.page.features.stock' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-features-stock',
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
                'restable.site.page.privacy_policy' => [
                    'cache_response' => [
                        'enabled' => true,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-privacy-policy',
                            ],
                        ],
                    ],
                ],
                'restable.site.page.request_demo.post' => [
                    'cache_response' => [
                        'enabled' => false,
                    ],
                    'module' => [
                        'static_pages' => [
                            'view_template_model' => [
                                'layout' => 'restablesite-layout::restable-site',
                                'template' => 'staticpages::page-privacy-policy',
                            ],
                        ],
                    ],
                    'form' => [
                        [
                            'name' => 'form_request_demo',
                            'map_direction_src' => 'form',
                            'map' => [
                                'application_id' => 'application_id',
                                'name_first' => 'name_first',
                                'contact_email' => 'contact_email',
                                'contact_phone' => 'contact_phone',
                                'work_title' => 'work_title',
                                'venue_name' => 'venue_name',
                                'country' => 'country',
                                'ip' => 'ip',
                                'created' => 'created',
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }
}
