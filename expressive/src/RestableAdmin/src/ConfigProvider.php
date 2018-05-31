<?php

declare(strict_types=1);

namespace RestableAdmin;

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
                Handler\AuthLoginHandler::class => Handler\Factory\AuthLoginHandlerFactory::class,
                Handler\AuthLogoutHandler::class => Handler\Factory\AuthLogoutHandlerFactory::class,
                Category\Form\CategoryForm::class =>
                    Category\Form\Factory\CategoryFormServiceFactory::class,
                Venue\Form\VenueWriteForm::class =>
                    Venue\Form\Factory\VenueFormServiceFactory::class,
                Client\Form\ClientWriteForm::class =>
                    Client\Form\Factory\VenueFormServiceFactory::class,
            ],
            'delegators' => [
                // It is worth to remind that Delegators are loaded using FIFO method.
                Handler\AuthLoginHandler::class => [
                    \Common\Handler\Delegator\ApplicationConfigAwareDelegator::class,
                    \Common\Handler\Delegator\ApplicationFormAwareDelegator::class,
                ],
                'RestableAdmin\Handler\CRUD\CreateHandler' => [
                    \Common\Handler\Delegator\ApplicationConfigAwareDelegator::class,
                    \Common\Handler\Delegator\ApplicationFormAwareDelegator::class,
                    \Common\Handler\Delegator\ApplicationFieldsetSaveServiceAwareDelegator::class,
                ],
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
                'restable-admin-layout'    => [__DIR__ . '/../templates/layout'],
                'restable-admin'    => [__DIR__ . '/../templates/restable-admin'],
                'restable-admin-venue'    => [__DIR__ . '/../templates/restable-admin/template-venue'],
                'restable-admin-application'    => [__DIR__ . '/../templates/restable-admin/template-application'],
                'restable-admin-client'    => [__DIR__ . '/../templates/restable-admin/template-client'],
                'restable-admin-category'    => [__DIR__ . '/../templates/restable-admin/template-category'],
                'restable-admin-contact'    => [__DIR__ . '/../templates/restable-admin/template-contact'],
                'restable-admin-authentication'    => [__DIR__ . '/../templates/restable-admin/template-authentication'],
                'restable-admin-partial'    => [__DIR__ . '/../templates/restable-admin/partial-common'],
            ],
        ];
    }

    public function getApplicationConfig()
    {
        return [
            'application' => [
                [
                    'application_id' => '9',
                    'application_name' => 'restableadmin',
                ]
            ],
            'table_service' => [
                'RestableAdmin\Admin\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Admin\TableGateway',
                    ],
                ],
                'RestableAdmin\Category\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Category\TableGateway',
                    ],
                ],
                'RestableAdmin\Client\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Client\TableGateway',
                    ],
                ],
                'RestableAdmin\Contact\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Contact\TableGateway',
                    ],
                ],
                'RestableAdmin\Contact\Address\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Contact\Address\TableGateway',
                    ],
                ],
                'RestableAdmin\Instance\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Instance\TableGateway',
                    ],
                ],
                'RestableAdmin\Venue\TableService' => [
                    'gateway' => [
                        'name' => 'RestableAdmin\Venue\TableGateway',
                    ],
                ],
            ],
            'gateway' => [
                'RestableAdmin\StaticPages\RequestDemo\TableGateway' => [
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
                'RestableAdmin\Order\TableGateway' => [
                    'name' => 'RestableAdmin\Order\TableGateway',
                    'table' => [
                        'name' => 'order',
                        'object' => Order\Model\OrderTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Order\Model\OrderModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Product\TableGateway' => [
                    'name' => 'RestableAdmin\Product\TableGateway',
                    'table' => [
                        'name' => 'product',
                        'object' => Product\Model\ProductTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Product\Model\ProductModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Stock\TableGateway' => [
                    'name' => 'RestableAdmin\Stock\TableGateway',
                    'table' => [
                        'name' => 'stock',
                        'object' => Stock\Model\StockTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Stock\Model\StockModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\StockProduct\TableGateway' => [
                    'name' => 'RestableAdmin\StockProduct\TableGateway',
                    'table' => [
                        'name' => 'stock',
                        'object' => Stock\Model\StockTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Stock\Model\StockProductModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Instance\TableGateway' => [
                    'name' => 'RestableAdmin\Instance\TableGateway',
                    'table' => [
                        'name' => 'application',
                        'object' => Instance\Model\ApplicationTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Instance\Model\ApplicationModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\ApplicationClient\TableGateway' => [
                    'name' => 'RestableAdmin\ApplicationClient\TableGateway',
                    'table' => [
                        'name' => 'application_client',
                        'object' => Instance\Model\ClientTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Instance\Model\ClientModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Client\TableGateway' => [
                    'name' => 'RestableAdmin\Client\TableGateway',
                    'table' => [
                        'name' => 'client',
                        'object' => Client\Model\Table::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Client\Model\Model::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Contact\TableGateway' => [
                    'name' => 'RestableAdmin\Contact\TableGateway',
                    'table' => [
                        'name' => 'contact',
                        'object' => Contact\Model\ContactTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Contact\Model\ContactModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Contact\Address\TableGateway' => [
                    'name' => 'RestableAdmin\Contact\Address\TableGateway',
                    'table' => [
                        'name' => 'contact_address',
                        'object' => Contact\Model\AddressTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Contact\Model\AddressModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'RestableAdmin\Venue\TableGateway' => [
                    'name' => 'RestableAdmin\Venue\TableGateway',
                    'table' => [
                        'name' => 'venue',
                        'object' => Venue\Model\VenueTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Venue\Model\VenueModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                    'paginator' => [
                        'object' => \Zend\Paginator\Paginator::class,
                        'adapter' => [
                            'object' => \Zend\Paginator\Adapter\DbSelect::class,
                        ],
                        'gateway' => 'RestableAdmin\Venue\TableGateway',
                        'db_select' => [
                            'columns' => ['client_uid','venue_uid','status','updated','created'],
                        ],
                    ],
                ],
                'RestableAdmin\Category\TableGateway' => [
                    'name' => 'RestableAdmin\Category\TableGateway',
                    'table' => [
                        'name' => 'category',
                        'object' => Category\Model\CategoryTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Category\Model\CategoryModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
            ], // gateway
            'handler' => [
                'RestableAdmin\Handler\AuthLoginHandler' => [
                    'route' => [
                        'restable.admin.auth.login' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'display',
                                'view_template_model' => [
                                    'layout' => 'layout-auth::layout-plain',
                                    'template' => 'restable-admin-authentication::form-login',
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.auth.login.post',
                                        ],
                                        'name' => 'form_login',
                                        'object' => \Authentication\Form\LoginForm::class,
                                    ]
                                ],
                            ],
                        ],
                        'restable.admin.auth.login.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'view_template_model' => [
                                    'layout' => 'layout-auth::layout-plain',
                                    'template' => 'restable-admin-authentication::form-login',
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.auth.login.post',
                                        ],
                                        'name' => 'form_login',
                                        'object' => \Authentication\Form\LoginForm::class,
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
                'RestableAdmin\Handler\CRUD\CreateHandler'=> [
                    'route' => [
                        'restable.admin.client.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.client.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Client',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Clients',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.client.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-client::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.client.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'object' => \RestableAdmin\Client\Form\ClientWriteForm::class,
                                        'template' => 'restable-admin-client::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.client.create
                        'restable.admin.client.create.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.client.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Client',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Clients',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.client.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-client::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'name' => 'form_create',
                                        'action' => [
                                            'route' => 'restable.admin.client.create.post',
                                        ],
//                                        'form_factory' => \RestableAdmin\Client\Form\ClientWriteForm::class,
                                        'object' => \RestableAdmin\Client\Form\ClientWriteForm::class,
                                        'save' => [
                                            'fieldset_client' => [
                                                'priority' => 100,
                                                'fieldset_name' => 'fieldset_client',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Client\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'status',
                                                        'source' => [
                                                            'type' => 'result-incoming',
                                                            'source_name' => 'fieldset_status',
                                                            'source_field_name' => 'status_code',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'fieldset_status' => [
                                                'priority' => 110,
                                                'fieldset_name' => 'fieldset_status',
                                            ],
                                            'collection_contact' => [
                                                'priority' => 120,
                                                'fieldset_name' => 'collection_contact',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\TableService',
                                                        'method' => 'saveItem'
                                                    ],
                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'client_uid',
                                                        'source' => [
                                                            'type' => 'result-insert',
                                                            'source_name' => 'fieldset_client',
                                                            'source_field_name' => 'client_uid',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'collection_address' => [
                                                'priority' => 130,
                                                'fieldset_name' => 'collection_address',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\Address\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'client_uid',
                                                        'source' => [
                                                            'type' => 'result-insert',
                                                            'source_name' => 'fieldset_client',
                                                            'source_field_name' => 'client_uid',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ], // restable.admin.client.create.post
                        'restable.admin.venue.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'acl' => true,
                                'rbac' => true,
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.venue.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Venue',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Venues',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.venue.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-venue::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.venue.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'form_factory' => \RestableAdmin\Venue\Form\VenueWriteForm::class,
                                        'template' => 'restable-admin-venue::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.venue.create
                        'restable.admin.venue.create.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'acl' => true,
                                'rbac' => true,
                                'data_template_model' => [
                                    'route_name' => 'restable.venue.create.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Venue',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Venues',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.venue.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-venue::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'name' => 'form_create',
                                        'action' => [
                                            'route' => 'restable.admin.venue.create.post',
                                        ],
                                        'form_factory' => \RestableAdmin\Venue\Form\VenueWriteForm::class,
                                        'save' => [
                                            'fieldset_venue' => [
                                                'priority' => 100,
                                                'fieldset_name' => 'fieldset_venue',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Venue\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'status',
                                                        'source' => [
                                                            'type' => 'result-incoming',
                                                            'source_name' => 'fieldset_status',
                                                            'source_field_name' => 'status_code',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'collection_contact' => [
                                                'priority' => 120,
                                                'fieldset_name' => 'collection_contact',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\TableService',
                                                        'method' => 'saveItem'
                                                    ],
                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'client_uid',
                                                        'source' => [
                                                            'type' => 'result-insert',
                                                            'source_name' => 'fieldset_venue',
                                                            'source_field_name' => 'client_uid',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'collection_address' => [
                                                'priority' => 130,
                                                'fieldset_name' => 'collection_address',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\Address\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                                'entity_change' => [
                                                    [
                                                        'field_name' => 'client_uid',
                                                        'source' => [
                                                            'type' => 'result-insert',
                                                            'source_name' => 'fieldset_venue',
                                                            'source_field_name' => 'client_uid',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ], // restable.admin.venue.create.post
                        'restable.admin.category.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.category.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Category',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Categories',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.category.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-category::form-create',
                                    ],
                                ],
                                'forms' => [
                                    'form_create'=>[
                                        'action' => [
                                            'route' => 'restable.admin.category.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'form_factory' => Category\Form\CategoryForm::class,
                                        'template' => 'restable-admin-category::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.category.create
                        'restable.admin.category.create.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.category.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Category',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Categories',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.category.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-category::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'name' => 'form_create',
                                        'action' => [
                                            'route' => 'restable.admin.category.create.post',
                                        ],
                                        'form_factory' => Category\Form\CategoryForm::class,
                                        'save' => [
                                            'fieldset_category' => [
                                                'fieldset_name' => 'fieldset_category',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Category\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ], // restable.admin.category.create.post
                        'restable.admin.contact.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.contact.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Contact',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Contacts',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.contact.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-contact::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.category.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'object' => \RestableAdmin\Contact\Form\ContactWriteForm::class,
                                        'template' => 'restable-admin-contact::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.contact.create
                        'restable.admin.contact.create.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.contact.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Contact',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Contacts',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.contact.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-contact::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'name' => 'form_create',
                                        'action' => [
                                            'route' => 'restable.admin.contact.create.post',
                                        ],
                                        'object' => Contact\Form\ContactWriteForm::class,
                                        'save' => [
                                            'collection_contact' => [
                                                'fieldset_name' => 'collection_contact',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ], // restable.admin.contact.create.post
                        'restable.admin.address.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.address.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Address',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Addresses',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.address.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-address::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.address.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'object' => Contact\Form\AddressWriteForm::class,
                                        'template' => 'restable-admin-address::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.address.create
                        'restable.admin.address.create.post' => [
                            'post' => [
                                'method' => 'POST',
                                'scenario' => 'process',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.address.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Address',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Addresses',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.address.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-address::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'name' => 'form_create',
                                        'action' => [
                                            'route' => 'restable.admin.address.create.post',
                                        ],
                                        'object' => Contact\Form\AddressWriteForm::class,
                                        'save' => [
                                            'collection_address' => [
                                                'fieldset_name' => 'collection_address',
                                                'service' => [
                                                    [
                                                        'name'=>'RestableAdmin\Contact\Address\TableService',
                                                        'method' => 'saveItem'
                                                    ],

                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ], // restable.admin.address.create.post
                        'restable.admin.application.create' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'create',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.application.create',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Create Instance',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Instances',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.application.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-create',
                                    'forms' => [
                                        'form_create' => 'restable-admin-application::form-create',
                                    ],
                                ],
                                'forms' => [
                                    [
                                        'action' => [
                                            'route' => 'restable.admin.application.create.post',
                                        ],
                                        'name' => 'form_create',
                                        'object' => Contact\Form\AddressWriteForm::class,
                                        'template' => 'restable-admin-application::form-create',
                                    ]
                                ],
                            ],
                        ], // restable.admin.application.create
                    ],
                ], // RestableAdmin\Handler\CRUD\CreateHandler
                'RestableAdmin\Handler\CRUD\ReadHandler' => [
                    'route' => [
                        'restable.admin.contact.read' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'details',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.contact.read',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Contact Details',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Contact',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-secondary ml-5',
                                                        'href' => 'helper::url:restable.admin.contact.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Contacts',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-secondary ml-1',
                                                        'href' => 'helper::url:restable.admin.contact.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                        [
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Update',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-0',
                                                        'href' => 'helper::url:restable.admin.contact.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Export',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-1',
                                                        'href' => 'helper::url:restable.admin.contact.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Delete',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-danger ml-1',
                                                        'href' => 'helper::url:restable.admin.contact.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-read',
                                ],
                            ],
                        ], // restable.admin.contact.read
                        'restable.admin.client.read' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'details',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.client.read',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Client Details',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Client',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-secondary ml-5',
                                                        'href' => 'helper::url:restable.admin.client.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'List Clients',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-secondary ml-1',
                                                        'href' => 'helper::url:restable.admin.client.list'
                                                    ],
                                                ],
                                            ],
                                        ],
                                        [
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Update',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-0',
                                                        'href' => 'helper::url:restable.admin.client.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Export',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-1',
                                                        'href' => 'helper::url:restable.admin.client.create'
                                                    ],
                                                ],
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Delete',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-danger ml-1',
                                                        'href' => 'helper::url:restable.admin.client.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ], // heading
                                    'main' => [
                                        [
                                            'name' => 'data_client',
                                            'action' => [
                                                'route' => 'restable.admin.address.create.post',
                                            ],
                                            'object' => Contact\Form\AddressWriteForm::class,
                                            'read' => [
                                                'collection_address' => [
                                                    'fieldset_name' => 'collection_address',
                                                    'service' => [
                                                        [
                                                            'name'=>'RestableAdmin\Contact\Address\TableService',
                                                            'method' => 'getItem'
                                                        ],

                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ], // data_template_model
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-read',
                                ],
                            ],
                        ], // restable.admin.contact.read
                    ],
                ], // RestableAdmin\Handler\CRUD\ReadHandler
                'RestableAdmin\Handler\CRUD\ListHandler'=> [
                    'route' => [
                        // Configuration by RouteName
                        'restable.admin.requests.demo' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableSite\StaticPages\RequestDemo\TableGateway',
                                    'db_select' => [
                                        'columns' => ['name_first','name_last','contact_phone','contact_email','venue_name','created'],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::enquiries-list',
                                ],
                            ],
                        ], // restable.admin.requests.demo
                        'restable.admin.dashboard' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.dashboard',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Dashboard',
                                        ],
                                    ],
                                    'table' => [
                                        'demo_requests' => [
                                            'name' => 'main',
                                            'paginator' => [
                                                'object' => \Zend\Paginator\Paginator::class,
                                                'adapter' => [
                                                    \Zend\Paginator\Adapter\AdapterInterface::class => \Zend\Paginator\Adapter\DbSelect::class,
                                                ],
                                                'gateway' => 'RestableSite\StaticPages\RequestDemo\TableGateway',
                                                'db_select' => [
                                                    'columns' => ['name_first','name_last','contact_phone','status','contact_email','venue_name','created'],
                                                    'where' => [
                                                        'status' => StaticPages\Model\RequestDemoModel::STATUS_NEW,
                                                    ],
                                                ],
                                            ],
                                            'headers'=> [
                                                'venue_name'=>'Venue',
                                                'name_first'=>'Name',
                                                'contact_email'=>'Email',
                                                'contact_phone'=>'Phone',
                                                'status'=>'Status',
                                                'created'=>'Created',
                                                100=>null,
                                            ],
                                            'rows' => [
                                                ['column'=>'venue_name'],
                                                ['column'=>['name_first','name_last']],
                                                ['column'=>'contact_email'],
                                                ['column'=>'contact_phone'],
                                                ['column'=>'status'],
                                                ['column'=>'created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::dashboard',
                                ],
                            ],
                        ], // restable.admin.dashboard
                        'restable.admin.orders.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Order\TableGateway',
                                    'db_select' => [
                                        'columns' => ['order_id','cart_id','order_total'=>'total','order_status'=>'status','order_created'=>'created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.orders.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Orders',
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'order_id'=>'Order Id',
                                                'cart_id'=>'Cart Id',
                                                'order_total'=>'Total',
                                                'order_status'=>'Status',
                                                'order_created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'order_id'],
                                                ['column'=>'cart_id'],
                                                ['column'=>'order_total'],
                                                ['column'=>'order_status'],
                                                ['column'=>'order_created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                ],
                            ],
                        ], // restable.admin.orders.list
                        'restable.admin.products.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Product\TableGateway',
                                    'db_select' => [
                                        'columns' => ['product_uid','name','price'=>'price','unit'=>'unit','description_short'=>'description_short','product_created'=>'created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.products.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Products',
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'product_uid'=>'Product Id',
                                                'name'=>'Product_name',
                                                'price'=>'Price',
                                                'unit'=>'Unit',
                                                'product_created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'product_uid'],
                                                ['column'=>'name'],
                                                ['column'=>'price'],
                                                ['column'=>'unit'],
                                                ['column'=>'product_created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                ],
                            ],
                        ], // restable.admin.products.list
                        'restable.admin.stock.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Stock\TableGateway',
                                    'db_select' => [
                                        'columns' => ['stock_uid','product_uid','product_qty','stock_status','stock_created'=>'created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.stock.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Stock',
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'stock_uid'=>'Stock Id',
                                                'product_uid'=>'Product Id',
                                                'product_qty'=>'Qty',
                                                'stock_status'=>'Price',
                                                'stock_created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'stock_uid'],
                                                ['column'=>'product_uid'],
                                                ['column'=>'product_qty'],
                                                ['column'=>'stock_status'],
                                                ['column'=>'stock_created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                ],
                            ],
                        ], // restable.admin.stock.list
                        'restable.admin.stock_product.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\StockProduct\TableGateway',
                                    'db_select' => [
                                        'columns' => ['stock_uid','product_uid','product_qty','stock_status','stock_created'=>'created'],
                                        'join' => [
                                            [
                                                'on' => 'product',
                                                'where' => 'product.product_uid = stock.product_uid',
                                                'columns' => ['name','price','description_short','unit'],
                                                'union' => 'left',
                                            ],
                                            [
                                                'on' => 'stock_status',
                                                'where' => 'stock_status.stock_uid = stock.stock_uid',
                                                'columns' => ['status_code'],
                                                'union' => 'left',
                                            ],
                                        ],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.stock_product.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Stock Products',
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'stock_uid'=>'Stock Id',
                                                'product_uid'=>'Product Id',
                                                'product_qty'=>'Qty',
                                                'price'=>'Price',
                                                'stock_status'=>'Status',
                                                'stock_created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'stock_uid'],
                                                ['column'=>'product_uid'],
                                                ['column'=>'product_qty'],
                                                ['column'=>'price'],
                                                ['column'=>'stock_status'],
                                                ['column'=>'stock_created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                ],
                            ],
                        ], // restable.admin.stock_product.list
                        'restable.admin.application.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Instance\TableGateway',
                                    'db_select' => [
                                        'columns' => ['application_uid','application_client_uid','application_status','updated','created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.application.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Application Instances',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Instance',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.application.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'application_uid'=>'App Id',
                                                'application_client_uid'=>'Client Id',
                                                'application_status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'application_uid'],
                                                ['column'=>'application_client_uid'],
                                                ['column'=>'application_status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                    'table_row' => 'restable-admin-application::table-row',
                                ],
                            ],
                        ], // restable.admin.application.list
                        'restable.admin.client.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Client\TableGateway',
                                    'db_select' => [
                                        'columns' => ['client_name','client_uid','status','updated','created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.client.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Clients',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Client',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.client.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'client_name'=>'Client Name',
                                                'client_uid'=>'Client Id',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                                100=>'Details',
                                            ],
                                            'rows' => [
                                                ['column'=>'client_name'],
                                                ['column'=>'client_uid'],
                                                ['column'=>'status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                                ['buttons' => [
                                                    [
                                                        'html_tag' => 'a',
                                                        'text' => 'Details',
                                                        'attributes' => [
                                                            'class' => 'btn btn-sm btn-info ml-5',
                                                            'href' => [
                                                                'type' => 'plugin',
                                                                'name' => 'url',
                                                                'arguments' => [
                                                                    'restable.admin.client.read',
                                                                    ['client_uid'=>"data::item=>client_uid"]
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                ],],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
//                                    'table_row' => 'restable-admin-client::table-row',
                                ],
                            ],
                        ], // restable.admin.client.list
                        'restable.admin.application_client.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\ApplicationClient\TableGateway',
                                    'db_select' => [
                                        'columns' => ['application_uid','client_uid','status','updated','created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.application_client.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Application Clients',
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'application_uid'=>'App Id',
                                                'client_uid'=>'Client Id',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'application_uid'],
                                                ['column'=>'client_uid'],
                                                ['column'=>'status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                    'table_row' => 'restable-admin-application::table-row-client',
                                ],
                            ],
                        ], // restable.admin.application_client.list
                        'restable.admin.venue.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Venue\TableGateway',
                                    'db_select' => [
                                        'columns' => ['client_uid','venue_uid','status','updated','created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.venue.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Venues',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Venue',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.venue.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'venue_uid'=>'Venue Id',
                                                'client_uid'=>'Client Id',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                            ],
                                            'rows' => [
                                                ['column'=>'venue_uid',],
                                                ['column'=>'client_uid',],
                                                ['column'=>'status',],
                                                ['column'=>'updated',],
                                                ['column'=>'created',],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
                                    'table_row' => 'restable-admin-venue::table-row',
                                ],
                            ],
                        ], // restable.admin.venue.list
                        'restable.admin.category.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Category\TableGateway',
                                    'db_select' => [
                                        'columns' => ['category_uid','category_parent','label','status','updated','created'],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.category.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Categories',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Category',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.category.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'category_uid'=>'Category Id',
                                                'category_parent'=>'Parent',
                                                'label'=>'Label',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                                100=>'Details',
                                            ],
                                            'rows' => [
                                                ['column'=>'category_uid'],
                                                ['column'=>'category_parent'],
                                                ['column'=>'label'],
                                                ['column'=>'status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                                ['buttons' => [
                                                    [
                                                        'html_tag' => 'a',
                                                        'text' => 'Details',
                                                        'attributes' => [
                                                            'class' => 'btn btn-sm btn-info ml-5',
                                                            'href' => [
                                                                'type' => 'plugin',
                                                                'name' => 'url',
                                                                'arguments' => [
                                                                    'restable.admin.category.read',
                                                                    ['category_uid'=>"data::item=>category_uid"]
                                                                ],
                                                            ],
//                                                            'href' => 'helper::url:restable.admin.category.read:["category_uid"=item:category_uid]'
                                                        ],
                                                    ],
                                                ],],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
//                                    'table_row' => 'restable-admin-category::table-row',
                                ],
                            ],
                        ], // restable.admin.category.list
                        'restable.admin.contact.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Contact\TableGateway',
                                    'db_select' => [
                                        'columns' => ['contact_uid','client_uid','contact_name','contact_email','contact_phone','status','updated','created'],
                                        'join' => [
                                            [
                                                'on' => 'client',
                                                'where' => 'client.client_uid = contact.client_uid',
                                                'columns' => ['client_name'],
                                                'union' => 'left',
                                            ],
                                        ],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.contact.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Contacts',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'New',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.contact.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'contact_uid'=>'Contact Id',
                                                'client_uid'=>'Client Id',
                                                'client_name'=>'Client Name',
                                                'contact_name'=>'Name',
                                                'contact_email'=>'Email',
                                                'contact_phone'=>'Phone',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                                100=>'Details',
                                            ],
                                            'rows' => [
                                                ['column'=>'contact_uid'],
                                                ['column'=>'client_uid'],
                                                ['column'=>'client_name'],
                                                ['column'=>'contact_name'],
                                                ['column'=>'contact_email'],
                                                ['column'=>'contact_phone'],
                                                ['column'=>'status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                                ['buttons' => [
                                                    [
                                                        'html_tag' => 'a',
                                                        'text' => 'Details',
                                                        'attributes' => [
                                                            'class' => 'btn btn-sm btn-info ml-5',
                                                            'href' => [
                                                                'type' => 'plugin',
                                                                'name' => 'url',
                                                                'arguments' => [
                                                                    'restable.admin.contact.read',
                                                                    ['contact_uid'=>"data::item=>contact_uid"]
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                ],],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
//                                    'table_row' => 'restable-admin-category::table-row',
                                ],
                            ],
                        ], // restable.admin.contact.list
                        'restable.admin.address.list' => [
                            'get' => [
                                'method' => 'GET',
                                'scenario' => 'list',
                                'paginator' => [
                                    'object' => \Zend\Paginator\Paginator::class,
                                    'adapter' => [
                                        'object' => \Zend\Paginator\Adapter\DbSelect::class,
                                    ],
                                    'gateway' => 'RestableAdmin\Contact\Address\TableGateway',
                                    'db_select' => [
                                        'columns' => ['address_uid','client_uid','application_uid','contact_type','address_label','first_name','status','updated','created'],
                                        'join' => [
                                            [
                                                'on' => 'client',
                                                'where' => 'client.client_uid = contact_address.client_uid',
                                                'columns' => ['client_name'],
                                                'union' => 'left',
                                            ],
                                        ],
                                    ],
                                ],
                                'data_template_model' => [
                                    'route_name' => 'restable.admin.address.list',
                                    'heading' => [
                                        [
                                            'html_tag' => 'h1',
                                            'text' => 'Addresses',
                                            'buttons' => [
                                                [
                                                    'html_tag' => 'a',
                                                    'text' => 'Create Address',
                                                    'attributes' => [
                                                        'class' => 'btn btn-sm btn-info ml-5',
                                                        'href' => 'helper::url:restable.admin.address.create'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'table' => [
                                        'main' => [
                                            'name' => 'main',
                                            'headers'=> [
                                                'address_uid'=>'Contact Id',
                                                'client_uid'=>'Client Id',
                                                'client_name'=>'Client Name',
                                                'application_uid'=>'Application Id',
                                                'contact_type'=>'Type',
                                                'first_name'=>'Name',
                                                'status'=>'Status',
                                                'updated'=>'Updated',
                                                'created'=>'Created',
                                                100=>'Details',
                                            ],
                                            'rows' => [
                                                ['column'=>'address_uid'],
                                                ['column'=>'client_uid'],
                                                ['column'=>'client_name'],
                                                ['column'=>'application_uid'],
                                                ['column'=>'contact_type'],
                                                ['column'=>'first_name'],
                                                ['column'=>'status'],
                                                ['column'=>'updated'],
                                                ['column'=>'created'],
                                                ['buttons' => [
                                                    [
                                                        'html_tag' => 'a',
                                                        'text' => 'Details',
                                                        'attributes' => [
                                                            'class' => 'btn btn-sm btn-info ml-5',
                                                            'href' => [
                                                                'type' => 'plugin',
                                                                'name' => 'url',
                                                                'arguments' => [
                                                                    'restable.admin.address.read',
                                                                    ['address_uid'=>"data::item=>address_uid"]
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                ],],
                                            ],
                                        ],
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-admin-layout::restable-admin',
                                    'template' => 'restable-admin::template-list',
//                                    'table_row' => 'restable-admin-category::table-row',
                                ],
                            ],
                        ], // restable.admin.contact.list
                    ],
                ], // RestableAdmin\Handler\CRUD\ListHandler
            ],
        ];
    }
}
