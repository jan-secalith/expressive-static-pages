<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Form;

use RestableAdmin\Venue\Model\VenueWriteModel;
use Zend\Form\Form as Form;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class VenueWriteForm extends Form
{
    private $clients;

    public function __construct($name = 'form_create', $options = array(),$clients=null)
    {
        parent::__construct($name,$options);

        $this->clients = $clients;

        $this
            ->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(true))
            ->setObject(new VenueWriteModel())
            ->setInputFilter($this->addInputFilter())
        ;

        $this->addElements($options);

        $this->addInputFilter();

    }

    protected function addElements($options=null)
    {

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'application_id',
        ], ['priority'=>10]);

        $this->add(array(
            'name' => 'form_create',
            'type' => \RestableAdmin\Venue\Form\Fieldset\WriteFieldset::class,
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

        $this->get('form_create')
            ->get('fieldset_venue')
            ->get('client_uid')
            ->setValueOptions($this->clients)
        ;


        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ], ['priority'=>60]);

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

        return $inputFilter;
    }
}
