<?php
namespace RestableSite\StaticPages\Form;

use RestableSite\StaticPages\InputFilter\RequestDemoInputFilter;
use RestableSite\StaticPages\Model\RequestDemoModel;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form as Form;

class RequestDemoForm extends Form
{
    public function __construct()
    {
        parent::__construct('form_request_demo_restable');

        $this
            ->setAttribute('method', 'post')
            ->setObject(new RequestDemoModel())
            ->setInputFilter(new RequestDemoInputFilter())
        ;

        $this->addElements();

    }

    protected function addElements()
    {

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'application_id',
        ], ['priority'=>0]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name_first',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => '* First Name',
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
                'placeholder' => "* Email",
            ],
            'options' => [
                'label' => "Email",
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'venue_name',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => "* Venue Name",
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
                'empty_option' => '* Please choose Work Title',
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
                'empty_option' => '* Please choose your Country',
                'value_options' => array(
                    'gb' => 'United Kingdom',
                    'us' => 'United States',
                    'eu' => 'EU',
                    'other' => 'Other',
                ),
            ],
        ], ['priority'=>30]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ], ['priority'=>60]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Place Request',
                'class' => 'btn btn-warning btn-lg w-100',
            ],
        ], ['priority'=>-100]);
    }
}
