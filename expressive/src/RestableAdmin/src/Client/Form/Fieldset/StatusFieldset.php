<?php

declare(strict_types=1);

namespace RestableAdmin\Client\Form\Fieldset;

use RestableAdmin\Client\Model\ClientStatusModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class StatusFieldset extends Fieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new ClientStatusModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements($options);


    }

    protected function addElements($options=[])
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
            'name' => 'status_code',
            'options' => array(
                'label' => 'Stock Quantity'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        if( ! array_key_exists('status_code_value',$options))
        {
            $curr = $this->getObject()->getStatusCurrentWithLabel(ClientStatusModel::STOCK_STATUS_DEFAULT);
            $status_code_options = $this->getObject()->getStatusAvailableWithLabels();

        }

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'status_code',
            'options' => array(
                'label' => 'Stock Status',
                'value_options' => [
                    'current' => [
                        'label' => 'Current',
                        'options' => $curr,
                    ],
                    'available' => [
                        'label' => 'Available',
                        'options' => $status_code_options
                    ],
                ],
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