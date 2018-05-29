<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Form\Factory;

use RestableAdmin\Venue\Form\WriteForm;
use Psr\Container\ContainerInterface;

class VenueFormServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $categoryTable = $container->get("RestableAdmin\Client\TableService");

        $categories = $categoryTable->fetchAll();

        $formCategories = [0=>'None'];
        foreach($categories as $category) {
            $formCategories[$category->getClientUid()] = $category->getClientName();
        }

        return new WriteForm('form_create',[],$formCategories);

    }
}
