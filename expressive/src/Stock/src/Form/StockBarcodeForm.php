<?php
namespace Stock\Form;

use Zend\InputFilter\InputFilter as InputFilter;
use Zend\Form\Form as Form;
use Stock\Model\StockBarcodeModel;

class StockBarcodeForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');

        $this
            ->setAttribute('method', 'post')
//            ->setObject(new StockBarcodeModel())
            ->setInputFilter(new InputFilter())
        ;

        $this->addElements();

        $this->addInputFilter();

    }

    protected function addElements()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'application_id',
        ], ['priority'=>10]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'stock_barcode',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'stock-barcode-search',
            ],
            'options' => [
                'label' => "Code"
            ],
        ], ['priority'=>40]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ], ['priority'=>60]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Search',
                'class' => 'btn btn-secondary ',
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
            'name'     => 'stock_barcode',
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
