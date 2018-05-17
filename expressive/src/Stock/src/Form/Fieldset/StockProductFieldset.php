<?php

declare(strict_types=1);

namespace Stock\Form\Fieldset;

use Stock\Model\StockBarcodeModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class StockProductFieldset extends Fieldset
{
    public function __construct($name = 'barcode', $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new StockBarcodeModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add([
            'type' => 'hidden',
            'name' => 'product_uid',
            'options' => [
                'label' => 'Product UID'
            ],
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'barcode_value',
            'options' => [
                'label' => 'Barcode Value',
                'label_attributes' => [
                    'class' => 'form-element-hide-first-span',
                ],
            ],
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ]);

        $this->add([
            'type' => 'button',
            'name' => 'barcode_remove',
            'options' => [
                'label' => 'Remove Barcode',
            ],
            'attributes' => [
                'value' => 'Remove Barcode',
                'class' => 'btn btn-sm btn-warning d-inline-flex',
            ],
        ]);

    }

    public function getInputFilterSpecification()
    {
        return array(
            'barcode_value' => [
                'required' => true,
            ],
        );
    }

}