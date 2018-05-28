<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Contact\Model\AddressModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class AddressFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new AddressModel());
        $this->setAttribute('class','form-fieldset-address');

        $this->setLabel('Address');

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'client_uid'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'first_name',
            'options' => array(
                'label' => 'First Name'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'last_name',
            'options' => array(
                'label' => 'Last Name'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'address_1',
            'options' => array(
                'label' => 'Address'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'address_2',
            'options' => array(
                'label' => 'Address Line 2 (Optional)'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'postcode',
            'options' => array(
                'label' => 'Postcode'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'city',
            'options' => array(
                'label' => 'Town / City'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'textarea',
            'name' => 'address_notes',
            'options' => array(
                'label' => 'Address Notes'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'collection_address_remove',
            'options' => array(
                'label' => 'Remove Address Entry'
            ),
            'attributes' => [
                'class' => 'btn btn-sm btn-warning btn-form',
                'data-target-type' => 'address',
                'data-action' => 'remove-collection-fieldset',
                'onClick' => 'javascript:removeCollectionFieldset(jQuery(this));',
            ],
        ));

    }

    public function getInputFilterSpecification()
    {
        return array(
            'first_name' => array(
                'required' => true,
            ),
            'address_1' => array(
                'required' => true,
            ),
        );
    }

}