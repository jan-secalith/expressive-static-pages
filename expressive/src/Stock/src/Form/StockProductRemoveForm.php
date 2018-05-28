<?php
namespace Stock\Form;

use Stock\Model\StockRemoveModel;
use Zend\Hydrator\ClassMethods;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class StockProductRemoveForm extends Form
{

    public function __construct($name = 'stock_product_remove_form', $options = array())
    {
        parent::__construct($name,$options);

        $this
            ->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(true))
            ->setObject(new StockRemoveModel())
//            ->setInputFilter($this->addInputFilter())
        ;

        $this->addElements();

        $this->addInputFilter();

    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        $this->add([
            'type'  => 'hidden',
            'name' => 'application_id',
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'product_uid',
        ], ['priority'=>10]);
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'stock_uid',
        ], ['priority'=>10]);

        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'stock_product_remove_confirm',
            'options' => array(
                'label' => 'Are you sure you want to delete the product?',
                'value_options' => array(
                    '0' => 'Nah',
                    'yes' => 'Yes I am sure',
                ),
            ),
        ));

        // Add the CSRF field
        $this->add([
            'type'  => 'csrf',
            'name' => 'csrf',
            'attributes' => [],
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);

        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Next Step',
                'id' => 'submitbutton',
            ],
        ]);
    }

    private function addInputFilter()
    {

    }
}