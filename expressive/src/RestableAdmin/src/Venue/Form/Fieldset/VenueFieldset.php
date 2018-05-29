<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Venue\Model\VenueModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;

class VenueFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new VenueModel());

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'venue_uid'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'venue_name',
            'options' => array(
                'label' => 'Venue Name'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'client_uid',
            'options' => array(
                'label' => 'Client',
                'value_options' => [
                    '0' => 'None',
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
            'venue_name' => array(
                'required' => true,
            ),
        );
    }

}