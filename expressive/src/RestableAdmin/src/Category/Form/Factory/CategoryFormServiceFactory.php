<?php

declare(strict_types=1);

namespace RestableAdmin\Category\Form\Factory;

use RestableAdmin\Category\Form\CategoryForm;
use Psr\Container\ContainerInterface;

class CategoryFormServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $categoryTable = $container->get("RestableAdmin\Category\TableService");

        $categories = $categoryTable->fetchAll();

        $formCategories = [0=>'No Parent (Root)'];
        foreach($categories as $category) {
            $formCategories[$category->getCategoryUid()] = $category->getLabel();
        }

        return new CategoryForm('form_create',[],$formCategories);

    }
}
