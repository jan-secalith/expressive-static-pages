<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Contact\Model\ContactModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class ContactFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new ContactModel());
        $this->setAttribute('class','form-fieldset-contact');
//        $this->setInputFilter($this->addInputFilter())

        $this->setLabel('Contact');

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
            'name' => 'contact_name',
            'options' => array(
                'label' => 'Contact Name'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'contact_email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'contact_phone',
            'options' => array(
                'label' => 'Phone'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'textarea',
            'name' => 'contact_notes',
            'options' => array(
                'label' => 'Notes'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'collection_contact_remove',
            'options' => array(
                'label' => 'Remove Contact Entry'
            ),
            'attributes' => [
                'class' => 'btn btn-sm btn-warning btn-form',
                'data-target-type' => 'contact',
                'data-action' => 'remove-collection-fieldset',
                'onClick' => 'javascript:removeCollectionFieldset(jQuery(this));',
            ],
        ));

    }

    public function getInputFilterSpecification()
    {
        return array(
            'contact_name' => array(
                'required' => true,
            ),
        );
    }

}