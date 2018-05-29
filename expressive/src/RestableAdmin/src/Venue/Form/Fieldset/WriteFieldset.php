<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Venue\Model\WriteModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class WriteFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new WriteModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'name' => 'fieldset_venue',
            'type' => \RestableAdmin\Venue\Form\Fieldset\VenueFieldset::class,
            'options' => array(
                'use_as_base_fieldset' => false
            )
        ));

        $this->add(array(
            'name' => 'fieldset_status',
            'type' => \RestableAdmin\Venue\Form\Fieldset\StatusFieldset::class,
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'collection_contact',
            'options' => array(
                'count' => 0,
                'label' => 'Contacts',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => \RestableAdmin\Contact\Form\Fieldset\ContactFieldset::class,
                ),
            ),
            'attributes' => [
                'class' => 'form-collection form-collection-contact',
                'id' => 'form-collection-contact',
                'data-template-index-placeholder' => '__index__',
            ],
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'collection_contact_add',
            'options' => array(
                'label' => 'Add Contact'
            ),
            'attributes' => [
                'class' => 'btn btn-sm btn-info btn-form',
                'data-target-type' => 'contact',
                'data-action' => 'add-collection-fieldset',
                'onClick' => 'javascript:addCollectionFieldset(jQuery(this),"prepend");',
            ],
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'collection_address',
            'options' => array(
                'count' => 0    ,
                'label' => 'Addresses',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => \RestableAdmin\Contact\Form\Fieldset\AddressFieldset::class,
                ),
            ),
            'attributes' => [
                'class' => 'form-collection form-collection-address',
                'id' => 'form-collection-address',
                'data-template-index-placeholder' => '__index__',
            ],
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'collection_address_add',
            'options' => array(
                'label' => 'Add Address'
            ),
            'attributes' => [
                'class' => 'btn btn-sm btn-info btn-form',
                'data-target-type' => 'address',
                'data-action' => 'add-collection-fieldset',
                'onClick' => 'javascript:addCollectionFieldset(jQuery(this),"prepend");',
            ],
        ));


    }

    public function getInputFilterSpecification()
    {
        return array(
//            'client_name' => array(
//                'required' => true,
//            ),
        );
    }

}