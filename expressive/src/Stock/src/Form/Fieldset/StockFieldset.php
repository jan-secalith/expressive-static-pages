<?php

declare(strict_types=1);

namespace Stock\Form\Fieldset;

use Stock\Model\StockModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class StockFieldset extends Fieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new StockModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'stock_uid'
        ));
        $this->add(array(
            'type' => 'hidden',
            'name' => 'product_uid'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'product_qty',
            'options' => array(
                'label' => 'Stock Quantity'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'product_qty' => array(
                'required' => true,
            ),
        );
    }

}