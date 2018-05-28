<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use RestableAdmin\Contact\Model\ContactWriteModel;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class ContactWriteFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name,$options);

        $this->setHydrator(new ClassMethods(true));
        $this->setObject(new ContactWriteModel());
//        $this->setInputFilter($this->addInputFilter())

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'type' => 'button',
            'name' => 'collection_contact_add',
            'options' => array(
                'label' => 'Add Another Contact'
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
            'name' => 'collection_contact',
            'options' => array(
                'count' => 1,
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