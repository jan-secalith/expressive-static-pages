<?php
namespace RestableSite\StaticPages\Form;

use Zend\InputFilter\InputFilter;
use Zend\Form\Form as Form;

class RequestDemoForm extends Form
{
    public function __construct()
    {
        parent::__construct('form_request_demo_restable');

        $this
            ->setAttribute('method', 'post')
//            ->setObject(new CartItemModel())
            ->setInputFilter(new InputFilter())
        ;

        $this->addElements();

//        $this->addInputFilter();

    }

    protected function addElements()
    {

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name_first',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'First Name',
            ],
            'options' => [
                'label' => "First Name",
            ],
        ], ['priority'=>40]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name_last',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Last Name",
            ],
            'options' => [
                'label' => "Last Name",
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'contact_phone',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Phone Number",
            ],
            'options' => [
                'label' => "Phone Number",
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Email',
            'name' => 'contact_email',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Email",
            ],
            'options' => [
                'label' => "Email",
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name_venue',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Venue Name",
            ],
            'options' => [
                'label' => "Venue Name",
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'work_title',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Work Title",
            ],
            'options' => [
                'label' => "Work Title",
                'empty_option' => 'Please choose Work Title',
                'value_options' => array(
                    'owner' => 'Owner',
                    'director' => 'Director',
                    'manager' => 'Manager',
                    'staff' => 'Staff',
                    'other' => 'Other',
                ),
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "Country",
            ],
            'options' => [
                'label' => "Country",
                'empty_option' => 'Please choose your Country',
                'value_options' => array(
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                    'eu' => 'EU',
                    'other' => 'Other',
                ),
            ],
        ], ['priority'=>30]);

//        $this->add([
//            'type' => 'Zend\Form\Element\Csrf',
//            'name' => 'csrf',
//        ], ['priority'=>60]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Place Request',
                'class' => 'btn btn-warning btn-lg w-100',
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
            'name'     => 'name_first',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);


        $inputFilter->add([
            'name'     => 'contact_email',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'contact_phone',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'work_title',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'name_venue',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'country',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        return $inputFilter;
    }
}
