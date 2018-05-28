<?php

declare(strict_types=1);

namespace RestableAdmin\Category\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Category\Model\CategoryModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class CategoryFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new CategoryModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'category_uid'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category_parent',
            'options' => array(
                'label' => 'Parent',
                'value_options' => [
                    'current' => [
                        'label' => 'Current',
                        'options' => [
                            '0'=>'Unspecified',
                        ],
                    ],
                    'available' => [
                        'label' => 'Available',
                        'options' => [
                            '0'=>'Unspecified',
                        ],
                    ],
                ],
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'label',
            'options' => array(
                'label' => 'Label'
            ),
            'attributes' => [
                'class' => 'form-control d-inline-flex w-auto',
            ],
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'category_parent' => array(
                'required' => true,
            ),
            'label' => array(
                'required' => true,
            ),
        );
    }

}