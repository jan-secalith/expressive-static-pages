<?php

declare(strict_types=1);

namespace RestableAdmin\Client\Form\Factory;

use RestableAdmin\Client\Form\ClientWriteForm;
use Psr\Container\ContainerInterface;

class ClientFormServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $categoryTable = $container->get("RestableAdmin\Client\TableService");

        $categories = $categoryTable->fetchAll();

        $formCategories = [0=>'None'];
        foreach($categories as $category) {
            $formCategories[$category->getClientUid()] = $category->getClientName();
        }

        return new ClientWriteForm('form_create',[],$formCategories);

    }
}
