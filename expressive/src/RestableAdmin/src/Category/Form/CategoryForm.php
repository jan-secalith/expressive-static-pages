<?php

declare(strict_types=1);

namespace RestableAdmin\Category\Form;

use RestableAdmin\Category\Model\CategoryWriteModel;
use Zend\Form\Form as Form;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class CategoryForm extends Form
{
    private $categories;

    public function __construct($name = 'form_create', $options = array(),$categories=null)
    {
        parent::__construct($name,$options);

        $this->categories = $categories;

        $this
            ->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(true))
            ->setObject(new CategoryWriteModel())
            ->setInputFilter($this->addInputFilter())
        ;

        $this->addElements($categories);

        $this->addInputFilter();

    }

    protected function addElements($options=null)
    {

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'application_id',
            'attributes'=>[
                'value' => 0
            ],
        ], ['priority'=>10]);



        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'fieldset_category',
            'options' => array(
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => \RestableAdmin\Category\Form\Fieldset\CategoryFieldset::class,
                ),
            ),
        ));

        $this->get('fieldset_category')
            ->getTargetElement()
            ->get('category_parent')
            ->setValueOptions($this->categories)
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
            'required' => true,
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
