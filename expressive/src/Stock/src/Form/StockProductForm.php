<?php

declare(strict_types=1);

namespace Stock\Form;

use Stock\Model\StockWriteModel;
use Zend\Form\Form as Form;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class StockProductForm extends Form
{
    public function __construct($name = 'stock_product_form', $options = array())
    {
        parent::__construct($name,$options);

        $this
            ->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(true))
            ->setObject(new StockWriteModel())
//            ->setInputFilter($this->addInputFilter())
        ;

        $this->addElements();

        $this->addInputFilter();

    }

    protected function addElements()
    {

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'application_id',
        ], ['priority'=>10]);

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'product_uid',
        ], ['priority'=>10]);
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'stock_uid',
        ], ['priority'=>10]);

        $this->add(array(
            'name' => 'fieldset_product',
            'type' => \Product\Form\Fieldset\ProductFieldset::class,
            'options' => array(
//                'use_as_base_fieldset' => true
            )
        ));

        $this->add(array(
            'name' => 'fieldset_stock',
            'type' => \Stock\Form\Fieldset\StockFieldset::class,
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'fieldset_barcode',
            'options' => array(
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => \Stock\Form\Fieldset\BarcodeFieldset::class,
                ),
            ),
        ));

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ], ['priority'=>60]);

        $this->add([
            'name' => 'submit_top',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Submit',
                'class' => 'btn btn-success ',
            ],
        ], ['priority'=>100]);
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Submit',
                'class' => 'btn btn-success ',
            ],
        ], ['priority'=>-100]);
    }

    private function addInputFilter()
    {

        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'application_id',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 64,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);


        $inputFilter->add([
            'name'     => 'product_uid',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 64,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'stock_uid',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 64,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        return $inputFilter;
    }
}
