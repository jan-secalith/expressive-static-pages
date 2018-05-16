<?php

declare(strict_types=1);

namespace Product\Form\Fieldset;

use Product\Model\ProductModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;

class ProductFieldset extends Fieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new ProductModel());

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'product_uid'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'name',
            'options' => array(
                'label' => 'Product Name'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'price',
            'options' => array(
                'label' => 'Price'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'unit',
            'options' => array(
                'label' => 'Unit'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'description_short',
            'options' => array(
                'label' => 'Short Description'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));
    }
}